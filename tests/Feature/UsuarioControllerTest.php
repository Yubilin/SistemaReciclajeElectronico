<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_crud_routes_work(): void
    {
        $this->get(route('usuarios.index'))->assertOk();
        $this->get(route('usuarios.create'))->assertOk();

        $this->post(route('usuarios.store'), [
            'nombre' => 'Ana Lopez',
            'apellido' => 'Lopez',
            'correo' => 'ana@example.com',
            'contraseña' => 'password123',
            'rol' => 'admin',
            'estado' => 'activo',
        ])->assertRedirect(route('usuarios.index'));

        $usuario = Usuario::where('correo', 'ana@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $usuario->contraseña));
        $this->get(route('usuarios.show', $usuario))->assertOk();
        $this->get(route('usuarios.edit', $usuario))->assertOk();

        $this->put(route('usuarios.update', $usuario), [
            'nombre' => 'Ana Garcia',
            'apellido' => 'Garcia',
            'correo' => 'ana@example.com',
            'contraseña' => '',
            'rol' => 'editor',
            'estado' => 'activo',
        ])->assertRedirect(route('usuarios.index'));

        $this->assertSame('Ana Garcia', $usuario->fresh()->nombre);
        $this->assertSame('editor', $usuario->fresh()->rol);
        $this->assertTrue(Hash::check('password123', $usuario->fresh()->contraseña));

        $this->delete(route('usuarios.destroy', $usuario))
            ->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }

    public function test_store_and_update_validate_usuario_data(): void
    {
        $this->from(route('usuarios.create'))
            ->post(route('usuarios.store'), [])
            ->assertSessionHasErrors(['nombre', 'apellido', 'correo', 'contraseña', 'rol', 'estado']);

        $usuario = Usuario::create([
            'nombre' => 'Ana Lopez',
            'apellido' => 'Lopez',
            'correo' => 'ana@example.com',
            'contraseña' => Hash::make('password123'),
            'rol' => 'admin',
            'estado' => 'activo',
        ]);
        $otroUsuario = Usuario::create([
            'nombre' => 'Luis Perez',
            'apellido' => 'Perez',
            'correo' => 'luis@example.com',
            'contraseña' => Hash::make('password123'),
            'rol' => 'usuario',
            'estado' => 'activo',
        ]);

        $this->from(route('usuarios.edit', $usuario))
            ->put(route('usuarios.update', $usuario), [
                'nombre' => 'Ana Lopez',
                'apellido' => 'Lopez',
                'correo' => $otroUsuario->correo,
                'contraseña' => '',
                'rol' => 'admin',
                'estado' => 'activo',
            ])
            ->assertSessionHasErrors(['correo']);
    }
}
