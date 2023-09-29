<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFormRequest;
use App\Http\Requests\MyBookingsRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ManageBookingResource;
use App\Mail\AdminBookingMail;
use App\Mail\CustomerBookingMail;
use App\Models\BlockedBooking;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
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

        // Send emails to customer
        Mail::to($user->email)->send(new CustomerBookingMail($booking));

        // Send email to admin users
        User::whereAdmin()->get()->each(function($admin) use($user, $booking){
            Mail::to($admin->email)->send(new AdminBookingMail($user, $booking));
        });

        // Return friendly message to user
        return response()->json('Booking confirmed for ' . $booking->date . ' at ' . $booking->slot);
    }

    /**
     * Get users bookings via email API
     *
     * @param MyBookingsRequest $bookingsRequest
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function get(MyBookingsRequest $bookingsRequest)
    {
        return BookingResource::collection(Booking::whereUserEmail($bookingsRequest->input('email'))->orderBy('date', 'DESC')->get());
    }

    /**
     * Get all bookings API
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show()
    {
        return ManageBookingResource::collection(Booking::with('user')->get());
    }

    /**
     * Return a list of blocked date and time slots
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blocked()
    {
        // Grab both bookings and blocked bookings dates and slots
        $bookings = Booking::select('date', 'slot')->get();
        $blockedSlots = BlockedBooking::select('date', 'slot')->get();

        // Merge both together and return to API
        return response()->json(collect([$bookings, $blockedSlots])->flatten()->toArray());
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
        // Format date
        $date = new Carbon($request->input('date'));
        $date = $date->format('Y-m-d');

        return Booking::firstOrCreate(array_merge($request->only(['make', 'model']), [
            'user_id' => $user->id,
            'date' => $date,
            'slot' => $request->input('slot'),
        ]));
    }
}
