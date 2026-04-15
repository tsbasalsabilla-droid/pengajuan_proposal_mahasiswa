<?php

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">

<div class="sidebar" id="sidebar">

    <!-- Brand -->
    <div class="sidebar-top">
        <div class="logo-mark">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <text x="8" y="11" text-anchor="middle" fill="#fff" font-family="Arial, sans-serif" font-size="13" font-weight="bold">SP</text>
            </svg>
        </div>
        <span class="brand-name">Sistem Proposal</span>
    </div>

    <!-- Nav: Menu Utama -->
    <nav class="nav-group">
        <div class="nav-label">Menu</div>

        <a href="dashboard" class="nav-item <?= $current_page === 'dashboard' ? 'active' : '' ?>">
            <span class="nav-icon">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 2a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H2a1 1 0 01-1-1V2zm0 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H2a1 1 0 01-1-1V9zm7-7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H9a1 1 0 01-1-1V2zm0 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H9a1 1 0 01-1-1V9z"/></svg>
            </span>
            <span class="nav-text">Dashboard</span>
        </a>

        <a href="pengajuan" class="nav-item <?= $current_page === 'pengajuan' ? 'active' : '' ?>">
            <span class="nav-icon">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M2.5 3A1.5 1.5 0 001 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0115 5.293V4.5A1.5 1.5 0 0013.5 3h-11z"/><path d="M15 6.954L8.978 9.86a2.25 2.25 0 01-1.956 0L1 6.954V11.5A1.5 1.5 0 002.5 13h11a1.5 1.5 0 001.5-1.5V6.954z"/></svg>
            </span>
            <span class="nav-text">Pengajuan</span>
        </a>

        <a href="detail_pengajuan" class="nav-item <?= $current_page === 'detail_pengajuan' ? 'active' : '' ?>">
            <span class="nav-icon">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 16A8 8 0 108 0a8 8 0 000 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 110-2 1 1 0 010 2z"/></svg>
            </span>
            <span class="nav-text">Detail Pengajuan</span>
        </a>
    </nav>

    <!-- Nav: Akun -->
    <nav class="nav-group">
        <div class="nav-label">Akun</div>
        
        <a href="<?= base_url('auth/logout') ?>" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>
            </span>
            <span class="nav-text">Logout</span>
        </a>

    <!-- Footer: User Info -->
    <div class="sidebar-footer">
        <a href="/profil" class="user-row">
            <div class="user-avatar">
                <?php
                // Ambil inisial dari nama user session
                $nama = $this->session->userdata('nama') ?? 'Mahasiswa';
                $inisial = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $nama)));
                echo substr($inisial, 0, 2);
                ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($this->session->userdata('nama') ?? 'Mahasiswa') ?></div>
                <div class="user-role"><?= htmlspecialchars($this->session->userdata('prodi') ?? 'Mahasiswa') ?></div>
            </div>
        </a>
    </div>

</div>

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        sidebar.classList.toggle('open');
        document.getElementById('sidebarOverlay').style.display =
            sidebar.classList.contains('open') ? 'block' : 'none';
    } else {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.remove('open');
    document.getElementById('sidebarOverlay').style.display = 'none';
}

// Restore collapsed state on desktop
document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === 'true') {
        document.getElementById('sidebar').classList.add('collapsed');
    }
});
</script>