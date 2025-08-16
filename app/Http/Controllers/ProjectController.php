<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the projects for the authenticated client.
     */
    public function index(): View
    {
        $projects = Auth::user()->projects()->withCount('proposals')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'budget' => 'required|numeric|min:1',
            'duration' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
        ]);

        Auth::user()->projects()->create($validated);

        return redirect(route('projects.index'))->with('status', 'Project created successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        // Policy authorization is handled at the route level to allow both clients and developers
        return view('projects.show', compact('project'));
    }
    
    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'budget' => 'required|numeric|min:1',
            'duration' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('status', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('status', 'Project deleted successfully!');
    }

    /**
     * Display the proposals for a given project.
     */
    public function showProposals(Project $project): View
    {
        $this->authorize('manage-proposals', $project);

        $proposals = $project->proposals()->with('user')->latest()->get();

        return view('projects.proposals.index', compact('project', 'proposals'));
    }

    /**
     * Display a listing of projects for developers to browse.
     */
    public function browse(): View
    {
        $projects = Project::where('status', 'open')->latest()->paginate(10);
        return view('projects.browse', compact('projects'));
    }
    
    /**
     * Mark a proposal as accepted and update project status.
     */
    public function acceptProposal(Project $project, Proposal $proposal): RedirectResponse
    {
        $this->authorize('manage-proposals', $project);

        if ($proposal->project_id !== $project->id) {
            return back()->withErrors('The selected proposal does not belong to this project.');
        }

        // Check if the project is still open
        if ($project->status !== 'open') {
            return back()->withErrors('This project is no longer open for proposals.');
        }

        // Mark the selected proposal as accepted
        $proposal->update(['status' => 'accepted']);

        // Mark all other proposals for this project as rejected
        $project->proposals()->where('id', '!=', $proposal->id)->update(['status' => 'rejected']);

        // Update the project status to 'in-progress'
        $project->update(['status' => 'in-progress']);

        // Log the hiring event (e.g., send notifications, create a hire record)
        // You can add your logic here

        return redirect()->route('projects.proposals.index', $project)->with('status', 'Proposal accepted successfully!');
    }

    /**
     * Reject a proposal for a project.
     */
    public function rejectProposal(Project $project, Proposal $proposal): RedirectResponse
    {
        $this->authorize('manage-proposals', $project);

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
}
