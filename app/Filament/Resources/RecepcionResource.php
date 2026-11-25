<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecepcionResource\Pages;
use App\Filament\Resources\RecepcionResource\RelationManagers;
use App\Models\Recepcion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecepcionResource extends Resource
{
    protected static ?string $model = Recepcion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->required(),
                Forms\Components\TextInput::make('observaciones')
                    ->required(),
                Forms\Components\TextInput::make('estado')
                    ->required(),
                Forms\Components\Select::make('usuario_id')
                    ->relationship('usuario', 'id')
                    ->required(),
                Forms\Components\Select::make('entregante_id')
                    ->relationship('entregante', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('observaciones')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('usuario.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entregante.id')
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
            'index' => Pages\ListRecepcions::route('/'),
            'create' => Pages\CreateRecepcion::route('/create'),
            'edit' => Pages\EditRecepcion::route('/{record}/edit'),
        ];
    }
}
