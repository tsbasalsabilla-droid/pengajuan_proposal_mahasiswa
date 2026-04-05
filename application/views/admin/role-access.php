<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <h5>Role : <?= $role['role']; ?></h5>

    <div class="row">
        <div class="col-lg-6">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($menu as $m) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $m['menu']; ?></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                <?= check_access($role['id'], $m['id']); ?> 
                                data-role="<?= $role['id']; ?>" 
                                data-menu="<?= $m['id']; ?>">
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
