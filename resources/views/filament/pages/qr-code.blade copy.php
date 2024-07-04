<x-filament-panels::page>
    <div>
        {{-- começa o script para qrcode --}}
        <video id="preview"></video>

        {{-- mostrar o code --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        
                    </tr>
                </thead>

                <tbody id="scannedData">
                    @foreach ($this->scannedCodes as $code)
                        <tr>
                            <td>{{ $code }}</td>
                        </tr>
                    @endforeach
                </tbody>
                     

            </table>
        </div>
        {{-- -------------------------------------- --}}

        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

        {{-- assim ele está en um arquivo no projeto --}}
        {{-- <script type="text/javascript" src="{{ asset('js/instascan.min.js') }}"></script> --}}

        <script type="text/javascript">
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview')
            });
            scanner.addListener('scan', function(content) {
                console.log(content);
    
                // não faz parte do codigo do qrcode, serve para mostar o que tem no qrcode
                let scannedData = document.getElementById('scannedData');
                let newRow = scannedData.insertRow();
                let newCell = newRow.insertCell(0);
                newCell.textContent = content;
            
                //-------------------------------
    
            });
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        </script>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            window.livewire.on('codeScanned', content => {
                @this.call('addScannedCode', content);
            });
        });
    </script>

    {{-- gera o qr code com a mensagem dentro, foi preciso rodar o comando (composer require simplesoftwareio/simple-qrcode) --}}

    
    

    {{ QrCode::generate('teste do qr code')}}

    


</x-filament-panels::page>
