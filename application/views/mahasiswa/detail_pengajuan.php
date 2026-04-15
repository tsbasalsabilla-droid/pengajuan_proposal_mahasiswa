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
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">
                            Pilih Proposal 
                            <?php if (!empty($proposals)): ?>
                                <span style="background: #6B3EE8; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 8px;"><?= count($proposals) ?> Proposal</span>
                            <?php endif; ?>
                        </label>
                        <select id="proposalSelector" style="width: 100%; background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #111; font-size: 14px; font-weight: 500;">
                            <?php if (!empty($proposals)): ?>
                                <?php foreach ($proposals as $index => $prop): ?>
                                    <?php 
                                    $status_label = ($prop->status == 'Disetujui' || $prop->status == 'sudah disetujui') ? 'Disetujui' : (($prop->status == 'Ditolak' || $prop->status == 'ditolak') ? 'Ditolak' : 'Sedang Diproses');
                                    $status_color = ($prop->status == 'Disetujui' || $prop->status == 'sudah disetujui') ? '#10b981' : (($prop->status == 'Ditolak' || $prop->status == 'ditolak') ? '#ef4444' : '#f59e0b');
                                    ?>
                                    <option value="<?= $index ?>" <?= ($proposal && $proposal->id == $prop->id) ? 'selected' : '' ?>>
                                        <?= $prop->judul ?> (<?= date('d M Y', strtotime($prop->tanggal)) ?>) - [<?= $status_label ?>]
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Tidak ada proposal</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Judul Proposal</label>
                        <div id="proposalJudul" style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #111; font-size: 14px; line-height: 1.6; font-weight: 500;">
                            <?= $proposal ? $proposal->judul : 'Tidak ada proposal' ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Link Dokumen</label>
                        <div id="proposalLink" style="display: block;">
                            <?php if ($proposal && $proposal->link): ?>
                                <a href="<?= $proposal->link; ?>" target="_blank" style="display: block; background: #fff; border: 1px solid #6B3EE8; padding: 10px 15px; border-radius: 8px; color: #6B3EE8; text-decoration: none; font-size: 13px; font-weight: 500; width: fit-content; transition: 0.2s;">
                                    Buka Tautan Proposal <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:5px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                                </a>
                            <?php else: ?>
                                <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #999; font-size: 14px;">
                                    Tidak ada link dokumen
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Dosen Pembimbing</label>
                        <div id="proposalDosen" style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #666; font-size: 14px;">
                            <?php 
                            if ($proposal) {
                                $dosen_list = [];
                                if ($proposal->dosen1) $dosen_list[] = $proposal->dosen1;
                                if ($proposal->dosen2) $dosen_list[] = $proposal->dosen2;
                                if ($proposal->dosen3) $dosen_list[] = $proposal->dosen3;
                                echo !empty($dosen_list) ? implode('<br>', $dosen_list) : 'Tidak ada dosen pembimbing';
                            } else {
                                echo 'Tidak ada dosen pembimbing';
                            }
                            ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Komentar Admin</label>
                        <div id="proposalKomentar" style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #666; font-size: 14px; line-height: 1.6;">
                            <?= $proposal ? (!empty($proposal->komentar) ? htmlspecialchars($proposal->komentar) : 'Belum ada komentar') : 'Belum ada komentar' ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 8px;">Status Validasi</label>
                        <span id="proposalStatus" class="status-badge" style="
                            <?php 
                            if ($proposal) {
                                if ($proposal->status == 'Disetujui' || $proposal->status == 'sudah disetujui') {
                                    echo 'background: #ecfdf5; color: #10b981;';
                                } elseif ($proposal->status == 'Ditolak' || $proposal->status == 'ditolak') {
                                    echo 'background: #fef2f2; color: #ef4444;';
                                } else {
                                    echo 'background: #fff7ed; color: #f59e0b;';
                                }
                            } else {
                                echo 'background: #fff7ed; color: #f59e0b;';
                            }
                            ?>
                            padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <span style="width: 6px; height: 6px; 
                                <?php 
                                if ($proposal) {
                                    if ($proposal->status == 'Disetujui' || $proposal->status == 'sudah disetujui') {
                                        echo 'background: #10b981;';
                                    } elseif ($proposal->status == 'Ditolak' || $proposal->status == 'ditolak') {
                                        echo 'background: #ef4444;';
                                    } else {
                                        echo 'background: #f59e0b;';
                                    }
                                } else {
                                    echo 'background: #f59e0b;';
                                }
                                ?>
                                border-radius: 50%;"></span>
                            <span id="statusText">
                                <?= $proposal ? (($proposal->status == 'Disetujui' || $proposal->status == 'sudah disetujui') ? 'Disetujui' : (($proposal->status == 'Ditolak' || $proposal->status == 'ditolak') ? 'Ditolak' : 'Sedang Diproses')) : 'Sedang Diproses' ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Data proposal dari PHP
        const proposalsData = <?= json_encode($proposals ?? []); ?>;
        
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
        
        // Handle perubahan selector proposal
        document.getElementById('proposalSelector').addEventListener('change', function() {
            const selectedIndex = this.value;
            const proposal = proposalsData[selectedIndex];
            
            if (proposal) {
                // Update judul
                document.getElementById('proposalJudul').textContent = proposal.judul || 'Tidak ada judul';
                
                // Update link dokumen
                const linkContainer = document.getElementById('proposalLink');
                if (proposal.link) {
                    linkContainer.innerHTML = `
                        <a href="${proposal.link}" target="_blank" style="display: block; background: #fff; border: 1px solid #6B3EE8; padding: 10px 15px; border-radius: 8px; color: #6B3EE8; text-decoration: none; font-size: 13px; font-weight: 500; width: fit-content; transition: 0.2s;">
                            Buka Tautan Proposal <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:5px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                    `;
                } else {
                    linkContainer.innerHTML = `
                        <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #999; font-size: 14px;">
                            Tidak ada link dokumen
                        </div>
                    `;
                }
                
                // Update dosen pembimbing
                const dosenContainer = document.getElementById('proposalDosen');
                const dosenList = [];
                if (proposal.dosen1) dosenList.push(proposal.dosen1);
                if (proposal.dosen2) dosenList.push(proposal.dosen2);
                if (proposal.dosen3) dosenList.push(proposal.dosen3);
                dosenContainer.innerHTML = dosenList.length > 0 ? dosenList.join('<br>') : 'Tidak ada dosen pembimbing';
                
                // Update komentar
                const komentarContainer = document.getElementById('proposalKomentar');
                komentarContainer.innerHTML = proposal.komentar ? proposal.komentar : 'Belum ada komentar';
                
                // Update status
                const statusContainer = document.getElementById('proposalStatus');
                const statusText = document.getElementById('statusText');
                const statusDot = statusContainer.querySelector('span:first-child');
                
                let bgColor, textColor, dotColor, statusLabel;
                
                if (proposal.status === 'Disetujui' || proposal.status === 'sudah disetujui') {
                    bgColor = '#ecfdf5';
                    textColor = '#10b981';
                    dotColor = '#10b981';
                    statusLabel = 'Disetujui';
                } else if (proposal.status === 'Ditolak' || proposal.status === 'ditolak') {
                    bgColor = '#fef2f2';
                    textColor = '#ef4444';
                    dotColor = '#ef4444';
                    statusLabel = 'Ditolak';
                } else {
                    bgColor = '#fff7ed';
                    textColor = '#f59e0b';
                    dotColor = '#f59e0b';
                    statusLabel = 'Sedang Diproses';
                }
                
                statusContainer.style.background = bgColor;
                statusContainer.style.color = textColor;
                statusDot.style.background = dotColor;
                statusText.textContent = statusLabel;
            } else {
                // Reset ke default jika tidak ada proposal
                document.getElementById('proposalJudul').textContent = 'Tidak ada proposal';
                document.getElementById('proposalLink').innerHTML = `
                    <div style="background: #fcfcfd; border: 1px solid #eef0f2; padding: 12px 15px; border-radius: 8px; color: #999; font-size: 14px;">
                        Tidak ada link dokumen
                    </div>
                `;
                document.getElementById('proposalDosen').textContent = 'Tidak ada dosen pembimbing';
                document.getElementById('proposalKomentar').innerHTML = 'Belum ada komentar';
            }
        });
    </script>
</body>
</html>
