<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'budget',
        'duration',
        'skills',
        'deadline',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client that owns the project.
     * This is kept for backward compatibility.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the proposals for the project.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Get the deliveries for the project.
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(ProjectDelivery::class);
    }

    /**
     * Get the reviews for the project.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the hires for the project.
     */
    public function hires(): HasMany
    {
        return $this->hasMany(Hire::class);
    }

    /**
     * Get the review for this project by a specific client.
     */
    public function reviewByClient($clientId)
    {
        return $this->reviews()->where('client_id', $clientId)->first();
    }

    /**
     * Get the payments for this project.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the payment for this project.
     * This is kept for backward compatibility.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Check if the project has been paid for.
     */
    public function isPaid(): bool
    {
        return $this->payment && $this->payment->status === 'completed';
    }
}
