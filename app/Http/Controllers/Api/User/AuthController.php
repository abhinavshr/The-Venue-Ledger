<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\FutsalVenue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate unique 6-digit OTP code
        do {
            $otp_code = random_int(100000, 999999);
        } while (User::where('otp_code', $otp_code)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'otp_code' => $otp_code,
            'role_id' => 1, // default role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Handle user login and token generation.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Handle user logout and token revocation.
     */
    public function logout(Request $request)
    {
        // Revoke all tokens for the user
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function registerFutsalVenue(Request $request, $user_id)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'logo_url' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $futsalVenue = FutsalVenue::create([
                'name' => $request->name,
                'address' => $request->address,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'logo_url' => $request->logo_url,
                'user_id' => $user_id,
            ]);

            $user = User::findOrFail($user_id);
            $user->update(['role_id' => 2]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Futsal Venue Registered Successfully and User Role Updated',
                'data' => [
                    'venue' => $futsalVenue,
                    'user' => $user
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
