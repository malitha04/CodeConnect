<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the projects for the client.
     */
    public function projects(): HasMany
    {
        // Assuming 'user_id' is the foreign key on the projects table
        return $this->hasMany(Project::class);
    }

    /**
     * Get the proposals for the developer.
     * This is the relationship the DashboardController needs.
     */
    public function proposals(): HasMany
    {
        // 'user_id' is the foreign key on the proposals table
        return $this->hasMany(Proposal::class);
    }

    /**
     * Get conversations where the user is user_one
     */
    public function conversationsAsUserOne(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_one');
    }

    /**
     * Get conversations where the user is user_two
     */
    public function conversationsAsUserTwo(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_two');
    }

    /**
     * Get all conversations for the user
     */
    public function conversations()
    {
        return $this->conversationsAsUserOne()->union($this->conversationsAsUserTwo()->toBase());
    }

    /**
     * Get all conversations with proper eager loading
     */
    public function getAllConversations()
    {
        $userOneConversations = $this->conversationsAsUserOne()->with(['messages', 'userTwo']);
        $userTwoConversations = $this->conversationsAsUserTwo()->with(['messages', 'userOne']);
        
        return $userOneConversations->get()->concat($userTwoConversations->get());
    }

    /**
     * Get the deliveries made by the developer.
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(ProjectDelivery::class, 'developer_id');
    }

    /**
     * Get the reviews written by the user (as client).
     */
    public function reviewsWritten(): HasMany
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    /**
     * Get the reviews received by the user (as developer).
     */
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'developer_id');
    }

    /**
     * Get the average rating for the developer.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviewsReceived()->published()->avg('rating') ?? 0;
    }

    /**
     * Get the total number of reviews for the developer.
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviewsReceived()->published()->count();
    }

    /**
     * Get the payments made by the user (as client).
     */
    public function paymentsMade(): HasMany
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    /**
     * Get the payments received by the user (as developer).
     */
    public function paymentsReceived(): HasMany
    {
        return $this->hasMany(Payment::class, 'developer_id');
    }

    /**
     * Get the total earnings for the developer.
     */
    public function getTotalEarningsAttribute()
    {
        return $this->paymentsReceived()->completed()->sum('amount');
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return null to indicate no profile picture (will use CSS fallback)
        return null;
    }

    /**
     * Get the profile picture URL for small avatars.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return null to indicate no profile picture (will use CSS fallback)
        return null;
    }

    /**
     * Get the user's initial for avatar fallback.
     */
    public function getInitialAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}
