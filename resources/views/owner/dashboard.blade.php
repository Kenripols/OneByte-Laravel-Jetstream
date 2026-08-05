<x-app-layout>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido a PetFindr') }}
        </h2>
    </x-slot> --}}

    <div class="pt-0 pb-12 lg:py-12 bg-[#F5F8FF] min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="pt-2 lg:py-8 space-y-8">

                    
                   {{-- ========================= --}}
                    {{-- BIENVENIDA ESCRITORIO --}}
                    {{-- ========================= --}}
                    <div class="hidden lg:block max-w-6xl mx-auto">

                        <div class="relative bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl overflow-hidden shadow-lg">

                            <div class="grid lg:grid-cols-[62%_38%]">

                                <div class="px-10 py-10 lg:px-12 flex flex-col justify-center">

                                    <h1 class="text-4xl font-bold text-[#000066]">
                                        Bienvenido a PetFinder
                                    </h1>

                                    <p class="mt-3 text-xl font-semibold text-[#000066]">
                                        {{ Auth::user()->email }}
                                    </p>

                                    <div class="mt-8 space-y-5">

                                        <p class="max-w-xl text-lg text-gray-700 leading-relaxed">
                                            Aquí encontrarás toda la información de tus mascotas
                                            en un solo lugar.
                                        </p>

                                        <p class="max-w-md text-gray-600 leading-8">
                                            Consulta su estado, sigue las publicaciones relacionadas
                                            y mantente informado de las novedades más importantes.
                                        </p>

                                    </div>

                                </div>


                                {{-- ========================= --}}
                                {{-- PANEL DECORATIVO --}}
                                {{-- ========================= --}}
                                <div class="hidden lg:block relative overflow-hidden">

                                    {{-- Fondo azul --}}
                                    <div class="absolute inset-0 bg-[#EEF5FF]"></div>


                                    {{-- Curva SVG --}}
                                    <svg
                                        class="absolute left-[-1px] top-0 h-full w-56"
                                        viewBox="0 0 240 600"
                                        preserveAspectRatio="none"
                                        xmlns="http://www.w3.org/2000/svg">

                                        {{-- Relleno blanco --}}
                                        <path
                                            d="
                                            M240 0
                                            C150 100 150 200 90 290
                                            C35 380 55 500 0 600
                                            L0 0
                                            Z"
                                            fill="#F8FAFC"
                                        />


                                        {{-- Línea azul de la curva --}}
                                        <path
                                            d="
                                            M240 0
                                            C150 100 150 200 90 290
                                            C35 380 55 500 0 600"
                                            fill="none"
                                            stroke="#000066"
                                            stroke-width="2"
                                            stroke-opacity="0.35"
                                        />

                                    </svg>


                                    {{-- Halo --}}
                                    <div
                                        class="absolute
                                            w-80
                                            h-80
                                            rounded-full
                                            bg-[#CFE3FF]
                                            opacity-70
                                            blur-[80px]
                                            right-[-60px]
                                            bottom-[-40px]">
                                    </div>


                                    {{-- Huella --}}
                                    <img
                                        src="{{ asset('images/paw.png') }}"
                                        alt=""
                                        class="absolute
                                            w-72
                                            -right-12
                                            bottom-[-60px]
                                            -rotate-[60deg]
                                            opacity-[0.10]
                                            pointer-events-none
                                            select-none">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ========================= --}}
                    {{-- BIENVENIDA CELULAR --}}
                    {{-- ========================= --}}
                    <div class="block lg:hidden max-w-6xl mx-auto">

                        <div class="relative bg-[#EEF5FF] border-2 border-[#000066] rounded-3xl overflow-hidden shadow-lg">

                            {{-- Huella --}}
                            <img
                                src="{{ asset('images/paw.png') }}"
                                alt=""
                                class="absolute
                                    w-72
                                    -right-12
                                    bottom-[-35px]
                                    -rotate-[60deg]
                                    opacity-[0.10]
                                    pointer-events-none
                                    select-none">


                            {{-- Contenido --}}
                            <div class="relative z-10 px-6 py-10 text-center">

                                <h1 class="text-3xl font-bold text-[#000066] leading-tight">
                                    Bienvenido a PetFinder
                                </h1>


                                <p class="mt-4 text-base font-semibold text-[#000066] break-all">
                                    {{ Auth::user()->email }}
                                </p>


                                <div class="mt-8 space-y-5">

                                    <p class="text-lg text-gray-700 leading-relaxed">
                                        Aquí encontrarás toda la información de tus mascotas
                                        en un solo lugar.
                                    </p>


                                    <p class="text-gray-600 leading-7">
                                        Consulta su estado, sigue las publicaciones relacionadas
                                        y mantente informado de las novedades más importantes.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ========================= --}}
                    {{-- ¿Cómo están tus mascotas hoy? --}}
                    {{-- ========================= --}}
                    <div class="max-w-6xl mx-auto mt-10">

                        <div class="relative overflow-hidden rounded-3xl border-2 border-[#000066] bg-[#EEF5FF] lg:bg-[#F8FAFC] shadow-lg">

                            {{-- ========================= --}}
                            {{-- PANEL DECORATIVO --}}
                            {{-- ========================= --}}
                            <div class="hidden lg:block absolute inset-y-0 right-0 w-[34%]">

                                {{-- Fondo azul completo --}}
                                <div class="absolute inset-0 bg-[#EEF5FF]"></div>


                                {{-- Curva SVG --}}
                                <svg
                                    class="absolute left-[-160px] top-0 h-full w-[calc(100%+160px)]"
                                    viewBox="0 0 600 600"
                                    preserveAspectRatio="none"
                                    xmlns="http://www.w3.org/2000/svg">


                                    {{-- Zona blanca de transición --}}
                                    <path
                                        d="
                                        M110 0
                                        C30 120 90 240 45 340
                                        C20 450 50 540 20 600
                                        L600 600
                                        L600 0
                                        Z"
                                        fill="#EEF5FF"
                                    />


                                    {{-- Línea curva --}}
                                    <path
                                        d="
                                        M110 0
                                        C30 120 90 240 45 340
                                        C20 450 50 540 20 600"
                                        fill="none"
                                        stroke="#000066"
                                        stroke-width="2"
                                        stroke-opacity="0.35"
                                    />

                                </svg>

                            </div>

                            {{-- ========================= --}}
                            {{-- CONTENIDO --}}
                            {{-- ========================= --}}
                            <div class="relative z-10 p-8">

                                {{-- Encabezado --}}
                                <div class="text-center">

                                    <h2 class="text-3xl font-bold text-[#000066]">
                                        ¿Cómo están tus mascotas hoy?
                                    </h2>

                                    <p class="mt-3 text-lg text-gray-500">
                                        Consulta rápidamente el estado actual de cada una.
                                    </p>

                                </div>

                                {{-- Tarjetas --}}
                                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                    
                                    {{-- Mascotas --}}

                                        @forelse($myPets as $pet)

                                            {{-- Tarjeta mascota --}}
                                            @php
                                                $photoRing = match($pet->currentState) {
                                                    \App\Enums\PetState::NORMAL => 'ring-[#A7D7B5]',
                                                    \App\Enums\PetState::LOST   => 'ring-[#E8A5A5]',
                                                    \App\Enums\PetState::FOUND  => 'ring-[#9CC6F3]',
                                                    \App\Enums\PetState::DEAD   => 'ring-[#CFCFCF]',
                                                    default => 'ring-[#D8E3F5]',
                                                };
                                            @endphp
                                            <div class="relative pt-10">

                                                {{-- Foto --}}
                                                <div class="absolute left-1/2 -translate-x-1/2 top-0 z-10">
             

                                                    <img src="{{ $pet->photo_url ?? asset('images/paw.png') }}"
                                                    alt="{{ $pet->name }}" 
                                                    class="w-24 h-24 rounded-full object-cover border-2 border-[#000066]">

                                                    
                                                </div>


                                                {{-- Tarjeta --}}
                                                @php
                                                    $styles = match($pet->currentState) {
                                                        \App\Enums\PetState::NORMAL => [
                                                            'card' => 'bg-[#F5FAF7]',
                                                            'badge' => 'bg-[#EAF7EF]',
                                                        ],

                                                        \App\Enums\PetState::LOST => [
                                                            'card' => 'bg-[#FFF6F6]',
                                                            'badge' => 'bg-[#FFEAEA]',
                                                        ],

                                                        \App\Enums\PetState::FOUND => [
                                                            'card' => 'bg-[#F5F9FF]',
                                                            'badge' => 'bg-[#EAF3FF]',
                                                        ],

                                                        \App\Enums\PetState::DEAD => [
                                                            'card' => 'bg-[#F9F9F9]',
                                                            'badge' => 'bg-[#EEEEEE]',
                                                        ],

                                                        default => [
                                                            'card' => 'bg-[#F8FAFC]',
                                                            'badge' => 'bg-[#EEF5FF]',
                                                        ],
                                                    };
                                                @endphp
                                                <div class="{{ $styles['card'] }} border-2 border-[#000066] rounded-2xl shadow-sm px-5 pt-16 pb-4 text-center transition-all duration-300 hover:shadow-md">


                                                    <h3 class="text-lg font-semibold text-[#000066]">
                                                        {{ $pet->name }}
                                                    </h3>


                                                    <div class="mt-3">

                                                        <span class="inline-flex items-center justify-center px-5 py-1.5 rounded-full border border-[#000066]/20 {{ $styles['badge'] }} text-[#000066] text-sm font-medium">

                                                            @if($pet->currentState)

                                                                {{ $pet->currentState->value === 'LOST'
                                                                    ? 'Perdida'
                                                                    : 'En casa' }}

                                                            @else

                                                                Sin estado

                                                            @endif

                                                        </span>

                                                    </div>


                                                </div>

                                            </div>


                                        @empty

                                            <p class="text-gray-500 text-center col-span-full">
                                                No tienes mascotas registradas.
                                            </p>

                                        @endforelse

                                    

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Mascotas perdidas --}}
                    <div
                        x-data="petViewer(@js($lostPetsData))"
                        x-init="init()"
                        class="max-w-6xl mx-auto mt-6"
                    >

                        <template x-if="pets.length">


                            <div class="bg-[#FFF6F6] border-2 border-[#000066] rounded-3xl shadow-lg overflow-hidden">


                                <div class="grid grid-cols-1 lg:grid-cols-[45%_55%]">

                                    {{-- ====================================================== --}}
                                    {{-- Columna izquierda - Información --}}
                                    {{-- ====================================================== --}}
                                    <div>

                                        {{-- ======================= --}}
                                        {{-- ESCRITORIO --}}
                                        {{-- ======================= --}}
                                        <div class="hidden lg:block pt-7 px-6 pb-6">

                                            <div class="flex items-start justify-between gap-3">

                                                {{-- Flecha izquierda --}}
                                                <button
                                                    @click="index = (index === 0 ? pets.length - 1 : index - 1)"
                                                    type="button"
                                                    class="flex-shrink-0 self-center"
                                                >
                                                    <span class="carousel-arrow">❮</span>
                                                </button>

                                                {{-- Contenido --}}
                                                <div class="flex flex-col items-center text-center w-full">

                                                    <img
                                                        :src="pets[index].photo_url || 'https://via.placeholder.com/150'"
                                                        class="w-44 h-44 object-cover rounded-3xl border-2 border-[#000066] shadow-md"
                                                    >

                                                    <h2
                                                        class="mt-6 text-2xl font-bold text-[#000066]"
                                                        x-text="pets[index].name"
                                                    ></h2>

                                                    <p class="mt-4 text-red-600 font-semibold">
                                                        Mascota perdida
                                                    </p>

                                                    <a
                                                        :href="`/pet/${pets[index].id}`"
                                                        class="mt-8 inline-flex items-center justify-center px-5 py-2 rounded-xl
                                                        border-2 border-[#000066] text-[#000066] bg-[#FFEAEA] font-semibold
                                                        hover:bg-[#f8aaaa] transition"
                                                    >
                                                        Ver detalle
                                                    </a>

                                                </div>

                                                {{-- Flecha derecha --}}
                                                <button
                                                    @click="index = (index === pets.length - 1 ? 0 : index + 1)"
                                                    type="button"
                                                    class="flex-shrink-0 self-center"
                                                >
                                                    <span class="carousel-arrow">❯</span>
                                                </button>

                                            </div>

                                        </div>


                                        {{-- ======================= --}}
                                        {{-- CELULAR --}}
                                        {{-- ======================= --}}
                                        <div class="block lg:hidden p-6">

                                            <div class="text-center">

                                                <h2
                                                    class="text-2xl font-bold text-[#000066]"
                                                    x-text="pets[index].name"
                                                ></h2>

                                                <p class="mt-2 text-red-600 font-semibold">
                                                    Mascota perdida
                                                </p>

                                            </div>


                                            {{-- Flechas --}}
                                            <div class="flex justify-between items-center mt-5 mb-3">

                                                <button
                                                    @click="index = (index === 0 ? pets.length - 1 : index - 1)"
                                                    type="button"
                                                >
                                                    <span class="carousel-arrow">❮</span>
                                                </button>

                                                <button
                                                    @click="index = (index === pets.length - 1 ? 0 : index + 1)"
                                                    type="button"
                                                >
                                                    <span class="carousel-arrow">❯</span>
                                                </button>

                                            </div>


                                            {{-- Imagen --}}
                                            <img
                                                :src="pets[index].photo_url || 'https://via.placeholder.com/150'"
                                                class="w-full h-40 object-cover rounded-3xl border-2 border-[#000066] shadow-md"
                                            >


                                            {{-- Botón --}}
                                            <div class="mt-6">

                                                <a
                                                    :href="`/pet/${pets[index].id}`"
                                                    class="w-full h-10 inline-flex items-center justify-center rounded-xl
                                                    border-2 border-[#000066] text-[#000066] bg-[#FFEAEA] font-semibold
                                                    hover:bg-[#F8aaaa] transition"
                                                >
                                                    Ver detalle
                                                </a>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- ====================================================== --}}
                                    {{-- Mapa (ÚNICO) --}}
                                    {{-- ====================================================== --}}
                                    <div class="p-6 pt-0 lg:pt-6">

                                        <div
                                            id="map"
                                            class="w-full h-72 lg:h-[22rem] rounded-2xl overflow-hidden"
                                        ></div>

                                    </div>

                                </div>


                            </div>


                        </template>

                    </div>


                    {{-- Tips y Novedades --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Tips --}}
                    @if(isset($tips) && count($tips))

                        <div class="relative overflow-hidden bg-[#EEF5FF] lg:bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl
                        shadow-lg transition-all duration-300 h-[300px] flex flex-col p-6">


                            {{-- ========================= --}}
                            {{-- DECORACIÓN ESCRITORIO --}}
                            {{-- ========================= --}}
                            <div class="hidden lg:block absolute inset-0 pointer-events-none">

                                <svg
                                    class="absolute inset-0 w-full h-full"
                                    viewBox="0 0 600 600"
                                    preserveAspectRatio="none"
                                    xmlns="http://www.w3.org/2000/svg">


                                    {{-- Fondo decorativo --}}
                                    <path
                                        d="
                                        M600 0
                                        L600 600
                                        L60 600
                                        C170 520 120 430 260 330
                                        C390 230 500 300 600 0
                                        Z"
                                        fill="#EEF5FF"
                                    />


                                    {{-- Línea límite --}}
                                    <path
                                        d="
                                        M600 0
                                        C500 300 390 230 260 330
                                        C120 430 170 520 60 600"
                                        fill="none"
                                        stroke="#000066"
                                        stroke-width="2"
                                        stroke-opacity="0.35"
                                    />


                                </svg>

                            </div>



                            {{-- ========================= --}}
                            {{-- CONTENIDO --}}
                            {{-- ========================= --}}
                            <div class="relative z-10 flex flex-col h-full">


                                <h2 class="text-2xl font-bold text-[#000066] text-center mb-6">
                                    Tips
                                </h2>


                                {{-- Contenido --}}
                                <div class="flex-1 overflow-hidden">


                                    <div @class([
                                        'space-y-3 pr-2',
                                        'overflow-y-auto h-full' => count($tips) > 3,
                                    ])>


                                        @foreach($tips as $tip)

                                            <div class="text-gray-700 font-medium border-b border-gray-200 pb-3">


                                                @if($tip->image)

                                                    @php
                                                        $tipImageUrl = str_starts_with($tip->image, 'http')
                                                            ? $tip->image
                                                            : asset('storage/' . $tip->image);
                                                    @endphp


                                                    <img
                                                        src="{{ $tipImageUrl }}"
                                                        alt="Imagen tip"
                                                        class="w-16 h-16 object-cover rounded-lg mb-2"
                                                    >

                                                @endif


                                                <p>
                                                    {{ $tip->title }}
                                                </p>


                                            </div>


                                        @endforeach


                                    </div>


                                </div>


                            </div>


                        </div>

                    @endif


                    {{-- Novedades --}}
                    @if(isset($news) && count($news))

                        <div class="relative overflow-hidden bg-[#EEF5FF] lg:bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl
                        shadow-lg transition-all duration-300 h-[300px] flex flex-col p-6">


                            {{-- ========================= --}}
                            {{-- DECORACIÓN ESCRITORIO --}}
                            {{-- ========================= --}}
                            <div class="hidden lg:block absolute inset-0 pointer-events-none">

                                <svg
                                    class="absolute inset-0 w-full h-full"
                                    viewBox="0 0 600 600"
                                    preserveAspectRatio="none"
                                    xmlns="http://www.w3.org/2000/svg">


                                    {{-- Fondo decorativo --}}
                                    <path
                                        d="
                                        M0 0
                                        L0 600
                                        L540 600
                                        C430 520 480 430 340 330
                                        C210 230 100 300 0 0
                                        Z"
                                        fill="#EEF5FF"
                                    />


                                    {{-- Línea límite --}}
                                    <path
                                        d="
                                        M0 0
                                        C100 300 210 230 340 330
                                        C480 430 430 520 540 600"
                                        fill="none"
                                        stroke="#000066"
                                        stroke-width="2"
                                        stroke-opacity="0.35"
                                    />


                                </svg>

                            </div>



                            {{-- Contenido --}}
                            <div class="relative z-10 flex flex-col h-full">


                                <h2 class="text-2xl font-bold text-[#000066] text-center mb-6">
                                    Novedades
                                </h2>



                                <div class="flex-1 overflow-hidden">


                                    <div class="space-y-4 overflow-y-auto h-full pr-2">


                                        @foreach($news as $post)

                                            <div class="border-b border-gray-200 pb-3">


                                                @if($post->image)

                                                    @php
                                                        $newsImageUrl = str_starts_with($post->image, 'http')
                                                            ? $post->image
                                                            : asset('storage/' . $post->image);
                                                    @endphp


                                                    <img
                                                        src="{{ $newsImageUrl }}"
                                                        alt="Imagen novedad"
                                                        class="w-16 h-16 object-cover rounded-lg mb-2"
                                                    >

                                                @endif

                                                <p class="font-semibold text-gray-800">
                                                    {{ $post->title }}
                                                </p>

                                                <p class="text-sm text-gray-400">
                                                    {{ $post->publish_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}
                                                </p>


                                            </div>


                                        @endforeach


                                    </div>


                                </div>


                            </div>


                        </div>

                    @endif

                    </div>

                

                    {{-- Cambios de estado --}}
                    @if(isset($statusPosts) && count($statusPosts))

                        <div class="bg-[#FFF6F6] border-2 border-[#000066] rounded-3xl
                        shadow-lg transition-all duration-300 p-6 h-[385px] flex flex-col">


                            <h2 class="text-2xl font-bold text-[#000066] text-center mb-6">
                                Cambios de estado
                            </h2>



                            <div class="flex-1 overflow-y-auto pr-2">

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                                @foreach($statusPosts as $post)


                                    <div class="bg-white/50 rounded-2xl p-4 border border-[#000066]/10
                                    flex flex-col items-center text-center">


                                        @if($post->pet?->photo_url)

                                            <img 
                                                src="{{ $post->pet->photo_url }}"
                                                alt="{{ $post->pet->name }}"
                                                class="w-20 h-20 rounded-full object-cover flex-shrink-0
                                                border-2 border-[#000066] mb-3"
                                            >

                                        @endif



                                        <div>


                                            <p class="font-semibold text-gray-800">

                                                {{ $post->title }}

                                            </p>



                                            @if($post->pet)

                                                <p class="text-sm text-gray-500 mt-2">

                                                    Mascota: {{ $post->pet->name }}

                                                </p>



                                                @if($post->pet->owner_id === auth()->id())

                                                    <p class="text-xs text-red-700 font-medium mt-1">

                                                        Tu publicación

                                                    </p>

                                                @endif


                                            @endif



                                            <p class="text-sm text-gray-400 mt-2">

                                                {{ $post->publish_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}

                                            </p>


                                        </div>


                                    </div>


                                @endforeach


                                </div>

                            </div>


                        </div>


                    @endif

                </div>

        </div>

    </div>


</x-app-layout>