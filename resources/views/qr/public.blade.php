<x-guest-layout>
    <div class="max-w-xl mx-auto py-10 px-4">

        {{-- Mascota --}}
        <div class="bg-white shadow rounded p-6 text-center">

            <h1 class="text-2xl font-bold mb-2">
                 {{ $qr->pet->name ?? 'Mascota' }}
            </h1>

            @if($qr->pet?->photo)
    <img src="{{ str_starts_with($qr->pet->photo, 'http') 
        ? $qr->pet->photo 
        : asset('storage/' . $qr->pet->photo) }}"
        class="mx-auto rounded mb-4 max-h-60">
@else
    <div class="mx-auto mb-4 w-48 h-48 bg-gray-200 rounded flex items-center justify-center">
        <span class="text-gray-500"> Sin foto</span>
    </div>
@endif

            <p class="text-gray-600 mb-4">
                Si encontraste esta mascota, podés avisarle al dueño
            </p>

        </div>

        {{-- Formulario --}}
        <div class="bg-white shadow rounded p-6 mt-6">

            <label class="block font-bold mb-2">
                Mensaje (opcional)
            </label>

            <textarea id="message"
                class="border rounded w-full p-2 mb-4"
                placeholder="Ej: Está en la plaza, parece bien"></textarea>

            <label class="block font-bold mb-2">
                Foto (opcional)
            </label>

            <input type="file"
                   id="photo"
                   accept="image/*"
                   capture="environment"
                   class="mb-4">

            <button onclick="sendLocation()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                Enviar ubicación al dueño
            </button>

            <p id="status" class="mt-4 text-sm text-center"></p>

        </div>

    </div>

    {{-- JS --}}
    <script>
    function sendLocation() {

        const status = document.getElementById('status');
        status.textContent = "Obteniendo ubicación...";

        if (!navigator.geolocation) {
            status.textContent = "Tu dispositivo no soporta geolocalización";
            return;
        }

        navigator.geolocation.getCurrentPosition(position => {

            const formData = new FormData();

            formData.append('lat', position.coords.latitude);
            formData.append('lng', position.coords.longitude);
            formData.append('message', document.getElementById('message').value);

            const fileInput = document.getElementById('photo');
            if (fileInput.files.length > 0) {
                formData.append('photo', fileInput.files[0]);
            }

            fetch("{{ route('qr.sendLocation', $qr->code) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                status.textContent = "Ubicación enviada correctamente ✅";
            })
            .catch(() => {
                status.textContent = "Error al enviar ❌";
            });

        }, () => {
            status.textContent = "No se pudo obtener la ubicación ❌";
        });
    }
    </script>

</x-guest-layout>