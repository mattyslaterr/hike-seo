import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler.js';
const app = createApp({});

// Booking form component
import BookingForm from './customer/BookingForm.vue';
app.component('booking-form', BookingForm);

// My bookings component
import MyBookings from './customer/MyBookings.vue';
app.component('my-bookings', MyBookings);

// Manage bookings component
import ViewBookings from './admin/ViewBookings.vue';
app.component('view-bookings', ViewBookings);

// Blocked bookings component
import BlockedBookings from './admin/BlockedBookings.vue';
app.component('blocked-bookings', BlockedBookings);

// SweetAlert2 for popup notifications
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
app.use(VueSweetalert2);

app.mount("#app");


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
