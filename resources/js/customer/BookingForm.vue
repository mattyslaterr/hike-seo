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

        <!-- Booking time slot -->
        <div class="row mb-2 justify-content-center">
            <div class="col">
                <label for="basic-url" class="form-label">Booking time</label>
                <div class="input-group mb-3">
                    <VueDatePicker
                        v-model="booking.time"
                        minutes-increment="30"
                        :disabled-week-days="[6, 7]"
                        :min-time="{hours: 9, minutes: 0}"
                        :max-time="{hours: 17, minutes: 30}"
                        :start-time="{hours: 9, minutes: 0}"
                        :min-date="new Date()"
                    ></VueDatePicker>
                </div>
            </div>

            <!-- Submit form -->
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
                time: null,
            }
        };
    },
    methods: {
        submit() {
            // Submit to API to confirm booking
            return axios.post('/api/booking/submit', this.booking)
                .then((response) => {

                    // Reset booking object to empty
                    Object.assign(this.$data, this.$options.data())

                    // Alert user booking successful
                    this.$swal.fire({
                        icon: 'success',
                        text: response.data,
                        showCloseButton: true,
                        confirmButtonText: 'Close',
                    })
                })
                .catch((error) => {

                    // Loop errors and add to bullet points
                    let errors = '';
                    for(let i = 0; i < error.response.data.length; i++) {
                        errors += '<li>'+error.response.data[i]+'</li>';
                    }

                    // Alert user of errors
                    this.$swal.fire({
                        icon: 'error',
                        html: errors,
                        showCloseButton: true,
                        confirmButtonText: 'Close',
                    })
                });
        }
    }
}
</script>
