<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSUL - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --morado-oscuro: #4a0080;
            --morado-medio: #7b2fbe;
            --morado-claro: #9d4edd;
            --morado-suave: #e9d8fd;
            --dorado: #f0c040;
            --dorado-suave: #fff8e1;
        }
        body {
            background: linear-gradient(135deg, var(--morado-oscuro) 0%, var(--morado-claro) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-logo h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
        }
        .header-logo p {
            color: var(--morado-suave);
            font-size: 1rem;
        }
        .rol-card {
            border: none;
            border-radius: 15px;
            padding: 25px 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .rol-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        .rol-card.active {
            border: 3px solid var(--dorado);
            background: var(--dorado-suave);
        }
        .rol-card i {
            font-size: 3rem;
            color: var(--morado-medio);
            margin-bottom: 10px;
        }
        .rol-card h5 {
            color: var(--morado-oscuro);
            font-weight: bold;
            margin-bottom: 5px;
        }
        .rol-card p {
            color: #666;
            font-size: 0.85rem;
            margin: 0;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin-top: 25px;
        }
        .form-card h4 {
            color: var(--morado-oscuro);
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-ingresar {
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
        .btn-ingresar:hover {
            background: var(--morado-oscuro);
            color: white;
        }
        .form-control:focus {
            border-color: var(--morado-claro);
            box-shadow: 0 0 0 0.2rem rgba(157, 78, 221, 0.25);
        }
        .link-registro {
            color: var(--morado-medio);
            text-decoration: none;
        }
        .link-registro:hover {
            color: var(--morado-oscuro);
        }
        .badge-rol {
            background: var(--dorado);
            color: var(--morado-oscuro);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header-logo">
            <h1><i class="bi bi-hospital"></i> CONSUL</h1>
            <p>Sistema de Agenda Médica</p>
        </div>

        {{-- Selección de rol --}}
        <div class="row g-3 mb-2" id="roles">
            <div class="col-md-4">
                <div class="rol-card" onclick="seleccionarRol('admin', this)">
                    <i class="bi bi-shield-lock"></i>
                    <h5>Administrador</h5>
                    <p>Gestión completa del sistema</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rol-card" onclick="seleccionarRol('doctor', this)">
                    <i class="bi bi-person-badge"></i>
                    <h5>Médico</h5>
                    <p>Agenda y consultas médicas</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rol-card" onclick="seleccionarRol('paciente', this)">
                    <i class="bi bi-person-heart"></i>
                    <h5>Paciente</h5>
                    <p>Agendar y ver mis citas</p>
                </div>
            </div>
        </div>

        {{-- Formulario de login --}}
        <div class="form-card" id="formLogin" style="display:none">
            <h4 id="tituloRol"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</h4>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    Credenciales incorrectas. Verifica tu correo y contraseña.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="rol_seleccionado" id="rol_seleccionado">

                <div class="mb-3">
                    <label class="form-label fw-bold">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="correo@ejemplo.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <button type="submit" class="btn-ingresar">
                    <i class="bi bi-box-arrow-in-right"></i> Ingresar
                </button>

                <div class="text-center mt-3">
                    <span id="linkRegistro" style="display:none">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="link-registro">Regístrate aquí</a>
                    </span>
                </div>

                <div class="text-center mt-2">
                    <a href="#" onclick="resetRol()" class="link-registro">
                        <i class="bi bi-arrow-left"></i> Cambiar tipo de usuario
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const titulos = {
            admin: '<i class="bi bi-shield-lock"></i> Acceso Administrador',
            doctor: '<i class="bi bi-person-badge"></i> Acceso Médico',
            paciente: '<i class="bi bi-person-heart"></i> Acceso Paciente'
        };

        function seleccionarRol(rol, card) {
            document.querySelectorAll('.rol-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            document.getElementById('rol_seleccionado').value = rol;
            document.getElementById('tituloRol').innerHTML = titulos[rol];
            document.getElementById('formLogin').style.display = 'block';
            if (rol === 'paciente') {
                document.getElementById('linkRegistro').style.display = 'block';
            } else {
                document.getElementById('linkRegistro').style.display = 'none';
            }
            document.getElementById('formLogin').scrollIntoView({ behavior: 'smooth' });
        }

        function resetRol() {
            document.querySelectorAll('.rol-card').forEach(c => c.classList.remove('active'));
            document.getElementById('formLogin').style.display = 'none';
            document.getElementById('rol_seleccionado').value = '';
        }
    </script>
</body>
</html>