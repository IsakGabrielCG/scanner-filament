  <!-- No seu arquivo blade do Livewire -->
  <div>
    <!-- Começa o script para qrcode -->

    <!-- Vídeo da câmera -->
    <video id="preview" class="mirrored-video"></video>

    <!-- Estilo CSS -->
    <style>
        .mirrored-video {
            transform: scaleX(-1);
            /* Espelha horizontalmente o vídeo */
            transform-origin: center;
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
                @foreach ($scannedCodes as $code)
                    <tr>
                        <td>{{ $code }}</td>
                    </tr>
                @endforeach
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
        function adjustCameraOrientation() {
            if (isMobileDevice) {
                // Verifica a orientação do dispositivo e aplica a transformação necessária
                if (window.innerWidth > window.innerHeight) {
                    preview.style.transform = 'rotate(90deg)';
                } else {
                    preview.style.transform = 'rotate(0deg)';
                }
            } else {
                preview.style.transform = 'none'; // Reset transform for non-mobile devices
            }
        }

        // Chama a função ao carregar a página e ao redimensionar a janela
        adjustCameraOrientation();
        window.addEventListener('resize', adjustCameraOrientation);

        let scanner = null; // Inicializa o scanner Instascan

        // Função para listar as câmeras e configurar o scanner
        function listCamerasAndSetup() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    setupScanner(cameras); // Configura o scanner com as câmeras disponíveis
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        }

        // Função para configurar o scanner com a câmera selecionada
        function setupScanner(cameras) {
            const cameraOptions = document.getElementById('cameraOptions');
            
            scanner = new Instascan.Scanner({
                video: preview
            });

            // Atualiza as opções de câmera no elemento select
            cameras.forEach(function(camera) {
                const option = document.createElement('option');
                option.value = camera.id;
                option.textContent = camera.name || `Camera ${camera.id}`;
                cameraOptions.appendChild(option);
            });

            // Inicia o scanner com a primeira câmera disponível
            scanner.addListener('scan', function(content) {
                console.log(content);
                updateScannedData(content); // Atualiza a tabela com o código escaneado
            });

            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }

        // Função para mudar a câmera do scanner
        function changeCamera(cameraId) {
            if (scanner) {
                scanner.stop(); // Para o scanner atual
                Instascan.Camera.getCameras().then(function(cameras) {
                    const selectedCamera = cameras.find(camera => camera.id === cameraId);
                    if (selectedCamera) {
                        scanner.start(selectedCamera); // Inicia o scanner com a câmera selecionada
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

    <!-- Interface para escolha da câmera -->
    <div>
        <select id="cameraOptions" onchange="changeCamera(this.value)">
            <!-- Opções de câmera serão adicionadas dinamicamente aqui -->
        </select>
    </div>
</div>