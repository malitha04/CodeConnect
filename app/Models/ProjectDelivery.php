<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDelivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'developer_id',
        'delivery_type',
        'file_path',
        'github_link',
        'other_link',
        'description',
        'status',
        'client_feedback'
    ];

    /**
     * Get the project that the delivery belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the developer that made the delivery.
     */
    public function developer(): BelongsTo
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
