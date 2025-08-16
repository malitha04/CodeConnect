<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProposalPolicy
{
    /**
     * Determine whether the user can create proposals.
     */
    public function createProposal(User $user, Project $project): Response
    {
        // A user can create a proposal if they are a developer
        // and they are not the client who created the project.
        if (!$user->hasRole('Developer')) {
            return Response::deny('Only developers can submit proposals.');
        }

        if ($user->id === $project->user_id) {
            return Response::deny('You cannot submit a proposal for your own project.');
        }

        // Check if the user has already submitted a proposal for this project
        if ($project->proposals()->where('user_id', $user->id)->exists()) {
            return Response::deny('You have already submitted a proposal for this project.');
        }

        // Check if the project is still open for proposals
        if ($project->status !== 'open') {
            return Response::deny('This project is no longer open for proposals.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can view the proposal.
     */
    public function view(User $user, Proposal $proposal): Response
    {
        // A user can view a proposal if they are the project's client or the developer who submitted it.
        if ($user->id === $proposal->project->user_id || $user->id === $proposal->user_id) {
            return Response::allow();
        }

        return Response::deny('You are not authorized to view this proposal.');
    }

    // Add other policy methods here as needed
}
