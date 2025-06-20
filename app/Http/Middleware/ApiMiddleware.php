<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Authorization token not provided.'], 401);
        }

        // Find user with matching personal_token
        $user = User::where('personal_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        // Log the user in without password
        Auth::login($user);

        return $next($request);
    }
}