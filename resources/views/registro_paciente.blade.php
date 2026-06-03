<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Paciente - Turnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h3>Bienvenido al Consultorio</h3>
                <p class="m-0">Ingrese sus datos para obtener un turno</p>
            </div>
            <div class="card-body p-4">
                
                <div class="mb-3">
                    <label for="nombre" class="form-label font-weight-bold">Nombre Completo:</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ej. Juan Pérez">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono de Contacto:</label>
                    <input type="text" id="telefono" class="form-control" placeholder="Ej. 5512345678">
                </div>

                <div class="mb-4">
                    <label for="servicio" class="form-label">Seleccione el Servicio:</label>
                    <select id="servicio" class="form-control">
                        <option value="1">Consulta General</option>
                        <option value="2">Pediatría</option>
                        <option value="3">Toma de Muestras</option>
                        <option value="4">Urgencias Menores</option>
                    </select>
                </div>

                <button id="btn-solicitar" class="btn btn-success w-100 fs-5">Solicitar Turno</button>

                <div id="respuesta" class="mt-4 text-center d-none alert alert-info">
                    <h5>Su turno es:</h5>
                    <h2 id="turno-generado" class="fw-bold text-success">---</h2>
                    <p class="m-0 text-muted">Espere en la sala a que aparezca en pantalla.</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            
            // Cuando le dan clic al botón (Igual que $("#bot").click en tu foto)
            $("#btn-solicitar").click(function() {
                
                // Recolectamos los datos de las cajas de texto
                var nom = $("#nombre").val();
                var tel = $("#telefono").val();
                var ser = $("#servicio").val();

                // Validación básica para que no vaya vacío
                if(nom == "" || tel == "") {
                    alert("Por favor, llene todos los campos.");
                    return;
                }

                // Hacemos la petición por POST usando AJAX (Igual que el $.post de la foto)
                $.ajax({
                    url: "/api/registrar-turno", // La ruta del servidor Laravel
                    type: "POST",
                    data: {
                        // Enviamos el token de seguridad que Laravel exige para formularios
                        _token: "{{ csrf_token() }}", 
                        nombre_paciente: nom,
                        telefono_paciente: tel,
                        servicio_id: ser
                    },
                    dataType: "json",
                    success: function(respuesta) {
                        // Si todo sale bien, mostramos el cuadro de respuesta con su turno
                        $("#respuesta").removeClass("d-none");
                        $("#turno-generado").text(respuesta.numero_turno);
                        
                        // Limpiamos los campos para el siguiente paciente
                        $("#nombre").val("");
                        $("#telefono").val("");
                    },
                    error: function() {
                        alert("Hubo un error al conectar con el servidor.");
                    }
                });

            });

        });
    </script>

</body>
</html>