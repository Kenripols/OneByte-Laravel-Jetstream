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
        <!-- Bienvenida -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 text-center">
                Bienvenido: {{ Auth::user()->name }}
            </h1>
<div x-data="petViewer(@js($lostPetsData))" x-init="init()" class="mx-6 mt-6">

    <template x-if="pets.length">
        <div class="bg-red-50 border-l-8 border-red-500 p-6 rounded-xl shadow">

            {{-- HEADER --}}
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

            {{-- MAPA GRANDE --}}
            <div id="map" class="w-full h-96 rounded-xl"></div>

            {{-- NAVEGACIÓN ENTRE MASCOTAS --}}
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
    {{-- TIPS --}}
            @if(isset($tips) && count($tips))
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold mb-4">💡 Tips</h2>

                <div class="space-y-2">
                    @foreach($tips as $tip)
                        <div class="text-gray-700 font-medium border-b pb-3">
                            @if($tip->image)
                                @php
                                    $tipImageUrl = str_starts_with($tip->image, 'http')
                                        ? $tip->image
                                        : asset('storage/' . $tip->image);
                                @endphp
                                <img src="{{ $tipImageUrl }}" alt="Imagen tip" class="w-16 h-16 object-cover rounded mb-2">
                            @endif
                            <p>{{ $tip->title }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- NOVEDADES --}}
            @if(isset($news) && count($news))
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold mb-4">Novedades</h2>

                <div class="space-y-4">
                    @foreach($news as $post)
                        <div class="border-b pb-3">
                            @if($post->image)
                                @php
                                    $newsImageUrl = str_starts_with($post->image, 'http')
                                        ? $post->image
                                        : asset('storage/' . $post->image);
                                @endphp
                                <img src="{{ $newsImageUrl }}" alt="Imagen novedad" class="w-16 h-16 object-cover rounded mb-2">
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

            {{-- CAMBIOS DE ESTADO --}}
            @if(isset($statusPosts) && count($statusPosts))
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold mb-4">Cambios de estado</h2>

                <div class="space-y-4">
                    @foreach($statusPosts as $post)
                        <div class="border-b pb-3">
                            <p class="font-semibold text-gray-800">
                                {{ $post->title }}
                            </p>
                            @if($post->pet)
                                <p class="text-sm text-gray-500">Mascota: {{ $post->pet->name }}</p>
                            @endif
                            <p class="text-sm text-gray-400">
                                {{ $post->publish_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

</x-app-layout>
