<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarioResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Inventario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;

class InventarioResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Inventario::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = '4. Inventario';
    protected static ?int $navigationSort = 1;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver inventario',
            'create' => 'crear inventario',
            'edit' => 'editar inventario',
            'delete' => 'eliminar inventario',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('cantidadDisponible')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(0)
                ->label('Cantidad Disponible'),
                
            Forms\Components\TextInput::make('cantidadMinima')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(0)
                ->disabled(fn (): bool => Gate::allows('editar inventario') && ! Gate::allows('gestionar usuarios'))
                ->dehydrated(fn (): bool => Gate::allows('gestionar usuarios'))
                ->label('Cantidad Mínima'),
                
            Forms\Components\Select::make('componente_id')
                ->relationship('componente', 'nombre')
                ->searchable()
                ->preload()
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled(fn (): bool => Gate::allows('editar inventario') && ! Gate::allows('gestionar usuarios'))
                ->dehydrated(fn (): bool => Gate::allows('gestionar usuarios'))
                ->label('Componente'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('componente.nombre')->label('Componente')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('cantidadDisponible')->numeric()->sortable(),
            Tables\Columns\TextColumn::make('cantidadMinima')->numeric()->sortable(),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListInventarios::route('/'), 'create' => Pages\CreateInventario::route('/create'), 'edit' => Pages\EditInventario::route('/{record}/edit')];
    }
}