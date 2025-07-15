<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCategoria extends EditRecord
{
    protected static string $resource = CategoriaResource::class;

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
            ->title('Categoria actualizada')
            ->body('La categoria ha sido actualizada exitosamente.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->successNotification(
                Notification::make()
                    ->title('Categoria eliminada')
                    ->body('La categoria ha sido eliminada exitosamente.')
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
