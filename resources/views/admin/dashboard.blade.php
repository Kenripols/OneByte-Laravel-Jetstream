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
                    <div class="bg-white border-2 border-[#000066] rounded-3xl py-6 pl-20 pr-16">

                        <div class="flex gap-6 items-center">


                            <!-- Foto -->

                            <div class="w-52 h-36 rounded-2xl overflow-hidden bg-gray-200 flex-shrink-0">

                                @if(!empty($pet->photo))

                                    <img
                                        src="{{ asset('storage/' . $pet->photo) }}"
                                        alt="{{ $pet->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        Sin foto
                                    </div>

                                @endif

                            </div>

                            <!-- Información -->

                            <div class="flex-1">

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
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

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
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">
                    
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
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

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
                <div class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

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

                <div class="h-72 flex items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    Gráfica próximamente
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
</x-app-layout>