<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Web Pengajuan Proposal Mahasiswa <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
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


<script src="<?= base_url('assets/');  ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/');  ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/');  ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/');  ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('assets/');  ?>js/sb-admin-2.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

<script>
    $(document).ready(function() {
        // ================= DATA TABLE DOSEN =================
        if ($('#datatable-datados').length) {
            if ($.fn.DataTable.isDataTable('#datatable-datados')) {
                $('#datatable-datados').DataTable().destroy();
            }
            $('#datatable-datados').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('data/getdatados'); ?>",
                    type: "POST"
                },
                columns: [
                    { data: 'no' },
                    { data: 'nidn' },
                    { data: 'nama_dos' },
                    { data: 'gelar' },
                    { data: 'aksi' }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });
        }

        // ================= DATA TABLE SISWA =================
        if ($('#datatable-datasiswa').length) {
            if ($.fn.DataTable.isDataTable('#datatable-datasiswa')) {
                $('#datatable-datasiswa').DataTable().destroy();
            }
            $('#datatable-datasiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('data/getdatasiswa'); ?>",
                    type: "POST"
                },
                columns: [
                    { data: 'no' },
                    { data: 'nim' },
                    { data: 'nama' },
                    { data: 'nama_prodi' },
                    { data: 'aksi' }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });
        }

        // ================= DATA TABLE VERIF =================
        if ($('#datatable-verif').length) {
            if ($.fn.DataTable.isDataTable('#datatable-verif')) {
                $('#datatable-verif').DataTable().destroy();
            }
            $('#datatable-verif').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('pengajuan/getverif'); ?>",
                    type: "POST"
                }
            });
        }

        // ================= DATA TABLE =================
        if ($('#dataTable').length) {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('data/getdata'); ?>",
                    type: "POST"
                }
            });
        }

        // ================= DATA TABLE DAFTAR =================
        if ($('#datatable-daftar').length) {
            if ($.fn.DataTable.isDataTable('#datatable-daftar')) {
                $('#datatable-daftar').DataTable().destroy();
            }
            $('#datatable-daftar').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= base_url('pengajuan/getdaftar'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nim" },
                    { "data": "judul" },
                    { "data": "berkas" },
                    { "data": "status" }
                ],
                "columnDefs": [{
                    "targets": [0, 4],
                    "orderable": false
                }]
            });
        }

        // ================= PROPOSAL DOSEN =================
        if ($('#table-proposal-dosen').length) {
            if ($.fn.DataTable.isDataTable('#table-proposal-dosen')) {
                $('#table-proposal-dosen').DataTable().destroy();
            }
            var tableProp = $('#table-proposal-dosen').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= base_url('dosen/get_data_proposal'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nim" },
                    { "data": "judul" },
                    { "data": "berkas" },
                    { "data": "status" }
                ],
                "columnDefs": [{ "targets": [0, 4], "orderable": false }]
            });

            // Script untuk memunculkan modal saat Status diklik
            $(document).on('click', '.btn-status', function() {
                let id = $(this).data('id');
                $('#status_id').val(id); // Masukkan ID ke input hidden di modal
                $('#statusModal').modal('show');
            });

            // Update status form submit
            $('#formStatusUpdate').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?= base_url('dosen/update_proposal'); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(res) {
                        if(res.status) {
                            $('#statusModal').modal('hide');
                            tableProp.ajax.reload(null, false);
                        }
                    }
                });
            });
        }

        // ================= SUBMIT EDIT DOSEN (AJAX) =================
        $('#formEditDosen').on('submit', function(e) {
            e.preventDefault(); // <--- INI KUNCINYA agar URL tidak berubah
            
            $.ajax({
                url: "<?= base_url('data/updatedatadosrow'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        $('#modalEditDosen').modal('hide');
                        $('#datatable-datados').DataTable().ajax.reload(null, false);
                        alert('Data Berhasil Diupdate!');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan saat update data');
                }
            });
        });

        // 2. ROLE ACCESS FUNCTION (INI YANG KAMU BUTUHKAN)
        function changeAccess(menuId, roleId) {
            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/role_access_detail/'); ?>" + roleId;
                },
                error: function(xhr) {
                    alert('Gagal mengubah akses!');
                    console.log(xhr.responseText);
                }
            });
        }

        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');
            changeAccess(menuId, roleId);
        });

        // 3. STATUS UPDATE FUNCTION
        function updateStatus(status) {
            let id = $('#status_id').val();
            $.ajax({
                url: "<?= base_url('pengajuan/updatestatus'); ?>",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        $('#statusModal').modal('hide');
                        $('#datatable-daftar').DataTable().ajax.reload(null, false); 
                    }
                }
            });
        }

        $(document).on('click', '.btn-status', function() {
            let id = $(this).data('id');
            $('#status_id').val(id); 
            $('#statusModal').modal('show'); 
        });

        // ================= EDIT/DELETE MAHASISWA =================
        $(document).on('click', '.btn-edit-siswa', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            // DEBUG
            console.log('Klik ID:', id);

            $.ajax({
                url: "<?= base_url('data/getdatamahasiswarow'); ?>",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function(res) {

                    console.log(res); // 

                    if (!res) {
                        alert('Data tidak ditemukan');
                        return;
                    }

                    // ISI FORM
                    $('#e_id_siswa').val(res.id_mahasiswa);
                    $('#e_nim').val(res.nim);
                    $('#e_nama_siswa').val(res.nama);
                    $('#e_prodi_id').val(res.prodi_id);

                    // TAMPILKAN MODAL
                    $('#editsiswaModal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal ambil data!');
                }
            });
        });

        // ================= DELETE MAHASISWA =================
        $(document).on('click', '.btn-delete-siswa', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: "<?= base_url('data/deletedatasiswarow'); ?>",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function(res) {
                        console.log(res);

                        if (res.status) {
                            // reload datatable TANPA refresh halaman
                            $('#datatable-datasiswa').DataTable().ajax.reload(null, false);

                            // notif
                            alert('Data berhasil dihapus!');
                        } else {
                            alert('Gagal hapus data!');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Gagal hapus data!');
                    }
                });
            }
        });

