<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Proposal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pengajuan.css'); ?>">
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

        .btn-outline {
            background: #fff; color: #555;
            border: 1px solid #e4e4ec; border-radius: 7px;
            padding: 7px 14px; font-size: 12px; font-weight: 500;
            cursor: pointer; font-family: inherit;
            display: flex; align-items: center; gap: 6px;
        }

        .btn-cancel {
            background: transparent; color: #888;
            border: 1px solid #e4e4ec; border-radius: 8px;
            padding: 9px 18px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: inherit;
        }

        .btn-submit {
            background: #6c3ce1; color: #fff;
            border: none; border-radius: 8px;
            padding: 9px 22px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: inherit;
            display: flex; align-items: center; gap: 7px;
            transition: background 0.15s;
        }

        .btn-submit:hover { background: #5a2ec8; }

        /* ALERT */
        .alert-info {
            background: #f0ecfd;
            border-left: 3px solid #6c3ce1;
            border-radius: 8px; padding: 11px 16px;
            font-size: 13px; color: #5a35c0;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 20px;
        }

        /* CARD */
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .card-head {
            padding: 20px 28px 18px;
            border-bottom: 1px solid #f2f2f6;
            display: flex; align-items: center; justify-content: space-between;
            margin: -30px -30px 20px -30px;
            padding: 30px;
        }

        .card-label {
            font-size: 10px; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: #bbb; margin-bottom: 3px;
        }

        .card-title { font-size: 16px; font-weight: 600; color: #1a1a2e; }

        /* SECTION DIVIDER */
        .section-divider {
            padding: 13px 28px;
            background: #fafafa;
            border-bottom: 1px solid #f2f2f6;
            border-top: 1px solid #f2f2f6;
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: #6c3ce1;
            margin: 20px -30px;
            padding: 13px 30px;
        }

        /* FIELD ROW */
        .field-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f4f4f8;
            gap: 24px;
        }

        .field-row:last-of-type { border-bottom: none; }

        .field-label { font-size: 13px; font-weight: 500; color: #444; }

        .field-hint { font-size: 11px; color: #bbb; margin-top: 2px; }

        /* INPUT */
        .form-input {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; color: #1a1a2e;
            background: #fff;
            border: 1px solid #e4e4ec;
            border-radius: 8px;
            padding: 9px 13px;
            outline: none; width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input:focus {
            border-color: #6c3ce1;
            box-shadow: 0 0 0 3px rgba(108,60,225,0.08);
        }

        .form-input[readonly] {
            color: #888;
            background: #fff;
            border-color: #f0f0f5;
            cursor: default;
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236c3ce1' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
            cursor: pointer;
        }

        /* CARD FOOTER */
        .card-foot {
            padding: 16px 28px;
            background: #fafafa;
            border-top: 1px solid #f2f2f6;
            display: flex; justify-content: flex-end;
            align-items: center; gap: 10px;
            margin: 0 -30px -30px -30px;
            padding: 20px 30px;
        }

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
                <div class="page-title">Pengajuan Proposal</div>
                <div class="page-sub">Selamat datang, <?= $this->session->userdata('nama'); ?></div>
            </div>
        </div>

        <div class="alert-info">
            <svg class="icon" style="flex-shrink:0;" viewBox="0 0 14 14">
                <circle cx="7" cy="7" r="6"/>
                <path d="M7 4.5v3M7 9.5v.1"/>
            </svg>
            <?php if ($sudah_disetujui): ?>
                Selamat! Proposal Anda sudah disetujui. Anda tidak dapat mengajukan proposal baru.
            <?php elseif ($ada_pending): ?>
                Anda masih memiliki proposal yang sedang diproses. Harap tunggu hingga proposal tersebut disetujui atau ditolak sebelum mengajukan yang baru.
            <?php elseif ($sudah_pengajuan): ?>
                Kamu sudah mengajukan proposal sebelumnya. Tinjau statusnya sebelum mengajukan yang baru.
            <?php else: ?>
                Isi form pengajuan proposal dengan lengkap untuk mengajukan proposal baru.
            <?php endif; ?>
        </div>

        <?php if ($bisa_mengajukan): ?>
        <div class="card">
            <form action="<?= base_url('mahasiswa/submit_pengajuan'); ?>" method="post">
            <div class="card-head">
                <div>
                    <div class="card-label">Dokumen Akademik</div>
                    <div class="card-title">Form Pengajuan Proposal</div>
                </div>
                <button class="btn-outline">
                    <svg class="icon" style="width:13px;height:13px;" viewBox="0 0 14 14">
                        <path d="M2 7h10M8 3l4 4-4 4"/>
                    </svg>
                    Lihat Detail Pengajuan
                </button>
            </div>

            <!-- INFORMASI MAHASISWA -->
            <div class="section-divider">Informasi Mahasiswa</div>

            <div class="field-row">
                <div>
                    <div class="field-label">NIM</div>
                    <div class="field-hint">Nomor induk mahasiswa</div>
                </div>
                <input type="text" class="form-input" value="<?= isset($user->nim) ? $user->nim : ''; ?>" readonly>
            </div>

            <div class="field-row">
                <div>
                    <div class="field-label">Nama Lengkap</div>
                    <div class="field-hint">Sesuai data akademik</div>
                </div>
                <input type="text" class="form-input" value="<?= isset($user->nama) ? $user->nama : $this->session->userdata('nama'); ?>" readonly>
            </div>

            <div class="field-row">
                <div>
                    <div class="field-label">Program Studi</div>
                </div>
                <input type="text" class="form-input" value="<?= isset($user->prodi) ? $user->prodi : ''; ?>" readonly>
            </div>

            <!-- DETAIL PROPOSAL -->
            <div class="section-divider">Detail Proposal</div>

            <div class="field-row">
                <div>
                    <div class="field-label">Judul Proposal</div>
                    <div class="field-hint">Tulis judul yang jelas dan spesifik</div>
                </div>
                <input type="text" class="form-input" name="judul" placeholder="Masukkan judul proposal">
            </div>

            <div class="field-row">
                <div>
                    <div class="field-label">Link Dokumen</div>
                    <div class="field-hint">Google Drive atau repositori lainnya</div>
                </div>
                <input type="url" class="form-input" name="link" placeholder="https://drive.google.com/...">
            </div>

            <!-- DOSEN PENGUJI -->
            <div class="section-divider">Dosen Penguji</div>

            <div class="field-row">
                <div>
                    <div class="field-label">Dosen Penguji 1</div>
                </div>
                <select class="form-input" name="dosen1">
                    <option value="">— Pilih Dosen —</option>
                    <?php foreach ($dosen as $item): ?>
                        <option value="<?= $item->id ?>"><?= $item->nama_dosen ?>, <?= $item->gelar ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-row">
                <div>
                    <div class="field-label">Dosen Penguji 2</div>
                </div>
                <select class="form-input" name="dosen2">
                    <option value="">— Pilih Dosen —</option>
                    <?php foreach ($dosen as $item): ?>
                        <option value="<?= $item->id ?>"><?= $item->nama_dosen ?>, <?= $item->gelar ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-row">
                <div>
                    <div class="field-label">Dosen Penguji 3</div>
                </div>
                <select class="form-input" name="dosen3">
                    <option value="">— Pilih Dosen —</option>
                    <?php foreach ($dosen as $item): ?>
                        <option value="<?= $item->id ?>"><?= $item->nama_dosen ?>, <?= $item->gelar ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="card-foot">
                <button class="btn-cancel">Batal</button>
                <button class="btn-submit">
                    <svg class="icon" viewBox="0 0 14 14"><path d="M1 7l4 4 8-8"/></svg>
                    Kirim Pengajuan
                </button>
            </div>
            </form>
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
        
        // Dosen selection validation
        const dosen1 = document.querySelector('select[name="dosen1"]');
        const dosen2 = document.querySelector('select[name="dosen2"]');
        const dosen3 = document.querySelector('select[name="dosen3"]');
        
        function updateDosenOptions() {
            const selected1 = dosen1.value;
            const selected2 = dosen2.value;
            const selected3 = dosen3.value;
            
            // Update dosen2 options
            Array.from(dosen2.options).forEach(option => {
                if (option.value && (option.value === selected1 || option.value === selected3)) {
                    option.disabled = true;
                    option.style.color = '#ccc';
                } else {
                    option.disabled = false;
                    option.style.color = '';
                }
            });
            
            // Update dosen3 options
            Array.from(dosen3.options).forEach(option => {
                if (option.value && (option.value === selected1 || option.value === selected2)) {
                    option.disabled = true;
                    option.style.color = '#ccc';
                } else {
                    option.disabled = false;
                    option.style.color = '';
                }
            });
            
            // Update dosen1 options
            Array.from(dosen1.options).forEach(option => {
                if (option.value && (option.value === selected2 || option.value === selected3)) {
                    option.disabled = true;
                    option.style.color = '#ccc';
                } else {
                    option.disabled = false;
                    option.style.color = '';
                }
            });
        }
        
        dosen1.addEventListener('change', updateDosenOptions);
        dosen2.addEventListener('change', updateDosenOptions);
        dosen3.addEventListener('change', updateDosenOptions);
        
        // Form submission validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const selected1 = dosen1.value;
            const selected2 = dosen2.value;
            const selected3 = dosen3.value;
            
            // Check for duplicate selections
            if (selected1 && (selected1 === selected2 || selected1 === selected3)) {
                e.preventDefault();
                alert('Dosen Penguji 1 tidak boleh sama dengan Dosen Penguji 2 atau 3');
                return false;
            }
            
            if (selected2 && selected2 === selected3) {
                e.preventDefault();
                alert('Dosen Penguji 2 tidak boleh sama dengan Dosen Penguji 3');
                return false;
            }
        });
    });
    </script>
</body>
</html>