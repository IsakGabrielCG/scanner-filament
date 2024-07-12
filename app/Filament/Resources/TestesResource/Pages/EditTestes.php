<?php

namespace App\Filament\Resources\TestesResource\Pages;

use App\Filament\Resources\TestesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestes extends EditRecord
{
    protected static string $resource = TestesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
