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
    ];

    /**
     * Define the relationship: A Project belongs to a User (Client).
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Define the relationship: A Project can have many Proposals.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
