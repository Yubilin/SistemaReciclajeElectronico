<?php

namespace App\Support;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

/**
 * Acceso a los catálogos definidos en config/raee.php.
 * Ejemplo de clave: 'estados.componentes', 'roles', 'prioridades'.
 */
class Catalogo
{
    /** @return list<string> */
    public static function valores(string $clave): array
    {
        return config("raee.$clave", []);
    }

    /** Opciones [valor => etiqueta] listas para un <select>. */
    public static function opciones(string $clave): array
    {
        $valores = self::valores($clave);

        return array_combine($valores, $valores);
    }

    public static function regla(string $clave): In
    {
        return Rule::in(self::valores($clave));
    }
}
