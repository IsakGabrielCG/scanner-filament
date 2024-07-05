<div>
    <!-- Começa o script para qrcode -->
    <!-- Vídeo da câmera -->
    <video id="preview" class="mirrored-video"></video>

    <!-- Estilo CSS -->
    <style>
        .mirrored-video {
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

    <!-- Inclua o script para instascan -->
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script type="text/javascript">
        const preview = document.getElementById('preview');
        const isMobileDevice = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        // Função para ajustar a orientação da câmera no dispositivo móvel
        function adjustCameraOrientation(selectedCameraId) {
            if (isMobileDevice) {
                if (selectedCameraId === 'back') {
                    preview.style.transform = 'rotate(0deg)';
                } else {
                    preview.style.transform = 'rotate(0deg)';
                }
            } else {
                preview.style.transform = 'none'; // Reset transform for non-mobile devices
            }
        }

        // Chama a função ao carregar a página e ao redimensionar a janela
        adjustCameraOrientation('back'); // Inicia com a câmera frontal por padrão
        
        window.addEventListener('resize', function() {
            const selectedCameraId = document.getElementById('cameraOptions').value;
            adjustCameraOrientation(selectedCameraId);
        });

        let scanner = null; // Inicializa o scanner Instascan

        // Função para listar as câmeras e configurar o scanner
        function listCamerasAndSetup() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (isMobileDevice) {
                    let frontCamera = null;
                    let backCamera = null;

                    cameras.forEach(function(camera) {
                        if (camera.name.toLowerCase().includes('front') && !frontCamera) {
                            frontCamera = camera;
                        } else if (camera.name.toLowerCase().includes('back') && !backCamera) {
                            backCamera = camera;
                        }
                    });

                    if (frontCamera && backCamera) {
                        setupScanner(frontCamera, backCamera);
                        showCameraOptions(frontCamera, backCamera);
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
        function setupScanner(frontCamera, backCamera) {
            scanner = new Instascan.Scanner({
                video: preview
            });

            scanner.addListener('scan', function(content) {
                console.log(content);
                updateScannedData(content);
            });

            scanner.start(frontCamera);

            document.getElementById('cameraOptions').addEventListener('change', function() {
                const selectedCameraId = this.value;
                adjustCameraOrientation(selectedCameraId);
                const selectedCamera = selectedCameraId === 'front' ? frontCamera : backCamera;
                if (selectedCamera) {
                    scanner.stop();
                    scanner.start(selectedCamera);
                } else {
                    console.error('Selected camera not found.');
                }
            });
        }

        // Função para configurar o scanner com a câmera selecionada (PC)
        function setupScannerForPC(cameras) {
            const cameraOptions = document.getElementById('cameraOptions');

            scanner = new Instascan.Scanner({
                video: preview
            });

            cameras.forEach(function(camera) {
                const option = document.createElement('option');
                option.value = camera.id;
                option.textContent = camera.name || `Camera ${camera.id}`;
                cameraOptions.appendChild(option);
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

            document.getElementById('cameraOptions').addEventListener('change', function() {
                const selectedCameraId = this.value;
                changeCamera(selectedCameraId);
            });
        }

        // Função para mudar a câmera do scanner
        function changeCamera(cameraId) {
            if (scanner) {
                scanner.stop();
                Instascan.Camera.getCameras().then(function(cameras) {
                    const selectedCamera = cameras.find(camera => camera.id === cameraId);
                    if (selectedCamera) {
                        scanner.start(selectedCamera);
                    } else {
                        console.error('Camera not found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });
            }
        }

        // Função para exibir as opções de câmera no elemento select (dispositivos móveis)
        function showCameraOptions(frontCamera, backCamera) {
            const cameraOptions = document.getElementById('cameraOptions');
            cameraOptions.innerHTML = '';

            const frontOption = document.createElement('option');
            frontOption.value = 'front';
            frontOption.textContent = frontCamera.name || 'Front Camera';
            cameraOptions.appendChild(frontOption);

            const backOption = document.createElement('option');
            backOption.value = 'back';
            backOption.textContent = backCamera.name || 'Back Camera';
            cameraOptions.appendChild(backOption);
        }

        // Função para atualizar a tabela com o código escaneado
        function updateScannedData(content) {
            let scannedData = document.getElementById('scannedData');
            let newRow = scannedData.insertRow();
            let newCell = newRow.insertCell(0);
            newCell.textContent = content;
        }

        // Inicia a listagem das câmeras e configurações ao carregar a página
        listCamerasAndSetup();
    </script>

    <!-- Interface para escolha da câmera -->
    <div>
        <select id="cameraOptions">
            <!-- Opções de câmera serão adicionadas dinamicamente aqui -->
        </select>
    </div>
</div>
