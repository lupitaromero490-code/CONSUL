<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->especialidad = Especialidad::create([
            'nombre'            => 'Cardiología',
            'descripcion'       => 'Enfermedades del corazón',
            'duracion_consulta' => 60,
            'activo'            => true,
        ]);
    }

    public function test_puede_crear_un_doctor()
    {
        $user = User::create([
            'name'     => 'Dr. Juan López',
            'email'    => 'juan@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'CED123',
            'telefono'        => '4431234567',
            'activo'          => true,
        ]);

        $this->assertDatabaseHas('doctores', [
            'cedula' => 'CED123',
            'activo' => true,
        ]);
    }

    public function test_doctor_tiene_especialidad()
    {
        $user = User::create([
            'name'     => 'Dr. Ana García',
            'email'    => 'ana@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'CED456',
            'activo'          => true,
        ]);

        $this->assertEquals('Cardiología', $doctor->especialidad->nombre);
    }

    public function test_doctor_tiene_usuario_asociado()
    {
        $user = User::create([
            'name'     => 'Dr. Pedro Ruiz',
            'email'    => 'pedro@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'CED789',
            'activo'          => true,
        ]);

        $this->assertEquals('Dr. Pedro Ruiz', $doctor->user->name);
        $this->assertEquals('doctor', $doctor->user->rol);
    }

    public function test_puede_desactivar_un_doctor()
    {
        $user = User::create([
            'name'     => 'Dr. Luis Torres',
            'email'    => 'luis@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'CED999',
            'activo'          => true,
        ]);

        $doctor->update(['activo' => false]);

        $this->assertDatabaseHas('doctores', [
            'id'     => $doctor->id,
            'activo' => false,
        ]);
    }

    public function test_puede_eliminar_un_doctor()
    {
        $user = User::create([
            'name'     => 'Dr. Carlos Mora',
            'email'    => 'carlos@test.com',
            'password' => bcrypt('password'),
            'rol'      => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id'         => $user->id,
            'especialidad_id' => $this->especialidad->id,
            'cedula'          => 'CED111',
            'activo'          => true,
        ]);

        $doctor->delete();

        $this->assertDatabaseMissing('doctores', ['id' => $doctor->id]);
    }
}