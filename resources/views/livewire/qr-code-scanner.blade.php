<x-filament::modal id="QrCodeModal">
    <div>
        <!-- Vídeo da câmera -->
        <div>
            {{-- mostra a camera --}}
            <div class="qrscanner" id="scanner">
            </div>
        </div>
    
        <!-- Estilo CSS -->
    
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
        <!-- -------------------------------------- -->
    
        
        <script type="text/javascript" src="/js/js/jsqrscanner.nocache.js"></script>
    
        <script type="text/javascript">
            // Variável global para armazenar o código escaneado
            var scannedCode = '';
    
            // Conjunto para armazenar códigos QR já escaneados
            var scannedCodesSet = new Set();
    
            // Função para verificar se scannedCode não está vazio e fechar a modal
            function checkAndCloseModal() {
                var modalId = 'QrCodeModal'; // Substitua 'QrCodeModal' pelo ID real da sua modal
    
                if (scannedCode !== '') {
                    var modal = document.getElementById(modalId);
                    console.log(document.getElementById("QrCodeModal"));
                    if (modal) {
                        modal.close(); // Fecha a modal se estiver aberta
                    }
                }
            }
    
            // Chamada da função após escanear o código
            function onQRCodeScanned(scannedText) {
                // Verifique se o código já foi escaneado
                if (!scannedCodesSet.has(scannedText)) {
                    scannedCode = scannedText; // Salva o código escaneado na variável global
                    scannedCodesSet.add(scannedText); // Adiciona o código ao conjunto
    
                    var scannedDataElement = document.getElementById("scannedData");
    
                    if (scannedDataElement) {
                        // Criar uma nova linha na tabela para cada código escaneado
                        var newRow = document.createElement("tr");
                        var newData = document.createElement("td");
                        newData.textContent = scannedText;
                        newRow.appendChild(newData);
    
                        // Adicionar a nova linha à tabela
                        scannedDataElement.appendChild(newRow);
    
                        // Após adicionar o código escaneado, verifique e feche a modal
                        checkAndCloseModal();
                    }
                }
            }
    
            // Esta função será chamada quando o JsQRScanner estiver pronto para uso
            function JsQRScannerReady() {
                // Cria um novo scanner passando uma função de callback que será invocada quando o scanner escanear com sucesso um código QR
                var jbScanner = new JsQRScanner(onQRCodeScanned);
                // Reduz o tamanho da imagem analisada para aumentar o desempenho em dispositivos móveis
                jbScanner.setSnapImageMaxSize(300);
                var scannerParentElement = document.getElementById("scanner");
                if (scannerParentElement) {
                    // Adiciona o jbScanner a um elemento DOM existente
                    jbScanner.appendTo(scannerParentElement);
                }
            }
    
            document.addEventListener('close-modal', function(event) {
                var modalId = event.detail.id;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.close(); // Certifique-se de que o método close() está disponível no modal de Filament
                }
            });
        </script>
    </div>
    
</x-filament::modal>