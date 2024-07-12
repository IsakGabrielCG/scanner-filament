<!-- resources/views/modal.blade.php -->

<div class="modal fade" id="qrScannerModal" tabindex="-1" role="dialog" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrScannerModalLabel">QR Code Scanner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do scanner QR Code aqui -->
                <!-- Pode ser um iframe, um script para abrir a câmera, etc. -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <!-- Outros botões ou ações necessárias -->
            </div>
        </div>
    </div>
</div>

<script>https://olive-jeans-count.loca.lt/
    function openQRScannerModal() {
        var modal = document.getElementById('qrScannerModal');
        modal.classList.add('show');
        modal.style.display = 'block';
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        var backdrop = document.createElement('div');
        backdrop.classList.add('modal-backdrop', 'fade', 'show');
        document.body.appendChild(backdrop);
    }

    function closeQRScannerModal() {
        var modal = document.getElementById('qrScannerModal');
        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-modal', 'false');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        var backdrop = document.querySelector('.modal-backdrop');
        document.body.removeChild(backdrop);
    }
</script>
