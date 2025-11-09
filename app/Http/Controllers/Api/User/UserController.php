<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use ApiResponse; 

    /**
     * Get the authenticated user's profile
     */
    public function getProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->responseError('Unauthenticated.', 401);
        }

        return $this->responseSuccess($user, 'User profile retrieved successfully.');
    }

    
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->responseError('Unauthenticated.', 401);
        }

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password'     => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return $this->responseSuccess($user, 'Profile updated successfully.');
    }
}