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



<script src="<?= base_url('assets/');  ?>js/sb-admin-2.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    // 1. DATA TABLES SETUP
    $('#datatable-datados, #datatable-datasiswa, #datatable-verif, #dataTable').DataTable({
        processing: true,
        serverSide: true
    });

    // DataTable untuk proposal dengan server-side processing
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

    // 4. CRUD DOSEN & MAHASISWA (Sederhanakan sementara untuk testing)
    // Jika butuh fungsi Edit/Delete yang spesifik, masukkan di bawah sini satu-satu
    // Pastikan setiap function ditutup dengan }); yang benar.

    // DataTable untuk proposal Dosen dengan server-side processing
    $(document).ready(function() {
        // 1. Inisialisasi DataTable (Read)
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
    });
</script>