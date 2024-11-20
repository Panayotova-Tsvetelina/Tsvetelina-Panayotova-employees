<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employee Work Pair Finder')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEJ1QhW2tqsWz3t4p8ppXmG65lP71vsWgBq1mC0p8j5zVs1BXaNfuA0KnAkv0" crossorigin="anonymous">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="bg-light">

<!-- Main Content -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    @yield('content')
</div>

<!-- Footer -->
@include('partials.footer')

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gyb6k8tUuGH1R27WTg0hZQ5dV2L4rW82nd1VYp8RzR0dpx4K+9"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-cu9/ulr1lh1ovVwGne6gpn8v3R8wXTw5igCpHkPwr5OXmkylXJw8p8VsbLU0S8M+"
        crossorigin="anonymous"></script>
</body>

</html>
