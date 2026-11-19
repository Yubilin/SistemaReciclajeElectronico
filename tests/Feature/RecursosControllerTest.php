<?php

namespace Tests\Feature;

use App\Models\asignacion;
use App\Models\Componentes;
use App\Models\Entregante;
use App\Models\Inventario;
use App\Models\Recepcion;
use App\Models\recuperacion;
use App\Models\Usuario;
use App\Models\categoria;
use App\Models\materialRecibido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecursosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_domain_resource_pages_load(): void
    {
        foreach ([
            'usuarios',
            'componentes',
            'categorias',
            'entregantes',
            'recepciones',
            'inventarios',
            'materiales-recibidos',
            'recuperaciones',
            'asignaciones',
        ] as $ruta) {
            $this->get(route($ruta . '.index'))->assertOk();
            $this->get(route($ruta . '.create'))->assertOk();
        }
    }

    public function test_componentes_and_inventario_preserve_the_one_to_one_relation(): void
    {
        $datos = $this->crearDatosDeMaterial();

        $this->post(route('componentes.store'), [
            'nombre' => 'Fuente',
            'descripcion' => 'Fuente recuperada',
            'cantidad' => 3,
            'estado' => 'Disponible',
            'recuperacion_id' => $datos['recuperacion']->id,
        ])->assertRedirect(route('componentes.index'));

        $componente = Componentes::firstOrFail();
        $this->get(route('componentes.show', $componente))
            ->assertOk()
            ->assertSee($datos['recuperacion']->fecha);

        $inventarioDatos = [
            'cantidadDisponible' => 3,
            'cantidadMinima' => 1,
            'componente_id' => $componente->id,
        ];
        $this->post(route('inventarios.store'), $inventarioDatos)
            ->assertRedirect(route('inventarios.index'));

        $inventario = Inventario::firstOrFail();
        $this->assertTrue($componente->inventario->is($inventario));
        $this->post(route('inventarios.store'), $inventarioDatos)
            ->assertSessionHasErrors(['componente_id']);

        $inventarioDatos['cantidadDisponible'] = 5;
        $this->put(route('inventarios.update', $inventario), $inventarioDatos)
            ->assertRedirect(route('inventarios.index'));
        $this->assertSame(5, $inventario->fresh()->cantidadDisponible);

        $this->delete(route('inventarios.destroy', $inventario))
            ->assertRedirect(route('inventarios.index'));
        $this->delete(route('componentes.destroy', $componente))
            ->assertRedirect(route('componentes.index'));
    }

    public function test_recepcion_controller_persists_both_belongs_to_relations(): void
    {
        $usuario = $this->crearUsuario();
        $entregante = Entregante::create([
            'nombre' => 'Luis',
            'apellido' => 'Pérez',
            'ci' => '12345',
            'telefono' => '555-0100',
            'direccion' => 'Calle 1',
        ]);
        $datos = [
            'fecha' => '2026-11-20',
            'observaciones' => 'Recepción de prueba',
            'estado' => 'Recibida',
            'usuario_id' => $usuario->id,
            'entregante_id' => $entregante->id,
        ];

        $this->get(route('recepciones.create'))
            ->assertOk()
            ->assertSee('Ana')
            ->assertSee('Luis');
        $this->post(route('recepciones.store'), $datos)
            ->assertRedirect(route('recepciones.index'));

        $recepcion = Recepcion::firstOrFail();
        $this->assertTrue($recepcion->usuario->is($usuario));
        $this->assertTrue($recepcion->entregante->is($entregante));
        $this->get(route('recepciones.show', $recepcion))
            ->assertOk()
            ->assertSee('Recepción de prueba')
            ->assertSee('Luis');

        $datos['estado'] = 'Revisada';
        $this->put(route('recepciones.update', $recepcion), $datos)
            ->assertRedirect(route('recepciones.index'));
        $this->assertSame('Revisada', $recepcion->fresh()->estado);
    }

    public function test_categoria_entregante_and_recuperacion_controllers_support_crud(): void
    {
        $datos = $this->crearDatosDeMaterial();

        $this->post(route('categorias.store'), [
            'nombre' => 'Accesorios',
            'descripcion' => 'Partes pequeñas',
        ])->assertRedirect(route('categorias.index'));
        $categoria = categoria::where('nombre', 'Accesorios')->firstOrFail();
        $this->put(route('categorias.update', $categoria), [
            'nombre' => 'Accesorios de cómputo',
            'descripcion' => 'Partes pequeñas',
        ])->assertRedirect(route('categorias.index'));
        $this->delete(route('categorias.destroy', $categoria))
            ->assertRedirect(route('categorias.index'));

        $this->post(route('entregantes.store'), [
            'nombre' => 'Marta',
            'apellido' => 'Díaz',
            'ci' => '67890',
            'telefono' => '555-0101',
            'direccion' => 'Calle 2',
        ])->assertRedirect(route('entregantes.index'));
        $entregante = Entregante::where('ci', '67890')->firstOrFail();
        $this->put(route('entregantes.update', $entregante), [
            'nombre' => 'Marta',
            'apellido' => 'Díaz',
            'ci' => '67890',
            'telefono' => '555-0102',
            'direccion' => 'Calle 3',
        ])->assertRedirect(route('entregantes.index'));
        $this->delete(route('entregantes.destroy', $entregante))
            ->assertRedirect(route('entregantes.index'));

        $this->post(route('recuperaciones.store'), [
            'fecha' => '2026-11-20',
            'observaciones' => 'Recuperación validada',
            'resultado' => 'Reutilizable',
            'material_recibido_id' => $datos['material']->id,
        ])->assertRedirect(route('recuperaciones.index'));
        $recuperacion = recuperacion::where('resultado', 'Reutilizable')->firstOrFail();
        $this->put(route('recuperaciones.update', $recuperacion), [
            'fecha' => '2026-11-20',
            'observaciones' => 'Recuperación validada',
            'resultado' => 'Recuperado',
            'material_recibido_id' => $datos['material']->id,
        ])->assertRedirect(route('recuperaciones.index'));
        $this->delete(route('recuperaciones.destroy', $recuperacion))
            ->assertRedirect(route('recuperaciones.index'));
    }

    public function test_asignacion_controller_uses_user_and_material_foreign_keys(): void
    {
        $datosRelacionados = $this->crearDatosDeMaterial();
        $datos = [
            'numeroTurno' => 12,
            'fechaInicio' => '2026-11-20',
            'fechaFinalizacion' => '2026-11-21',
            'prioridad' => 'Alta',
            'estado' => 'Pendiente',
            'observacion' => 'Asignación de prueba',
            'usuario_id' => $datosRelacionados['usuario']->id,
            'material_recibido_id' => $datosRelacionados['material']->id,
        ];

        $this->post(route('asignaciones.store'), $datos)
            ->assertRedirect(route('asignaciones.index'));

        $asignacion = asignacion::firstOrFail();
        $this->assertTrue($asignacion->usuario->is($datosRelacionados['usuario']));
        $this->assertTrue($asignacion->materialRecibido->is($datosRelacionados['material']));
        $this->get(route('asignaciones.show', $asignacion))
            ->assertOk()
            ->assertSee('Ana')
            ->assertSee('Laptop');

        $datos['estado'] = 'En proceso';
        $this->put(route('asignaciones.update', $asignacion), $datos)
            ->assertRedirect(route('asignaciones.index'));
        $this->assertSame('En proceso', $asignacion->fresh()->estado);
    }

    private function crearDatosDeMaterial(): array
    {
        $usuario = $this->crearUsuario();
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
        $material = materialRecibido::create([
            'nombre' => 'Laptop',
            'tipo' => 'Equipo',
            'marca' => 'Marca',
            'modelo' => 'Modelo X',
            'descripcion' => 'Equipo para reciclar',
            'cantidad' => 1,
            'categoria_id' => $categoria->id,
            'recepcion_id' => $recepcion->id,
        ]);
        $recuperacion = recuperacion::create([
            'fecha' => '2026-11-20',
            'observaciones' => 'Recuperación de prueba',
            'resultado' => 'Aprovechable',
            'material_recibido_id' => $material->id,
        ]);

        return compact('usuario', 'entregante', 'recepcion', 'categoria', 'material', 'recuperacion');
    }

    private function crearUsuario(): Usuario
    {
        return Usuario::create([
            'nombre' => 'Ana',
            'apellido' => 'López',
            'correo' => 'ana@example.com',
            'contraseña' => 'password123',
            'rol' => 'admin',
            'estado' => 'activo',
        ]);
    }
}
