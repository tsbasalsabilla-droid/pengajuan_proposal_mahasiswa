<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Proposal</h5>
                <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body text-center">
                <p>Tentukan status untuk proposal ini:</p>
                <input type="hidden" id="status_id">
                <button onclick="updateStatus('Disetujui')" class="btn btn-success">Setujui</button>
                <button onclick="updateStatus('Ditolak')" class="btn btn-danger">Tolak</button>
                <button onclick="updateStatus('Pending')" class="btn btn-warning">Pending</button>
            </div>
        </div>
    </div>
</div>
