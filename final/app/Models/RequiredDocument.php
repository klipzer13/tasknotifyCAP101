<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequiredDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'name',
        'type',
        'description',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
    
    public function submittedDocuments(): HasMany
    {
        return $this->hasMany(SubmittedDocument::class);
    }
}