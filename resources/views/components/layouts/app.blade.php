<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-partials.head />
</head>

<body>
    <x-partials.app.header />
    <div>
        {{ $slot }}
    </div>
    <x-partials.app.footer />
</body>

</html>
