<style>
#datatable-daftar_wrapper .dataTables_filter {
    float: none !important;
    text-align: left !important;
}
#datatable-daftar_wrapper .dataTables_paginate {
    float: none !important;
    text-align: left !important;
}
<style>
#datatable-daftar_wrapper .dataTables_filter {
    float: none !important;
    text-align: left !important;
}
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengajuan Proposal</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable-daftar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Judul Proposal</th>
                            <th>Berkas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Proposal</h5>
                <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" id="status_id">
                <p>Tentukan status untuk proposal ini:</p>
                <div class="d-flex justify-content-center" style="gap: 10px;">
                    <button class="btn btn-success" onclick="updateStatus('Disetujui')">Setuju</button>
                    <button class="btn btn-danger" onclick="updateStatus('Ditolak')">Tolak</button>
                </div>
            </div>
        </div>
    </div>
</div>
