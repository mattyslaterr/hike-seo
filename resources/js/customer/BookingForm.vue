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

                    <!-- Date -->
                    <select class="form-control" v-model="booking.date">
                        <option v-if="booking.date === null" :value="null">Select a date</option>
                        <option v-for="date in dates" :value="date">{{ date }}</option>
                    </select>

                    <!-- Time -->
                    <select class="form-control" v-model="booking.slot" :disabled="!booking.date">
                        <option v-if="booking.slot === null" :value="null">Select a time</option>
                        <option v-for="time in times">{{ time }}</option>
                    </select>
                </div>
            </div>

            <!-- Submit form -->
            <div class="col form-inline">
                <button type="submit" class="btn btn-primary w-100" @click="submit()" style="margin-top: 32px;">Submit</button>
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
                date: null,
                slot: null,
            },
            blocked: [],
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
        },
        getBookings() {
            // Submit to API to get bookings to block out calendar where slots not available
            return axios.get('/api/booking/blocked')
                .then((response) => {

                    // Set list of blocked date and time slots
                    this.blocked = response.data;
                })
                .catch(() => {

                    // Alert user of error
                    this.$swal.fire({
                        icon: 'error',
                        text: 'An error occurred retrieving calendar, please try again.',
                        showCloseButton: true,
                        confirmButtonText: 'Close',
                    })
                });
        },
    },
    computed: {
        dates: function() {
            let week_dates = [];
            let current_date = new Date();
            let next_month = new Date(current_date);
            next_month.setMonth(current_date.getMonth() + 1);
            next_month.setDate(1);

            // Loop through days and add to array of Monday - Friday dates
            while (next_month.getMonth() === current_date.getMonth() + 1) {
                if (next_month.getDay() >= 1 && next_month.getDay() <= 5) {
                    week_dates.push(new Date(next_month).toDateString());
                }

                next_month.setDate(next_month.getDate() + 1);
            }

            // Return array of open dates
            return week_dates;
        },
        times: function() {
            // Array of available time slots
            let times = [];

            // Loop through iterations on 30 increments, to 5pm
            // 9am open, 5.30 close. Last slot 5pm
            for (let i = 9 * 60; i <= 17.25 * 60; i += 30) {
                let skip_time = false;
                let hour = Math.floor(i / 60);
                let minute = i % 60;

                // Format time into readable format - Minute:Second
                let formatted_time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;

                // Check the time slot is available
                for(let i = 0; i < this.blocked.length; i++) {
                    // Cast both dates to date string to compare
                    let blocked_date = new Date(this.blocked[i].date).toDateString();
                    let selected_date = new Date(this.booking.slot).toDateString();

                    // Check if selected date is in blocked dates list
                    if(selected_date === blocked_date) {

                        // Check if selected time is in blocked slots list
                        if(formatted_time === this.blocked[i].slot) {
                            // skip_time = true;
                        }
                    }
                }

                if(!skip_time) {
                    times.push(formatted_time);
                }
            }

            // Return array of available time slots based on selected date
            return [...new Set(times)];
        }
    },
    mounted()  {
        this.getBookings();
    }
}
</script>
