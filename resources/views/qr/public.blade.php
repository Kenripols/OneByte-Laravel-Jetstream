<x-guest-layout>
    <div class="max-w-xl mx-auto py-10 px-4">

        {{-- Mascota --}}
        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm text-center">

            <h1 class="text-3xl font-bold text-[#000066]"> {{ $qr->pet->name ?? 'Mascota' }} </h1>

            @php
                $petPhotoUrl = null;
                if ($qr->pet?->photo) {
                    $petPhotoUrl = str_starts_with($qr->pet->photo, 'http')
                        ? $qr->pet->photo
                        : asset('storage/' . $qr->pet->photo);
                }
            @endphp

            @if($petPhotoUrl) 
            <div class="mt-6 flex justify-center"> 
                <img src="{{ $petPhotoUrl }}" alt="{{ $qr->pet->name ?? 'Mascota' }}" 
                class="w-52 h-52 object-cover rounded-3xl border border-gray-200 shadow-sm"> 
            </div> 
            
            @else 
            <div class="mt-6 mx-auto w-52 h-52 bg-[#EEF5FF] border border-[#000066]/20 
            rounded-3xl flex items-center justify-center"> 
                <span class="text-gray-500"> Sin foto </span> 
            </div> 
            @endif

            <p class="mt-6 text-gray-600 text-base leading-relaxed"> 
                Si encontraste esta mascota, podés avisarle al dueño. 
            </p>

        </div>

        {{-- Formulario --}}
        <div class="mb-6 mt-6 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">

            <label class="block font-bold text-[#000066] mb-3"> 
                Mensaje (opcional) 
            </label>

            <textarea 
                id="message" 
                class="border border-gray-300 rounded-xl w-full px-3 py-2 
                focus:ring-1 focus:ring-[#000066] focus:border-[#000066] 
                resize-none" rows="4" placeholder="Ej: Está en la plaza, parece bien" >
            </textarea>

            <label class="block font-bold text-[#000066] mb-3">
                Foto (opcional)
            </label>

            <label for="photo" class="flex w-full items-center justify-center 
            bg-white text-[#000066] border-2 border-[#000066] rounded-xl 
            px-4 py-3 font-semibold cursor-pointer transition hover:bg-[#F1F5F9]">
                Seleccionar archivo
            </label>

            <input
                type="file"
                id="photo"
                accept="image/*"
                capture="environment"
                class="hidden">


            <button onclick="sendLocation()" 
                class="mt-4 w-full bg-white text-[#000066] border-2 border-[#000066] 
                rounded-xl px-5 py-3 font-semibold shadow-sm transition hover:bg-[#F1F5F9]">
                Enviar ubicación al dueño
            </button>

            <p id="status" class="mt-4 text-sm text-center font-medium" aria-live="polite" >

            </p>

        </div>

    </div>

    {{-- JS --}}
    <script>
    function sendLocation() {

        const status = document.getElementById('status');
        status.className = "mt-4 text-sm text-center font-medium text-[#000066]"; 
        status.textContent = "Obteniendo ubicación...";

        if (!navigator.geolocation) { 
            status.className = "mt-4 text-sm text-center font-medium text-red-600"; 
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
                status.className = "mt-4 text-sm text-center font-medium text-[#000066]"; 
                status.textContent = "Ubicación enviada correctamente";
            })
            .catch(() => {
                status.className = "mt-4 text-sm text-center font-medium text-red-600"; 
                status.textContent = "Error al enviar";
            });

        }, () => {
            status.className = "mt-4 text-sm text-center font-medium text-red-600"; 
            status.textContent = "No se pudo obtener la ubicación";
        });
    }
    </script>

</x-guest-layout>