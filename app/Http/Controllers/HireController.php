<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HireController extends Controller
{
    /**
     * Display a list of the authenticated client's hired projects.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Query accepted proposals for projects created by the authenticated client
        $acceptedProposals = Proposal::whereHas('project', function ($query) {
            $query->where('user_id', Auth::id()); // Use user_id instead of client_id
        })
        ->with(['project', 'user']) // Eager load both the project and the developer (user)
        ->where('status', 'accepted')
        ->get();

        // Map the data into a structured format for the view
        $hires = $acceptedProposals->map(function ($proposal) {
            if ($proposal->project && $proposal->user) {
                return (object) [
                    'id' => $proposal->id,
                    'project_id' => $proposal->project->id,
                    'project_title' => $proposal->project->title,
                    'project_budget' => $proposal->project->budget,
                    'project_status' => $proposal->project->status,
                    'project_deadline' => $proposal->project->deadline,
                    'developer_name' => $proposal->user->name,
                    'developer_id' => $proposal->user->id,
                    'proposal_bid' => $proposal->bid_amount,
                    'proposal_created_at' => $proposal->created_at,
                    'proposal_accepted_at' => $proposal->updated_at, // When status was changed to accepted
                ];
            }
            return null;
        })->filter()->values();

        return view('my-hires', compact('hires'));
    }

    /**
     * Mark a project as completed.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsCompleted(Project $project): RedirectResponse
    {
        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            return back()->withErrors('You are not authorized to modify this project.');
        }

        // Check if the project has an accepted proposal
        if (!$project->proposals()->where('status', 'accepted')->exists()) {
            return back()->withErrors('This project does not have an accepted proposal.');
        }

        // Check if the project is currently in-progress
        if ($project->status !== 'in-progress') {
            return back()->withErrors('Only in-progress projects can be marked as completed.');
        }

        // Update the project status to completed
        $project->update(['status' => 'completed']);

        // Redirect to the review creation page
        return redirect()->route('reviews.create', $project)->with('status', 'Project marked as completed! Now please leave a review for the developer.');
    }
}
