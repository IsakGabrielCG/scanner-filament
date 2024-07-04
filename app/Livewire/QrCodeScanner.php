<?php

namespace App\Livewire;

use Livewire\Component;

class QrCodeScanner extends Component
{
    public $scannedCodes = [];

    public function render()
    {
        return view('livewire.qr-code-scanner');
    }

    public function addScannedCode($content)
    {
        $this->scannedCodes[] = $content;
    }
}