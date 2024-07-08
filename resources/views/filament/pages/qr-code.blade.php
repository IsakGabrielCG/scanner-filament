<x-filament-panels::page>
    <!-- No seu arquivo blade do Livewire -->
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
    
            /* Esconder o seletor de câmeras em dispositivos móveis */
            @media only screen and (max-width: 768px) {
                #cameraOptionsContainer {
                    display: none;
                }
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
        <div id="message"></div>
    
        <!-- Inclua o script para instascan -->
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    
        <script type="text/javascript">
            const preview = document.getElementById('preview');
            const message = document.getElementById('message');
            const isMobileDevice = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
            // Função para ajustar a orientação da câmera no dispositivo móvel
            function adjustCameraOrientation(selectedCameraId) {
                if (isMobileDevice) {
                    if (selectedCameraId === 'back') {
                        preview.style.transform = 'rotateY(180deg) scaleX(-1)';
                    } else {
                        preview.style.transform = 'rotateY(180deg) scaleX(-1)';
                    }
                } else {
                    preview.style.transform = 'scaleX(-1)';
    
                }
            }
    
            // Chama a função ao redimensionar a janela
    
    
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
    
        <!-- Interface para escolha da câmera (apenas PC) -->
        <div id="cameraOptionsContainer">
            <select id="cameraOptions">
                <!-- Opções de câmera serão adicionadas dinamicamente aqui -->
            </select>
        </div>
    </div>
    


</x-filament-panels::page>
