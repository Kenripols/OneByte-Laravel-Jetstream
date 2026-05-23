<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Petfindr' }}</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-fondo text-gray-900">

    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-xl p-4">
            {{ $slot }}
        </div>
    </div>

</body>
</html>