<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->especialidad = Especialidad::create([
            'nombre'            => 'Medicina General',
            'descripcion'       => 'Prueba',
            'duracion_consulta' => 30,
            'activo'            => true,
        ]);

        $this->userDoctor = User::create([
            'name'     => 'Dr. Prueba',
            'email'    => 'doctor@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $this->doctor = Doctor::create([
            'user_id'         => $this->userDoctor->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'TEST001',
            'activo'          => true,
        ]);

        $this->paciente = User::create([
            'name'     => 'Paciente Prueba',
            'email'    => 'paciente@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'paciente',
        ]);
    }

    public function test_puede_crear_una_cita()
    {
        Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '09:00',
            'hora_fin'    => '09:30',
            'estado'      => 'pendiente',
            'motivo'      => 'Revisión general',
        ]);

        $this->assertDatabaseHas('citas', [
            'doctor_id' => $this->doctor->id,
            'user_id'   => $this->paciente->id,
            'estado'    => 'pendiente',
        ]);
    }

    public function test_puede_cambiar_estado_de_cita()
    {
        $cita = Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin'    => '10:30',
            'estado'      => 'pendiente',
        ]);

        $cita->modificar('confirmada');

        $this->assertDatabaseHas('citas', [
            'id'     => $cita->id,
            'estado' => 'confirmada',
        ]);
    }

    public function test_cita_pertenece_a_un_doctor()
    {
        $cita = Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '11:00',
            'hora_fin'    => '11:30',
            'estado'      => 'pendiente',
        ]);

        $this->assertEquals($this->doctor->id, $cita->doctor->id);
    }

    public function test_cita_pertenece_a_un_paciente()
    {
        $cita = Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '12:00',
            'hora_fin'    => '12:30',
            'estado'      => 'pendiente',
        ]);

        $this->assertEquals($this->paciente->id, $cita->paciente->id);
    }

    public function test_puede_eliminar_una_cita()
    {
        $cita = Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '13:00',
            'hora_fin'    => '13:30',
            'estado'      => 'pendiente',
        ]);

        $cita->delete();

        $this->assertDatabaseMissing('citas', ['id' => $cita->id]);
    }
}