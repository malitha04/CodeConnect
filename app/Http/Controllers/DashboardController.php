<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Conversation;
use App\Models\Hire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        // Check if the user has an 'Admin' role
        if ($user->hasRole('Admin')) {
            // Redirect admin users to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // Check if the user has a 'Client' role
        if ($user->hasRole('Client')) {
            // Get real data for client dashboard
            $projects = $user->projects()->latest()->take(5)->get();
            $myProjectsCount = $user->projects()->count();
            $openProjectsCount = $user->projects()->where('status', 'open')->count();
            $inProgressHires = $user->projects()->where('status', 'in_progress')->count();
            
            // Get active hires (projects with accepted proposals)
            $activeHires = Project::where('user_id', $user->id)
                ->whereHas('proposals', function($query) {
                    $query->where('status', 'accepted');
                })
                ->whereIn('status', ['in_progress', 'review', 'completed'])
                ->with(['proposals' => function($query) {
                    $query->where('status', 'accepted')->with('user');
                }])
                ->latest()
                ->take(3)
                ->get();

            // Get recent proposals for client's projects
            $recentProposals = Proposal::whereHas('project', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['project', 'user'])
            ->latest()
            ->take(3)
            ->get();

            // Calculate total spent
            $totalSpent = Payment::where('client_id', $user->id)
                ->where('status', 'completed')
                ->sum('amount');

            // Get this month's spending
            $thisMonthSpending = Payment::where('client_id', $user->id)
                ->where('status', 'completed')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount');

            // Get pending payments
            $pendingPayments = Payment::where('client_id', $user->id)
                ->whereIn('status', ['pending', 'processing'])
                ->with(['project', 'developer'])
                ->latest()
                ->take(3)
                ->get();

            // Get recent messages
            $recentMessages = Conversation::where(function($query) use ($user) {
                $query->where('user_one', $user->id)
                      ->orWhere('user_two', $user->id);
            })
            ->with(['messages' => function($query) {
                $query->latest()->take(1);
            }, 'userOne', 'userTwo'])
            ->whereHas('messages')
            ->latest()
            ->take(3)
            ->get();

            // Get projects needing attention (recent proposals, approaching deadlines)
            $projectsNeedingAttention = Project::where('user_id', $user->id)
                ->where(function($query) {
                    $query->where('status', 'open')
                          ->orWhere(function($q) {
                              $q->whereIn('status', ['in_progress', 'review'])
                                ->where('deadline', '<=', now()->addDays(7));
                          });
                })
                ->with(['proposals' => function($query) {
                    $query->latest()->take(3);
                }])
                ->latest()
                ->take(3)
                ->get();

            return view('dashboard-client', compact(
                'projects', 
                'myProjectsCount', 
                'openProjectsCount', 
                'inProgressHires',
                'activeHires',
                'recentProposals',
                'totalSpent',
                'thisMonthSpending',
                'pendingPayments',
                'recentMessages',
                'projectsNeedingAttention'
            ));
        }

        // Check if the user has a 'Developer' role
        if ($user->hasRole('Developer')) {
            // Get real data for developer dashboard
            $proposalsCount = $user->proposals()->count();
            $acceptedProposalsCount = $user->proposals()->where('status', 'accepted')->count();
            
            // Get active projects (projects where developer has accepted proposals)
            $activeProjects = Project::whereHas('proposals', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', 'accepted');
            })->whereIn('status', ['in_progress', 'review'])
              ->with(['proposals' => function($query) use ($user) {
                  $query->where('user_id', $user->id)->where('status', 'accepted');
              }])
              ->latest()
              ->take(3)
              ->get();

            // Get recent proposals
            $recentProposals = $user->proposals()
                ->with('project')
                ->latest()
                ->take(2)
                ->get();

            // Calculate earnings
            $thisMonthEarnings = Payment::where('developer_id', $user->id)
                ->where('status', 'completed')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount');

            // Get average rating
            $averageRating = $user->reviewsReceived()
                ->where('status', 'published')
                ->avg('rating') ?? 0;

            // Get recent messages
            $recentMessages = Conversation::where(function($query) use ($user) {
                $query->where('user_one', $user->id)
                      ->orWhere('user_two', $user->id);
            })
            ->with(['messages' => function($query) {
                $query->latest()->take(1);
            }, 'userOne', 'userTwo'])
            ->whereHas('messages')
            ->latest()
            ->take(3)
            ->get();

            // Get upcoming deadlines
            $upcomingDeadlines = Project::whereHas('proposals', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', 'accepted');
            })->whereIn('status', ['in_progress', 'review'])
              ->where('deadline', '>=', now())
              ->where('deadline', '<=', now()->addDays(14))
              ->orderBy('deadline')
              ->take(3)
              ->get();

            return view('dashboard-developer', compact(
                'proposalsCount', 
                'acceptedProposalsCount',
                'activeProjects',
                'recentProposals',
                'thisMonthEarnings',
                'averageRating',
                'recentMessages',
                'upcomingDeadlines'
            ));
        }

        // Default view for users without a specific role
        return view('dashboard');
    }

    /**
     * Display a listing of hires for the authenticated client.
     */
    public function hires(): View
    {
        // This is where you would fetch and pass the hires to the view.
        // For now, it will simply return an empty view.
        // The hires page will be built in a future step.
        return view('hires.index');
    }
}
