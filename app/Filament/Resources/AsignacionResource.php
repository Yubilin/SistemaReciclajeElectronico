<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numeroTurno')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('fechaInicio')
                    ->required(),
                Forms\Components\DatePicker::make('fechaFinalizacion')
                    ->required(),
                Forms\Components\TextInput::make('prioridad')
                    ->required(),
                Forms\Components\TextInput::make('estado')
                    ->required(),
                Forms\Components\TextInput::make('observacion')
                    ->required(),
                Forms\Components\Select::make('usuario_id')
                    ->relationship('usuario', 'id')
                    ->required(),
                Forms\Components\Select::make('material_recibido_id')
                    ->relationship('materialRecibido', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numeroTurno')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fechaInicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fechaFinalizacion')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prioridad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('observacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('usuario.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('materialRecibido.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsignacions::route('/'),
            'create' => Pages\CreateAsignacion::route('/create'),
            'edit' => Pages\EditAsignacion::route('/{record}/edit'),
        ];
    }
}
