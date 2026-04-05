<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($role as $r) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $r['role']; ?></td>
                        <td>
                            <a href="<?= base_url('admin/role_access_detail/') . $r['id']; ?>" class="badge badge-warning">access</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
