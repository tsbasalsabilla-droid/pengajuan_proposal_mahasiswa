<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengajuan Proposal</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable-daftar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Judul Proposal</th>
                            <th>Berkas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($proposal)): ?>
                            <?php $i = 1; foreach($proposal as $p): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $p['nim']; ?></td>
                                <td><?= $p['judul']; ?></td>
                                <td><a href="<?= $p['link']; ?>" target="_blank" class="badge badge-info">Lihat File</a></td>
                                <td>
                                    <button type="button" 
                                            class="btn-status-fiks <?php 
                                                $status = $p['status'] ?? 'Pending'; 
                                                $warna = 'bg-pending';
                                                if ($status === 'Disetujui') $warna = 'bg-setuju';
                                                if ($status === 'Ditolak') $warna = 'bg-ditolak';
                                                echo $warna; 
                                            ?> btn-status" 
                                            data-id="<?= $p['id']; ?>">
                                        <?= $status; ?>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data proposal</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Proposal</h5>
                <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body text-center">
                <p>Tentukan status untuk proposal ini:</p>
                <input type="hidden" id="status_id">
                <button onclick="updateStatus('Disetujui')" class="btn btn-success">Setujui</button>
                <button onclick="updateStatus('Ditolak')" class="btn btn-danger">Tolak</button>
                <button onclick="updateStatus('Pending')" class="btn btn-warning">Pending</button>
            </div>
        </div>
    </div>
</div>
