<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any projects.
     */
    public function viewAny(User $user)
    {
        // This policy allows any authenticated user to see the projects index,
        // but the query in the controller will scope it to their own projects.
        return true;
    }

    /**
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project)
    {
        // A client can view a project if they own it.
        // A developer can view a project if it is 'open'.
        return $user->hasRole('Client') && $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can create projects.
     */
    public function create(User $user)
    {
        return $user->hasRole('Client');
    }

    /**
     * Determine whether the user can update the project.
     */
    public function update(User $user, Project $project)
    {
        // Only the client who owns the project can update it.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(User $user, Project $project)
    {
        // Only the client who owns the project can delete it.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can restore the project.
     */
    public function restore(User $user, Project $project)
    {
        // This is a default policy method, you can adjust as needed.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can permanently delete the project.
     */
    public function forceDelete(User $user, Project $project)
    {
        // This is a default policy method, you can adjust as needed.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the client can view proposals for their project.
     */
    public function showProposals(User $user, Project $project)
    {
        // Only the client who owns the project can view its proposals.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the client can manage proposals for their project.
     */
    public function manageProposals(User $user, Project $project)
    {
        // Only the client who owns the project can manage its proposals.
        return $user->id === $project->user_id;
    }
}
