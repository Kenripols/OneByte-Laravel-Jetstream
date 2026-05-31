@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Bienvenida -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Bienvenido,
                    {{ Auth::user()->name ?: Auth::user()->email }}
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Desde este panel podrás administrar usuarios, mascotas, placas QR,
                    publicaciones y visualizar estadísticas generales del sistema PetFinder.
                </p>

            </section>


            <!--Inicio Carrousel -->

<section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

    <!-- Título-->
    <h2 class="text-2xl font-semibold text-center text-[#000066] mb-4">
        Últimas Publicaciones
    </h2>

    <!-- Carousel Bootstrap -->
    <div id="petCarousel"
    class="carousel slide carousel-fade mt-4"
    data-bs-ride="carousel">

        <!-- Indicadores -->

        <div class="carousel-indicators">

            @foreach($latestPets as $index => $pet)

                <button
                    type="button"
                    data-bs-target="#petCarousel"
                    data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}">
                </button>

            @endforeach

        </div>


        <!-- Slides -->

        <div class="carousel-inner rounded-3xl overflow-hidden">

            @foreach($latestPets as $index => $pet)

                <!-- Slide -->
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                    <!-- Card -->
                    <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl py-6 px-6 md:pl-20 md:pr-16">

                        <div class="flex flex-col md:flex-row items-center gap-6">


                            <!-- Foto -->

                            <div class="w-full md:w-64 aspect-[4/3] md:h-40 rounded-2xl overflow-hidden bg-gray-200 flex-shrink-0 flex items-center justify-center">

                                @if(!empty($pet->photo))

                                    <img
                                        src="{{ Str::startsWith($pet->photo, 'http')
                                            ? $pet->photo
                                            : asset('storage/' . $pet->photo) }}"
                                        onerror="this.src='{{ asset('images/imagen-no-disponible.png') }}'"
                                        alt="{{ $pet->name }}"
                                        class="{{ Str::contains($pet->photo, 'no-image')
                                            ? 'max-w-full max-h-full object-contain p-2'
                                            : 'w-full h-full object-cover' }}"
                                    >

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        Sin foto
                                    </div>

                                @endif

                            </div>

                            <!-- Información -->

                            <div class="flex-1 text-center md:text-left">

                                <!-- Nombre -->
                                <h3 class="text-3xl font-bold text-[#000066]">
                                    {{ $pet->name }}
                                </h3>

                                <!-- Estado -->
                                <p class="mt-3 text-sm font-semibold">

                                    @if(optional($pet->currentStateModel)->state === \App\Enums\PetState::LOST)

                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-600">
                                            Mascota perdida
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-600">
                                            Mascota encontrada
                                        </span>

                                    @endif

                                </p>

                                <!-- Fecha -->
                                <p class="text-gray-500 mt-4">
                                    Actualizado {{ $pet->updated_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <!-- Flecha Izquierda -->

        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#petCarousel"
            data-bs-slide="prev">

            <span class="carousel-arrow text-4xl text-[#000066]">
                ❮
            </span>

        </button>

        <!-- Flecha Derecha -->

        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#petCarousel"
            data-bs-slide="next">

            <span class="carousel-arrow text-4xl text-[#000066]">
                ❯
            </span>

        </button>

    </div>

</section>

<!-- Fin Carrousel -->




            <!-- Estadisticas Generales -->
            <section id="estadisticas" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- Usuarios -->
                <a href="{{ route('admin.users.index') }}"
                    class="block bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1
                    hover:shadow-2xl
                    cursor-pointer">

                    <p class="text-sm font-medium text-center text-[#000066]">
                        Usuarios
                    </p>

                    <p
                    x-data="{ count: 0, target: {{ $totalUsers }} }"
                    x-init="
                        let step = Math.ceil(target / 50);

                        let interval = setInterval(() => {
                            count += step;

                            if (count >= target) {
                                count = target;
                                clearInterval(interval);
                            }
                        }, 30)
                    "x-text="count" class="mt-2 text-4xl font-bold text-center text-[#000066]">
                </p>

                </a>

                <!-- Mascotas -->
                <a href="{{ route('admin.pets.index') }}"
                    class="block bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1
                    hover:shadow-2xl
                    cursor-pointer">
                    
                    <p class="text-sm font-medium text-center text-[#000066]">
                        Mascotas
                    </p>

                    <p
                    x-data="{ count: 0, target: {{ $totalPets }} }"
                    x-init="
                        let step = Math.ceil(target / 50);

                        let interval = setInterval(() => {
                            count += step;

                            if (count >= target) {
                                count = target;
                                clearInterval(interval);
                            }
                        }, 30)
                    "x-text="count" class="mt-2 text-4xl font-bold text-center text-[#000066]">
                    </p>
        
                </a>

                <!-- Perdidas -->
                <a href="#estadisticas"
                    class="block bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1
                    hover:shadow-2xl
                    cursor-pointer">

                    <p class="text-sm font-medium text-center text-[#000066]">
                        Perdidas
                    </p>

                    <p
                    x-data="{ count: 0, target: {{ $lostPets }} }"
                    x-init="
                        let step = Math.ceil(target / 50);

                        let interval = setInterval(() => {
                            count += step;

                            if (count >= target) {
                                count = target;
                                clearInterval(interval);
                            }
                        }, 30)
                    "x-text="count" class="mt-2 text-4xl font-bold text-center text-[#000066]">
                    </p>

                </a>

                <!-- Encontradas -->
                <a href="#estadisticas"
                    class="block bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1
                    hover:shadow-2xl
                    cursor-pointer">

                    <p class="text-sm font-medium text-center text-[#000066]">
                        Encontradas
                    </p>

                    <p
                    x-data="{ count: 0, target: {{ $foundPets }} }"
                    x-init="
                        let step = Math.ceil(target / 50);

                        let interval = setInterval(() => {
                            count += step;

                            if (count >= target) {
                                count = target;
                                clearInterval(interval);
                            }
                        }, 30)
                    "x-text="count" class="mt-2 text-4xl font-bold text-center text-[#000066]">
                    </p>
                    <p class="mt-2 text-4xl font-bold text-center text-green-500">
                        
                    </p>

                </a>

            </section>


            <!-- Graficas -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                <h2 class="text-xl font-semibold text-center text-[#000066] mb-4">
                    Estadísticas
                </h2>
                <!-- Inicio de Grid de 4 gráficas -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                <!-- Doughnut mascotas perdidas y encontradas -->
                <div class="bg-[#F8FAFC] rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                    <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                        Mascotas perdidas y encontradas
                    </h3>

                    <div class="h-72">
                        <canvas id="petsChart"></canvas>
                    </div>

                </div>

                <!-- Barras Mascotas registradas por mes -->
                <div class="bg-[#F8FAFC] rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                    <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                        Mascotas registradas por mes
                    </h3>

                    <div class="h-72">
                        <canvas id="monthlyPetsChart"></canvas>
                    </div>

                </div>

                <!-- Barras Usuarios registrados por mes -->
                <div class="bg-[#F8FAFC] rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                    <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                        Usuarios registrados por mes
                    </h3>

                    <div class="h-72">
                        <canvas id="usersChart"></canvas>
                    </div>

                </div>

                <!-- Gráfica para QR Registrados -->
                <div class="bg-[#F8FAFC] rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                    <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                        QR registrados por mes
                    </h3>

                    <div class="h-72">
                        <canvas id="qrChart"></canvas>
                    </div>

                </div>

                </div>
                <!-- Fin de sección de 4 gráficas -->

                <!-- Inicio de sección de la gráfica de qr escaneados por mes -->

                <!-- Gráfica de escaneos QR por mes -->

                <div class="mt-8 bg-[#F8FAFC] rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                    Escaneos QR por mes
                </h3>

                <!-- Total de escaneos por mes -->
                <div class="mt-4 text-center">

                    <p
                        x-data="{ count: 0, target: {{ $totalScans }} }"
                        x-init="
                            let step = Math.ceil(target / 50);

                            let interval = setInterval(() => {

                                count += step;

                                if (count >= target) {
                                    count = target;
                                    clearInterval(interval);
                                }

                            }, 30);
                        "
                        x-text="count"
                        class="text-6xl font-bold text-[#000066]">
                    </p>

                    <p class="text-gray-500 text-sm mt-2">
                        Escaneos totales registrados
                    </p>

                </div>

                <!-- Grafica de escaneos QR por mes -->
                <div class="h-96">
                    <canvas id="qrScansChart"></canvas>
                </div>

                </div>
                <!-- Fin de sección de la gráfica de qr escaneados por mes -->

            </section>


            <!-- Sección Actividad Reciente -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                <h2 class="text-xl font-semibold text-center text-[#000066] mb-6">
                    Actividad reciente
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4">

                    <!-- Usuarios -->
                    @foreach($recentUsers as $user)

                        <div class="bg-[#F8FAFC] rounded-2xl border-2 border-[#000066] p-4
                            transition-all duration-300 ease-in-out
                            hover:-translate-y-1
                            hover:shadow-2xl">

                            <h3 class="font-semibold text-[#000066]">
                                Usuario registrado
                            </h3>

                            <p class="text-gray-700">
                                {{ $user->name ?? $user->email }}
                            </p>

                            <p class="text-sm text-gray-400 mt-2">
                                {{ $user->created_at->diffForHumans() }}
                            </p>

                        </div>

                    @endforeach

                    <!-- Mascotas -->
                    @foreach($recentPets as $pet)

                        <div class="bg-[#F8FAFC] rounded-2xl border-2 border-[#000066] p-4
                            transition-all duration-300 ease-in-out
                            hover:-translate-y-1
                            hover:shadow-2xl">

                            <h3 class="font-semibold text-[#000066] mb-3">
                                Mascota registrada
                            </h3>

                            <div class="flex items-center gap-3">

                            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#000066] flex-shrink-0">

                                <img
                                    src="{{ !empty($pet->photo)
                                        ? (Str::startsWith($pet->photo, 'http')
                                            ? $pet->photo
                                            : asset('storage/' . $pet->photo))
                                        : asset('images/imagen-no-disponible.png') }}"
                                    onerror="this.src='{{ asset('images/imagen-no-disponible.png') }}'"
                                    alt="{{ $pet->name }}"
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            <div>

                                <p class="font-medium text-gray-700">
                                    {{ $pet->name }}
                                </p>

                                <p class="text-sm text-gray-400">
                                    {{ $pet->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>


                        </div>

                    @endforeach

                    <!-- Escaneos -->
                    @foreach($recentReadings as $reading)

                        <div class="bg-[#F8FAFC] rounded-2xl border-2 border-[#000066] p-4
                            transition-all duration-300 ease-in-out
                            hover:-translate-y-1
                            hover:shadow-2xl">

                            <h3 class="font-semibold text-[#000066]">
                                QR escaneado
                            </h3>

                            <p class="text-gray-700">
                                {{ $reading->qrPlate?->code ?? 'QR' }}
                            </p>

                            <p class="text-sm text-gray-400 mt-2">
                                {{ $reading->created_at->diffForHumans() }}
                            </p>

                        </div>

                    @endforeach

                    <!-- Perdidas -->
                    @foreach($recentLostPets as $lost)

                        <div class="bg-[#F8FAFC] rounded-2xl border-2 border-[#000066] p-4
                            transition-all duration-300 ease-in-out
                            hover:-translate-y-1
                            hover:shadow-2xl">

                            <h3 class="font-semibold text-[#000066] mb-3">
                                Mascota perdida
                            </h3>

                            <div class="flex items-center gap-3">

                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#000066] flex-shrink-0">

                                    <img
                                        src="{{ !empty($lost->pet?->photo)
                                            ? (Str::startsWith($lost->pet->photo, 'http')
                                                ? $lost->pet->photo
                                                : asset('storage/' . $lost->pet->photo))
                                            : asset('images/imagen-no-disponible.png') }}"
                                        onerror="this.src='{{ asset('images/imagen-no-disponible.png') }}'"
                                        alt="{{ $lost->pet?->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                </div>

                                <div>

                                    <p class="font-medium text-gray-700">
                                        {{ $lost->pet?->name }}
                                    </p>

                                    <p class="text-sm text-gray-400">
                                        {{ $lost->started_at?->diffForHumans() }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                    <!-- Encontradas -->
                    @foreach($recentFoundPets as $found)

                        <div class="bg-[#F8FAFC] rounded-2xl border-2 border-[#000066] p-4
                            transition-all duration-300 ease-in-out
                            hover:-translate-y-1
                            hover:shadow-2xl">

                            <h3 class="font-semibold text-[#000066] mb-3">
                                Mascota encontrada
                            </h3>

                            <div class="flex items-center gap-3">

                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#000066] flex-shrink-0">

                                    <img
                                        src="{{ !empty($found->pet?->photo)
                                            ? (Str::startsWith($found->pet->photo, 'http')
                                                ? $found->pet->photo
                                                : asset('storage/' . $found->pet->photo))
                                            : asset('images/imagen-no-disponible.png') }}"
                                        onerror="this.src='{{ asset('images/imagen-no-disponible.png') }}'"
                                        alt="{{ $found->pet?->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                </div>

                                <div>

                                    <p class="font-medium text-gray-700">
                                        {{ $found->pet?->name }}
                                    </p>

                                    <p class="text-sm text-gray-400">
                                        {{ $found->started_at?->diffForHumans() }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </section>

        </div>

    </div>


<!-- script para graficas de estadisticas -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Doughnut chart
    const ctx = document.getElementById('petsChart');

            new Chart(ctx, {
                type: 'doughnut',

                data: {
                    labels: ['Perdidas', 'Encontradas'],

                    datasets: [{
                        data: [
                            {{ $lostPets }},
                            {{ $foundPets }}
                        ],

                        backgroundColor: [
                            '#EAB308',
                            '#22C55E'
                        ],

                        borderWidth: 0
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            position: 'bottom',

                            labels: {
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },

                    cutout: '70%'
                }
            });


    // Bar chart
    const monthlyCtx = document.getElementById('monthlyPetsChart');

            new Chart(monthlyCtx, {

                type: 'bar',

                data: {
                    labels: @json($months),

                    datasets: [{
                        label: 'Mascotas registradas',

                        data: @json($totals),

                        borderRadius: 12,

                        backgroundColor: '#000066'
                    }]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {

                        y: {
                            beginAtZero: true,

                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });


    // Barra Usuarios 
    const usersCtx = document.getElementById('usersChart');

        new Chart(usersCtx, {

            type: 'line',

            data: {
                labels: @json($userMonths),

                datasets: [{
                    label: 'Usuarios registrados',

                    data: @json($userTotals),

                    borderColor: '#000066',

                    backgroundColor: 'rgba(0,0,102,0.1)',

                    tension: 0.4,

                    fill: true
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    // Gráfica QR Registrados
    const qrCtx = document.getElementById('qrChart');

        new Chart(qrCtx, {

            type: 'bar',

            data: {
                labels: @json($qrMonths),

                datasets: [{
                    label: 'QR registrados',

                    data: @json($qrTotals),

                    backgroundColor: '#2563EB',

                    borderRadius: 12
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }); 
        
    // Gráfica de QRs escaneados por mes
    const scansCtx = document.getElementById('qrScansChart');

    new Chart(scansCtx, {

        type: 'line',

        data: {
            labels: @json($scanMonths),

            datasets: [{
                label: 'Escaneos QR',

                data: @json($scanTotals),

                tension: 0.4,

                fill: true,

                borderColor: '#000066',

                backgroundColor: 'rgba(0,0,102,0.12)',

                pointRadius: 5,

                pointHoverRadius: 8
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }
            },

            scales: {

                y: {
                    beginAtZero: true
                }
            }
        }
    });

        });
        </script>

        
</x-app-layout>