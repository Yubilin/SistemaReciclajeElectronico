<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Asignacion;
use App\Models\Usuario;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class AsignacionResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Asignacion::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = '3. Recuperación y componentes';
    protected static ?int $navigationSort = 1;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'ver asignacion',
            'create' => 'crear asignacion',
            'edit' => 'editar asignacion',
            'delete' => 'eliminar asignacion',
        ];
    }

    protected static function canEditRecord(Model $record): bool
    {
        return Gate::allows('gestionar usuarios')
            || ((int) $record->getAttribute('usuario_id') === (int) Filament::auth()->id());
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Gate::allows('editar asignacion') && ! Gate::allows('gestionar usuarios')) {
            $query->where('usuario_id', Filament::auth()->id());
        }

        return $query;
    }
    public static function getNavigationLabel(): string
    {
        return 'Asignaciones';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Asignaciones';
    }

    public static function getModelLabel(): string
    {
        return 'Asignación';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('numeroTurno')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(1)
                ->label('Número de Turno'),
                
            Forms\Components\DatePicker::make('fechaInicio')
                ->required()
                ->label('Fecha de Inicio'),
                
            Forms\Components\DatePicker::make('fechaFinalizacion')
                ->required()
                ->afterOrEqual('fechaInicio')
                ->label('Fecha de Finalización'),
                
            Forms\Components\Select::make('prioridad')
                ->options([
                    'Baja' => 'Baja',
                    'Media' => 'Media',
                    'Alta' => 'Alta',
                ])
                ->required()
                ->default('Media'),
                
            Forms\Components\Select::make('estado')
                ->options([
                    'Pendiente' => 'Pendiente',
                    'En Progreso' => 'En Progreso',
                    'Completada' => 'Completada',
                ])
                ->required()
                ->default('Pendiente'),
                
            Forms\Components\Textarea::make('observacion')
                ->maxLength(500)
                ->columnSpanFull(),
                
            Forms\Components\Select::make('usuario_id')
                ->relationship(
                    'usuario',
                    'nombre',
                    modifyQueryUsing: fn (Builder $query) => $query->whereHas(
                        'roles',
                        fn (Builder $roleQuery) => $roleQuery->where('name', 'Técnico'),
                    ),
                )
                ->getOptionLabelFromRecordUsing(fn (Usuario $record): string => trim("{$record->nombre} {$record->apellido}"))
                ->searchable(['nombre', 'apellido'])
                ->preload()
                ->disabled(fn (): bool => Gate::allows('editar asignacion') && ! Gate::allows('gestionar usuarios'))
                ->dehydrated(fn (): bool => Gate::allows('gestionar usuarios'))
                ->required()
                ->helperText('Máximo 7 trabajos pendientes o en progreso por técnico.')
                ->label('Técnico Asignado'),
                
            Forms\Components\Select::make('material_recibido_id')
                ->relationship('materialRecibido', 'nombre')
                ->searchable()
                ->preload()
                ->disabled(fn (): bool => Gate::allows('editar asignacion') && ! Gate::allows('gestionar usuarios'))
                ->dehydrated(fn (): bool => Gate::allows('gestionar usuarios'))
                ->required()
                ->label('Material'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('numeroTurno')->numeric()->sortable()->label('Turno'),
            Tables\Columns\TextColumn::make('fechaInicio')->date()->sortable(),
            Tables\Columns\TextColumn::make('fechaFinalizacion')->date()->sortable(),
            Tables\Columns\TextColumn::make('prioridad')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Alta' => 'danger', 'Media' => 'warning', 'Baja' => 'success', default => 'gray',
                }),
            Tables\Columns\TextColumn::make('estado')->badge(),
            Tables\Columns\TextColumn::make('usuario.nombre')->label('Técnico')->searchable(),
            Tables\Columns\TextColumn::make('materialRecibido.nombre')->label('Material')->limit(30),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('estado')->options(['Pendiente' => 'Pendiente', 'En Progreso' => 'En Progreso', 'Completada' => 'Completada']),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return ['index' => Pages\ListAsignacions::route('/'), 'create' => Pages\CreateAsignacion::route('/create'), 'edit' => Pages\EditAsignacion::route('/{record}/edit')];
    }
}