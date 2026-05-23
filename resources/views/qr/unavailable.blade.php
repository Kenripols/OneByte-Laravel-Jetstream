<!-- // Reemplazamos por el layout de guest porque sino queda inaccesible al no tener una sesión -->

<x-guest-layout>
    <div class="p-6 text-center">
        <h1 class="text-2xl font-bold text-red-600">
            QR no disponible
        </h1>

        <p class="mt-4 text-gray-600">
            Este código QR ya fue usado, está vencido o no es válido.
        </p>
    </div>
</x-guest-layout>