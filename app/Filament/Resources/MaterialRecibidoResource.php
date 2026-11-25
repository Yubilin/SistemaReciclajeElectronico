<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialRecibidoResource\Pages;
use App\Filament\Resources\MaterialRecibidoResource\RelationManagers;
use App\Models\MaterialRecibido;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialRecibidoResource extends Resource
{
    protected static ?string $model = MaterialRecibido::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required(),
                Forms\Components\TextInput::make('tipo')
                    ->required(),
                Forms\Components\TextInput::make('marca')
                    ->required(),
                Forms\Components\TextInput::make('modelo')
                    ->required(),
                Forms\Components\TextInput::make('descripcion')
                    ->required(),
                Forms\Components\TextInput::make('cantidad')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('categoria_id')
                    ->relationship('categoria', 'id')
                    ->required(),
                Forms\Components\Select::make('recepcion_id')
                    ->relationship('recepcion', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('modelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recepcion.id')
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
            'index' => Pages\ListMaterialRecibidos::route('/'),
            'create' => Pages\CreateMaterialRecibido::route('/create'),
            'edit' => Pages\EditMaterialRecibido::route('/{record}/edit'),
        ];
    }
}
