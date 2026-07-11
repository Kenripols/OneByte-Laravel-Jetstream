<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-8">

            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Editar Publicación
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Modifica los datos de la publicación seleccionada.
                </p>

            </div>


            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">

                <form action="{{ route('admin.posts.update', $post) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-5">

                    @csrf
                    @method('PUT')


                    <div>

                        <label class="block mb-2 font-medium text-gray-700">
                            Título
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title', $post->title) }}"
                               maxlength="80"
                               class="w-full rounded-xl border border-gray-300 px-3 py-2
                                      focus:ring-1 focus:ring-[#000066]
                                      focus:border-[#000066]"
                               required>

                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                    </div>


                    <div>

                        <label class="block mb-2 font-medium text-gray-700">
                            Tipo
                        </label>

                        <select name="type"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2
                                       focus:ring-1 focus:ring-[#000066]
                                       focus:border-[#000066]"
                                required>

                            <option value="tip" @selected(old('type', $post->type) === 'tip')}>
                                Tip
                            </option>

                            <option value="news" @selected(old('type', $post->type) === 'news')}>
                                Novedad
                            </option>

                        </select>

                        @error('type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                    </div>


                    <div>

                        <label class="block mb-2 font-medium text-gray-700">
                            Imagen (opcional)
                        </label>

                        <input type="file"
                               name="image"
                               accept="image/*"
                               class="w-full rounded-xl border border-gray-300
                                      px-3 py-2 bg-white
                                      focus:ring-1 focus:ring-[#000066]
                                      focus:border-[#000066]">

                        @error('image')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                    </div>


                    @if($post->image)

                        @php
                            $postImageUrl = str_starts_with($post->image, 'http')
                                ? $post->image
                                : asset('storage/' . $post->image);
                        @endphp


                        <div class="bg-white border border-gray-200 rounded-2xl p-4">

                            <p class="text-sm text-gray-600 mb-3">
                                Imagen actual
                            </p>

                            <img src="{{ $postImageUrl }}"
                                 alt="Imagen publicación"
                                 class="w-40 h-40 object-cover rounded-xl border">

                        </div>

                    @endif


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Fecha inicio (solo Novedad)
                            </label>

                            <input type="datetime-local"
                                   name="publish_at"
                                   value="{{ old('publish_at', optional($post->publish_at)->format('Y-m-d\\TH:i')) }}"
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2
                                          focus:ring-1 focus:ring-[#000066]
                                          focus:border-[#000066]">

                            @error('publish_at')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Fecha fin (solo Novedad)
                            </label>

                            <input type="datetime-local"
                                   name="expires_at"
                                   value="{{ old('expires_at', optional($post->expires_at)->format('Y-m-d\\TH:i')) }}"
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2
                                          focus:ring-1 focus:ring-[#000066]
                                          focus:border-[#000066]">

                            @error('expires_at')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                    </div>


                    <div class="pt-2">

                        <label class="inline-flex items-center gap-2 text-gray-700">

                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   @checked(old('is_active', $post->is_active))
                                   class="rounded border-gray-300
                                          text-[#000066]
                                          focus:ring-[#000066]">

                            <span>
                                Publicación activa
                            </span>

                        </label>

                    </div>


                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">


                        <button type="submit"
                                class="px-5 py-2
                                       rounded-xl
                                       border-2 border-[#000066]
                                       bg-white
                                       text-[#000066]
                                       hover:bg-[#F1F5F9]
                                       transition">

                            Guardar cambios

                        </button>


                        <a href="{{ route('admin.posts.index') }}"
                           class="px-5 py-2
                                  rounded-xl
                                  border-2 border-gray-400
                                  bg-white
                                  text-gray-600
                                  hover:bg-gray-100
                                  transition
                                  text-center">

                            Cancelar

                        </a>


                    </div>


                </form>

            </div>

        </div>

    </div>

</x-app-layout>