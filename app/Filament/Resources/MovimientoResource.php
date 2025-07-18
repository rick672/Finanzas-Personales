<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoResource\Pages;
use App\Filament\Resources\MovimientoResource\RelationManagers;
use App\Models\Movimiento;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static ?string $navigationGroup = 'Finanzas';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Movimiento')
                    ->schema([
                        Forms\Components\Grid::make(6)
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Usuarios')
                                    ->relationship('user', 'name')
                                    ->columnSpan(3)
                                    ->required(),
                                Forms\Components\Select::make('categoria_id')
                                    ->label('Categorias')
                                    ->relationship('categoria', 'nombre')
                                    ->columnSpan(3)
                                    ->required(),
                                Forms\Components\Select::make('tipo')
                                    ->label('Tipo')
                                    ->columnSpan(2)
                                    ->options([
                                        'ingreso'=>'Ingreso', 
                                        'gasto'=>'Gasto'
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('monto')
                                    ->label('Monto')
                                    ->columnSpan(2)
                                    ->step(0.01)
                                    ->prefix('Bs.')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\DatePicker::make('fecha')
                                    ->label('Fecha')
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\RichEditor::make('descripcion')
                                    ->label('Descripcion')
                                    ->columnSpan(3)
                                    ->required(),
                                Forms\Components\FileUpload::make('foto')
                                    ->label('Foto')
                                    ->columnSpan(3)
                                    ->disk('public')
                                    ->directory('movimientos')
                                    ->image()
                                    ->imageEditor(),
                            ])
                    ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('Nro.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Bs. '.number_format($state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripcion')
                    ->limit(50)
                    ->html()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->width(80)
                    ->height(80)
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
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
                SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->label('Tipo'),
                SelectFilter::make('Categoria')
                    ->relationship('categoria', 'nombre')
                    ->label('Categoria'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->successNotification(
                        Notification::make()
                            ->title('Movimiento eliminado')
                            ->body('El movimiento ha sido eliminado exitosamente.')
                            ->success()
                    ),
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
            'index' => Pages\ListMovimientos::route('/'),
            'create' => Pages\CreateMovimiento::route('/create'),
            'edit' => Pages\EditMovimiento::route('/{record}/edit'),
        ];
    }
}
