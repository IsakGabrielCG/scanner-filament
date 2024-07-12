<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class QrCode extends Field
{
    protected string $view = 'forms.components.qr-code';

    public function getValue(): string
    {
        $value = parent::getValue();
        return $value;
    }
}