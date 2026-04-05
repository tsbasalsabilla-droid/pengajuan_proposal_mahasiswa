<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?= $this->session->flashdata('message'); ?>


<!-- dosen: Table List -->
<div class="table-responsive">
  <table id="datatable-verif" class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">NIM</th>
        <th scope="col">Nama</th>
        <th scope="col">Judul</th>
        <th scope="col">Link</th>
        <th scope="col">Tanggal Pengajuan</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  </div>

<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Ubah Status</h5>
      </div>

      <div class="modal-body text-center">
        <p>Pilih status verifikasi proposal:</p>

        <input type="hidden" id="status_id">

        <button onclick="updateStatus('sudah disetujui')" class="btn btn-success">
    Setujui
</button>

<button onclick="updateStatus('ditolak')" class="btn btn-danger">
    Tolak
</button>
      </div>

    </div>
  </div>
</div>