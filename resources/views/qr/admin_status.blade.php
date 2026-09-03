<x-app-layout>

    <div class="min-h-screen bg-[#F5F8FF] pt-0 pb-12 lg:py-12 px-4">

        <div class="max-w-2xl mx-auto">

            {{-- Encabezado --}}
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 sm:p-10 text-center shadow-sm mb-8">

                <h1 class="text-3xl font-bold text-[#000066]">
                    Estado del QR
                </h1>

                <p class="mt-4 text-gray-500 text-base sm:text-lg leading-relaxed">
                    Consultá la información y el estado actual de este código QR.
                </p>

            </div>

            {{-- Contenido --}}
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 sm:p-8 shadow-sm">

                {{-- Código --}}
                <div class="mb-6">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Código
                    </span>

                    <p class="mt-2 font-mono text-lg font-bold text-[#000066]">
                        {{ $qr->code }}
                    </p>
                </div>

                {{-- Estado --}}
                <div class="mb-6">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Estado
                    </span>

                    <div class="mt-2">
                        @php
                            $statusColors = [
                                \App\Models\QrPlate::STATUS_GENERATED  => 'bg-gray-100 text-gray-600',
                                \App\Models\QrPlate::STATUS_DOWNLOADED => 'bg-blue-100 text-blue-700',
                                \App\Models\QrPlate::STATUS_CLAIMED    => 'bg-yellow-100 text-yellow-700',
                                \App\Models\QrPlate::STATUS_REGISTERED => 'bg-purple-100 text-purple-700',
                                \App\Models\QrPlate::STATUS_ASSIGNED   => 'bg-green-100 text-green-700',
                                \App\Models\QrPlate::STATUS_EXPIRED    => 'bg-red-100 text-red-600',
                                \App\Models\QrPlate::STATUS_REPLACED   => 'bg-orange-100 text-orange-600',
                            ];

                            $color = $statusColors[$qr->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp

                        <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold {{ $color }}">
                            {{ $qr->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Mascota --}}
                @if($qr->pet)
                    <div class="border-t border-gray-200 pt-6 mb-6">

                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Mascota asignada
                        </span>

                        <p class="mt-2 font-semibold text-[#000066] text-lg">
                            {{ $qr->pet->name }}
                        </p>

                        @if($qr->pet->breed)
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $qr->pet->breed->name ?? '' }}
                            </p>
                        @endif

                    </div>
                @endif

                {{-- Dueño --}}
                @if($qr->owner_user_id)

                    @php
                        $owner = \App\Models\Owner::where('user_id', $qr->owner_user_id)
                            ->with('user')
                            ->first();
                    @endphp

                    @if($owner)

                        <div class="border-t border-gray-200 pt-6 mb-6">

                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Usuario registrado
                            </span>

                            <p class="mt-2 font-semibold text-[#000066]">
                                {{ $owner->user->name ?? '—' }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $owner->user->email ?? '' }}
                            </p>

                        </div>

                    @endif

                @endif

                {{-- Eventos recientes --}}
                @php
                    $events = $qr->events()->latest()->take(5)->get();
                @endphp

                @if($events->isNotEmpty())

                    <div class="border-t border-gray-200 pt-6">

                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Historial reciente
                        </span>

                        <ul class="mt-4 space-y-3">

                            @foreach($events as $event)

                                <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-sm">

                                    <span class="text-gray-700 capitalize">
                                        {{ $event->type }}
                                    </span>

                                    <span class="text-gray-400">
                                        {{ $event->created_at->format('d/m/Y H:i') }}
                                    </span>

                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
