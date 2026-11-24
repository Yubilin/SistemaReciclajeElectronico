@props(['valor' => null])

@php
    // Mapeo puramente visual: texto del estado -> color del badge.
    // Los valores válidos se definen en config/raee.php.
    $clave = \Illuminate\Support\Str::of((string) $valor)->ascii()->lower()->trim()->toString();

    $tono = match (true) {
        // Verde lima: terminado / correcto
        in_array($clave, [
            'entregado', 'recibido', 'recuperado', 'reciclado', 'completado',
            'exitoso', 'activo',
        ], true) => 'ok',
        // Ámbar: pendiente o requiere atención
        in_array($clave, [
            'pendiente', 'en proceso', 'parcial', 'peligroso', 'media',
        ], true) => 'warn',
        // Rojo: negativo
        in_array($clave, [
            'cancelado', 'descartado', 'fallido', 'inactivo', 'alta',
        ], true) => 'danger',
        // Cyan: informativo
        $clave === 'baja' => 'info',
        default => 'muted',
    };
@endphp

@if ($clave !== '')
    <span {{ $attributes->class(['raee-badge', 'raee-badge--' . $tono]) }}>{{ $valor }}</span>
@else
    <span class="text-body-secondary">—</span>
@endif
