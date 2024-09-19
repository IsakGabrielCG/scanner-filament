<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class QrCode extends Page
{
    public $scannedCodes = [];

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.pages.qr-code';

    public function addScannedCode($code)
    {
        $this->scannedCodes[] = $code;
    }
}