// --- 1. TAMBAH DOSEN (AJAX) ---
$(document).on('click', '.btn-simpan-dosen', function(e) {
    e.preventDefault();
    var formData = $('#formAddDosen').serialize();
    $.ajax({
        url: "<?= base_url('data/datados'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(res) {
            if(res.status) {
                $('#newDosenModal').modal('hide');
                $('#formAddDosen')[0].reset();
                $('#datatable-datados').DataTable().ajax.reload(null, false);
                alert(res.message);
            }
        },
        error: function(xhr) {
            alert("Error: Gagal menambah data. Cek koneksi atau database.");
        }
    });
});

// --- 2. EDIT DOSEN (AMBIL DATA KE MODAL) ---
$(document).on('click', '.btn-edit-dosen', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.ajax({
        url: "<?= base_url('data/getdatadosrow'); ?>",
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function(res) {
            if (res) {
                // Pastikan ID input di View data_dosen.php adalah e_id_dosen, e_nidn, dst.
                $('#e_id_dosen').val(res.id_dosen);
                $('#e_nidn').val(res.nidn);
                $('#e_nama_dos').val(res.nama_dos);
                $('#e_gelar').val(res.gelar);
                $('#editdosModal').modal('show');
            }
        }
    });
});

// --- 3. UPDATE DOSEN (SIMPAN PERUBAHAN) ---
$(document).on('click', '.btn-update-dosen', function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= base_url('data/updatedatadosrow'); ?>",
        type: "POST",
        data: $('#formEditDos').serialize(), // Pastikan ID Form di View adalah formEditDos
        dataType: "json",
        success: function(res) {
            if (res.status) {
                $('#editdosModal').modal('hide');
                $('#datatable-datados').DataTable().ajax.reload(null, false);
                alert('Data dosen berhasil diperbarui!');
            }
        },
        error: function(xhr) {
            alert("Gagal mengupdate data.");
        }
    });
});

// --- 4. DELETE DOSEN ---
$(document).on('click', '.btn-delete-dosen', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    
    if (id === undefined) {
        alert("Error: ID Dosen tidak ditemukan pada tombol!");
        return;
    }

    if (confirm('Yakin ingin menghapus dosen ini?')) {
        $.ajax({
            url: "<?= base_url('data/deletedatadosrow'); ?>",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $('#datatable-datados').DataTable().ajax.reload(null, false);
                    alert('Data berhasil dihapus!');
                } else {
                    alert('Gagal menghapus data dari database.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Error sistem saat menghapus data.');
            }
        });
    }
});

        // ================= EDIT FORM SUBMIT (AJAX) =================
        $('#formEditSiswa').on('submit', function(e) {
            e.preventDefault(); // ❗ biar gak reload

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {

                    console.log(res);

                    if (res.status) {
                        // tutup modal
                        $('#editsiswaModal').modal('hide');

                        // reload datatable TANPA refresh halaman
                        $('#datatable-datasiswa').DataTable().ajax.reload(null, false);

                        // notif (optional)
                        alert(res.message);
                    } else {
                        alert('Gagal update!');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal update!');
                }
            });
        });

        // ================= ADD FORM SUBMIT (AJAX) =================
        $('#formAddsiswa').on('submit', function(e) {
            e.preventDefault(); // ❗ biar gak reload

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {

                    console.log(res);

                    if (res.status) {
                        // tutup modal
                        $('#newsiswaModal').modal('hide');

                        // reload datatable TANPA refresh halaman
                        $('#datatable-datasiswa').DataTable().ajax.reload(null, false);

                        // notif (optional)
                        alert(res.message);
                        
                        // reset form
                        $('#formAddsiswa')[0].reset();
                    } else {
                        alert('Gagal tambah data!');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal tambah data!');
                }
            });
        });
    });
</script>