<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSUL - Sistema de Agenda Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --morado-oscuro: #4a0080;
            --morado-medio: #7b2fbe;
            --morado-claro: #9d4edd;
            --morado-suave: #e9d8fd;
        }
        body { background-color: #f8f5ff; }
        .navbar { background-color: var(--morado-oscuro) !important; }
        .navbar-brand, .nav-link { color: white !important; }
        .nav-link:hover { color: var(--morado-suave) !important; }
        .btn-primary { background-color: var(--morado-medio); border-color: var(--morado-medio); }
        .btn-primary:hover { background-color: var(--morado-oscuro); border-color: var(--morado-oscuro); }
        .table thead { background-color: var(--morado-suave); color: var(--morado-oscuro); }
        .card-header-morado { background-color: var(--morado-medio); color: white; }
        .badge-morado { background-color: var(--morado-claro); }
        .sidebar { background-color: var(--morado-oscuro); min-height: 100vh; padding-top: 20px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 10px 20px; }
        .sidebar .nav-link:hover { color: white; background-color: var(--morado-medio); border-radius: 5px; }
        .sidebar .nav-link.active { color: white; background-color: var(--morado-claro); border-radius: 5px; }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content { padding: 20px; }
        .stat-card { border-left: 4px solid var(--morado-medio); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-hospital"></i> CONSUL
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            <span class="badge bg-light text-dark ms-1">{{ auth()->user()->rol }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->esAdmin())
                    <li class="nav-item mt-2">
                        <small class="text-white-50 px-3">ADMINISTRACIÓN</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctores.index') }}">
                            <i class="bi bi-person-badge"></i> Doctores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('especialidades.index') }}">
                            <i class="bi bi-clipboard2-pulse"></i> Especialidades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.index') }}">
                            <i class="bi bi-calendar-check"></i> Todas las Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consultas.index') }}">
                            <i class="bi bi-file-medical"></i> Consultas
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->esDoctor())
                    <li class="nav-item mt-2">
                        <small class="text-white-50 px-3">MI AGENDA</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.index') }}">
                            <i class="bi bi-calendar-check"></i> Mis Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('horarios.index') }}">
                            <i class="bi bi-clock"></i> Mis Horarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consultas.index') }}">
                            <i class="bi bi-file-medical"></i> Consultas
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->esPaciente())
                    <li class="nav-item mt-2">
                        <small class="text-white-50 px-3">MIS CITAS</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.index') }}">
                            <i class="bi bi-calendar-check"></i> Mis Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.create') }}">
                            <i class="bi bi-plus-circle"></i> Agendar Cita
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Contenido principal --}}
            <div class="col-md-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>