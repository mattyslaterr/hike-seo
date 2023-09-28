<template>
    <div class="form-control">

        <!-- Name -->
        <div class="row mb-2">
            <div class="col">
                <label for="first-name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first-name" v-model="booking.first_name">
            </div>

            <div class="col">
                <label for="last-name" class="form-label">Last name</label>
                <input type="text" class="form-control input-sm" id="last-name" v-model="booking.last_name">
            </div>
        </div>

        <!-- Email & Phone -->
        <div class="row mb-2">
            <div class="col">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" v-model="booking.email">
            </div>
            <div class="col">
                <label for="phone-number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone-number" v-model="booking.phone_number">
            </div>
        </div>

        <!-- Make & Model -->
        <div class="row mb-2">
            <div class="col">
                <label for="make" class="form-label">Make</label>
                <input type="text" class="form-control" id="make" v-model="booking.make">
            </div>
            <div class="col">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" v-model="booking.model">
            </div>
        </div>

        <div class="row mb-2 justify-content-center">
            <div class="col">
                <label for="basic-url" class="form-label">Booking time</label>
                <div class="input-group mb-3">
                    <VueDatePicker v-model="booking.booking_time"></VueDatePicker>
                </div>
            </div>

            <div class="col form-inline">
                <button type="submit" class="btn btn-primary w-100" @click="submit()">Submit</button>
            </div>

        </div>

    </div>

</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            booking: {
                first_name: '',
                last_name: '',
                email: '',
                phone_number: '',
                make: '',
                model: '',
                booking_time: null,
            }
        };
    },
    methods: {
        submit() {
            return axios.post('/api/booking/submit', this.booking)
                .then((res) => {

                })
                .catch((error) => {

                });
        }
    }
}
</script>
