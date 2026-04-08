<footer class="bg-white py-3" style="position: fixed; bottom: 0; left: 224px; right: 0; z-index: 1;">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span style="font-size: 12px;">Copyright &copy; Web Pengajuan Proposal Mahasiswa <?= date('Y'); ?></span>
        </div>
    </div>
</footer>

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

<!-- SCRIPT: Update Status Proposal -->
<script>
function updateStatus(status) {
    let csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
    let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
    let id = $('#status_id').val();

    $.ajax({
        url: "<?= base_url('pengajuan/updatestatus'); ?>",
        type: 'POST',
        data: { [csrfName]: csrfHash, id: id, status: status },
        success: function(response) {
            let res = typeof response === 'string' ? JSON.parse(response) : response;
            if (res.status) {
                $('#statusModal').modal('hide');
                setTimeout(function() {
                    if ($.fn.DataTable.isDataTable('#tableVerif')) {
                        $('#tableVerif').DataTable().ajax.reload(null, false);
                    } else if ($.fn.DataTable.isDataTable('#datatable-daftar')) {
                        $('#datatable-daftar').DataTable().ajax.reload(null, false);
                    } else {
                        location.reload();
                    }
                }, 300);
            } else {
                alert('Gagal: ' + res.message);
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan sistem.');
        }
    });
}

$(document).on('click', '.btn-status', function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    $('#status_id').val(id);
    $('#statusModal').modal('show');
});
</script>

<!-- SCRIPT: DataTables -->
<script>
$(document).ready(function () {

    // ===================== DAFTAR PROPOSAL =====================
    if ($('#datatable-daftar').length) {
        $('#datatable-daftar').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: '<?= base_url("pengajuan/getdaftar") ?>',
                type: 'POST'
            },
            columns: [
                { data: 'no' },
                { data: 'nim' },
                { data: 'judul' },
                { data: 'berkas' },
                { data: 'status' }
            ],
            columnDefs: [
                { targets: [0, 3, 4], orderable: false }
            ]
        });
    }

    // ===================== DATA DOSEN =====================
    if ($('#datatable-datados').length) {
        var tableDos = $('#datatable-datados').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url("data/getdatados") ?>',
                type: 'POST'
            },
            columns: [
                { data: 'no' },
                { data: 'nidn' },
                { data: 'nama_dos' },
                { data: 'gelar' },
                { data: 'aksi', orderable: false, searchable: false }
            ]
        });

        // Tambah dosen
        $('.btn-simpan-dosen').on('click', function () {
            $.ajax({
                url: '<?= base_url("data/datados") ?>',
                type: 'POST',
                data: $('#formAddDosen').serialize(),
                success: function () {
                    $('#newDosenModal').modal('hide');
                    $('#formAddDosen')[0].reset();
                    tableDos.ajax.reload();
                }
            });
        });

        // Buka modal edit dosen
        $('#datatable-datados tbody').on('click', '.btn-edit-dosen', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url("data/getdatadosrow") ?>',
                type: 'POST',
                data: { id: id },
                success: function (res) {
                    var data = typeof res === 'string' ? JSON.parse(res) : res;
                    $('#e_id_dosen').val(data.id_dosen);
                    $('#e_nidn').val(data.nidn);
                    $('#e_nama_dos').val(data.nama_dos);
                    $('#e_gelar').val(data.gelar);
                    $('#editdosModal').modal('show');
                }
            });
        });

        // Update dosen
        $('.btn-update-dosen').on('click', function () {
            $.ajax({
                url: '<?= base_url("data/updatedatadosrow") ?>',
                type: 'POST',
                data: $('#formEditDos').serialize(),
                success: function () {
                    $('#editdosModal').modal('hide');
                    tableDos.ajax.reload();
                }
            });
        });

        // Delete dosen
        $('#datatable-datados tbody').on('click', '.btn-delete-dosen', function () {
            var id = $(this).data('id');
            if (confirm('Yakin hapus data dosen ini?')) {
                $.ajax({
                    url: '<?= base_url("data/deletedatadosrow") ?>',
                    type: 'POST',
                    data: { id: id },
                    success: function () {
                        tableDos.ajax.reload();
                    }
                });
            }
        });
    }

    // ===================== DATA MAHASISWA =====================
    if ($('#datatable-datasiswa').length) {
        var tableSiswa = $('#datatable-datasiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url("data/getdatasiswa") ?>',
                type: 'POST'
            },
            columns: [
                { data: 'no' },
                { data: 'nim' },
                { data: 'nama' },
                { data: 'nama_prodi' },
                { data: 'aksi', orderable: false, searchable: false }
            ]
        });

        // Buka modal edit mahasiswa
        $('#datatable-datasiswa tbody').on('click', '.btn-edit-siswa', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url("data/getdatamahasiswarow") ?>',
                type: 'POST',
                data: { id: id },
                success: function (res) {
                    var data = typeof res === 'string' ? JSON.parse(res) : res;
                    $('#e_id_siswa').val(data.id_mahasiswa);
                    $('#e_nim').val(data.nim);
                    $('#e_nama_siswa').val(data.nama);
                    $('#e_prodi_id').val(data.prodi_id);
                    $('#editsiswaModal').modal('show');
                }
            });
        });

        // Delete mahasiswa
        $('#datatable-datasiswa tbody').on('click', '.btn-delete-siswa', function () {
            var id = $(this).data('id');
            if (confirm('Yakin hapus data mahasiswa ini?')) {
                $.ajax({
                    url: '<?= base_url("data/deletedatasiswarow") ?>',
                    type: 'POST',
                    data: { id: id },
                    success: function () {
                        tableSiswa.ajax.reload();
                    }
                });
            }
        });

        // Update mahasiswa
        $('.btn-update-siswa').on('click', function () {
            $.ajax({
                url: '<?= base_url("data/updatemahasiswa") ?>',
                type: 'POST',
                data: $('#formEditSiswa').serialize(),
                success: function () {
                    $('#editsiswaModal').modal('hide');
                    tableSiswa.ajax.reload();
                }
            });
        });
    }

});
</script>