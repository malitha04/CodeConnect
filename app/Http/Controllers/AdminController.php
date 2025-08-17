<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Proposal;
use App\Models\Review;
use App\Models\Conversation;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $activeProjects = Project::whereIn('status', ['open', 'in_progress', 'review'])->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        
        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('user')->latest()->take(5)->get();
        $recentPayments = Payment::with(['project', 'client', 'developer'])
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        $clientsCount = User::role('Client')->count();
        $developersCount = User::role('Developer')->count();
        $adminsCount = User::role('Admin')->count();
        
        // Contact statistics
        $totalContacts = Contact::count();
        $unreadContacts = Contact::unread()->count();
        $readContacts = Contact::read()->count();
        $repliedContacts = Contact::replied()->count();
        $recentContacts = Contact::latest()->take(5)->get();

        // Get recent activity
        $recentActivity = collect();
        
        $recentUsers->each(function($user) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'user_registration',
                'title' => 'New user registered: ' . $user->name,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'fas fa-user-plus',
                'color' => 'accent-green'
            ]);
        });
        
        $recentProjects->each(function($project) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'project_posted',
                'title' => 'New project posted: ' . $project->title,
                'time' => $project->created_at->diffForHumans(),
                'icon' => 'fas fa-project-diagram',
                'color' => 'accent-blue'
            ]);
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'totalRevenue',
            'recentUsers',
            'recentProjects',
            'recentPayments',
            'clientsCount',
            'developersCount',
            'adminsCount',
            'recentActivity',
            'totalContacts',
            'unreadContacts',
            'readContacts',
            'repliedContacts',
            'recentContacts'
        ));
    }

    /**
     * Display all users with pagination and search
     */
    public function users(Request $request)
    {
        $query = User::with('roles');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->role($request->role);
        }
        
        $users = $query->latest()->paginate(10);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        $user->load(['projects', 'proposals', 'reviewsWritten', 'reviewsReceived', 'paymentsMade', 'paymentsReceived']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show user edit form
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
        ]);

        DB::transaction(function() use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update role
            $user->syncRoles([$request->role]);
        });

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        DB::transaction(function() use ($user) {
            // Delete related data
            $user->projects()->delete();
            $user->proposals()->delete();
            $user->reviewsWritten()->delete();
            $user->reviewsReceived()->delete();
            $user->paymentsMade()->delete();
            $user->paymentsReceived()->delete();
            
            // Delete conversations
            Conversation::where('user_one', $user->id)->orWhere('user_two', $user->id)->delete();
            
            // Delete user
            $user->delete();
        });

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display all projects with pagination and search
     */
    public function projects(Request $request)
    {
        $query = Project::with(['user', 'proposals']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $projects = $query->latest()->paginate(10);
        
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show project details
     */
    public function showProject(Project $project)
    {
        $project->load(['user', 'proposals.user', 'reviews', 'payments']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Delete project
     */
    public function deleteProject(Project $project)
    {
        DB::transaction(function() use ($project) {
            // Delete related data
            $project->proposals()->delete();
            $project->reviews()->delete();
            $project->payments()->delete();
            $project->deliveries()->delete();
            
            // Delete project
            $project->delete();
        });

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        // Revenue data for charts
        $monthlyRevenue = Payment::where('status', 'completed')
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // User registration data
        $monthlyUsers = User::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Recent transactions
        $recentTransactions = Payment::with(['project', 'client', 'developer'])
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenue[$i])) {
                $monthlyRevenue[$i] = 0;
            }
            if (!isset($monthlyUsers[$i])) {
                $monthlyUsers[$i] = 0;
            }
        }

        ksort($monthlyRevenue);
        ksort($monthlyUsers);

        // Prepare data for charts
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $revenueData = [
            'labels' => $months,
            'data' => array_values($monthlyRevenue)
        ];
        
        $usersData = [
            'labels' => $months,
            'data' => array_values($monthlyUsers)
        ];

        return view('admin.reports', compact('revenueData', 'usersData', 'recentTransactions'));
    }

    /**
     * Get system statistics for AJAX requests
     */
    public function getStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::whereIn('status', ['open', 'in_progress', 'review'])->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'clients_count' => User::role('Client')->count(),
            'developers_count' => User::role('Developer')->count(),
            'admins_count' => User::role('Admin')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Display contact messages
     */
    public function contacts()
    {
        $contacts = Contact::latest()->paginate(10);
        
        // Calculate statistics for the view
        $stats = [
            'total' => Contact::count(),
            'unread' => Contact::unread()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
        ];
        
        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Show specific contact message
     */
    public function showContact(Contact $contact)
    {
        // Mark as read when viewed
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark contact as read
     */
    public function markContactAsRead(Contact $contact)
    {
        $contact->update(['status' => 'read']);
        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Delete contact message
     */
    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Message deleted successfully.');
    }

    /**
     * Reply to contact message
     */
    public function replyToContact(Request $request, Contact $contact)
    {
        $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $contact->update([
            'status' => 'replied',
            'admin_reply' => $request->reply,
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Export users data as CSV
     */
    public function exportUsers()
    {
        $users = User::with('roles')->get();
        
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Role',
                'Email Verified',
                'Registration Date',
                'Last Updated',
                'Total Projects',
                'Total Proposals',
                'Total Reviews Given',
                'Total Reviews Received',
                'Total Payments Made',
                'Total Payments Received'
            ]);
            
            // Add user data
            foreach ($users as $user) {
                $role = $user->roles->first() ? $user->roles->first()->name : 'No Role';
                
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $role,
                    $user->email_verified_at ? 'Yes' : 'No',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s'),
                    $user->projects()->count(),
                    $user->proposals()->count(),
                    $user->reviewsWritten()->count(),
                    $user->reviewsReceived()->count(),
                    $user->paymentsMade()->count(),
                    $user->paymentsReceived()->count()
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export projects data as CSV
     */
    public function exportProjects()
    {
        $projects = Project::with(['user', 'proposals'])->get();

        $filename = 'projects_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($projects) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID',
                'Title',
                'Client',
                'Budget',
                'Status',
                'Proposals Count',
                'Created At',
                'Updated At'
            ]);

            foreach ($projects as $project) {
                fputcsv($file, [
                    $project->id,
                    $project->title,
                    optional($project->user)->name,
                    $project->budget,
                    $project->status,
                    $project->proposals->count(),
                    $project->created_at->format('Y-m-d H:i:s'),
                    $project->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export contact messages as CSV
     */
    public function exportContacts()
    {
        $contacts = Contact::all();

        $filename = 'contacts_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Subject',
                'Message',
                'Status',
                'Created At',
                'Replied At'
            ]);

            foreach ($contacts as $c) {
                fputcsv($file, [
                    $c->id,
                    $c->name,
                    $c->email,
                    $c->subject,
                    $c->message,
                    $c->status,
                    optional($c->created_at)->format('Y-m-d H:i:s'),
                    optional($c->replied_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export recent transactions (payments) as CSV
     */
    public function exportTransactions()
    {
        $payments = Payment::with(['project', 'client', 'developer'])->orderByDesc('created_at')->get();

        $filename = 'transactions_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Transaction ID',
                'Project',
                'Client',
                'Developer',
                'Amount',
                'Status',
                'Paid At',
                'Created At'
            ]);

            foreach ($payments as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->transaction_id,
                    optional($p->project)->title,
                    optional($p->client)->name,
                    optional($p->developer)->name,
                    $p->amount,
                    $p->status,
                    optional($p->paid_at)->format('Y-m-d H:i:s'),
                    optional($p->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display admin settings page
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
