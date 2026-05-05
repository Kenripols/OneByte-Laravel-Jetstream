<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Publicación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6" x-data="{ type: '{{ old('type', 'tip') }}' }">
                <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 font-medium">Título</label>
                        <input type="text" name="title" value="{{ old('title') }}" maxlength="80" class="w-full border rounded p-2" required>
                        @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Tipo</label>
                        <select name="type" x-model="type" class="w-full border rounded p-2" required>
                            <option value="tip" @selected(old('type') === 'tip')>Tip</option>
                            <option value="news" @selected(old('type') === 'news')>Novedad</option>
                        </select>
                        @error('type') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Imagen (opcional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full border rounded p-2 bg-white">
                        @error('image') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div x-show="type === 'news'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Fecha inicio</label>
                            <input type="datetime-local" name="publish_at" value="{{ old('publish_at') }}" class="w-full border rounded p-2">
                            @error('publish_at') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Fecha fin</label>
                            <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="w-full border rounded p-2">
                            @error('expires_at') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Guardar</button>
                        <a href="{{ route('admin.posts.index') }}" class="bg-gray-300 hover:bg-gray-400 py-2 px-4 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
