<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <form method="GET" action="{{ route('admin.posts.index') }}" class="flex gap-3 items-center">
                    <select name="type" class="border rounded py-2 pl-3 pr-10 w-48">
                        <option value="">Todos los tipos</option>
                        <option value="tip" @selected(request('type') === 'tip')>Tip</option>
                        <option value="news" @selected(request('type') === 'news')>Novedad</option>
                        <option value="lost" @selected(request('type') === 'lost')>Cambio de estado</option>
                    </select>
                    <select name="is_active" class="border rounded py-2 pl-3 pr-10 w-56">
                        <option value="">Activas e inactivas</option>
                        <option value="1" @selected(request('is_active') === '1')>Solo activas</option>
                        <option value="0" @selected(request('is_active') === '0')>Solo inactivas</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded border border-blue-700">
                        Filtrar
                    </button>
                </form>

                <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Nueva publicación
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ $sortLink('id') }}" class="hover:underline">ID {{ $sortArrow('id') }}</a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ $sortLink('title') }}" class="hover:underline">Título {{ $sortArrow('title') }}</a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ $sortLink('type') }}" class="hover:underline">Tipo {{ $sortArrow('type') }}</a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mascota</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ $sortLink('is_active') }}" class="hover:underline">Estado {{ $sortArrow('is_active') }}</a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ $sortLink('publish_at') }}" class="hover:underline">Publicación {{ $sortArrow('publish_at') }}</a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($posts as $post)
                            <tr>
                                <td class="px-4 py-3">{{ $post->id }}</td>
                                <td class="px-4 py-3">{{ $post->title }}</td>
                                <td class="px-4 py-3">
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
                                <td class="px-4 py-3">{{ $post->pet?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs {{ $post->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                        {{ $post->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $post->publish_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-3 flex gap-3">
                                    @if(in_array($post->type, ['tip', 'news']))
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:underline">Editar</a>
                                    @endif
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Quitar esta publicación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Quitar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay publicaciones para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
