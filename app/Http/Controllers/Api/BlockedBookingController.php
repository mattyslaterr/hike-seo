<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBlockedBookingRequest;
use App\Http\Requests\RemoveBlockedBookingRequest;
use App\Models\BlockedBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlockedBookingController extends Controller
{
    /**
     * Get users bookings via email API
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show()
    {
        return BlockedBooking::get();
    }

    /**
     * Add a blocked booking slot
     *
     * @param AddBlockedBookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(AddBlockedBookingRequest $request)
    {
        // Convert to datetime object
        $date = new Carbon($request->input('date'));

        // Create booking
        BlockedBooking::firstOrCreate([
            'date' => $date->format('Y-m-d'),
            'slot' => $request->input('slot'),
        ]);

        // Friendly response message to user
        return response()->json('Blocked booking slot successfully added');
    }

    /**
     * Remove a blocked booking slot
     *
     * @param RemoveBlockedBookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(RemoveBlockedBookingRequest $request)
    {
        // Convert to datetime object
        $date = new Carbon($request->input('date'));

        // Delete blocked booking
        BlockedBooking::where('date', $date->format('Y-m-d'))->where('slot', $request->input('slot'))->delete();

        // Friendly response message to user
        return response()->json('Blocked booking slot successfully removed');
    }
}
