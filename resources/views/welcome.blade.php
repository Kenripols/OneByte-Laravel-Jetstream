<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body class="bg-[#FDFDFC] text-[#1b1b18]">
    <header>
        <div class="container-fluid">

            <!--Comienzo del menú-->
            <div class="row">
                <div class="col-12">
                    @if (Route::has('login'))
                        <div class="menu-dropdown float-end ">
                            <img src="{{ asset('images/user.png') }}"
                            alt="Icono Usuario"
                            class="icono-menu icono-usuario">
                            <div class="menu-dropdown-options">
                                <a href="{{ route('login') }}">
                                    <button type="button" class="btn-login btn boton-ini-se">Iniciar Sesión</button>
                                </a>

                                @if (Route::has('register'))
      
                                    <a href="{{ route('register') }}">
                                        <button type="button" class="btn-register btn boton-reg">Registrarse</button>
                                    </a>
                                @endif

                            </div>
                        </div>
                    @endif


                    <div class="float-end">
                        <a href="{{ url('/') }}"><img src="{{ asset('images/home.png') }}"
                            alt="Icono Home"
                            class="icono-menu icono-home">
                        </a>
                    </div>

                </div>
            </div>
            <!--Fin del menú-->

            <!-- Inicio del Logo y Titulo -->
            <div class="row fondo align-items-center">

                <!-- Logo Movil -->
                <div class="col-3 d-sm-none">
                    <a href="{{ url('/') }}">
                        <img class="logo-movil" 
                        src="{{ asset('images/paw.png') }}" 
                        alt="Logo Huella">
                    </a>    
                </div>

                <!-- Titulo Movil -->
                <div class="col-9 d-sm-none">
                    <h1 class="titulo-movil">
                        PetFinder
                    </h1>

                    <p class="subtitulo-movil">
                        Sistema de Mascotas Perdidas
                    </p>
                </div>

                <!-- Logo Escritorio -->
                <div class="col-sm-2 d-none d-sm-flex justify-content-start">
                    <a href="{{ url('/') }}">
                        <img class="logo-escritorio"
                        src="{{ asset('images/paw.png') }}"
                        alt="Logo Huella">
                    </a>
                </div>

                <!-- Titulo Escritorio -->
                <div class="col-sm-8 d-none d-sm-block text-center">
                    <h1 class="titulo-escritorio">
                        PetFinder
                    </h1>

                    <p class="subtitulo-escritorio">
                        Sistema de Mascotas Perdidas
                    </p>
                </div>

                <div class="col-sm-2 d-none d-sm-block"></div>

            </div>
            <!-- Fin del Logo y Titulo -->

            <!-- Inicio del Carrousel -->
            <div id="petCarousel" class="carousel slide mt-4" data-bs-ride="carousel">

                <!-- Indicadores -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="3"></button>
                </div>

                <!-- Slides -->
                <div class="carousel-inner rounded shadow">

                    <!-- Slide 1 -->
                    <div class="carousel-item active">

                        <!-- Imagen Slide 1 Escritorio -->
                        <img src="{{ asset('images/slide-1-home.png') }}"
                            class="d-none d-md-block w-100 slider-img-desktop"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                        <!-- Texto Slide 1 Escritorio -->    
                        <div class="carousel-caption d-none d-md-block caption-desktop">
                            <h3 class="slide-title-desktop">Registrá tu mascota</h3>
                            <p class="slide-text-desktop">
                            Asociá un código QR único al collar de tu mascota.
                            </p>
                        </div>

                        <!-- Imagen Slide 1 Movil --> 
                        <img src="{{ asset('images/slide-1-home-movil.png') }}"
                            class="d-block d-md-none w-100 slider-img-mobile"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                        <!-- Texto Slide 1 Movil -->
                        <div class="d-block d-md-none caption-mobile">
                            <h3 class="slide-title-mobile">
                                Registrá tu mascota
                            </h3>
                            <p class="slide-text-mobile">
                                Asociá un QR al collar para encontrarla más rápido.
                            </p>
                        </div>

                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                    <!-- Imagen Slide 2 Escritorio -->
                        <img src="{{ asset('images/slide-2-home.png') }}"
                            class="d-none d-md-block w-100 slider-img-desktop"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 2 Escritorio -->    
                        <div class="carousel-caption d-none d-md-block caption-desktop">
                            <h3 class="slide-title-desktop">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-desktop">
                            Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>

                    <!-- Imagen Slide 2 Movil --> 
                        <img src="{{ asset('images/slide-2-home-movil.png') }}"
                            class="d-block d-md-none w-100 slider-img-mobile"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 2 Movil -->
                        <div class="d-block d-md-none caption-mobile">
                            <h3 class="slide-title-mobile">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-mobile">
                                Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item">
                    <!-- Imagen Slide 3 Escritorio -->
                        <img src="{{ asset('images/slide-3-home.png') }}"
                            class="d-none d-md-block w-100 slider-img-desktop"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 3 Escritorio -->    
                        <div class="carousel-caption d-none d-md-block caption-desktop">
                            <h3 class="slide-title-desktop">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-desktop">
                            Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>

                    <!-- Imagen Slide 3 Movil --> 
                        <img src="{{ asset('images/slide-3-home-movil.png') }}"
                            class="d-block d-md-none w-100 slider-img-mobile"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 3 Movil -->
                        <div class="d-block d-md-none caption-mobile">
                            <h3 class="slide-title-mobile">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-mobile">
                                Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="carousel-item">
                    <!-- Imagen Slide 4 Escritorio -->
                        <img src="{{ asset('images/slide-4-home.png') }}"
                            class="d-none d-md-block w-100 slider-img-desktop"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 4 Escritorio -->    
                        <div class="carousel-caption d-none d-md-block caption-desktop">
                            <h3 class="slide-title-desktop">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-desktop">
                            Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>

                    <!-- Imagen Slide 4 Movil --> 
                        <img src="{{ asset('images/slide-4-home-movil.png') }}"
                            class="d-block d-md-none w-100 slider-img-mobile"
                            alt="Mascota registrada">
                        <!-- Overlay -->    
                        <div class="slide-overlay"></div>
                    <!-- Texto Slide 4 Movil -->
                        <div class="d-block d-md-none caption-mobile">
                            <h3 class="slide-title-mobile">
                                Escaneo rápido
                            </h3>
                            <p class="slide-text-mobile">
                                Cualquier persona puede escanear el QR desde su celular.
                            </p>
                        </div>
                    </div>

                    </div>

                    <!-- Flechas -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
                        <span class="carousel-arrow">❮</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
                        <span class="carousel-arrow">❯</span>
                    </button>

                </div>
            </div>
            <!-- Fin del Carrousel -->

        
        <footer class="bebas-neue-regular ">
            <div class="container">
                <div class="row d-sm-none">

                    <div class="col-4">
                        <img class="logo-footer" src="{{ asset('images/dog.png') }}" alt="Logo Dogchows">
                    </div>
                    <div class="col-4">
                        <img class="logo-footer" src="{{ asset('images/pd.png') }}" alt="Logo Pedigree">
                    </div>
                    <div class="col-4">
                        <img class="logo-footer" src="{{ asset('images/whis.png') }}" alt="Logo Whiskas">
                    </div>

                </div>

                <div class="row d-sm-none">

                    <div class="col-2"></div>
                    <div class="col-4">
                        <img class="logo-footer" src="{{ asset('images/puri.png') }}" alt="Logo Purina">
                    </div>
                    <div class="col-4">
                        <img class="logo-footer" src="{{ asset('images/adv.png') }}" alt="Logo Advantix">
                    </div>
                    <div class="col-2"></div>
                </div>
                <hr class="d-sm-none">
                <div class="row d-sm-none">
                    <h5 class="texto-footer"><small>Todos los derechos reservados</small> © 2024 Onebyte</h5>
                </div>

                <div class="row">
                    <div class="col d-none d-sm-block">
                        <img class="logo-footer" src="{{ asset('images/dog.png') }}" alt="Logo Dogchows">
                    </div>
                    <div class="col d-none d-sm-block">
                        <img class="logo-footer" src="{{ asset('images/pd.png') }}" alt="Logo Pedigree">
                    </div>
                    <div class="col d-none d-sm-block">
                        <img class="logo-footer" src="{{ asset('images/whis.png') }}" alt="Logo Whiskas">
                    </div>
                    <div class="col d-none d-sm-block">
                        <img class="logo-footer" src="{{ asset('images/puri.png') }}" alt="Logo Purina">
                    </div>
                    <div class="col d-none d-sm-block">
                        <img class="logo-footer" src="{{ asset('images/adv.png') }}" alt="Logo Advantix">
                    </div>
                </div>
                <hr class="d-none d-sm-block">
                <div class="row d-none d-sm-block">
                    <h5 class="texto-footer"><small>Todos los derechos reservados</small> © 2024 Onebyte</h5>
                </div>

            </div>


        </footer>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
