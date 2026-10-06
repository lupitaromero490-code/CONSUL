# CONSUL

Sistema de agenda médica para una clínica, con gestión de citas, consultas, turnos y ventanillas. Proyecto académico de la materia Arquitectura y Despliegue de Aplicaciones Back-End (Instituto Tecnológico de Zitácuaro, TecNM).

## Tecnologías
Laravel 13, PHP 8.3+, Blade, Tailwind CSS, Alpine.js, Vite, Laravel Breeze, Laravel Sanctum, DomPDF, Mailtrap (correos en desarrollo), MySQL (base principal), PostgreSQL (réplica), Docker (Laravel Sail), PHPUnit

## Qué hace
- Inicio de sesión con permisos según el rol (administrador, doctor y paciente)
- Dashboard con las citas del día
- Administrador: gestión de doctores, especialidades, servicios, ventanillas, pacientes y turnos
- Doctor: gestión de sus horarios y de sus consultas
- Agenda de citas con consulta de horarios disponibles
- Consultas con descarga en PDF
- Notificación por correo al confirmar una cita
- API con autenticación por tokens (Sanctum)
- Réplica de la base de datos en PostgreSQL
- Seeders con 3,000 registros de prueba

## Cómo correrlo
Requisitos: Git, Docker Desktop, PHP y Composer.

```
git clone https://github.com/lupitaromero490-code/CONSUL.git
cd CONSUL
cp .env.example .env
composer install
php artisan key:generate
```

Edita el .env y cambia las contraseñas de ejemplo. Luego:

```
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

La app queda en http://localhost:8080

Pruebas:

```
./vendor/bin/sail artisan test
```

## Usuario administrador
Define ADMIN_EMAIL y ADMIN_PASSWORD en el .env antes de correr los seeders. Si no defines la contraseña, se genera una aleatoria y se muestra en la consola al ejecutar el seeder.

## Autoría
Desarrollo: María Guadalupe Romero Guerra.
Proyecto realizado en equipo como trabajo escolar.
