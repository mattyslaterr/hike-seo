<template>
    <div>
        <div class="form-control" style="padding: 15px;">

            <!-- Block a booking slot -->
            <div class="row mb-2 justify-content-center">
                <div class="col">
                    <label for="booking-time" class="form-label">Block a booking slot</label>
                    <div class="input-group mb-3">

                        <!-- Date -->
                        <select class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="date" style="margin-right: 15px;">
                            <option v-if="date === null" :value="null">Select a date</option>
                            <option v-for="date in dates" :value="date">{{ date }}</option>
                        </select>

                        <!-- Time -->
                        <select class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="slot" :disabled="!date" style="margin-right: 15px;">
                            <option v-if="slot === null" :value="null">Select a time</option>
                            <option v-for="time in times">{{ time }}</option>
                        </select>

                        <!-- Submit form -->
                        <button class="btn btn-green" @click="blockBooking()">
                            Block slot
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="blockedBookings.length > 0">
            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700 mb-6 mt-6">

            <table class="min-w-full text-left text-sm font-light w-full">
                <thead class="border-b font-medium dark:border-neutral-500">
                    <tr>
                        <th scope="col" class="px-6 py-4">#</th>
                        <th scope="col" class="px-6 py-4">Date</th>
                        <th scope="col" class="px-6 py-4">Slot</th>
                        <th scope="col" class="px-6 py-4">Blocked At</th>
                        <th scope="col" class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b dark:border-neutral-500" v-for="(blockedBooking, index) in blockedBookings">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ index + 1}}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ blockedBooking.date }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ blockedBooking.slot }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ blockedBooking.created_at }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold" @click="unblockBooking(blockedBooking)" style="cursor: pointer;">Unblock</td>
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
            blockedBookings: [],
            date: null,
            slot: null,
        };
    },
    methods: {
        getBlockedBookings() {
            // Get all bookings
            return axios.get('/api/blocked-bookings/all')
                .then((response) => {
                    this.blockedBookings = response.data;
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
        blockBooking() {
            // Submit to API to block booking
            return axios.post('/api/blocked-bookings/add', {
                date: this.date,
                slot: this.slot
            })
                .then((response) => {

                    // Fetch the new blocked bookings
                    this.getBlockedBookings();

                    // Alert user blocked booking successful
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
        unblockBooking(blockedBooking) {
            // Submit to API to unblock booking
            return axios.post('/api/blocked-bookings/remove', {
                date: blockedBooking.date,
                slot: blockedBooking.slot
            })
                .then((response) => {

                    // Fetch the new blocked bookings
                    this.getBlockedBookings();

                    // Alert user unblock booking successful
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
                let hour = Math.floor(i / 60);
                let minute = i % 60;

                // Format time into readable format - Minute:Second
                let formatted_time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;

                times.push(formatted_time);
            }

            // Return array of available time slots based on selected date
            return [...new Set(times)];
        }
    },
    mounted() {
        this.getBlockedBookings();
    }
}
</script>

<style>
.btn {
    @apply font-bold py-2 px-4 rounded;
}
.btn-green {
    @apply bg-green-500 text-white;
}
</style>
