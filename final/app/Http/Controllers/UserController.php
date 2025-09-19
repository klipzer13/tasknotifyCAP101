<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;
use App\Mail\WelcomeToTaskNotify;

class UserController extends Controller
{
    public function index()
    {
        $authUserId = Auth::id();
        $users = User::with(['role', 'department'])
            ->where('id', '!=', $authUserId)
            ->paginate(10);
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.members', compact('users', 'roles', 'departments'));
    }
    public function viewpassword()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to change your password.');
        }
        return view('change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->default_password = 0;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
            'role_id' => $user->role->id // Add this line
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['role_id'] = 3;
        $validated['department_id'] = 1;

        $validated['password'] = Str::random(10);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('profile/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;
        } else {
            $validated['avatar'] = 'storage/profile/avatars/profile.png';
        }

        $validated['password'] = Hash::make($validated['password']);
        $passwordPlain = Str::random(10);
        $validated['password'] = Hash::make($passwordPlain);
        $user = User::create($validated);
        Mail::to($user->email)->queue(new WelcomeToTaskNotify($user, $passwordPlain));


        // Log who is creating and who is being created
        // $createdBy = Auth::check() ? Auth::user()->name . ' (ID: ' . Auth::user()->id . ')' : 'Unknown';
        // $createdUser = $user->name . ' (ID: ' . $user->id . ')';
        // Log::info("User '{$createdBy}' created user '{$createdUser}'.");

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
            'role_id' => 'exists:roles,id',
            'department_id' => 'exists:departments,id',
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

        // Log who is updating and who is being updated
        $updatedBy = Auth::check() ? Auth::user()->name . ' (ID: ' . Auth::user()->id . ')' : 'Unknown';
        $updatedUser = $user->name . ' (ID: ' . $user->id . ')';
        Log::info("User '{$updatedBy}' updated user '{$updatedUser}'.");

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }

    // app/Http/Controllers/UserController.php

    public function destroy(User $user)
    {

    }
    public function status(Request $request, User $user)
    {

        $validated = $request->validate([
            'status' => 'required'
        ]);
        $oldStatus = $user->status;
        $user->status = $validated['status'];
        $user->update();

        // // Log who changed the status and what the change was
        // $changedBy = Auth::check() ? Auth::user()->name . ' (ID: ' . Auth::user()->id . ')' : 'Unknown';
        // Log::info("User '{$changedBy}' changed status of user '{$user->name} (ID: {$user->id})' from '{$oldStatus}' to '{$user->status}'.");

        return response()->json(['success' => true, 'message' => 'User status updated test successfully']);
    }
    public function redirec()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        } else {
            $roleId = $user->role->id ?? null;

            if ($user->default_password == 1) {
                return redirect()->route('change-password');
            } else {
                switch ($roleId) {
                    case 1:
                        return redirect('/admin/dashboard');
                    case 2:
                        return redirect('/chairperson/dashboard');
                    case 3:
                        return redirect('/employee/dashboard');
                    default:
                        return redirect('/home');
                }
            }
        }
    }
}