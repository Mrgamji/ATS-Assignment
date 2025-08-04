<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->input('email');
        $otp = $request->input('otp');

        // OTP is stored as: Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));
        $cacheKey = 'otp_' . $email;
        $cachedOtp = Cache::get($cacheKey);

        if (!$cachedOtp) {
            return response()->json(['error' => 'OTP expired or not found.'], 400);
        }

        if ((string) $cachedOtp !== (string) $otp) {
            return response()->json(['error' => 'Invalid OTP.'], 400);
        }

        // Mark user as verified (set email_verified_at)
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
        }

        // Remove OTP from cache after successful verification
        Cache::forget($cacheKey);

        return response()->json(['message' => 'OTP verified successfully.'], 200);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        // Automatically split the user's name into first and last name
        $nameParts = explode(' ', trim($user->name), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // Overwrite request data so validation and fill will use these
        $request->merge([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'photo' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'emergency_contact_name' => 'sometimes|nullable|string|max:255',
            'emergency_contact_phone' => 'sometimes|nullable|string|max:20',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'manager_id' => 'sometimes|nullable|integer|exists:employees,id',
            'employment_type' => 'required|in:full-time,graduate-trainee,intern,part-time,contract',
            'date_of_joining' => 'required|nullable|date',
            'employee_code' => 'required|string|max:255',
            'gender' => 'required|string|max:20',
            'date_of_birth' => 'sometimes|nullable|date',
            'role' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        // Try to find the existing employee
        $employee = \App\Models\Employee::where('email', $user->email)->first();
    
        if (!$employee) {
            // Create a new employee record
            $employee = new \App\Models\Employee();
    
            // Set default values from authenticated user if necessary
            $employee->email = $user->email;
        }
    
        // Fill from request
        $employee->fill($request->only([
            'first_name',
            'last_name',
            'photo',
            'phone',
            'address',
            'emergency_contact_name',
            'emergency_contact_phone',
            'designation',
            'department',
            'manager_id',
            'employment_type',
            'date_of_joining',
            'employee_code',
            'gender',
            'date_of_birth',
            'role',
        ]));
    
        // Save new or updated employee
        $employee->save();
    
        return response()->json([
            'message' => $employee->wasRecentlyCreated
                ? 'Employee profile created successfully.'
                : 'Employee profile updated successfully.',
            'employee' => $employee
        ]);
    }
    
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'name'     => $request->input('fullname'),
                'email'    => $request->input('email'),
                'phone'    => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
            ]);

            $token = JWTAuth::fromUser($user);
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in cache for 10 minutes (or you can use DB if preferred)
            try {
                Cache::put('otp_' . $user->email, (string) $otp, now()->addMinutes(10));

                // Send OTP to user's email
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) 
                 {
                       $message->to($user->email)
                   ->subject('Your OTP Code from ATS');
              });
            } catch (\Exception $e) {
                Log::error('Failed to send OTP or cache OTP', [
                    'email' => $user->email,
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
            }

            return response()->json([
                'user'  => $user,
                'token' => $token,
                'message' => 'User registered successfully.'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Signup error', [
                'email' => $request->input('email'),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred during signup. ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Attempt to log in and get the token
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Could not create token', 'details' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }

        // Authenticated user
        $user = JWTAuth::user();

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json(['message' => 'Reset link sent to your email.']);
            } else {
                // Log the error status for debugging
                Log::error('Unable to send reset link.', [
                    'email' => $request->input('email'),
                    'status' => $status
                ]);
                return response()->json(['error' => 'Unable to send reset link.'], 500);
            }
        } catch (\Exception $e) {
            // Log the exception details
            Log::error('Exception while sending reset link.', [
                'email' => $request->input('email'),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred while sending reset link.' . $e->getMessage()], 500);
        }
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // This is a placeholder. Actual email verification logic depends on your implementation.
        // For example, you might have a verification_tokens table, or use Laravel's built-in verification.
        // Here, we just return a success message for demonstration.
        return response()->json(['message' => 'Email verified successfully.']);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user && $request->user()->token()) {
            $request->user()->token()->revoke();
        }
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
