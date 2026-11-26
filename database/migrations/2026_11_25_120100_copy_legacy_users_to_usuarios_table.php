<?php

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            foreach (DB::table('users')->orderBy('id')->get() as $user) {
                if (DB::table('usuarios')->where('correo', $user->email)->exists()) {
                    continue;
                }

                $name = preg_split('/\s+/', trim($user->name), 2) ?: [];
                $now = now();
                $usuarioId = DB::table('usuarios')->insertGetId([
                    'nombre' => $name[0] ?? 'Usuario',
                    'apellido' => $name[1] ?? 'Usuario',
                    'correo' => $user->email,
                    'contraseña' => $user->password,
                    'rol' => null,
                    'estado' => 'Activo',
                    'remember_token' => $user->remember_token,
                    'created_at' => $user->created_at ?? $now,
                    'updated_at' => $user->updated_at ?? $now,
                ]);

                foreach (['model_has_roles', 'model_has_permissions'] as $table) {
                    $assignments = DB::table($table)
                        ->where('model_type', User::class)
                        ->where('model_id', $user->id)
                        ->get();

                    foreach ($assignments as $assignment) {
                        $row = (array) $assignment;
                        $row['model_type'] = Usuario::class;
                        $row['model_id'] = $usuarioId;

                        DB::table($table)->insertOrIgnore($row);
                    }
                }
            }
        });
    }

    public function down(): void
    {
        // Keep the copied accounts so rolling back a deployment cannot lock out administrators.
    }
};