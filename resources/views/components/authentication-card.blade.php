<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
 <!-- Logo -->    
    <div class="mb-4">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/paw.png') }}" class="login-logo" alt="Logo PetFinder">
        </a>
    </div>

    <div class="login-card">
        {{ $slot }}
    </div>
</div>
