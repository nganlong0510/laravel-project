<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="p-10 bg-cover overflow-x-hidden">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h1 class="text-3xl font-bold underline">Welcome to Laravel App</h1>
    </nav>

    <div class="container mt-4 md:container md:mx-auto">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
