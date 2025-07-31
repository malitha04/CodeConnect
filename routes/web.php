<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProposalController;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Project routes for Clients (CRUD)
    Route::resource('projects', ProjectController::class)->middleware('role:Client');

    // Route for Clients to view proposals for a specific project
    // This was added in the previous step and is kept here.
    Route::get('/projects/{project}/proposals', [ProjectController::class, 'showProposals'])
        ->middleware('role:Client')
        ->name('projects.proposals.index');

    // Route for Developers to browse projects
    Route::get('/browse-projects', [ProjectController::class, 'browse'])
        ->middleware('role:Developer')
        ->name('projects.browse');

    // Routes for Proposals (for Developers)
    Route::middleware('role:Developer')->group(function () {
        Route::get('/projects/{project}/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
        Route::post('/projects/{project}/proposals', [ProposalController::class, 'store'])->name('proposals.store');

        // NEW: Route for Developers to view their submitted proposals
        Route::get('/my-proposals', [ProposalController::class, 'indexDeveloper'])
            ->name('proposals.index_developer');
    });

    // Route for Inbox/Messages
    Route::get('/inbox', [ConversationController::class, 'index'])->name('inbox.index');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
