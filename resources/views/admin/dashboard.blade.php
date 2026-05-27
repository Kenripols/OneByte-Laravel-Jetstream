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
                    <div class="bg-white border-2 border-[#000066] rounded-3xl py-6 px-6 md:pl-20 md:pr-16">

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
            <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- Usuarios -->
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

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

                </div>

                <!-- Mascotas -->
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">
                    
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
        
                </div>

                <!-- Perdidas -->
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

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

                </div>

                <!-- Encontradas -->
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

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

                </div>

            </section>


            <!-- Graficas -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                <h2 class="text-xl font-semibold text-center text-[#000066] mb-4">
                    Estadísticas
                </h2>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                <!-- Doughnut -->
                <div class="bg-white rounded-3xl p-6 shadow-sm
                transition-all duration-300 ease-in-out
                hover:-translate-y-1
                hover:shadow-2xl">

                    <h3 class="text-lg font-semibold text-center text-[#000066] mb-4">
                        Mascotas perdidas vs encontradas
                    </h3>

                    <div class="h-72">
                        <canvas id="petsChart"></canvas>
                    </div>

                </div>

                <!-- Barras -->
                <div class="bg-white rounded-3xl p-6 shadow-sm
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

            </div>

            </section>


            <!-- Actividad -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                <h2 class="text-xl font-semibold text-center text-[#000066] mb-4">
                    Actividad reciente
                </h2>

                <div class="h-48 flex items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    Tabla próximamente
                </div>

            </section>

        </div>

    </div>

    <!-- script para graficas de estadisticas -->
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

        });
        </script>
</x-app-layout>