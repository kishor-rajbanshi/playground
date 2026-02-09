<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="laravel-auth text-red-500">Hello from the package div</div>
    <div x-data="{ open: false }">
        <button @click="open = true">Expand</button>

        <span x-show="open">
            Content...
        </span>
    </div>
</body>

</html>
