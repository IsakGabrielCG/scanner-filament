<!doctype html>

<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- This script loads your compiled module.   -->
    <script type="text/javascript" src="/js/js/jsqrscanner.nocache.js"></script>
</head>

<body>

    <style>
        .qrscanner {

            width: 50%;
        }
        
    </style>

    <div>

        <div>
            {{-- mostra a camera --}}
            <div class="qrscanner" id="scanner">
            </div>

        </div>

        <!-- Mostrar o código escaneado -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Código Escaneado</th>
                    </tr>
                </thead>
                <tbody id="scannedData">
                    <!-- Aqui serão exibidos os códigos escaneados -->
                </tbody>
            </table>
        </div>


    </div>


    <script type="text/javascript">
        function onQRCodeScanned(scannedText) {
            var scannedDataElement = document.getElementById("scannedData");

            if (scannedDataElement) {
                // Criar uma nova linha na tabela para cada código escaneado
                var newRow = document.createElement("tr");
                var newData = document.createElement("td");
                newData.textContent = scannedText;
                newRow.appendChild(newData);

                // Adicionar a nova linha à tabela
                scannedDataElement.appendChild(newRow);
            }
        }


        //this function will provide the video stream
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




        //this function will be called when JsQRScanner is ready to use
        function JsQRScannerReady() {
            //create a new scanner passing to it a callback function that will be invoked when the scanner succesfully scan a QR code
            var jbScanner = new JsQRScanner(onQRCodeScanned);
            //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
            //reduce the size of analyzed image to increase performance on mobile devices
            jbScanner.setSnapImageMaxSize(300);
            var scannerParentElement = document.getElementById("scanner");
            if (scannerParentElement) {
                //append the jbScanner to an existing DOM element
                jbScanner.appendTo(scannerParentElement);
            }
        }
    </script>

</body>

</html>
