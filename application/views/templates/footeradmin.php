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
    function pilihStatus(status) {
    $('#selected_status').val(status);

    // aktifkan textarea
    $('#komentar').prop('disabled', false);

    if (status === 'Ditolak') {
        $('#komentar').attr('placeholder', 'Komentar wajib diisi karena ditolak!');
    } else {
        $('#komentar').attr('placeholder', 'Komentar (opsional)');
    }
}

function updateStatus() {
    let id = $('#status_id').val();
    let status = $('#selected_status').val();
    let komentar = $('#komentar').val();

    console.log('UPDATE STATUS - ID:', id, 'Status:', status);

    if (!status) {
        alert('Pilih status dulu!');
        return;
    }

    if (status === 'Ditolak' && komentar.trim() === '') {
        alert('Komentar wajib diisi jika menolak!');
        return;
    }

    $.ajax({
        url: "<?= base_url('pengajuan/updatestatus'); ?>",
        type: 'POST',
        data: { id: id, status: status, komentar: komentar },
        success: function(response) {
            console.log('UPDATE STATUS - Response:', response);
            let res = typeof response === 'string' ? JSON.parse(response) : response;
            if (res.status) {
                console.log('UPDATE STATUS - Success:', res.message);
                $('#statusModal').modal('hide');
                $('#komentar').val('').prop('disabled', true);
            $('#selected_status').val('');
                setTimeout(function() {
                    // Cek semua DataTables yang ada dan reload
                    if ($.fn.DataTable.isDataTable('#datatable-daftar')) {
                        console.log('UPDATE STATUS - Reloading #datatable-daftar');
                        $('#datatable-daftar').DataTable().ajax.reload(null, false);
                    }
                    if ($.fn.DataTable.isDataTable('#tableVerif')) {
                        console.log('UPDATE STATUS - Reloading #tableVerif');
                        $('#tableVerif').DataTable().ajax.reload(null, false);
                    }
                    if (!$.fn.DataTable.isDataTable('#datatable-daftar') && !$.fn.DataTable.isDataTable('#tableVerif')) {
                        console.log('UPDATE STATUS - No DataTables found, reloading page');
                        location.reload();
                    }
                    if (status === 'Ditolak' && komentar.trim() === '') {
                        alert('Komentar wajib diisi jika menolak!');
                        return;
                    }
                }, 300);
            } else {
                console.log('UPDATE STATUS - Failed:', res.message);
                alert('Gagal update status: ' + res.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('UPDATE STATUS - AJAX Error:', xhr.responseText, status, error);
            alert('Terjadi kesalahan sistem. Silakan coba lagi.');
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
        // Cek jumlah kolom yang ada di tabel
        var columnCount = $('#datatable-daftar thead th').length;
        console.log('Jumlah kolom tabel:', columnCount);
        
        var columnsConfig = [];
        var ajaxUrl = '';
        
        // Konfigurasi berdasarkan jumlah kolom
        if (columnCount === 6) {
            // Untuk admin/proposal.php (6 kolom)
            columnsConfig = [
                { data: 'no' },
                { data: 'nim' },
                { data: 'judul' },
                { data: 'berkas' },
                { data: 'komentar' },
                { data: 'status' }
            ];
            ajaxUrl = '<?= base_url("admin/getproposals") ?>';
        } else if (columnCount === 5) {
            // Untuk admin/proposal.php lama (5 kolom)
            columnsConfig = [
                { data: 'no' },
                { data: 'nim' },
                { data: 'judul' },
                { data: 'berkas' },
                { data: 'dosen1' },
                { data: 'dosen2' },
                { data: 'dosen3' },
                { data: 'status' },
                { data: 'tanggal' },
                { data: 'aksi' }
            ];
            ajaxUrl = '<?= base_url("pengajuan/getdaftar") ?>';
        }
        
        $('#datatable-daftar').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: ajaxUrl,
                type: 'POST',
                data: function (d) {
                    console.log('DataTables Request Data:', d);
                    return d;
                },
                error: function(xhr, error, thrown) {
                    console.log('DataTables Error:', xhr.responseText);
                    console.log('Status:', xhr.status);
                    console.log('Error:', error);
                }
            },
            columns: columnsConfig
        });

        // Buka modal edit daftar
        $('#datatable-daftar tbody').on('click', '.btn-edit-daftar', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url("pengajuan/getdaftarrow") ?>',
                type: 'POST',
                data: { id: id },
                success: function (res) {
                    var data = typeof res === 'string' ? JSON.parse(res) : res;
                    $('#e_id').val(data.id);
                    $('#e_nim').val(data.nim);
                    $('#e_judul').val(data.judul);
                    $('#e_link').val(data.link);
                    $('#e_dosen1_id').val(data.dosen1);
                    $('#e_dosen2_id').val(data.dosen2);
                    $('#e_dosen3_id').val(data.dosen3);
                    $('#editdaftarModal').modal('show');
                }
            });
        });

        // Delete daftar
        $('#datatable-daftar tbody').on('click', '.btn-delete-daftar', function () {
            var id = $(this).data('id');
            if (confirm('Yakin hapus data ini?')) {
                $.ajax({
                    url: '<?= base_url("pengajuan/deletedaftarrow") ?>',
                    type: 'POST',
                    data: { id: id },
                    success: function () {
                        $('#datatable-daftar').DataTable().ajax.reload();
                    }
                });
            }
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
        }); }
});
</script>