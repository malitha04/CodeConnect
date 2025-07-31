<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Developer')) {
            return view('dashboard-developer');
        }

        if ($user->hasRole('Client')) {
            // Get the 3 most recent projects for the logged-in client
            $projects = $user->projects()->latest()->take(3)->get();

            // Pass the projects to the client dashboard view
            return view('dashboard-client', [
                'projects' => $projects
            ]);
        }
        
        if ($user->hasRole('Admin')) {
            // You can create a dashboard-admin.blade.php view for this
            return view('dashboard-admin');
        }

        // Fallback for any other case
        return redirect('/');
    }
}
