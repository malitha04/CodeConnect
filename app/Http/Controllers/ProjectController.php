<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    // ... index, create, store methods remain the same ...

    /**
     * Display a listing of all open projects for developers to browse.
     */
    public function browse(Request $request): View
    {
        // Start with a query for open projects
        $query = Project::where('status', 'open');

        // If a search term is provided, filter by title or description
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        // If a category is selected, filter by that category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Get the filtered projects, ordered by newest first, and paginate
        $projects = $query->latest()->paginate(10)->withQueryString();

        return view('projects.browse', [
            'projects' => $projects
        ]);
    }

    // ... show, edit, update, destroy methods remain the same ...
    
    /**
     * Display a listing of the client's own projects.
     */
    public function index(): View
    {
        $projects = Auth::user()->projects()->latest()->paginate(10);
        return view('projects.index', ['projects' => $projects]);
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
            'description' => 'required|string|min:50',
            'category' => 'required|string',
            'budget' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'skills' => 'nullable|string',
        ]);

        Auth::user()->projects()->create($validated);
        return redirect()->route('projects.index')->with('success', 'Project posted successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        if ($project->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        if ($project->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'category' => 'required|string',
            'budget' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'skills' => 'nullable|string',
        ]);
        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        if ($project->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
