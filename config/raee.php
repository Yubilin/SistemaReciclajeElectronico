<?php

/*
|--------------------------------------------------------------------------
| Catálogos del sistema RAEE
|--------------------------------------------------------------------------
| Valores permitidos para los campos de tipo "estado", "prioridad",
| "resultado" y "rol". Se usan en la validación (web y API) y en los
| formularios. Para agregar un valor, solo edítalo aquí.
|
| Los colores de los badges se definen en
| resources/views/components/estado-badge.blade.php.
*/

return [

    'estados' => [
        // Recepción del material por parte del centro.
        'recepciones' => ['Pendiente', 'Entregado', 'Recibido', 'Cancelado'],

        // Componentes obtenidos del proceso de recuperación.
        'componentes' => ['Pendiente', 'Recuperado', 'Reciclado', 'Peligroso', 'Descartado'],

        // Asignaciones de trabajo a usuarios.
        'asignaciones' => ['Pendiente', 'En proceso', 'Completado', 'Cancelado'],

        // Cuentas de usuario.
        'usuarios' => ['Activo', 'Inactivo'],
    ],

    'prioridades' => ['Alta', 'Media', 'Baja'],

    'resultados' => ['Exitoso', 'Parcial', 'Fallido'],

    // Hoy los roles son solo una etiqueta: el sistema aún no tiene
    // autenticación ni permisos asociados a ellos.
    'roles' => ['Administrador', 'Recepcionista', 'Técnico'],

];
