<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Task Notifications (boolean columns)
            $table->boolean('task_assigned')->default(true);
            $table->boolean('task_updated')->default(true);
            $table->boolean('due_date_reminder')->default(true);

            // Notification Methods (boolean columns)
            $table->boolean('email')->default(true);
            $table->boolean('sms')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
