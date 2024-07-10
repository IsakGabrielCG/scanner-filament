<!doctype html>

<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- This script loads your compiled module.   -->
    <script type="text/javascript" src="/js/js/jsqrscanner.nocache.js"></script>
</head>

<body>

    <div>

        <div>
            {{-- mostra a camera --}}
            <div class="qrscanner" id="scanner">
            </div>

        </div>

        <div>
            <div>
                Texto escaneado
                <div class="FlexPanel form-field-input-panel">
                    <textarea id="scannedTextMemo"> </textarea>
                </div>
            </div>

            <div>
                Historico de textos escaneados
                <div>
                    <textarea id="scannedTextMemoHist"> </textarea>
                </div>
            </div>

        </div>

    </div>


    <script type="text/javascript">
        function onQRCodeScanned(scannedText) {
            var scannedTextMemo = document.getElementById("scannedTextMemo");
            if (scannedTextMemo) {
                scannedTextMemo.value = scannedText;
            }
            var scannedTextMemoHist = document.getElementById("scannedTextMemoHist");
            if (scannedTextMemoHist) {
                scannedTextMemoHist.value = scannedTextMemoHist.value + '\n' + scannedText;
            }
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

        //this function will be called when JsQRScanner is ready to use
        function JsQRScannerReady() {
            //create a new scanner passing to it a callback function that will be invoked when
            //the scanner succesfully scan a QR code
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