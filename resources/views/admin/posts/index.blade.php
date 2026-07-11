<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto space-y-8">

        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">

            <h1 class="text-3xl font-bold text-center text-[#000066]">
                Publicaciones
            </h1>

            <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                Administra publicaciones y controla estados.
            </p>

        </div>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto space-y-8">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <form method="GET"
                      action="{{ route('admin.posts.index') }}"
                      class="flex flex-col md:flex-row gap-3">

                    <select
                        name="type"
                        class="rounded-xl border border-gray-300 px-3 py-2
                               focus:ring-1 focus:ring-[#000066]
                               focus:border-[#000066]">

                        <option value="">Todos los tipos</option>
                        <option value="tip" @selected(request('type') === 'tip')>Tip</option>
                        <option value="news" @selected(request('type') === 'news')>Novedad</option>
                        <option value="lost" @selected(request('type') === 'lost')>Cambio de estado</option>

                    </select>

                    <select
                        name="is_active"
                        class="rounded-xl border border-gray-300 px-3 py-2 pr-8
                        focus:ring-1 focus:ring-[#000066]
                        focus:border-[#000066]">

                        <option value="">Activas e inactivas</option>
                        <option value="1" @selected(request('is_active') === '1')>Solo activas</option>
                        <option value="0" @selected(request('is_active') === '0')>Solo inactivas</option>

                    </select>

                    <button
                        type="submit"
                        class="px-5 py-2
                               rounded-xl
                               border-2 border-[#000066]
                               bg-white
                               text-[#000066]
                               hover:bg-[#F1F5F9]
                               transition">
                        Filtrar
                    </button>

                </form>

                <a href="{{ route('admin.posts.create') }}"
                   class="inline-flex items-center justify-center
                          px-5 py-2
                          rounded-xl
                          border-2 border-[#000066]
                          bg-white
                          text-[#000066]
                          hover:bg-[#F1F5F9]
                          transition">

                    Nueva publicación

                </a>

            </div>

        </div>

        <!-- Tabla -->
        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">
                @php
                    $sortLink = function (string $column) use ($sort, $direction) {
                        $nextDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
                        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $nextDirection, 'page' => 1]);
                    };
                    $sortArrow = function (string $column) use ($sort, $direction) {
                        if ($sort !== $column) {
                            return '↕';
                        }
                        return $direction === 'asc' ? '↑' : '↓';
                    };
                @endphp

                <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full divide-y divide-gray-200">

                        <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">

                            <tr>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    <a href="{{ $sortLink('id') }}" class="inline-flex items-center gap-1 whitespace-nowrap hover:text-[#000066]">
                                        ID {{ $sortArrow('id') }}
                                    </a>
                                </th>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    <a href="{{ $sortLink('title') }}" class="hover:text-[#000066]">
                                        Título {{ $sortArrow('title') }}
                                    </a>
                                </th>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    <a href="{{ $sortLink('type') }}" class="hover:text-[#000066]">
                                        Tipo {{ $sortArrow('type') }}
                                    </a>
                                </th>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    Mascota
                                </th>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    <a href="{{ $sortLink('is_active') }}" class="hover:text-[#000066]">
                                        Estado {{ $sortArrow('is_active') }}
                                    </a>
                                </th>

                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                                    <a href="{{ $sortLink('publish_at') }}" class="hover:text-[#000066]">
                                        Publicación {{ $sortArrow('publish_at') }}
                                    </a>
                                </th>

                                <th class="px-4 py-4 text-center text-xs font-semibold uppercase text-[#000066]">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse($posts as $post)

                                <tr class="hover:bg-[#F8FAFC] transition">

                                    <td class="px-4 py-2 text-sm whitespace-nowrap">
                                        {{ $post->id }}
                                    </td>

                                    <td class="px-4 py-2 text-sm max-w-[200px]">
                                        <div class="truncate">
                                            {{ $post->title }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-2 text-sm whitespace-nowrap">

                                        @if($post->type === 'tip')
                                            TIP
                                        @elseif($post->type === 'news')
                                            Novedad
                                        @elseif($post->type === 'lost')
                                            CdE
                                        @else
                                            {{ $post->type }}
                                        @endif

                                    </td>

                                    <td class="px-4 py-2 text-sm">
                                        {{ $post->pet?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 text-sm whitespace-nowrap">

                                        <span class="px-2 py-1 rounded text-xs
                                            {{ $post->is_active
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-gray-200 text-gray-700' }}">

                                            {{ $post->is_active ? 'Activa' : 'Inactiva' }}

                                        </span>

                                    </td>

                                    <td class="px-4 py-2 text-sm whitespace-nowrap">
                                        {{ $post->publish_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2">

                                        <div class="flex items-center justify-center gap-2">

                                            @if(in_array($post->type, ['tip', 'news']))

                                                <a href="{{ route('admin.posts.edit', $post) }}"
                                                class="w-24 px-3 py-1 text-xs sm:text-sm
                                                border-2 border-[#000066] text-[#000066]
                                                rounded-lg hover:bg-[#F1F5F9] transition
                                                text-center">
                                                Editar
                                                </a>

                                            @endif


                                            <form action="{{ route('admin.posts.destroy', $post) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Quitar esta publicación?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                class="w-24 px-3 py-1 text-xs sm:text-sm
                                                border-2 border-[#000066]
                                                text-[#000066] rounded-lg
                                                hover:bg-[#ff5555] transition">
                                                Quitar
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="px-4 py-6 text-center text-gray-500">

                                        No hay publicaciones para mostrar.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                </div>
            </div>

            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">
                {{ $posts->links() }}
            </div>
        </div>

    </div>
    </div>
    </div>
</x-app-layout>
