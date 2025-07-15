<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Mockery\Matcher\Not;

class CreateCategoria extends CreateRecord
{
    protected static string $resource = CategoriaResource::class;

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
            ->title('Categoria creada')
            ->body('La categoria ha sido creada exitosamente.')
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
