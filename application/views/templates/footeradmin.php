<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Web Pengajuan Proposal Mahasiswa <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
</div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('Auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<style>
    /* CSS FIX: Menjamin teks terlihat dan tombol punya ukuran */
    .btn-status-fiks {
        display: inline-block !important;
        padding: 7px 14px !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        line-height: 1 !important;
        text-align: center !important;
        white-space: nowrap !important;
        vertical-align: middle !important;
        cursor: pointer !important;
        border-radius: 50px !important; /* Biar lebih modern (pill) */
        border: none !important;
        min-width: 100px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Warna Background & Teks */
    .bg-pending { background-color: #ffc107 !important; color: #212529 !important; }
    .bg-setuju  { background-color: #28a745 !important; color: #ffffff !important; }
    .bg-ditolak { background-color: #dc3545 !important; color: #ffffff !important; }

    /* Fix tabel agar tidak melar ke samping */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
    }
</style>

<script>
    function updateStatus(status) {
        let id = $('#status_id').val();
        if(!id) return alert("ID tidak valid!");

        $.ajax({
            url: "<?= base_url('pengajuan/updatestatus'); ?>",
            type: "POST",
            data: { id: id, status: status },
            dataType: "json",
            beforeSend: function() {
                // Opsional: tambahkan loading
            },
            success: function(res) {
                // res.status harus true dari controller PHP
                if (res.status == true || res.status == "true") { 
                    $('#statusModal').modal('hide');
                    // Reload tabel tanpa reset posisi halaman
                    if ($.fn.DataTable.isDataTable('#datatable-daftar')) {
                        $('#datatable-daftar').DataTable().ajax.reload(null, false);
                    }
                    alert('Status Berhasil Diperbarui!');
                } else {
                    alert('Gagal update: ' + (res.message || 'Cek Controller PHP'));
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Error Server! Cek Console (F12)');
            }
        });
    }

    $(document).ready(function() {
        if ($('#datatable-daftar').length) {
            var table = $('#datatable-daftar').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    "url": "<?= base_url('pengajuan/getdaftar'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nim" },
                    { "data": "judul" },
                    { "data": "berkas" },
                    { 
                        "data": "status",
                        "render": function(data, type, row) {
                            // LOGIKA DEFAULT PENDING
                            let label = (data === null || data === '' || data === undefined) ? 'PENDING' : data.toUpperCase();
                            
                            let warna = 'bg-pending';
                            if (label === 'SETUJU') warna = 'bg-setuju';
                            if (label === 'DITOLAK') warna = 'bg-ditolak';

                            // Gunakan row.id_proposal (sesuaikan dengan nama kolom di DB kamu)
                            let proposalID = row.id_proposal || row.id;

                            return `<button type="button" 
                                        class="btn-status-fiks ${warna} btn-status" 
                                        data-id="${proposalID}">
                                        ${label}
                                    </button>`;
                        }
                    }
                ]
            });
        }

        // Gunakan EVENT DELEGATION untuk tombol di dalam DataTable
        $(document).on('click', '.btn-status', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            $('#status_id').val(id); // Pastikan input ini ada di modal!
            $('#statusModal').modal('show');
        });

        // DataTable untuk Data Dosen
        if ($('#datatable-datados').length) {
            $('#datatable-datados').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    "url": "<?= base_url('data/getdatados'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nidn" },
                    { "data": "nama_dos" },
                    { "data": "gelar" },
                    { "data": "aksi" }
                ]
            });
        }

        // DataTable untuk Data Mahasiswa
        if ($('#datatable-datasiswa').length) {
            $('#datatable-datasiswa').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    "url": "<?= base_url('data/getdatasiswa'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nim" },
                    { "data": "nama" },
                    { "data": "nama_prodi" },
                    { "data": "aksi" }
                ]
            });
        }

        // JavaScript untuk Data Mahasiswa AJAX
        $(document).on('click', '.btn-edit-siswa', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('data/getdatamahasiswarow'); ?>",
                type: "POST",
                data: { id: id },
                success: function(res) {
                    $('#e_id_siswa').val(res.id_mahasiswa);
                    $('#e_nim').val(res.nim);
                    $('#e_nama_siswa').val(res.nama);
                    $('#e_prodi_id').val(res.prodi_id);
                    $('#editsiswaModal').modal('show');
                }
            });
        });

        $(document).on('click', '.btn-delete-siswa', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: "<?= base_url('data/deletedatasiswarow'); ?>",
                    type: "POST",
                    data: { id: id },
                    success: function(res) {
                        if (res.status) {
                            $('#datatable-datasiswa').DataTable().ajax.reload(null, false);
                        }
                    }
                });
            }
        });

        // JavaScript untuk Data Dosen AJAX
        $(document).on('click', '.btn-edit-dosen', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('data/getdatadosrow'); ?>",
                type: "POST",
                data: { id: id },
                success: function(res) {
                    $('#e_id_dosen').val(res.id_dosen);
                    $('#e_nidn').val(res.nidn);
                    $('#e_nama_dos').val(res.nama_dos);
                    $('#e_gelar').val(res.gelar);
                    $('#editDosenModal').modal('show');
                }
            });
        });

        $(document).on('click', '.btn-delete-dosen', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: "<?= base_url('data/deletedatadosrow'); ?>",
                    type: "POST",
                    data: { id: id },
                    success: function(res) {
                        if (res.status) {
                            $('#datatable-datados').DataTable().ajax.reload(null, false);
                        }
                    }
                });
            }
        });
    });
</script>
