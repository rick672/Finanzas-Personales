<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMovimiento extends EditRecord
{
    protected static string $resource = MovimientoResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    protected function afterSave()
    {
        Notification::make()
            ->title('Movimiento actualizado')
            ->body('El movimiento ha sido actualizado exitosamente.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->successNotification(
                Notification::make()
                    ->title('Movimiento eliminado')
                    ->body('El movimiento ha sido eliminado exitosamente.')
                    ->success()
            ),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Actualizar'),
            $this->getCancelFormAction()
                ->label('Cancelar'),
        ];
    }
    
}
