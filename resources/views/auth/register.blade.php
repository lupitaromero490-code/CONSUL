<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSUL - Registro de Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --morado-oscuro: #4a0080;
            --morado-medio: #7b2fbe;
            --morado-claro: #9d4edd;
            --morado-suave: #e9d8fd;
            --dorado: #f0c040;
        }
        body {
            background: linear-gradient(135deg, var(--morado-oscuro) 0%, var(--morado-claro) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px 0;
        }
        .registro-container {
            width: 100%;
            max-width: 700px;
            padding: 20px;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .header-logo h1 { color: white; font-size: 2rem; font-weight: bold; }
        .header-logo p { color: var(--morado-suave); }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .form-card h4 {
            color: var(--morado-oscuro);
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            border-bottom: 2px solid var(--dorado);
            padding-bottom: 10px;
        }
        .seccion-titulo {
            color: var(--morado-medio);
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--morado-suave);
        }
        .btn-registrar {
            background: var(--morado-medio);
            border: none;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-registrar:hover { background: var(--morado-oscuro); color: white; }
        .form-control:focus {
            border-color: var(--morado-claro);
            box-shadow: 0 0 0 0.2rem rgba(157,78,221,0.25);
        }
        .input-group-text { background: var(--morado-suave); border-color: #dee2e6; color: var(--morado-oscuro); }
        .link-login { color: var(--morado-medio); text-decoration: none; }
        .link-login:hover { color: var(--morado-oscuro); }
    </style>
</head>
<body>
    <div class="registro-container">
        <div class="header-logo">
            <h1><i class="bi bi-hospital"></i> CONSUL</h1>
            <p>Registro de Nuevo Paciente</p>
        </div>

        <div class="form-card">
            <h4><i class="bi bi-person-plus"></i> Crear cuenta de paciente</h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <p class="seccion-titulo"><i class="bi bi-person"></i> Datos personales</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="nombre" class="form-control"
                                   value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Apellido</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="apellido" class="form-control"
                                   value="{{ old('apellido') }}" placeholder="Tu apellido" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="telefono" class="form-control"
                                   value="{{ old('telefono') }}" placeholder="10 dígitos">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fecha de nacimiento</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" name="fecha_nacimiento" class="form-control"
                                   value="{{ old('fecha_nacimiento') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="direccion" class="form-control"
                               value="{{ old('direccion') }}" placeholder="Calle, colonia, ciudad">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alergias conocidas</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-exclamation-triangle"></i></span>
                        <input type="text" name="alergias" class="form-control"
                               value="{{ old('alergias') }}" placeholder="Ej: Penicilina, látex (opcional)">
                    </div>
                </div>

                <p class="seccion-titulo"><i class="bi bi-envelope"></i> Datos de acceso</p>
                <div class="mb-3">
                    <label class="form-label fw-bold">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Confirmar contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Repite tu contraseña" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-registrar mt-2">
                    <i class="bi bi-check-circle"></i> Crear mi cuenta
                </button>

                <div class="text-center mt-3">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="link-login">Inicia sesión aquí</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>