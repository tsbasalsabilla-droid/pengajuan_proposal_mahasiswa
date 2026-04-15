<style>
#datatable-daftar_wrapper .dataTables_filter {
    float: none !important;
    text-align: right !important;
}
#datatable-daftar_wrapper .dataTables_paginate {
    float: none !important;
    text-align: left !important;
}

/* Atur lebar kolom agar tidak terpotong */
#datatable-daftar {
    width: 100% !important;
    table-layout: fixed;
}

#datatable-daftar th:nth-child(1), #datatable-daftar td:nth-child(1) { 
    width: 50px; 
    text-align: center;
}
#datatable-daftar th:nth-child(2), #datatable-daftar td:nth-child(2) { 
    width: 120px; 
    text-align: center;
}
#datatable-daftar th:nth-child(3), #datatable-daftar td:nth-child(3) { 
    width: auto; 
    min-width: 300px;
    max-width: 400px;
    word-wrap: break-word;
    white-space: normal;
}
#datatable-daftar th:nth-child(4), #datatable-daftar td:nth-child(4) { 
    width: 100px; 
    text-align: center;
}
#datatable-daftar th:nth-child(5), #datatable-daftar td:nth-child(5) { 
    width: 120px; 
    text-align: center;
}

#datatable-daftar td {
    word-wrap: break-word;
    white-space: normal;
    vertical-align: middle;
}

#datatable-daftar th:nth-child(3) {
    text-align: left;
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
        <th scope="col">Komentar</th>
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
                <input type="hidden" id="selected_status">
                <p>Tentukan status untuk proposal ini:</p>
                 <div class="d-flex justify-content-center mb-3" style="gap: 10px;">
        <button class="btn btn-success" onclick="pilihStatus('Disetujui')">Setuju</button>
        <button class="btn btn-danger" onclick="pilihStatus('Ditolak')">Tolak</button>
    </div>

    <!-- Komentar -->
    <div class="form-group text-left">
        <label for="komentar">Komentar</label>
        <textarea id="komentar" class="form-control" rows="3" disabled placeholder="Pilih status dulu..."></textarea>
    </div>

    <!-- Tombol simpan -->
    <button class="btn btn-primary mt-2" onclick="updateStatus()">Simpan</button>
</div>
            </div>
            
        </div>
    </div>
</div>
