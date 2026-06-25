<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Estado del QR
        </h2>
    </x-slot>

    <div class="py-8 max-w-lg mx-auto px-4">

        <div class="bg-white shadow rounded-lg p-6">

            {{-- Código --}}
            <div class="mb-4">
                <span class="text-xs text-gray-400 uppercase tracking-wide">Código</span>
                <p class="font-mono text-lg font-bold text-gray-800">{{ $qr->code }}</p>
            </div>

            {{-- Estado --}}
            <div class="mb-4">
                <span class="text-xs text-gray-400 uppercase tracking-wide">Estado</span>
                <div class="mt-1">
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
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $color }}">
                        {{ $qr->status_label }}
                    </span>
                </div>
            </div>

            {{-- Mascota --}}
            @if($qr->pet)
                <div class="mb-4 border-t pt-4">
                    <span class="text-xs text-gray-400 uppercase tracking-wide">Mascota asignada</span>
                    <p class="font-semibold text-gray-800 mt-1">{{ $qr->pet->name }}</p>
                    @if($qr->pet->breed)
                        <p class="text-sm text-gray-500">{{ $qr->pet->breed->name ?? '' }}</p>
                    @endif
                </div>
            @endif

            {{-- Dueño --}}
            @if($qr->owner_user_id)
                @php $owner = \App\Models\Owner::where('user_id', $qr->owner_user_id)->with('user')->first(); @endphp
                @if($owner)
                    <div class="mb-4 border-t pt-4">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Usuario registrado</span>
                        <p class="font-semibold text-gray-800 mt-1">{{ $owner->user->name ?? '—' }}</p>
                        <p class="text-sm text-gray-500">{{ $owner->user->email ?? '' }}</p>
                    </div>
                @endif
            @endif

            {{-- Eventos recientes --}}
            @php $events = $qr->events()->latest()->take(5)->get(); @endphp
            @if($events->isNotEmpty())
                <div class="border-t pt-4">
                    <span class="text-xs text-gray-400 uppercase tracking-wide">Historial reciente</span>
                    <ul class="mt-2 space-y-1">
                        @foreach($events as $event)
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-700 capitalize">{{ $event->type }}</span>
                                <span class="text-gray-400">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

    </div>
</x-app-layout>
