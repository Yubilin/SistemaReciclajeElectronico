<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntreganteResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Entregante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EntreganteResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Entregante::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = '1. Preparación';
    protected static ?int $navigationSort = 2;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver entregante',
            'create' => 'crear entregante',
            'edit' => 'editar entregante',
            'delete' => 'eliminar entregante',
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
                
            Forms\Components\TextInput::make('apellido')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L} ]+$/u')
                ->validationMessages(['regex' => 'El apellido solo puede contener letras y espacios.']),
                
            Forms\Components\TextInput::make('ci')
                ->required()
                ->maxLength(20)
                ->regex('/^[0-9\-]+$/')
                ->validationMessages(['regex' => 'El CI solo puede contener números y guiones.']),
                
            Forms\Components\TextInput::make('telefono')
                ->tel()
                ->required()
                ->maxLength(20)
                ->regex('/^[0-9\+\-\s]+$/')
                ->validationMessages(['regex' => 'El teléfono solo puede contener números, signos +, - y espacios.']),
                
            Forms\Components\TextInput::make('direccion')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L}\p{N}\s\,\.\#\-]+$/u')
                ->validationMessages(['regex' => 'Dirección inválida.']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('apellido')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ci')->label('C.I.')->searchable(),
            Tables\Columns\TextColumn::make('telefono')->searchable(),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListEntregantes::route('/'), 'create' => Pages\CreateEntregante::route('/create'), 'edit' => Pages\EditEntregante::route('/{record}/edit')];
    }
}