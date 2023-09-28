import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler.js';
const app = createApp({});

// Booking form component
import BookingForm from './customer/BookingForm.vue';
app.component('booking-form', BookingForm);

// Date picker for customer frontend
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
app.component('VueDatePicker', VueDatePicker);

app.mount("#app");
