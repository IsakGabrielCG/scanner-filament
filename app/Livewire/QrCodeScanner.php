<?php

namespace App\Livewire;

use Livewire\Component;

class QrCodeScanner extends Component
{
    public $scannedCode = '';

    protected $listeners = ['codeScanned'];

    public function scan($code)
    {
        $this->scannedCode = $code;
        $this->emit('codeScanned', $code);
    }

    public function codeScanned($code)
    {
        $this->dispatchBrowserEvent('close-modal', ['code' => $code]);
    }

    public function render()
    {
        return view('livewire.qr-code-scanner');
    }
}
