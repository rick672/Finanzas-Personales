<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresupuestoResource\Pages;
use App\Filament\Resources\PresupuestoResource\RelationManagers;
use App\Models\Presupuesto;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Presupuesto')
                    ->schema([
                        Forms\Components\Grid::make(12)
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Usuario')
                                    ->columnSpan(6)
                                    ->relationship('user', 'name')
                                    ->required(),
                                Forms\Components\Select::make('categoria_id')
                                    ->label('Categoria')
                                    ->columnSpan(6)
                                    ->relationship('categoria', 'nombre')
                                    ->required(),
                                Forms\Components\TextInput::make('monto_asignado')
                                    ->label('Monto Asignado')
                                    ->required()
                                    ->step(0.01)
                                    ->prefix('Bs.')
                                    ->columnSpan(3)
                                    ->numeric(),
                                Forms\Components\TextInput::make('monto_gastado')
                                    ->label('Monto Gastado')
                                    ->required()
                                    ->columnSpan(3)
                                    ->step(0.01)
                                    ->prefix('Bs.')
                                    ->numeric()
                                    ->disabled()
                                    ->default(0.00),
                                Forms\Components\Select::make('mes')
                                    ->label('Mes')
                                    ->required()
                                    ->options([
                                        'January' => 'Enero',
                                        'February' => 'Febrero',
                                        'March' => 'Marzo',
                                        'April' => 'Abril',
                                        'May' => 'Mayo',
                                        'June' => 'Junio',
                                        'July' => 'Julio',
                                        'August' => 'Agosto',
                                        'September' => 'Septiembre',
                                        'October' => 'Octubre',
                                        'November' => 'Noviembre',
                                        'December' => 'Diciembre',
                                    ])
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('anio')
                                    ->label('Año')
                                    ->required()
                                    ->columnSpan(3),
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
                    ->label('Usuario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto_asignado')
                    ->label('Monto Asignado')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Bs. '.number_format($state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto_gastado')
                    ->label('Monto Gastado')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Bs. '.number_format($state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('mes')
                    ->label('Mes')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anio')
                    ->label('Año')
                    ->searchable(),
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
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->successNotification(
                        Notification::make()
                            ->title('Presupuesto eliminado')
                            ->body('El presupuesto ha sido eliminado exitosamente.')
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
            'index' => Pages\ListPresupuestos::route('/'),
            'create' => Pages\CreatePresupuesto::route('/create'),
            'edit' => Pages\EditPresupuesto::route('/{record}/edit'),
        ];
    }
}
