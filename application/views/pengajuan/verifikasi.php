<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?= $this->session->flashdata('message'); ?>


<!-- DataTables Server Side -->
<div class="table-responsive">
  <table id="tableVerif" class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">NIM</th>
        <th scope="col">Nama</th>
        <th scope="col">Judul</th>
        <th scope="col">Link</th>
        <th scope="col">Tanggal</th>
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
        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <input type="hidden" id="status_id">
        <p>Pilih status verifikasi proposal:</p>
        <div class="d-flex justify-content-center" style="gap: 10px;">
            <button class="btn btn-warning" onclick="updateStatus('Pending')">Pending</button>
            <button class="btn btn-success" onclick="updateStatus('Disetujui')">Disetujui</button>
            <button class="btn btn-danger" onclick="updateStatus('Ditolak')">Ditolak</button>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<script type="text/javascript">
    var table;
    $(document).ready(function() {
        // Inisialisasi Datatable
        table = $('#tableVerif').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 

            "ajax": {
                "url": "<?php echo base_url('pengajuan/getverif')?>",
                "type": "POST"
            },

            "columnDefs": [
                { 
                    "targets": [ 0, 4, 6 ], // Kolom #, Link, dan Status tidak bisa di-sort
                    "orderable": false, 
                },
            ],
            // Pastikan mapping datanya sesuai dengan yang dikirim Controller
            "columns": [
                { "data": "no" },
                { "data": "nim" },
                { "data": "nama" },
                { "data": "judul" },
                { "data": "link" },
                { "data": "tanggal" },
                { "data": "status" }
            ]
        });
    });
</script>