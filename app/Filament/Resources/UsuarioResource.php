<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsuarioResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Usuario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UsuarioResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Usuario::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = '5. Administración';
    protected static ?int $navigationSort = 1;

    protected static function getPermissionMap(): array
    {
        return [
            'view' => 'gestionar usuarios',
            'create' => 'gestionar usuarios',
            'edit' => 'gestionar usuarios',
            'delete' => 'gestionar usuarios',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L} ]+$/u') // ✅ Solo letras y espacios (soporta ñ, tildes)
                ->validationMessages([
                    'regex' => 'El nombre solo puede contener letras y espacios.',
                ]),
                
            Forms\Components\TextInput::make('apellido')
                ->required()
                ->maxLength(255)
                ->regex('/^[\p{L} ]+$/u') // ✅ Solo letras y espacios
                ->validationMessages([
                    'regex' => 'El apellido solo puede contener letras y espacios.',
                ]),
                
            Forms\Components\TextInput::make('correo')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
                
            Forms\Components\TextInput::make('contraseña')
                ->password()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->minLength(8)
                ->maxLength(255)
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->helperText('Dejar en blanco para mantener la contraseña actual.'),
                
            // ✅ El Select ES la validación: impide escribir texto, solo permite elegir roles existentes
            Forms\Components\Select::make('roles')
                ->relationship('roles', 'name')
                ->label('Rol del Usuario')
                ->multiple()
                ->preload()
                ->searchable()
                ->required(),
                
            // ✅ El Select ES la validación: impide escribir estados inventados
            Forms\Components\Select::make('estado')
                ->options([
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                ])
                ->required()
                ->default('Activo'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('apellido')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('correo')
                ->searchable()
                ->sortable(),
                
            // ✅ CORREGIDO: Ahora maneja tanto strings como arrays
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Rol')
                ->badge()
                ->color('primary')
                ->formatStateUsing(fn ($state): string => is_array($state) ? implode(', ', $state) : (string) $state),
                
            Tables\Columns\TextColumn::make('estado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Activo' => 'success',
                    'Inactivo' => 'danger',
                    default => 'gray',
                }),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('estado')
                ->options([
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsuarios::route('/'),
            'create' => Pages\CreateUsuario::route('/create'),
            'edit' => Pages\EditUsuario::route('/{record}/edit'),
        ];
    }
}