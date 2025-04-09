<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'department'])->paginate(10);
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.members', compact('users', 'roles', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('profile/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;
        } else {
            $validated['avatar'] = 'storage/profile/avatars/profile.png';
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return response()->json(['success' => true, 'message' => 'User created successfully']);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->load(['role', 'department']),
            'avatar_url' => asset($user->avatar)
        ]);
    }

    public function edit(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user,
            'avatar_url' => asset($user->avatar)
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it's not the default one
            if ($user->avatar && $user->avatar !== 'storage/profile/avatars/profile.png') {
                Storage::delete(str_replace('storage/', 'public/', $user->avatar));
            }

            $path = $request->file('avatar')->store('profile/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }

    // app/Http/Controllers/UserController.php

    public function destroy(User $user)
    {
        // Don't delete the avatar if it's the default one
        if ($user->avatar && $user->avatar !== 'storage/profile/avatars/profile.png') {
            Storage::delete(str_replace('storage/', 'public/', $user->avatar));
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
}