<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecuperacionResource\Pages;
use App\Filament\Resources\RecuperacionResource\RelationManagers;
use App\Models\Recuperacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecuperacionResource extends Resource
{
    protected static ?string $model = Recuperacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->required(),
                Forms\Components\TextInput::make('observaciones')
                    ->required(),
                Forms\Components\TextInput::make('resultado')
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
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('observaciones')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resultado')
                    ->searchable(),
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
            'index' => Pages\ListRecuperacions::route('/'),
            'create' => Pages\CreateRecuperacion::route('/create'),
            'edit' => Pages\EditRecuperacion::route('/{record}/edit'),
        ];
    }
}
