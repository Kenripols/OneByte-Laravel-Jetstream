@if(session('error'))

    <div class="bg-red-100 p-3 mb-4 rounded">
        {{ session('error') }}
    </div>
@endif
<div>
    <h1>¿Qué querés hacer con el QR?</h1>
    <form method="POST" action="{{ route('owner.qr.claim', $qr->code) }}">
        @csrf
        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Sí, usar QR
        </button>
    </form>
<a href="{{ route('owner.dashboard') }}"
   class="bg-gray-300 px-4 py-2 rounded">
    No, cancelar
</a>
</div>