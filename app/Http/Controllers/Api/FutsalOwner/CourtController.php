<?php

namespace App\Http\Controllers\Api\FutsalOwner;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\FutsalVenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Fetch all courts for the logged-in futsal venue.
     */
    public function index()
    {
        $venue = FutsalVenue::where('user_id', Auth::id())->first();

        if (!$venue) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'status' => true,
            'data' => Court::where('futsal_venue_id', $venue->id)->get()
        ]);
    }

    /**
     * Create a new court for the logged-in futsal venue.
     */
    public function store(Request $request)
    {
        $venue = FutsalVenue::where('user_id', Auth::id())->first();

        if (!$venue) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'surface_type' => 'required|string',
            'price_per_hour' => 'required|numeric',
            'status' => 'nullable|string'
        ]);

        $validated['futsal_venue_id'] = $venue->id;

        $court = Court::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Court created successfully',
            'data' => $court
        ], 201);
    }

    /**
     * Fetch a single court (only if belongs to logged-in venue).
     */
    public function show($id)
    {
        $venue = FutsalVenue::where('user_id', Auth::id())->first();
        $court = Court::where('id', $id)
                      ->where('futsal_venue_id', $venue->id)
                      ->first();

        if (!$court) {
            return response()->json(['message' => 'Court not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $court]);
    }

    /**
     * Update court (only if belongs to logged-in venue).
     */
    public function update(Request $request, $id)
    {
        $venue = FutsalVenue::where('user_id', Auth::id())->first();

        $court = Court::where('id', $id)
                      ->where('futsal_venue_id', $venue->id)
                      ->first();

        if (!$court) {
            return response()->json(['message' => 'Not authorized or Court not found'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer',
            'surface_type' => 'sometimes|string',
            'price_per_hour' => 'sometimes|numeric',
            'status' => 'sometimes|string',
        ]);

        $court->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Court updated successfully',
            'data' => $court
        ]);
    }

    /**
     * Delete court (only if belongs to logged-in venue).
     */
    public function destroy($id)
    {
        $venue = FutsalVenue::where('user_id', Auth::id())->first();

        $court = Court::where('id', $id)
                      ->where('futsal_venue_id', $venue->id)
                      ->first();

        if (!$court) {
            return response()->json(['message' => 'Not authorized or Court not found'], 403);
        }

        $court->delete();

        return response()->json([
            'status' => true,
            'message' => 'Court deleted successfully'
        ]);
    }
}

