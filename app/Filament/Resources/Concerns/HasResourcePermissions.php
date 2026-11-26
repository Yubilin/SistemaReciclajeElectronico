<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

trait HasResourcePermissions
{
    protected static function getPermissionMap(): array
    {
        return [];
    }

    protected static function hasResourcePermission(string $action): bool
    {
        $permission = static::getPermissionMap()[$action] ?? null;

        return filled($permission) && Gate::allows($permission);
    }

    protected static function canEditRecord(Model $record): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return static::hasResourcePermission('view');
    }

    public static function canCreate(): bool
    {
        return static::hasResourcePermission('create');
    }

    public static function canEdit(Model $record): bool
    {
        return static::hasResourcePermission('edit') && static::canEditRecord($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::hasResourcePermission('delete');
    }

    public static function canDeleteAny(): bool
    {
        return static::hasResourcePermission('delete');
    }
}