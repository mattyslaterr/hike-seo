<?php

namespace App\Rules;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class HasBooking implements Rule
{
    protected $date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Format date to match stored dates
        $date = new Carbon($this->date);
        $date = $date->format('Y-m-d');

        // Check if booking for this date and time already exists
        if(!Booking::hasBooking($date, $value)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Time slot unavailable, please try a different slot.';
    }
}
