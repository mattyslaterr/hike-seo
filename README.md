## Hayden's Garage

We would like you to create a booking system for Hayden’s Garage.
The business owner Paul wants to capture the following information and save it to the
database;
- Name
- Email Address
- Phone Number
- Vehicle Make & Model
- Date & time of booking

Customers should be able to book in 30-minute intervals. The garage is open between
9am and 5:30pm, Monday to Friday. Only 1 booking should be allowed per slot.

It should be possible for Paul to prevent specific days and slots from being booked. Paul
should be able to see upcoming bookings from an admin interface, and be able to filter
to a specific day. A booking confirmation needs to be emailed to both Paul and the customer.


## Setup

This application uses Laravel 9 and VueJS, installed via sail for MYSQL database.
- ./vendor/bin/sail up
- php artisan serve

Please refer to the .env.example as the environment file for setup. You can create your own admin account via /register to access the staff portal to login and view bookings, and add in blocked booking slots. 

The environment is hooked into a MailTrap inbox I have setup. Due to being on the free plan, I would recommend setting up another free inbox and update the SMTP credentials to see the mails sent as I am unable to add users to my inbox.

## Notes
Given the time constraints, some stuff is definitely lacking that I would have loved to fixed or improve on.
- A service to handle all booking related functionality rather than in the controller to save duplicated and bulky code
- Fixed inline styling
- A date picker plugin on the homepage that can handle specific blocked out dates and times
- More information on the booking in the staff panel on the calendar
- Templates (email & layout)
- Authentication/middleware for admin APIs
- Put emails into a job queue

## Credits

- https://webpixels.io/ - used for drop in homepage design
- Laravel Breeze for auth system / staff panel
- Laravel Sail
- Vite / Vue
- Mailtrap
