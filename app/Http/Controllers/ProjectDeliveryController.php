<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDelivery;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectDeliveryController extends Controller
{
    /**
     * Display a listing of deliveries for a developer.
     */
    public function index(): View
    {
        $deliveries = Auth::user()->deliveries()
            ->with(['project.user'])
            ->latest()
            ->paginate(10);

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new delivery.
     */
    public function create(Project $project): View|RedirectResponse
    {
        // Check if the authenticated user is the developer assigned to this project
        $acceptedProposal = $project->proposals()
            ->where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->first();

        if (!$acceptedProposal) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to deliver this project.');
        }

        return view('deliveries.create', compact('project'));
    }

    /**
     * Store a newly created delivery in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        // Check if the authenticated user is the developer assigned to this project
        $acceptedProposal = $project->proposals()
            ->where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->first();

        if (!$acceptedProposal) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to deliver this project.');
        }

        $validated = $request->validate([
            'delivery_type' => 'required|in:file,github,other',
            'description' => 'required|string|max:1000',
            'project_file' => 'required_if:delivery_type,file|file|max:10240', // 10MB max
            'github_link' => 'required_if:delivery_type,github|url|nullable',
            'other_link' => 'required_if:delivery_type,other|url|nullable',
        ]);

        $deliveryData = [
            'project_id' => $project->id,
            'developer_id' => Auth::id(),
            'delivery_type' => $validated['delivery_type'],
            'description' => $validated['description'],
        ];

        // Handle file upload
        if ($request->delivery_type === 'file' && $request->hasFile('project_file')) {
            $file = $request->file('project_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('project-deliveries', $fileName, 'public');
            $deliveryData['file_path'] = $filePath;
        }

        // Handle GitHub link
        if ($request->delivery_type === 'github') {
            $deliveryData['github_link'] = $validated['github_link'];
        }

        // Handle other link
        if ($request->delivery_type === 'other') {
            $deliveryData['other_link'] = $validated['other_link'];
        }

        ProjectDelivery::create($deliveryData);

        return redirect()->route('deliveries.index')->with('status', 'Project delivery submitted successfully!');
    }

    /**
     * Display the specified delivery.
     */
    public function show(ProjectDelivery $delivery): View
    {
        // Check if user is authorized to view this delivery
        if (Auth::id() !== $delivery->developer_id && Auth::id() !== $delivery->project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('deliveries.show', compact('delivery'));
    }

    /**
     * Download the project file.
     */
    public function download(ProjectDelivery $delivery): RedirectResponse
    {
        // Check if user is authorized to download this delivery
        if (Auth::id() !== $delivery->developer_id && Auth::id() !== $delivery->project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($delivery->delivery_type !== 'file' || !$delivery->file_path) {
            return back()->withErrors('No file available for download.');
        }

        if (!Storage::disk('public')->exists($delivery->file_path)) {
            return back()->withErrors('File not found.');
        }

        return Storage::disk('public')->download($delivery->file_path);
    }

    /**
     * Display deliveries for a specific project (client view).
     */
    public function projectDeliveries(Project $project): View
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $deliveries = $project->deliveries()
            ->with('developer')
            ->latest()
            ->paginate(10);

        return view('deliveries.project-deliveries', compact('project', 'deliveries'));
    }

    /**
     * Update delivery status (approve/reject) by client.
     */
    public function updateStatus(Request $request, ProjectDelivery $delivery): RedirectResponse
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $delivery->project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'client_feedback' => 'nullable|string|max:1000',
        ]);

        $delivery->update([
            'status' => $validated['status'],
            'client_feedback' => $validated['client_feedback'] ?? null,
        ]);

        $statusMessage = $validated['status'] === 'approved' ? 'Delivery approved!' : 'Delivery rejected.';
        return back()->with('status', $statusMessage);
    }
}
