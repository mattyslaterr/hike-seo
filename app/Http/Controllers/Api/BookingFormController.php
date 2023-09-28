<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFormRequest;
use App\Http\Requests\MyBookingsRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BookingFormController extends Controller
{
    /**
     * Submit booking form API
     *
     * @param BookingFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(BookingFormRequest $request)
    {
        // Find or create user account
        $user = $this->createOrFindUser($request);

        // Add booking and tie to user
        $booking = $this->storeBooking($request, $user);

        // Return friendly message to user
        return response()->json('Booking confirmed for '.$booking->time);
    }

    /**
     * Get users bookings via email API
     *
     * @param MyBookingsRequest $bookingsRequest
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function get(MyBookingsRequest $bookingsRequest)
    {
        return BookingResource::collection(Booking::whereUserEmail($bookingsRequest->input('email'))->orderBy('time', 'DESC')->get());
    }

    /**
     * Find or create user account
     *
     * @param Request $request
     * @return User
     */
    protected function createOrFindUser(Request $request): User
    {
        return User::firstOrCreate(['email' => $request->input('email')], [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('first_name'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make('password')
        ]);
    }

    /**
     * Add booking and tie to user
     *
     * @param Request $request
     * @param User $user
     * @return Booking
     */
    protected function storeBooking(Request $request, User $user): Booking
    {
        return Booking::firstOrCreate(array_merge($request->only(['make', 'model']), [
            'user_id' => $user->id,
            'time' => new Carbon($request->input('time')),
        ]));
    }
}
