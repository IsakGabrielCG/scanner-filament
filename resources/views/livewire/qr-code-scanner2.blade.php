<!-- No seu arquivo blade do Livewire -->
<div>
    <!-- Começa o script para qrcode -->
    <!-- Vídeo da câmera -->
    <video id="preview" class="mirrored-video"></video>

    <!-- Estilo CSS -->
    <style>
        .mirrored-video {
            /* transform: scaleX(-1);
            /* Espelha horizontalmente o vídeo */
            /* transform-origin: center;  */
            /* Define o ponto de origem da transformação */
            width: 100%;
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
                // Verifica a orientação do dispositivo e aplica a transformação necessária
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
        adjustCameraOrientation('front'); // Inicia com a câmera frontal por padrão
        
        window.addEventListener('resize', function() {
            const selectedCameraId = document.getElementById('cameraOptions').value;
            adjustCameraOrientation(selectedCameraId);
        });

        let scanner = null; // Inicializa o scanner Instascan

        // Função para listar as câmeras e configurar o scanner
        function listCamerasAndSetup() {
            Instascan.Camera.getCameras().then(function(cameras) {
                let frontCamera = null;
                let backCamera = null;

                // Filtra as câmeras frontal e traseira, se disponíveis
                cameras.forEach(function(camera) {
                    if (camera.name.toLowerCase().includes('front') && !frontCamera) {
                        frontCamera = camera;
                    } else if (camera.name.toLowerCase().includes('back') && !backCamera) {
                        backCamera = camera;
                    }
                });

                // Configura o scanner com a câmera frontal e/ou traseira encontrada
                if (frontCamera && backCamera) {
                    setupScanner(frontCamera, backCamera); // Passa as duas câmeras encontradas
                    showCameraOptions(frontCamera, backCamera); // Exibe as opções de câmera
                } else {
                    console.error('No suitable cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        }

        // Função para configurar o scanner com a câmera selecionada
        function setupScanner(frontCamera, backCamera) {
            scanner = new Instascan.Scanner({
                video: preview
            });

            // Inicia o scanner com a câmera frontal por padrão
            scanner.addListener('scan', function(content) {
                console.log(content);
                updateScannedData(content); // Atualiza a tabela com o código escaneado
            });

            scanner.start(frontCamera); // Inicia o scanner com a câmera frontal

            // Listener para mudança de câmera
            document.getElementById('cameraOptions').addEventListener('change', function() {
                const selectedCameraId = this.value;
                adjustCameraOrientation(selectedCameraId); // Ajusta a orientação ao trocar a câmera
                const selectedCamera = selectedCameraId === 'front' ? frontCamera : backCamera;
                if (selectedCamera) {
                    scanner.stop(); // Para o scanner atual
                    scanner.start(selectedCamera); // Inicia o scanner com a câmera selecionada
                } else {
                    console.error('Selected camera not found.');
                }
            });
        }

        // Função para exibir as opções de câmera no elemento select
        function showCameraOptions(frontCamera, backCamera) {
            const cameraOptions = document.getElementById('cameraOptions');
            cameraOptions.innerHTML = ''; // Limpa as opções existentes

            // Adiciona a opção de câmera frontal
            const frontOption = document.createElement('option');
            frontOption.value = 'front';
            frontOption.textContent = frontCamera.name || 'Front Camera';
            cameraOptions.appendChild(frontOption);

            // Adiciona a opção de câmera traseira
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
