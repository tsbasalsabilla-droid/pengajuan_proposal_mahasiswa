<div class="content p-4">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <p>Selamat datang di Dashboard <?= $user['role']; ?> 👋</p>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-primary"><?= $total_mahasiswa; ?></h4>
                <p>Total Mahasiswa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-success"><?= $total_dosen; ?></h4>
                <p>Total Dosen</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-warning"><?= $total_proposal; ?></h4>
                <p>Total Proposal</p>
            </div>
        </div>
    </div>
</div>