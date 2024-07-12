<div>
    <div>
        <div class="qrscanner" id="scanner"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Código Escaneado</th>
                </tr>
            </thead>
            <tbody id="scannedData"></tbody>
        </table>
    </div>

    <script type="text/javascript" src="/js/js/jsqrscanner.nocache.js"></script>

    <script type="text/javascript">
        function onQRCodeScanned(scannedText) {
            var scannedDataElement = document.getElementById("scannedData");

            if (scannedDataElement) {
                var newRow = document.createElement("tr");
                var newData = document.createElement("td");
                newData.textContent = scannedText;
                newRow.appendChild(newData);
                scannedDataElement.appendChild(newRow);
            }

            Livewire.emit('scan', scannedText);
        }

        function provideVideo() {
            var n = navigator;

            if (n.mediaDevices && n.mediaDevices.getUserMedia) {
                return n.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    },
                    audio: false
                });
            }

            return Promise.reject('Your browser does not support getUserMedia');
        }

        function provideVideoQQ() {
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (isMobile && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                return navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            exact: 'environment'
                        }
                    },
                    audio: false
                });
            } else if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                return navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
            }

            return Promise.reject('Your browser does not support getUserMedia');
        }

        function JsQRScannerReady() {
            var jbScanner = new JsQRScanner(onQRCodeScanned);
            jbScanner.setSnapImageMaxSize(300);
            var scannerParentElement = document.getElementById("scanner");
            if (scannerParentElement) {
                jbScanner.appendTo(scannerParentElement);
            }
        }

        document.addEventListener('close-modal', function (event) {
            var modal = document.querySelector('x-filament::modal');
            if (modal) {
                modal.remove(); // Fechar o modal
            }

            var qrCodeInput = document.querySelector('input[name="QrCode"]');
            if (qrCodeInput) {
                qrCodeInput.value = event.detail.code; // Preencher o campo com o código QR escaneado
            }
        });
    </script>
</div>