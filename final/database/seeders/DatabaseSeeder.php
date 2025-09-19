<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Department;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Priorities
        Priority::create(['name' => 'high']);
        Priority::create(['name' => 'medium']);
        Priority::create(['name' => 'low']);

        $statuses = [
            ['name' => 'pending'],
            ['name' => 'in_progress'],
            ['name' => 'pending_approval'],
            ['name' => 'completed'],
            ['name' => 'rejected'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator'],
            ['name' => 'Chairperson', 'description' => 'Department Manager'],
            ['name' => 'Employee', 'description' => 'Regular Member'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
        $departments = [
            ['name' => 'N/A', 'description' => 'Not Assigned'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin12345'),
            'username' => 'admin',
            'role_id' => '1',
            'department_id' => '1',
            'phone' => '1234567890',
            'default_password' => 0,
            'avatar' => 'storage/profile/avatars/profile.png'
        ]);


    }
}
