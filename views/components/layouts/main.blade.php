<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? config('app.name') . ' - ' . $title : config('app.name') }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body class="bg-mauve-200">

    <x-navigation />

    <div class="content bg-mauve-200 space-y-4 my-4">
        {{ $slot }}
    </div>

    <x-toaster-hub />

    @livewireScripts
</body>

</html>