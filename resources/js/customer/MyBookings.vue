<template>
    <div>
        <div class="form-control" v-if="bookings.length === 0">

            <!-- Email address -->
            <div class="row mb-2">
                <div class="col">
                    <label for="email" class="form-label">Please enter your email address</label>
                    <input type="email" class="form-control" id="email" v-model="email">
                </div>
            </div>

            <!-- Submit form -->
            <div class="row">
                <div class="col form-inline">
                    <button type="submit" class="btn btn-primary w-100" @click="submit()">Submit</button>
                </div>
            </div>
        </div>

        <div v-if="bookings.length > 0">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Booking time</th>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(booking, index) in bookings">
                    <th scope="row">{{ index + 1}}</th>
                    <td>{{ booking.date + ' ' + booking.slot }}</td>
                    <td>{{ booking.make }}</td>
                    <td>{{ booking.model }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            bookings: [],
        };
    },
    methods: {
        submit() {
            // Submit to API to get bookings for specified email address
            return axios.get('/api/booking/my-bookings?email='+this.email)
                .then((response) => {
                    this.bookings = response.data.data;
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
