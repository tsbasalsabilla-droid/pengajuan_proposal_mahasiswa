<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">
    <style>
        /* MAIN */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f4f7fe;
        }

        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between; margin-bottom: 24px;
        }

        .page-title { font-size: 20px; font-weight: 600; color: #1a1a2e; }
        .page-sub { font-size: 13px; color: #9999aa; margin-top: 3px; }

        /* BUTTONS */
        .btn-primary {
            background: #6c3ce1; color: #fff;
            border: none; border-radius: 8px;
            padding: 9px 18px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: inherit;
            display: flex; align-items: center; gap: 6px;
        }

        .btn-primary:hover { background: #5a2ec8; }

        /* Grid Layouts */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 24px;
        }

        /* Card Styling */
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid #f0f0f5;
        }

        .stat-label { font-size: 10px; font-weight: 700; color: #aaa; letter-spacing: 0.05em; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
        .stat-desc { font-size: 12px; font-weight: 500; color: #999; }

        /* Colors */
        .color-process { color: #6c3ce1; }
        .color-success { color: #10b981; }
        .color-danger { color: #ef4444; }

        /* Card Head */
        .card-head-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title { font-size: 16px; font-weight: 600; color: #1a1a2e; }
        .view-all { font-size: 13px; color: #6c3ce1; text-decoration: none; font-weight: 500; }
        .view-all:hover { text-decoration: underline; }

        /* Table Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .data-table th { text-align: left; font-size: 11px; color: #aaa; padding: 12px; border-bottom: 1px solid #f0f0f5; }
        .data-table td { padding: 16px 12px; font-size: 13px; color: #444; border-bottom: 1px solid #f8f8fb; }

        /* Badges */
        .badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #ecfdf5; color: #10b981; }
        .badge-danger { background: #fef2f2; color: #ef4444; }
        .badge-warning { background: #fef3c7; color: #f59e0b; }

        /* Activity Feed */
        .activity-list { list-style: none; padding: 0; margin-top: 20px; }
        .activity-item { position: relative; padding-left: 20px; margin-bottom: 20px; border-left: 2px solid #eee; }
        .activity-item::before { 
            content: ''; position: absolute; left: -6px; top: 0; 
            width: 10px; height: 10px; border-radius: 50%; background: #ddd; 
        }
        .activity-item.purple::before { background: #6c3ce1; }
        .activity-item.green::before { background: #10b981; }
        .activity-text { font-size: 13px; color: #333; font-weight: 500; }
        .activity-time { font-size: 11px; color: #aaa; }

        svg.icon {
            width: 14px; height: 14px;
            stroke: currentColor; fill: none;
            stroke-width: 1.8;
            stroke-linecap: round; stroke-linejoin: round;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php $this->load->view('templates/sidebarmahasiswa'); ?>

        <main class="main-content">
            <div class="page-header">
                <div>
                    <div class="page-title">Dashboard</div>
                    <div class="page-sub">Selamat datang, <?= $this->session->userdata('nama'); ?></div>
                </div>
                <a href="<?= base_url('mahasiswa/pengajuan'); ?>" class="btn-primary" style="text-decoration: none;">
                    <svg class="icon" viewBox="0 0 14 14"><path d="M7 1v12M1 7h12"/></svg>
                    Ajukan Proposal
                </a>
            </div>

            <?php if ($sudah_pengajuan): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">PROPOSAL AKTIF</div>
                    <div class="stat-value"><?= $proposals_aktif ?></div>
                    <div class="stat-desc color-process">Sedang diproses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">DISETUJUI</div>
                    <div class="stat-value"><?= $proposals_disetujui ?></div>
                    <div class="stat-desc color-success">Total disetujui</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">DITOLAK</div>
                    <div class="stat-value"><?= $proposals_ditolak ?></div>
                    <div class="stat-desc color-danger">Perlu ditinjau</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">TOTAL PENGAJUAN</div>
                    <div class="stat-value"><?= $total_proposals ?></div>
                    <div class="stat-desc">Sepanjang waktu</div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($sudah_pengajuan): ?>
            <div class="dashboard-grid">
                <div class="card main-table">
                    <div class="card-head-flex">
                        <div class="card-title">Proposal Terbaru</div>
                        <a href="#" class="view-all">Lihat semua</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>JUDUL</th>
                                <th>JENIS</th>
                                <th>STATUS</th>
                                <th>TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 0;
                            foreach ($proposals as $proposal): 
                                if ($counter >= 5) break; // Tampilkan maksimal 5 proposal terbaru
                                $counter++;
                            ?>
                            <tr>
                                <td><?= $proposal->judul ?></td>
                                <td>Tugas Akhir</td>
                                <td>
                                    <?php 
                                    $badge_class = '';
                                    if ($proposal->status == 'sudah disetujui') {
                                        $badge_class = 'badge-success';
                                        $status_text = 'Disetujui';
                                    } else {
                                        $badge_class = 'badge-warning';
                                        $status_text = 'Sedang diproses';
                                    }
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $status_text ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($proposal->tanggal)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($proposals)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #999;">
                                    Belum ada data proposal
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card activity-feed">
                    <div class="card-title">Aktivitas Terbaru</div>
                    <ul class="activity-list">
                        <?php 
                        $activity_counter = 0;
                        foreach ($proposals as $proposal): 
                            if ($activity_counter >= 3) break; // Tampilkan maksimal 3 aktivitas
                            $activity_counter++;
                        ?>
                        <li class="activity-item <?= $proposal->status == 'sudah disetujui' ? 'green' : 'purple' ?>">
                            <div class="activity-text">
                                <?= $proposal->status == 'sudah disetujui' ? 'Proposal Tugas Akhir disetujui' : 'Proposal Tugas Akhir baru diajukan' ?>
                            </div>
                            <div class="activity-time">
                                <?php 
                                $tanggal = new DateTime($proposal->tanggal);
                                $sekarang = new DateTime();
                                $selisih = $sekarang->diff($tanggal);
                                
                                if ($selisih->days == 0) {
                                    echo 'Hari ini';
                                } elseif ($selisih->days == 1) {
                                    echo '1 hari lalu';
                                } elseif ($selisih->days < 7) {
                                    echo $selisih->days . ' hari lalu';
                                } else {
                                    echo date('d M Y', strtotime($proposal->tanggal));
                                }
                                ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                        <?php if (empty($proposals)): ?>
                        <li style="color: #999; font-size: 13px;">
                            Belum ada aktivitas
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <!-- Tampilkan pesan jika belum ada pengajuan -->
            <div class="card" style="text-align: center; padding: 60px 30px;">
                <div style="font-size: 48px; color: #ddd; margin-bottom: 20px;">📋</div>
                <div style="font-size: 18px; font-weight: 600; color: #333; margin-bottom: 10px;">
                    Belum Ada Pengajuan Proposal
                </div>
                <div style="font-size: 14px; color: #999; margin-bottom: 30px;">
                    Anda belum pernah mengajukan proposal. Klik tombol "Ajukan Proposal" untuk memulai.
                </div>
                <a href="<?= base_url('mahasiswa/index'); ?>" class="btn-primary" style="margin: 0 auto; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <svg class="icon" viewBox="0 0 14 14"><path d="M7 1v12M1 7h12"/></svg>
                    Ajukan Proposal
                </a>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            sidebar.classList.toggle('open');
            overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
        } else {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('open');
        overlay.style.display = 'none';
    }

    // Restore collapsed state on desktop
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
        }
    });
    </script>
</body>
</html>
