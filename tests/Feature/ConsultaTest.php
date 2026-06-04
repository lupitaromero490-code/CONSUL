<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->especialidad = Especialidad::create([
            'nombre'            => 'Pediatría',
            'descripcion'       => 'Atención infantil',
            'duracion_consulta' => 45,
            'activo'            => true,
        ]);

        $this->userDoctor = User::create([
            'name'     => 'Dr. Test',
            'email'    => 'drtest@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $this->doctor = Doctor::create([
            'user_id'         => $this->userDoctor->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'TESTCED',
            'activo'          => true,
        ]);

        $this->paciente = User::create([
            'name'     => 'Paciente Test',
            'email'    => 'pactest@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'paciente',
        ]);

        $this->cita = Cita::create([
            'doctor_id'   => $this->doctor->id,
            'user_id'     => $this->paciente->id,
            'fecha'       => now()->addDay()->format('Y-m-d'),
            'hora_inicio' => '09:00',
            'hora_fin'    => '09:45',
            'estado'      => 'confirmada',
        ]);
    }

    public function test_puede_crear_una_consulta()
    {
        $consulta = Consulta::create([
            'cita_id'     => $this->cita->id,
            'peso'        => 70.5,
            'talla'       => 170.0,
            'sintomas'    => 'Dolor de cabeza y fiebre',
            'diagnostico' => 'Gripe común',
            'receta'      => 'Paracetamol 500mg cada 8 horas',
        ]);

        $this->assertDatabaseHas('consultas', [
            'cita_id'     => $this->cita->id,
            'diagnostico' => 'Gripe común',
        ]);
    }

    public function test_consulta_pertenece_a_una_cita()
    {
        $consulta = Consulta::create([
            'cita_id'     => $this->cita->id,
            'sintomas'    => 'Tos y congestion',
            'diagnostico' => 'Resfriado',
        ]);

        $this->assertEquals($this->cita->id, $consulta->cita->id);
    }

    public function test_puede_modificar_una_consulta()
    {
        $consulta = Consulta::create([
            'cita_id'     => $this->cita->id,
            'sintomas'    => 'Dolor abdominal',
            'diagnostico' => 'Gastritis leve',
            'receta'      => 'Omeprazol 20mg',
        ]);

        $consulta->modificar([
            'sintomas'         => 'Dolor abdominal severo',
            'diagnostico'      => 'Gastritis severa',
            'receta'           => 'Omeprazol 40mg',
            'notas_pendientes' => 'Regresar en una semana',
        ]);

        $this->assertDatabaseHas('consultas', [
            'id'          => $consulta->id,
            'diagnostico' => 'Gastritis severa',
        ]);
    }

    public function test_consulta_tiene_datos_del_paciente()
    {
        $consulta = Consulta::create([
            'cita_id'     => $this->cita->id,
            'sintomas'    => 'Mareos',
            'diagnostico' => 'Anemia leve',
        ]);

        $this->assertEquals(
            $this->paciente->id,
            $consulta->cita->paciente->id
        );
    }

    public function test_puede_eliminar_una_consulta()
    {
        $consulta = Consulta::create([
            'cita_id'     => $this->cita->id,
            'sintomas'    => 'Prueba',
            'diagnostico' => 'Prueba diagnóstico',
        ]);

        $consulta->delete();

        $this->assertDatabaseMissing('consultas', ['id' => $consulta->id]);
    }
}