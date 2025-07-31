<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProposalController extends Controller
{
    /**
     * Display a listing of the proposals for a specific project.
     */
    public function index(Project $project): View
    {
        // Ensure the logged-in user owns the project before showing proposals
        if ($project->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('proposals.index', ['project' => $project]);
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function create(Project $project): View
    {
        return view('proposals.create', ['project' => $project]);
    }

    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        // Check if the developer has already submitted a proposal for this project
        $existingProposal = $project->proposals()->where('developer_id', Auth::id())->exists();
        if ($existingProposal) {
            return back()->withErrors(['general' => 'You have already submitted a proposal for this project.']);
        }

        $project->proposals()->create([
            'developer_id' => Auth::id(),
            'cover_letter' => $validated['cover_letter'],
            'bid_amount' => $validated['bid_amount'],
        ]);

        return redirect()->route('projects.browse')->with('success', 'Your proposal has been submitted successfully!');
    }
}
