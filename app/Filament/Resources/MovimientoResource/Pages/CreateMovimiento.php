<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function afterCreate()
    {
        Notification::make()
            ->title('Movimiento creado')
            ->body('El movimiento ha sido creado exitosamente.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Registrar'),
            $this->getCancelFormAction()
                ->label('Cancelar'),
        ];
    }
}
