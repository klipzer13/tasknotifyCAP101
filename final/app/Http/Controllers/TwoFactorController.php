<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function sendcode(Request $request)
    {

        $userId = Auth::id(); // Get the authenticated user's ID
        // Join the 6-digit code array into a single string
        $codeArray = $request->input('code'); // returns an array: ['1', '2', '3', '4', '5', '6']
        $verificationCode = implode('', $codeArray); // '123456'

        $userId = Auth::id(); // Get the authenticated user's ID

        // Check if the verification code matches the one in the database
        $codeMatch = DB::table('users')
            ->where('id', $userId)
            ->where('email_verification_token', $verificationCode)
            ->exists();



        if ($codeMatch) {
            // Generate a new 6-digit random verification code
            $newVerificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Update the user's email_verification_token in the database
            DB::table('users')
                ->where('id', $userId)
                ->update(['email_verification_token' => $newVerificationCode]);
            if (Auth::check()) {

                $user = Auth::user();
                $roleId = $user->role->id ?? null;

                // Log the user login with time and date
                \Illuminate\Support\Facades\Log::info('User logged in', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'timestamp' => now()->toDateTimeString(),
                ]);

                switch ($roleId) {
                    case 1:
                        return redirect()->route('task.dashboard');
                    case 2:
                        return redirect()->route('chairperson.dashboard');
                    case 3:
                        return redirect()->route('employee.dashboard');
                    default:
                        return redirect('/home');
                }
            }
        } else {
            return redirect()->back()->withErrors(['code' => 'The verification code is incorrect.']);
        }
        // Proceed with verification logic...
    }
    public function resendcode()
    {

        // Generate a new 6-digit random verification code
        $newVerificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update the user's email_verification_token in the database
        $userId = Auth::id();
        DB::table('users')
            ->where('id', $userId)
            ->update(['email_verification_token' => $newVerificationCode]);

        // Send the new verification code to the user's email
        $userEmail = Auth::user()->email;

        Mail::raw("Your new verification code is: $newVerificationCode", function ($message) use ($userEmail) {
            $message->to($userEmail)
                ->subject('Your New Verification Code');
        });

        // Return a response indicating the code was resent
        return redirect()->back()->with('status', 'A new verification code has been sent to your email.');

    }

}
