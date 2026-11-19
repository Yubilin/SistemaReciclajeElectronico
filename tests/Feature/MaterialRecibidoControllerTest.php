<?php

namespace Tests\Feature;

use App\Models\Entregante;
use App\Models\Recepcion;
use App\Models\Usuario;
use App\Models\categoria;
use App\Models\materialRecibido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialRecibidoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_recibido_crud_uses_its_category_and_reception_relations(): void
    {
        [$categoria, $recepcion] = $this->crearRelaciones();
        $datos = [
            'nombre' => 'Laptop',
            'tipo' => 'Equipo',
            'marca' => 'Marca',
            'modelo' => 'Modelo X',
            'descripcion' => 'Equipo para reciclar',
            'cantidad' => 1,
            'categoria_id' => $categoria->id,
            'recepcion_id' => $recepcion->id,
        ];

        $this->get(route('materiales-recibidos.create'))
            ->assertOk()
            ->assertSee('Cómputo')
            ->assertSee((string) $recepcion->id);
        $this->post(route('materiales-recibidos.store'), $datos)
            ->assertRedirect(route('materiales-recibidos.index'));

        $material = materialRecibido::firstOrFail();
        $this->get(route('materiales-recibidos.index'))
            ->assertOk()
            ->assertSee('Cómputo')
            ->assertSee((string) $recepcion->id);
        $this->get(route('materiales-recibidos.show', $material))
            ->assertOk()
            ->assertSee('Cómputo');

        $datos['cantidad'] = -1;
        $this->from(route('materiales-recibidos.edit', $material))
            ->put(route('materiales-recibidos.update', $material), $datos)
            ->assertSessionHasErrors(['cantidad']);

        $datos['cantidad'] = 2;
        $this->put(route('materiales-recibidos.update', $material), $datos)
            ->assertRedirect(route('materiales-recibidos.index'));
        $this->assertSame(2, $material->fresh()->cantidad);

        $this->delete(route('materiales-recibidos.destroy', $material))
            ->assertRedirect(route('materiales-recibidos.index'));
        $this->assertDatabaseMissing('material_recibidos', ['id' => $material->id]);
    }

    public function test_material_recibido_requires_existing_category_and_reception_records(): void
    {
        $this->from(route('materiales-recibidos.create'))
            ->post(route('materiales-recibidos.store'), [
                'nombre' => 'Laptop',
                'tipo' => 'Equipo',
                'marca' => 'Marca',
                'modelo' => 'Modelo X',
                'descripcion' => 'Equipo para reciclar',
                'cantidad' => 1,
                'categoria_id' => 999,
                'recepcion_id' => 999,
            ])
            ->assertSessionHasErrors(['categoria_id', 'recepcion_id']);
    }

    private function crearRelaciones(): array
    {
        $usuario = Usuario::create([
            'nombre' => 'Ana',
            'apellido' => 'López',
            'correo' => 'ana@example.com',
            'contraseña' => 'password123',
            'rol' => 'admin',
            'estado' => 'activo',
        ]);
        $entregante = Entregante::create([
            'nombre' => 'Luis',
            'apellido' => 'Pérez',
            'ci' => '12345',
            'telefono' => '555-0100',
            'direccion' => 'Calle 1',
        ]);
        $recepcion = Recepcion::create([
            'fecha' => '2026-11-20',
            'observaciones' => 'Recepción de prueba',
            'estado' => 'Recibida',
            'usuario_id' => $usuario->id,
            'entregante_id' => $entregante->id,
        ]);
        $categoria = categoria::create([
            'nombre' => 'Cómputo',
            'descripcion' => 'Equipos informáticos',
        ]);

        return [$categoria, $recepcion];
    }
}
