<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-8">

            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Crear Publicación
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Completa los datos para crear una nueva publicación.
                </p>

            </div>


            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6"
                 x-data="{ type: '{{ old('type', 'tip') }}' }">

                <form action="{{ route('admin.posts.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-5">

                    @csrf


                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Título
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
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
                                x-model="type"
                                class="w-full rounded-xl border border-gray-300 px-3 py-2
                                       focus:ring-1 focus:ring-[#000066]
                                       focus:border-[#000066]"
                                required>

                            <option value="tip" @selected(old('type') === 'tip')>
                                Tip
                            </option>

                            <option value="news" @selected(old('type') === 'news')>
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


                    <div x-show="type === 'news'"
                         x-cloak
                         class="grid grid-cols-1 md:grid-cols-2 gap-4">


                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Fecha inicio
                            </label>

                            <input type="datetime-local"
                                   name="publish_at"
                                   value="{{ old('publish_at') }}"
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2
                                          focus:ring-1 focus:ring-[#000066]
                                          focus:border-[#000066]">

                            @error('publish_at')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block mb-2 font-medium text-gray-700">
                                Fecha fin
                            </label>

                            <input type="datetime-local"
                                   name="expires_at"
                                   value="{{ old('expires_at') }}"
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2
                                          focus:ring-1 focus:ring-[#000066]
                                          focus:border-[#000066]">

                            @error('expires_at')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


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

                            Guardar

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