<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssuePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'filename',
        'path',
        'size',
    ];

    // Relationship: Photo belongs to an issue
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    // Helper to get the full URL
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
