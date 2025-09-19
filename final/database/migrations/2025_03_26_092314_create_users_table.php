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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('email_verification_token', 255)->nullable();
            $table->string('password', 255);
            $table->string('username', 50)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('avatar', 255)->nullable()->default('profile/avatar/profile.png');
            $table->enum('status', ['active', 'inactive'])->default('active');
            // Foreign Keys
            $table->unsignedBigInteger('role_id'); 
            $table->unsignedBigInteger('department_id');

            // Define foreign key constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->boolean('default_password')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

