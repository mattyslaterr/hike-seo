<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hayden's Garage | My Bookings</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Car image styling --->
    <style>
        .car-container {
            min-height: 100vh;
        }

        .car {
            background: url('/images/car.jpeg');
            background-size: cover;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-0 py-3">
                <div class="container-fluid max-w-screen-xl">
                    <!-- Logo -->
                    <h3>Hayden's Garage <i class="bi bi-car-front"></i></h3>

                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <!-- Nav -->
                        <ul class="navbar-nav mx-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/my-bookings">My Bookings</a>
                            </li>
                        </ul>
                        <!-- Action -->
                        <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                            <a href="/dashboard" class="btn btn-sm btn-neutral w-full w-lg-auto">
                                Staff Login
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid max-w-screen-xl">
                <div class="row">
                    <div class="col-6 mb-5 mb-lg-0 mt-5">
                        <h1 class="ls-tight font-bolder display-5">
                            My Bookings
                        </h1>

                        <my-bookings></my-bookings>
                    </div>

                    <div class="col-6 p-0 m-0 car-container">
                        <div class="car"></div>
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/app.js')
    </body>
</html>
