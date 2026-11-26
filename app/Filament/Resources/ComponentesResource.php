<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComponentesResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Componentes;
use App\Models\Recuperacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComponentesResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Componentes::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = '3. Recuperación y componentes';
    protected static ?int $navigationSort = 3;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver componente',
            'create' => 'crear componente',
            'edit' => 'editar componente',
            'delete' => 'eliminar componente',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L}\p{N}\s]+$/u')
                ->validationMessages(['regex' => 'Solo se permiten letras, números y espacios.']),
                
            Forms\Components\TextInput::make('descripcion')
                ->required()
                ->maxLength(255),
                
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(0),
                
            Forms\Components\Select::make('estado')
                ->options([
                    'Disponible' => 'Disponible',
                    'Dañado' => 'Dañado',
                    'En uso' => 'En uso',
                ])
                ->required()
                ->default('Disponible'),
                
            Forms\Components\Select::make('recuperacion_id')
                ->options(fn () => Recuperacion::query()
                    ->with('materialRecibido')
                    ->orderByDesc('fecha')
                    ->get()
                    ->mapWithKeys(fn (Recuperacion $recuperacion): array => [
                        $recuperacion->id => sprintf(
                            'Recuperación #%d · %s · %s · %s',
                            $recuperacion->id,
                            $recuperacion->materialRecibido?->nombre ?? 'Material sin nombre',
                            $recuperacion->resultado,
                            \Carbon\Carbon::parse($recuperacion->fecha)->format('d/m/Y'),
                        ),
                    ])
                    ->all())
                ->searchable()
                ->exists(table: 'recuperacions', column: 'id')
                ->required()
                ->label('Recuperación'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('cantidad')->numeric()->sortable(),
            Tables\Columns\TextColumn::make('estado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Disponible' => 'success', 'Dañado' => 'danger', 'En uso' => 'warning', default => 'gray',
                }),
            Tables\Columns\TextColumn::make('recuperacion.id')
                ->label('Recuperación')
                ->formatStateUsing(fn ($state, $record): string => sprintf(
                    'Recuperación #%s · %s',
                    $state,
                    $record->recuperacion?->materialRecibido?->nombre ?? 'Material sin nombre',
                ))
                ->sortable(),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListComponentes::route('/'), 'create' => Pages\CreateComponentes::route('/create'), 'edit' => Pages\EditComponentes::route('/{record}/edit')];
    }
}