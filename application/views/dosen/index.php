<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <p>Selamat datang di Dashboard Dosen 👋</p>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-primary">Total Proposal</h4>
                <p><?= count($proposal) ?? 0; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-success">Pending</h4>
                <p>Menunggu Verifikasi</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4 class="text-warning">Selesai</h4>
                <p>Sudah Diverifikasi</p>
            </div>
        </div>
    </div>
</div>
