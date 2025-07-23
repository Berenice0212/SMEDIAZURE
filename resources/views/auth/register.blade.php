<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMEDI - Registro</title>
    
    <link href="{{ asset('css/simplebar.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-light.css') }}" rel="stylesheet">

    <style>
        body {
            background: url("{{ asset('img/login/torre_registro.avif') }}") no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.4); /* Capa oscura para mejorar contraste */
            z-index: -1;
        }

        .login-btn {
            background-color: #2A5C8A !important;
            border-color: #1E4A6D !important;
            color: white !important;
        }

        .login-btn:hover {
            background-color: #1E4A6D !important;
            transform: translateY(-1px);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95); /* Ligera transparencia para que no se vea tan opaco */
        }
    </style>
</head>
<body class="light">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <div class="col-lg-6 d-none d-lg-flex" style="background: rgba(0, 0, 0, 0.5);">
                <div class="p-5 text-white">
                    <h2 class="display-4 font-weight-bold">Sistema de Monitoreo</h2>
                    <p class="lead">Comunidades de Bacalar</p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="w-75 mx-auto">
                    <div class="card shadow-sm border-0" style="border-top: 3px solid #2A5C8A !important;">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <img src="{{ asset('img/login/logo_smedi.jpg') }}" alt="SMEDI Logo" style="height: 70px; width: auto;">
                            </div>

                            <h2 class="h5 text-center mb-4">Registro de Usuario</h2>

                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name">Nombre</label>
                                    <input type="text" id="name" name="name" 
                                           class="form-control form-control-lg"
                                           value="{{ old('name') }}" required autofocus>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" id="email" name="email" 
                                           class="form-control form-control-lg"
                                           value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="password" name="password" 
                                           class="form-control form-control-lg" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password_confirmation">Confirmar contraseña</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                           class="form-control form-control-lg" required>
                                </div>

                                <button type="submit" class="btn btn-lg btn-block login-btn py-2 mb-3">
                                    <i class="fe fe-user-plus mr-2"></i> Registrarse
                                </button>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: #2A5C8A;">
                                        ¿Ya tienes cuenta? Iniciar sesión
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <p class="text-muted small">SMEDI © {{ date('Y') }} - Monitoreo de enlaces</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
</body>
</html>