<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/detail_pengajuan.css'); ?>">
</head>
<body>
    <div class="dashboard">
        <?php $this->load->view('templates/sidebarmahasiswa'); ?>

        <main class="content" style="margin-left: 240px; padding: 30px;">
            <div class="topbar">
                <div class="topbar-left">
                    <h1>Detail Pengajuan</h1>
                    <p>Informasi lengkap mengenai status proposal Anda</p>
                </div>
                <a href="<?= base_url('mahasiswa/index'); ?>" class="btn-primary" style="background: #6B3EE8;">
                    Lihat Semua Pengajuan
                </a>
            </div>

            <div class="card" style="max-width: 1000px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: #fff; padding: 25px 30px; border-bottom: 1px solid #f0f0f0;">
                    <div style="font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Dokumen Akademik</div>
                    <h2 style="font-size: 20px; font-weight: 600; color: #1a1a1a;">Form Detail Pengajuan</h2>
                </div>

                <div style="padding: 30px;">
                    <div style="color: #6B3EE8; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 25px; letter-spacing: 0.5px;">Informasi Mahasiswa</div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">NIM</label>
                        <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #666; font-size: 14px;">
                            <?= $user->nim; ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Nama Lengkap</label>
                        <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #666; font-size: 14px;">
                            <?= $user->nama; ?>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #f5f5f5; margin: 30px 0;"></div>
                    <div style="color: #6B3EE8; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 25px; letter-spacing: 0.5px;">Detail Proposal</div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Judul Proposal</label>
                        <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #111; font-size: 14px; line-height: 1.6; font-weight: 500;">
                            <?= $proposal->judul; ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Link Dokumen</label>
                        <a href="<?= $proposal->link; ?>" target="_blank" style="display: block; background: #fff; border: 1px solid #6B3EE8; padding: 10px 15px; border-radius: 8px; color: #6B3EE8; text-decoration: none; font-size: 13px; font-weight: 500; width: fit-content; transition: 0.2s;">
                            Buka Tautan Proposal <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:5px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                    </div>

                    <?php if ($proposal->dosen1 || $proposal->dosen2 || $proposal->dosen3): ?>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Dosen Pembimbing</label>
                        <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #666; font-size: 14px;">
                            <?php 
                            $dosen_list = [];
                            if ($proposal->dosen1) $dosen_list[] = $proposal->dosen1;
                            if ($proposal->dosen2) $dosen_list[] = $proposal->dosen2;
                            if ($proposal->dosen3) $dosen_list[] = $proposal->dosen3;
                            echo implode('<br>', $dosen_list);
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Status Validasi</label>
                        <span class="status-badge" style="
                            <?php 
                            if ($proposal->status == 'sudah disetujui') {
                                echo 'background: #ecfdf5; color: #10b981;';
                            } else {
                                echo 'background: #fff7ed; color: #f59e0b;';
                            }
                            ?>
                            padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <span style="width: 6px; height: 6px; 
                                <?php 
                                if ($proposal->status == 'sudah disetujui') {
                                    echo 'background: #10b981;';
                                } else {
                                    echo 'background: #f59e0b;';
                                }
                                ?>
                                border-radius: 50%;"></span>
                            <?= $proposal->status == 'sudah disetujui' ? 'Disetujui' : 'Sedang Diproses' ?>
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    </script>
</body>
</html>
