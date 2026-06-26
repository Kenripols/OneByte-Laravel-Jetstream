<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Encabezado -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center text-[#000066]">
                    Usuarios eliminados
                </h1>

                <p class="mt-3 text-gray-500 text-center text-base sm:text-lg lg:text-xl leading-relaxed">
                    Gestión de usuarios eliminados del sistema
                </p>

            </section>

            <!-- Contenido -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6 sm:p-8 shadow-sm">

                <!-- Tabla -->
                <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="min-w-[850px] w-full divide-y divide-gray-200">
                            <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Fecha de eliminación
                                    </th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider w-64">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-[#F8FAFC] transition-all duration-200">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-[11px] sm:text-xs sm:text-sm whitespace-nowrap">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-[11px] sm:text-xs sm:text-sm whitespace-nowrap">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-[11px] sm:text-xs sm:text-sm whitespace-nowrap">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-[11px] sm:text-xs sm:text-sm whitespace-nowrap">
                                            {{ $user->deleted_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                                            <div class="flex justify-center">
                                                <form action="{{ route('admin.users.restore', $user->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Estás seguro de restaurar este usuario?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="w-24 px-3 py-1 text-xs sm:text-sm
                                                                   border-2 border-[#000066]
                                                                   text-[#000066]
                                                                   rounded-lg
                                                                   hover:bg-[#F1F5F9]
                                                                   transition">
                                                        Restaurar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="mt-6 border-2 border-[#000066] rounded-2xl p-4 bg-[#F8FAFC]">
                    {{ $users->links() }}
                </div>

            </section>

        </div>

    </div>

</x-app-layout>