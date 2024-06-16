<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\API\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    // This class handles user authentication requests

    /**
     * Handle login request
     */
    public function login(LoginUserRequest $request)
    {
        // Validate the request
        $request->validated($request->all());

        // Attempt to authenticate the user
        if(!Auth::attempt($request->only('email', 'password'))){
            
            // If authentication fails, return a successful response with an error message
            return $this->ok('Invalid credentials');
        }

        // Get the authenticated user
        $user = User::firstWhere('email', $request->email);

        // Create a new API token for the user with necessary abilities based on user roles. Return a successful response with the token
        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for' . $user->email,
                    $user->getAbilities(),
                    now()->addDays(3)
                )->plainTextToken,
            ]
        );
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        // Delete the user's current access token
        $request->user()->currentAccessToken()->delete();

        // Return a successful response
        return $this->ok('');

    }
}
