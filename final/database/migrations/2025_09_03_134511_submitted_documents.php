<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submitted_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('required_document_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->integer('rejection_count')->default(0);
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['task_id', 'user_id']);
            $table->index(['status', 'reviewed_at']);
        });
        
        // Create a table to track document rejection history
        Schema::create('rejection_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitted_document_id')->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->foreignId('rejected_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('rejected_at');
            $table->integer('revision_number');
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['submitted_document_id', 'revision_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejection_history');
        Schema::dropIfExists('submitted_documents');
    }
};