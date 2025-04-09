<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAuditLog extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'action', 'old_data', 'new_data', 'description'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}