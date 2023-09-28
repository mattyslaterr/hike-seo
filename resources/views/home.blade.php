<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hayden's Garage</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
    <body>
        <div id="app">
                <nav class="navbar navbar-expand-lg navbar-light bg-light px-0 py-3">
                    <div class="container-xl max-w-screen-xl">
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
                                <a href="#" class="btn btn-sm btn-neutral w-full w-lg-auto">
                                    Staff Login
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="py-24">
                    <div class="container max-w-screen-xl">
                        <div class="row align-items-center">
                            <div class="col-6 col-lg-5 mb-5 mb-lg-0">
                                <h1 class="ls-tight font-bolder display-5">
                                    Book your car in today
                                </h1>

                                <booking-form></booking-form>
                            </div>

                            <div class="col-6">
                                <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="img-fluid">
                            </div>

                        </div>
                    </div>
                </div>
        </div>
        @vite('resources/js/app.js')
    </body>
</html>
