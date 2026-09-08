<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dev</title>
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <h2 class="font-bold">icons</h2>

    <div class="grid grid-cols-4 gap-4">
        @foreach($icons as $iconView)
        @php
        $icon = basename($iconView, '.blade.php');
        @endphp

        <div class="flex flex-col items-center">
            <div class="text-4xl">
                <x-icon :icon="$icon" />
            </div>
            <div>{{ $icon }}</div>
        </div>

        @endforeach
    </div>

    <h2 class="font-bold mt-8">routes</h2>

    @foreach($routes as $route)
    <li>
        <a href="{{ url($route['uri']) }}">
            {{ $route['name'] }}
        </a>
    </li>
    @endforeach

</body>

</html>
