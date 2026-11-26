<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialRecibidoResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\MaterialRecibido;
use App\Models\Recepcion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialRecibidoResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = MaterialRecibido::class;
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $navigationGroup = '2. Recepción de equipos';
    protected static ?int $navigationSort = 2;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver material',
            'create' => 'crear material',
            'edit' => 'editar material',
            'delete' => 'eliminar material',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L}\p{N}\s]+$/u')
                ->validationMessages(['regex' => 'Solo letras, números y espacios.']),
                
            Forms\Components\TextInput::make('tipo')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L}\s]+$/u')
                ->validationMessages(['regex' => 'El tipo solo puede contener letras y espacios.']),
                
            Forms\Components\TextInput::make('marca')
                ->required()
                ->maxLength(255)
                ->alphaNum()
                ->validationMessages(['alpha_num' => 'La marca solo puede contener letras y números.']),
                
            Forms\Components\TextInput::make('modelo')
                ->required()
                ->maxLength(255)
                ->alphaNum()
                ->validationMessages(['alpha_num' => 'El modelo solo puede contener letras y números.']),
                
            Forms\Components\Textarea::make('descripcion')
                ->required()
                ->maxLength(500)
                ->columnSpanFull(),
                
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(1),
                
            Forms\Components\Select::make('categoria_id')
                ->relationship('categoria', 'nombre')
                ->searchable()
                ->preload()
                ->required(),
                
            Forms\Components\Select::make('recepcion_id')
                ->options(fn () => Recepcion::query()
                    ->with('entregante')
                    ->orderByDesc('fecha')
                    ->get()
                    ->mapWithKeys(fn (Recepcion $recepcion): array => [
                        $recepcion->id => sprintf(
                            'Recepción #%d · %s · %s',
                            $recepcion->id,
                            trim(($recepcion->entregante?->nombre ?? '') . ' ' . ($recepcion->entregante?->apellido ?? '')),
                            \Carbon\Carbon::parse($recepcion->fecha)->format('d/m/Y'),
                        ),
                    ])
                    ->all())
                ->searchable()
                ->exists(table: 'recepcions', column: 'id')
                ->required()
                ->label('Recepción'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('marca')->searchable(),
            Tables\Columns\TextColumn::make('modelo')->searchable(),
            Tables\Columns\TextColumn::make('cantidad')->numeric()->sortable(),
            Tables\Columns\TextColumn::make('categoria.nombre')->label('Categoría')->searchable(),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListMaterialRecibidos::route('/'), 'create' => Pages\CreateMaterialRecibido::route('/create'), 'edit' => Pages\EditMaterialRecibido::route('/{record}/edit')];
    }
}