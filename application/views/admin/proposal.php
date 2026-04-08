<style>
#datatable-daftar_wrapper .dataTables_filter {
    float: none !important;
    text-align: right !important;
}
#datatable-daftar_wrapper .dataTables_paginate {
    float: none !important;
    text-align: left !important;
}
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

<!-- Table List -->
<div class="table-responsive">
  <table id="datatable-daftar" class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">NIM</th>
        <th scope="col">Judul Proposal</th>
        <th scope="col">Berkas</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
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
