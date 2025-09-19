<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRejectionHistory extends Model
{
    use HasFactory;

    protected $table = 'rejection_history';

    protected $fillable = [
        'submitted_document_id',
        'reason',
        'rejected_by',
        'rejected_at',
        'revision_number'
    ];

    protected $casts = [
        'rejected_at' => 'datetime',
    ];

    public function submittedDocument(): BelongsTo
    {
        return $this->belongsTo(SubmittedDocument::class);
    }
    
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}