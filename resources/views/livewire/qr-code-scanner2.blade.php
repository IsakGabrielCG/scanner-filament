<div>
    <!-- Vídeo da câmera -->
    <video id="preview" class="mirrored-video"></video>

    <!-- Estilo CSS -->
    <style>
        .mirrored-video {
            transform: scaleX(-1);
            /* Inverte horizontalmente */
            width: 50%;
        }
        
    </style>

    <!-- Mostrar o código escaneado -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody id="scannedData">
                <!-- Aqui serão exibidos os códigos escaneados -->
            </tbody>
        </table>
    </div>
    <!-- -------------------------------------- -->

    <!-- Div para exibir a mensagem -->

    <!-- Inclua o script para instascan -->
    <script type="text/javascript" src="js/instascan.min.js"></script>

    {{-- <script type="text/javascript" src="{{ asset('js/instascan.min.js') }}"></script> 
    
    
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    --}}

    <script type="text/javascript">
        const preview = document.getElementById('preview');
        const isMobileDevice = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        // Função para ajustar a orientação da câmera no dispositivo móvel
        function adjustCameraOrientation(selectedCameraId) {
            if (isMobileDevice) {
                if (selectedCameraId === 'back') {
                    preview.style.transform = 'rotateY(180deg) scaleX(-1)';
                } else {
                    preview.style.transform = ' scaleX(-1)';
                }
            } else {
                preview.style.transform = 'scaleX(-1)';

            }
        }


        let scanner = null; // Inicializa o scanner Instascan

        // Função para listar as câmeras e configurar o scanner
        function listCamerasAndSetup() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (isMobileDevice) {
                    let backCamera = null;

                    cameras.forEach(function(camera) {
                        if (camera.name.toLowerCase().includes('back') && !backCamera) {
                            backCamera = camera;
                        }
                    });

                    if (backCamera) {
                        setupScanner(backCamera);
                    } else {
                        console.error('No suitable cameras found.');
                    }
                } else {
                    if (cameras.length > 0) {
                        setupScannerForPC(cameras);
                    } else {
                        console.error('No cameras found.');
                    }
                }
            }).catch(function(e) {
                console.error(e);
            });
        }

        // Função para configurar o scanner com a câmera selecionada (dispositivos móveis)
        function setupScanner(backCamera) {
            scanner = new Instascan.Scanner({
                video: preview
            });

            // orientar imagem depois que ela aparecer na tela
            preview.addEventListener('loadedmetadata', function() {
                const selectedCameraId = 'back'; 
                adjustCameraOrientation(selectedCameraId);
            });

            scanner.addListener('scan', function(content) {
                console.log(content);
                updateScannedData(content);
            });

            scanner.start(backCamera);
        }

        // Função para configurar o scanner com a câmera selecionada (PC)
        function setupScannerForPC(cameras) {

            scanner = new Instascan.Scanner({
                video: preview
            });

            scanner.addListener('scan', function(content) {
                console.log(content);
                updateScannedData(content);
            });

            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }

        // Função para atualizar a tabela com o código escaneado
        function updateScannedData(content) {
            let scannedData = document.getElementById('scannedData');
            let newRow = scannedData.insertRow();
            let newCell = newRow.insertCell(0);
            newCell.textContent = content;
        }

        // Inicia a configurações ao carregar a página
        listCamerasAndSetup();
    </script>

</div>
