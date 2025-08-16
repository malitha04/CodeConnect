<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cover_letter',
        'bid_amount',
        'status',
        'project_id',
        'user_id',
        'developer_id'
    ];

    /**
     * Get the project that the proposal belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user (developer) that made the proposal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the freelancer (developer) that made the proposal.
     * This is kept for backward compatibility.
     */
    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Get the client of the project.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project.user_id');
    }
}
