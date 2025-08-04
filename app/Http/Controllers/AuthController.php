<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'phone'    => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
            ]);

            $token = JWTAuth::fromUser($user);

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
