<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecepcionResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Recepcion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecepcionResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Recepcion::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = '2. Recepción de equipos';
    protected static ?int $navigationSort = 1;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver recepcion',
            'create' => 'crear recepcion',
            'edit' => 'editar recepcion',
            'delete' => 'eliminar recepcion',
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Recepciones';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Recepciones';
    }

    public static function getModelLabel(): string
    {
        return 'Recepción';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('fecha')
                ->required()
                ->default(now()),
                
            Forms\Components\Textarea::make('observaciones')
                ->maxLength(500)
                ->columnSpanFull(),
                
            Forms\Components\Select::make('estado')
                ->options([
                    'Pendiente' => 'Pendiente',
                    'Completada' => 'Completada',
                    'Cancelada' => 'Cancelada',
                ])
                ->required()
                ->default('Pendiente'),
                
            Forms\Components\Select::make('usuario_id')
                ->relationship('usuario', 'nombre')
                ->searchable()
                ->preload()
                ->required()
                ->label('Usuario'),
                
            Forms\Components\Select::make('entregante_id')
                ->relationship('entregante', 'nombre')
                ->getOptionLabelFromRecordUsing(fn ($record): string => trim("{$record->nombre} {$record->apellido}"))
                ->searchable(['nombre', 'apellido'])
                ->preload()
                ->required()
                ->label('Entregante'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('fecha')->date()->sortable(),
            Tables\Columns\TextColumn::make('estado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Completada' => 'success', 'Pendiente' => 'warning', 'Cancelada' => 'danger', default => 'gray',
                }),
            Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario')->searchable(),
            Tables\Columns\TextColumn::make('entregante.nombre')->label('Entregante')->searchable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('estado')->options(['Pendiente' => 'Pendiente', 'Completada' => 'Completada', 'Cancelada' => 'Cancelada']),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListRecepcions::route('/'), 'create' => Pages\CreateRecepcion::route('/create'), 'edit' => Pages\EditRecepcion::route('/{record}/edit')];
    }
}