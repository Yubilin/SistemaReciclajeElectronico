<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriaResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Categoria::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = '1. Preparación';
    protected static ?int $navigationSort = 1;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver categoria',
            'create' => 'crear categoria',
            'edit' => 'editar categoria',
            'delete' => 'eliminar categoria',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L} ]+$/u')
                ->validationMessages(['regex' => 'El nombre solo puede contener letras y espacios.']),
                
            Forms\Components\TextInput::make('descripcion')
                ->required()
                ->maxLength(255)
                ->regex('~^[\p{L}\p{N}\s\p{P}]+$~u')
                ->validationMessages(['regex' => 'La descripción solo puede contener letras, números, espacios y signos de puntuación.']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('descripcion')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListCategorias::route('/'), 'create' => Pages\CreateCategoria::route('/create'), 'edit' => Pages\EditCategoria::route('/{record}/edit')];
    }
}