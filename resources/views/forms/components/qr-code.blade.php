{{-- <!-- resources/views/forms/components/qr-code.blade.php -->

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">

    <div>
        <button type="button" onclick="openQRScannerModal()">Abrir Scanner</button>
        <!-- Adicione type="button" para evitar a submissão do formulário -->
    </div>
    
</x-dynamic-component> --}}



{{-- outros botoes --}}
{{-- <x-filament::button wire:click="openQRScannerModal()" color="danger" size="xl" icon="heroicon-o-qr-code" icon-position="after" tooltip="Abrir a camera">
    QrCode
</x-filament::button>

<x-filament::icon-button
    icon="heroicon-o-qr-code"
    label="New label"
    tag="a"
    href="https://filamentphp.com"
/>

<x-filament::link
    wire:click="openNewUserModal"
    tag="button"
>
    New user
</x-filament::link> --}}



{{-- resources/views/forms/components/qr-code.blade.php --}}

<x-filament::modal id="QrCodeModal">
    <x-slot name="trigger">
        <x-filament::button icon="heroicon-o-qr-code">
            QrCode
        </x-filament::button>
    </x-slot>

    <x-slot name="heading">
        Leitor de QrCode
    </x-slot>

    <x-slot name="description">
        Aponte a câmera para o QrCode
    </x-slot>

    <div class="container">
        @livewire('qr-code-scanner')
    </div>

</x-filament::modal>

