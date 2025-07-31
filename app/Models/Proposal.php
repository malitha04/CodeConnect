<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'developer_id',
        'cover_letter',
        'bid_amount',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}
