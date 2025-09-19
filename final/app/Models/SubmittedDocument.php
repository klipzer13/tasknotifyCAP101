<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmittedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'required_document_id',
        'user_id',
        'filename',
        'path',
        'mime_type',
        'size',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'rejection_count'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
    
    public function requiredDocument(): BelongsTo
    {
        return $this->belongsTo(RequiredDocument::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    
    public function rejectionHistory(): HasMany
    {
        return $this->hasMany(DocumentRejectionHistory::class);
    }
    
    // Helper method to reject a document
    public function reject($reason, $rejectedById)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'reviewed_by' => $rejectedById,
            'reviewed_at' => now(),
            'rejection_count' => $this->rejection_count + 1
        ]);
        
        // Record in rejection history
        DocumentRejectionHistory::create([
            'submitted_document_id' => $this->id,
            'reason' => $reason,
            'rejected_by' => $rejectedById,
            'rejected_at' => now(),
            'revision_number' => $this->rejection_count
        ]);
    }
    
    // Helper method to approve a document
    public function approve($approvedById)
    {
        $this->update([
            'status' => 'approved',
            'rejection_reason' => null,
            'reviewed_by' => $approvedById,
            'reviewed_at' => now()
        ]);
    }
    public function rejectionHistories()
    {
        return $this->hasMany(DocumentRejectionHistory::class, 'submitted_document_id');
    }

    /**
     * Get the latest rejection history for the submitted document.
     */
    public function latestRejection()
    {
        return $this->hasOne(DocumentRejectionHistory::class, 'submitted_document_id')
            ->latest('rejected_at');
    }

    /**
     * Check if the document has been rejected before.
     */
    public function hasRejectionHistory()
    {
        return $this->rejectionHistories()->exists();
    }

    /**
     * Get the total number of rejections for this document.
     */
    public function getTotalRejectionsAttribute()
    {
        return $this->rejectionHistories()->count();
    }
}