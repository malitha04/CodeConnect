<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PageController,
    ProfileController,
    DashboardController,
    ProjectController,
    ConversationController,
    ProposalController,
    HireController,
    ReviewController,
    PaymentController,
    SettingsController,
    NotificationController,
    ProjectDeliveryController,
    AdminController
};

// 🌐 Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // 📊 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 🔍 Specific routes that need to be defined before parameter routes
    Route::get('/reviews/received', [ReviewController::class, 'receivedReviews'])->name('reviews.received');
    
    // 👑 Admin Routes
    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects.index');
        Route::get('/projects/{project}', [AdminController::class, 'showProject'])->name('projects.show');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
        Route::get('/contacts/{contact}', [AdminController::class, 'showContact'])->name('contacts.show');
    });

    // ⚙️ Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::get('/settings/password', [SettingsController::class, 'password'])->name('settings.password');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::delete('/settings/profile-picture', [SettingsController::class, 'removeProfilePicture'])->name('settings.remove-picture');

    // 🔔 Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::patch('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👤 Client Routes
    Route::middleware('role:Client')->group(function () {
        // Specific routes first to prevent parameter conflicts
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        
        Route::get('/projects/{project}/proposals', [ProjectController::class, 'showProposals'])->name('projects.proposals.index');
        Route::post('/projects/{project}/complete', [ProjectController::class, 'markAsCompleted'])->name('projects.markAsCompleted');
        
        Route::patch('/proposals/{proposal}/accept', [ProposalController::class, 'accept'])->name('proposals.accept');
        Route::patch('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');

        Route::get('/reviews/my-reviews', [ReviewController::class, 'index'])->name('reviews.my-reviews');
        Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
        Route::post('/projects/{project}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        
        Route::get('/payments/my-payments', [PaymentController::class, 'myPayments'])->name('payments.my-payments');
    });

    // 🔍 Project View (Client & Developer) - moved after specific routes
    Route::get('/projects/{project}', [ProjectController::class, 'show'])
        ->middleware('role:Client|Developer')
        ->name('projects.show');

    // 🧑‍💻 Developer Routes
    Route::middleware('role:Developer')->group(function () {
        Route::get('/browse-projects', [ProjectController::class, 'browse'])->name('projects.browse');
        
        // Specific delivery routes first
        Route::get('/projects/{project}/deliveries/create', [ProjectDeliveryController::class, 'create'])->name('deliveries.create');
        Route::resource('deliveries', ProjectDeliveryController::class)->except(['create']);
        Route::post('/projects/{project}/deliveries', [ProjectDeliveryController::class, 'store'])->name('deliveries.store');
        
        Route::get('/projects/{project}/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
        Route::post('/projects/{project}/proposals', [ProposalController::class, 'store'])->name('proposals.store');
        Route::get('/my-proposals', [ProposalController::class, 'indexDeveloper'])->name('proposals.index_developer');


        Route::get('/payments/received', [PaymentController::class, 'index'])->name('payments.received');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::patch('/payments/{payment}/mark-completed', [PaymentController::class, 'markAsCompleted'])->name('payments.markAsCompleted');
    });

    // 📦 Delivery Routes (Client & Developer Access)
    Route::middleware('role:Client|Developer')->group(function () {
        Route::get('/deliveries/{delivery}', [ProjectDeliveryController::class, 'show'])->name('deliveries.show');
        Route::get('/deliveries/{delivery}/download', [ProjectDeliveryController::class, 'download'])->name('deliveries.download');
        Route::patch('/deliveries/{delivery}/status', [ProjectDeliveryController::class, 'updateStatus'])->name('deliveries.updateStatus');
    });

    // 💬 General Authenticated Routes
    Route::get('/inbox', [ConversationController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/start', [ConversationController::class, 'create'])->name('inbox.start');
    Route::post('/inbox/start', [ConversationController::class, 'store'])->name('inbox.start');
    Route::post('/inbox', [ConversationController::class, 'store'])->name('inbox.store');
    Route::get('/inbox/{conversation}', [ConversationController::class, 'show'])->name('inbox.show');
    Route::post('/inbox/{conversation}', [ConversationController::class, 'sendMessage'])->name('inbox.sendMessage');
    Route::delete('/inbox/{conversation}', [ConversationController::class, 'destroy'])->name('inbox.destroy');
    
    Route::get('/my-hires', [HireController::class, 'index'])->name('hires.index');
    Route::get('/my-hires/{hire}', [HireController::class, 'show'])->name('hires.show');
});

// 🔑 Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
