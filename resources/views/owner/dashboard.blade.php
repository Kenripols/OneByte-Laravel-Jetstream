<x-app-layout>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido a PetFindr') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="py-8 space-y-8">

                    {{-- Bienvenida --}}
                    <div class="mx-6 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">

                        <h1 class="text-3xl font-bold text-center text-[#000066]">
                            Bienvenido
                        </h1>

                        <p class="mt-2 text-center text-xl font-semibold text-[#000066]">
                            {{ Auth::user()->email }}
                        </p>

                        <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                            Aquí podrás consultar el estado de tus mascotas y mantenerte informado.
                        </p>

                    </div>

                        <!-- Estado de mascotas -->
                        <div class="mx-6 mt-8 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">

                            <h2 class="text-2xl font-bold text-center text-[#000066]">
                                ¿Cómo están tus mascotas hoy?
                            </h2>

                            <div class="mt-6 flex flex-wrap justify-center gap-8">

                                @forelse($myPets as $pet)

                                    <div class="flex flex-col items-center">

                                        <img 
                                            src="{{ $pet->photo_url ?? asset('images/paw.png') }}"
                                            alt="{{ $pet->name }}"
                                            class="w-24 h-24 rounded-full object-cover border-2 border-[#000066]"
                                        >

                                        <p class="mt-3 font-semibold text-gray-800 text-center">
                                            {{ $pet->name }}
                                        </p>

                                        @if($pet->currentState)

                                        <span class="mt-1 text-sm font-medium
                                            {{ $pet->currentState->value === 'LOST'
                                                ? 'text-red-600'
                                                : 'text-green-600' }}">

                                            {{ $pet->currentState->value === 'LOST'
                                                ? 'Perdida'
                                                : 'En casa' }}

                                        </span>

                                    @endif
                                    </div>

                                @empty

                                    <p class="text-gray-500 text-center">
                                        No tienes mascotas registradas.
                                    </p>

                                @endforelse
                            </div>
                        </div>


                    {{-- Mascotas perdidas --}}
                    <div x-data="petViewer(@js($lostPetsData))"
                    x-init="console.log(pets); init()"
                    class="mx-6 mt-6">

                        <template x-if="pets.length">

                            <div class="bg-red-50 border-l-8 border-red-500 p-6 rounded-xl shadow">

                                {{-- Header mascota perdida --}}
                                <div class="flex items-center gap-6 mb-4">

                                    <img :src="pets[index].photo_url || 'https://via.placeholder.com/150'"
                                         class="w-28 h-28 object-cover rounded-lg">


                                    <div>

                                        <h2 class="text-2xl font-bold text-red-700"
                                            x-text="pets[index].name + ' está perdida'">
                                        </h2>


                                        <a :href="`/pet/${pets[index].id}`"
                                           class="inline-block mt-3 bg-red-600 text-white px-4 py-2 rounded-lg">

                                            Ver detalle

                                        </a>

                                    </div>

                                </div>


                                {{-- Mapa --}}
                                <div id="map" class="w-full h-96 rounded-xl"></div>


                                {{-- Navegación --}}
                                <div class="flex justify-between mt-4">

                                    <button
                                        @click="index = (index === 0 ? pets.length - 1 : index - 1)"
                                        class="bg-gray-200 px-4 py-2 rounded">

                                        ◀

                                    </button>


                                    <button
                                        @click="index = (index === pets.length - 1 ? 0 : index + 1)"
                                        class="bg-gray-200 px-4 py-2 rounded">

                                        ▶

                                    </button>


                                </div>


                            </div>

                        </template>


                    </div>


                    {{-- Tips --}}
                    @if(isset($tips) && count($tips))

                        <div class="bg-white rounded-xl shadow p-6">

                            <h2 class="text-lg font-bold mb-4">
                                Tips
                            </h2>


                            <div class="space-y-2">

                                @foreach($tips as $tip)

                                    <div class="text-gray-700 font-medium border-b pb-3">

                                        @if($tip->image)

                                            @php
                                                $tipImageUrl = str_starts_with($tip->image, 'http')
                                                    ? $tip->image
                                                    : asset('storage/' . $tip->image);
                                            @endphp


                                            <img src="{{ $tipImageUrl }}"
                                                 alt="Imagen tip"
                                                 class="w-16 h-16 object-cover rounded mb-2">

                                        @endif


                                        <p>
                                            {{ $tip->title }}
                                        </p>


                                    </div>

                                @endforeach

                            </div>


                        </div>

                    @endif



                    {{-- Novedades --}}
                    @if(isset($news) && count($news))

                        <div class="bg-white rounded-xl shadow p-6">

                            <h2 class="text-lg font-bold mb-4">
                                Novedades
                            </h2>


                            <div class="space-y-4">

                                @foreach($news as $post)

                                    <div class="border-b pb-3">


                                        @if($post->image)

                                            @php
                                                $newsImageUrl = str_starts_with($post->image, 'http')
                                                    ? $post->image
                                                    : asset('storage/' . $post->image);
                                            @endphp


                                            <img src="{{ $newsImageUrl }}"
                                                 alt="Imagen novedad"
                                                 class="w-16 h-16 object-cover rounded mb-2">

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

                    @endif

                     {{-- Cambios de estado --}}
                    @if(isset($statusPosts) && count($statusPosts))

                        <div class="bg-white rounded-xl shadow p-6">

                            <h2 class="text-lg font-bold">
                                Cambios de estado
                            </h2>


                            <div class="space-y-4">

                                @foreach($statusPosts as $post)

                                    <div class="border-b pb-3 flex gap-3 items-start">


                                        @if($post->pet?->photo_url)

                                            <img src="{{ $post->pet->photo_url }}"
                                                 alt="{{ $post->pet->name }}"
                                                 class="w-7 h-7 rounded object-cover flex-shrink-0">

                                        @endif



                                        <div>


                                            <p class="font-semibold text-gray-800">

                                                {{ $post->title }}

                                            </p>



                                            @if($post->pet)

                                                <p class="text-sm text-gray-500">

                                                    Mascota: {{ $post->pet->name }}

                                                </p>



                                                @if($post->pet->owner_id === auth()->id())

                                                    <p class="text-xs text-amber-700 font-medium">

                                                        Tu publicación

                                                    </p>

                                                @endif


                                            @endif



                                            <p class="text-sm text-gray-400">

                                                {{ $post->publish_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}

                                            </p>


                                        </div>


                                    </div>


                                @endforeach


                            </div>


                        </div>


                    @endif


                </div>

            </div>

        </div>

    </div>


</x-app-layout>