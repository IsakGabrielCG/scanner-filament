<?php

namespace App\Filament\Resources\TestesResource\Pages;

use App\Filament\Resources\TestesResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTestes extends CreateRecord
{
    protected static string $resource = TestesResource::class;


    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('filament-panels::resources/pages/create-record.form.actions.create.label'))
            ->submit('create')
            ->keyBindings(['mod+s'])
            ->action(function () {
                //return $this->dispatch('open-modal', id: 'QrCodeModal');;
            });
    }

    public function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Action::make('customAction')
                ->action(function () {
                    //call your modal
                    $this->dispatch('open-modal', id: 'QrCodeModal');
                }),
        ];
    }
}
