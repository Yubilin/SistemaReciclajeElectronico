<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecuperacionResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Recuperacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecuperacionResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Recuperacion::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = '3. Recuperación y componentes';
    protected static ?int $navigationSort = 2;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver recuperacion',
            'create' => 'crear recuperacion',
            'edit' => 'editar recuperacion',
            'delete' => 'eliminar recuperacion',
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Recuperaciones';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Recuperaciones';
    }

    public static function getModelLabel(): string
    {
        return 'Recuperación';
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
                
            Forms\Components\Select::make('resultado')
                ->options([
                    'Recuperado' => 'Recuperado',
                    'Desechado' => 'Desechado',
                    'En proceso' => 'En proceso',
                ])
                ->required()
                ->default('En proceso'),
                
            Forms\Components\Select::make('material_recibido_id')
                ->relationship('materialRecibido', 'nombre')
                ->searchable()
                ->preload()
                ->required()
                ->label('Material'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('fecha')->date()->sortable(),
            Tables\Columns\TextColumn::make('resultado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Recuperado' => 'success', 'Desechado' => 'danger', 'En proceso' => 'warning', default => 'gray',
                }),
            Tables\Columns\TextColumn::make('materialRecibido.nombre')->label('Material')->searchable()->limit(30),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListRecuperacions::route('/'), 'create' => Pages\CreateRecuperacion::route('/create'), 'edit' => Pages\EditRecuperacion::route('/{record}/edit')];
    }
}