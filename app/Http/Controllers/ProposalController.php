<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\ProposalSubmitted;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProposalController extends Controller
{

    /**
     * Display a listing of proposals for a specific project (client view).
     */
    public function index(Project $project): View
    {
        // Simple authorization check
        if (Auth::id() !== $project->user_id) {
            abort(403, 'You are not authorized to view proposals for this project.');
        }

        $proposals = $project->proposals()->with('freelancer')->latest()->paginate(10);

        return view('proposals.index', compact('project', 'proposals'));
    }

    /**
     * Display a listing of proposals submitted by the authenticated developer.
     */
    public function indexDeveloper(): View
    {
        $proposals = Auth::user()->proposals()
            ->with(['project.user', 'project']) // Load project and project owner (client)
            ->latest()
            ->paginate(10);
        return view('proposals.index-developer', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function create(Project $project): View|RedirectResponse
    {
        // Simple authorization check
        if (!Auth::user()->hasRole('Developer')) {
            return redirect()->route('projects.show', $project)->withErrors('Only developers can submit proposals.');
        }

        if (Auth::id() === $project->user_id) {
            return redirect()->route('projects.show', $project)->withErrors('You cannot submit a proposal for your own project.');
        }

        if ($project->proposals()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('projects.show', $project)->withErrors('You have already submitted a proposal for this project.');
        }

        if ($project->status !== 'open') {
            return redirect()->route('projects.show', $project)->withErrors('This project is no longer open for proposals.');
        }
        
        return view('proposals.create', compact('project'));
    }

    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        // Simple authorization check
        if (!Auth::user()->hasRole('Developer')) {
            return redirect()->route('projects.show', $project)->withErrors('Only developers can submit proposals.');
        }

        if (Auth::id() === $project->user_id) {
            return redirect()->route('projects.show', $project)->withErrors('You cannot submit a proposal for your own project.');
        }

        if ($project->proposals()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('projects.show', $project)->withErrors('You have already submitted a proposal for this project.');
        }

        if ($project->status !== 'open') {
            return redirect()->route('projects.show', $project)->withErrors('This project is no longer open for proposals.');
        }

        $validated = $request->validate([
            'bid_amount' => 'required|numeric|min:1',
            'cover_letter' => 'required|string',
        ]);

        $proposal = $project->proposals()->create([
            'user_id' => Auth::id(),
            'developer_id' => Auth::id(), // Keep this for backward compatibility
            'cover_letter' => $validated['cover_letter'],
            'bid_amount' => $validated['bid_amount'],
            'status' => 'pending', // default status
        ]);

        // Send notification to the project owner
        $project->user->notify(new ProposalSubmitted($proposal, $project));

        return redirect()->route('proposals.index_developer')->with('status', 'Proposal submitted successfully!');
    }

    /**
     * Accept a proposal, update project status, and reject other proposals.
     */
    public function acceptProposal(Project $project, Proposal $proposal): RedirectResponse
    {
        // Simple authorization check
        if (Auth::id() !== $project->user_id) {
            abort(403, 'You are not authorized to manage proposals for this project.');
        }

        // check if project is still open
        if ($project->status !== 'open') {
            return back()->withErrors('This project is no longer open for proposals.');
        }

        // Mark the selected proposal as accepted
        $proposal->update(['status' => 'accepted']);

        // Mark all other proposals for this project as rejected
        $project->proposals()->where('id', '!=', $proposal->id)->update(['status' => 'rejected']);

        // Update the project status to 'in-progress'
        $project->update(['status' => 'in-progress']);

        // Create a hire record
        $project->hires()->create([
            'client_id' => $project->user_id,
            'developer_id' => $proposal->user_id,
            'project_id' => $project->id,
            'proposal_id' => $proposal->id,
            'status' => 'active'
        ]);

        return redirect()->route('projects.proposals.index', $project)->with('status', 'Proposal accepted successfully!');
    }

    /**
     * Reject a proposal for a project.
     */
    public function rejectProposal(Project $project, Proposal $proposal): RedirectResponse
    {
        // Simple authorization check
        if (Auth::id() !== $project->user_id) {
            abort(403, 'You are not authorized to manage proposals for this project.');
        }

        if ($proposal->project_id !== $project->id) {
            return back()->withErrors('The selected proposal does not belong to this project.');
        }

        // Only update if the status is not already accepted
        if ($proposal->status !== 'accepted') {
            $proposal->update(['status' => 'rejected']);
            return back()->with('status', 'Proposal rejected successfully.');
        }

        return back()->withErrors('Cannot reject an already accepted proposal.');
    }

    /**
     * Accept a proposal (route method).
     */
    public function accept(Proposal $proposal): RedirectResponse
    {
        return $this->acceptProposal($proposal->project, $proposal);
    }

    /**
     * Reject a proposal (route method).
     */
    public function reject(Proposal $proposal): RedirectResponse
    {
        return $this->rejectProposal($proposal->project, $proposal);
    }
}
