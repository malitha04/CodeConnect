<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for a developer.
     */
    public function index(User $developer): View
    {
        $reviews = $developer->reviewsReceived()
            ->with(['project', 'client'])
            ->published()
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('developer', 'reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Project $project): View|RedirectResponse
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to review this project.');
        }

        // Check if project is completed
        if ($project->status !== 'completed') {
            return redirect()->route('dashboard')->withErrors('You can only review completed projects.');
        }

        // Check if user already reviewed this project
        $existingReview = $project->reviewByClient(Auth::id());
        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview)->withErrors('You have already reviewed this project.');
        }

        // Get the developer for this project
        $developer = $project->proposals()
            ->where('status', 'accepted')
            ->first()
            ->user;

        return view('reviews.create', compact('project', 'developer'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to review this project.');
        }

        // Check if project is completed
        if ($project->status !== 'completed') {
            return redirect()->route('dashboard')->withErrors('You can only review completed projects.');
        }

        // Check if user already reviewed this project
        $existingReview = $project->reviewByClient(Auth::id());
        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview)->withErrors('You have already reviewed this project.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Get the developer for this project
        $developer = $project->proposals()
            ->where('status', 'accepted')
            ->first()
            ->user;

        Review::create([
            'project_id' => $project->id,
            'client_id' => Auth::id(),
            'developer_id' => $developer->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'published',
        ]);

        return redirect()->route('hires.index')->with('status', 'Review submitted successfully!');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review): View
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review): View|RedirectResponse
    {
        // Check if the authenticated user is the review author
        if (Auth::id() !== $review->client_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to edit this review.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        // Check if the authenticated user is the review author
        if (Auth::id() !== $review->client_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to edit this review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('reviews.show', $review)->with('status', 'Review updated successfully!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        // Check if the authenticated user is the review author
        if (Auth::id() !== $review->client_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to delete this review.');
        }

        $review->delete();

        return redirect()->route('hires.index')->with('status', 'Review deleted successfully!');
    }

    /**
     * Display reviews written by the authenticated user.
     */
    public function myReviews(): View
    {
        $reviews = Auth::user()->reviewsWritten()
            ->with(['project', 'developer'])
            ->latest()
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }

    /**
     * Display reviews received by the authenticated developer.
     */
    public function receivedReviews(): View
    {
        $reviews = Auth::user()->reviewsReceived()
            ->with(['project', 'client'])
            ->published()
            ->latest()
            ->paginate(10);

        return view('reviews.received-reviews', compact('reviews'));
    }
}
