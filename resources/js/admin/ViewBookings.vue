<template>
    <div>
        <div class="p-6 text-gray-900">
            <FullCalendar :options="calendarOptions"/>
        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import axios from "axios";

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    interactionPlugin // needed for dateClick
                ],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                weekends: false,
                events: [],
            },
        }
    },
    methods: {
        getBookings() {
            // Get all bookings
            return axios.get('/api/booking/all')
                .then((response) => {
                    this.calendarOptions.events = response.data.data;
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
    },
    mounted() {
       this.getBookings();
    }
}
</script>
