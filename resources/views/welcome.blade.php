<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

<body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header>
        <div class="container-fluid">

            <!--Comienzo del menú-->
            <div class="row">
                <div class="">
                    @if (Route::has('login'))
                        <div class="dropdown float-end ">
                            <img src="{{ asset('images/user.png') }}" alt="Icono Usuario" class="dropdown"
                                style="width: 25px; padding-top: 7px; padding-bottom: 7px; 
                            margin-left: 20px;margin-right: 15px;">
                            <div class="dropdown-options">
                                <a href="{{ route('login') }}">
                                    <button type="button" class="btn btn-danger boton-ini-se">Iniciar Sesión</button>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <button type="button" class="btn btn-primary boton-reg">Registrar
                                            Usuario</button>
                                    </a>
                                @endif

                            </div>
                        </div>
                    @endif


                    <div class="float-end">
                        <a href="#"><img src="{{ asset('images/home.png') }}" alt="Icono Home"
                                style="width: 25px;  padding-top: 7px; padding-bottom: 7px;">
                        </a>
                    </div>

                </div>
            </div>
            <!--Fin del menú-->

            <!--Inicio de logo y titulo-->

            <div class="row fondo">

                <div class="col-3 d-sm-none">
                    <a href="#">
                        <img class="logo " src="{{ asset('images/paw.png') }}" alt="Logo Huella">
                    </a>
                </div>

                <div class="col-2 d-none d-sm-block">
                    <a href="#">
                        <img class="logogrande" src="{{ asset('images/paw.png') }}" alt="Logo Huella">
                    </a>
                </div>

                <div class="col-9 d-sm-none">
                    <h1 class="titulo-menu ">Sistema de Mascotas Perdidas</h1>
                </div>

                <div class="col-8 d-none d-sm-block">
                    <h1 class="titulo-menu-gr text-center">Sistema de Mascotas Perdidas</h1>
                </div>

                <div class="col-2 d-none d-sm-block">

                </div>


            </div>

            <!--Fin de logo y titulo-->




        </div>

    </header>



    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
