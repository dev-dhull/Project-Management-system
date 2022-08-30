<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
