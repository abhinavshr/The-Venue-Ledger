<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FutsalVenue;
use Illuminate\Http\Request;

class FutsalOwnerVerification extends Controller
{

     public function updateVerification(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accept,reject',
        ]);

        $venue = FutsalVenue::find($id);

        if (!$venue) {
            return response()->json([
                'message' => 'Futsal venue not found.'
            ], 404);
        }

        $venue->verification = $request->status === 'accept';
        $venue->save();

        return response()->json([
            'message' => $request->status === 'accept'
                ? 'Futsal venue verified successfully.'
                : 'Futsal venue verification rejected.',
            'data' => $venue
        ], 200);
    }

}
