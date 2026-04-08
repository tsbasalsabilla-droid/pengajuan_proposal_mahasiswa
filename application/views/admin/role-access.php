<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <h5>Role : <?= $role['role']; ?></h5>
    
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Submenu</th>
                        <th>Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($submenu as $sm) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $sm['menu_name']; ?></td>
                        <td><?= $sm['title']; ?></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                <?= check_access($role['id'], $sm['id']); ?> 
                                data-role="<?= $role['id']; ?>" 
                                data-menu="<?= $sm['id']; ?>">
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Wait for jQuery to be available
function initRoleAccess() {
    if (typeof $ !== 'undefined') {
        $('.form-check-input[data-role]').on('change', function() {
            var checkbox = $(this);
            var roleId = checkbox.data('role');
            var menuId = checkbox.data('menu');
            var isChecked = checkbox.prop('checked');
            
            $.ajax({
                url: '<?= base_url("admin/changeaccess") ?>',
                type: 'POST',
                data: { roleId: roleId, menuId: menuId },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert('Access berhasil diubah!');
                    } else {
                        checkbox.prop('checked', !isChecked);
                        alert('Gagal mengubah access');
                    }
                },
                error: function() {
                    checkbox.prop('checked', !isChecked);
                    alert('Terjadi kesalahan');
                }
            });
        });
    } else {
        setTimeout(initRoleAccess, 100);
    }
}

// Start checking for jQuery
initRoleAccess();
</script>

</div>
