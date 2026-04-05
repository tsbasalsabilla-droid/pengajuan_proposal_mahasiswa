<?php 
function check_access($role_id, $menu_id) {
    $ci = get_instance();
    
    // Debug: Log parameters
    log_message('debug', 'check_access called with role_id=' . $role_id . ', menu_id=' . $menu_id);
    
    $result = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    $has_access = $result->num_rows() > 0;
    
    // Debug: Log result
    log_message('debug', 'check_access result: ' . ($has_access ? 'HAS ACCESS' : 'NO ACCESS') . ' (rows=' . $result->num_rows() . ')');

    if ($has_access) {
        return "checked='checked'";
    }
}

function is_logged_in() {
    $ci = get_instance();
    
    // 1. Cek sudah login belum?
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        // 2. Kalau sudah login, cek rolenya punya akses ke menu ini tidak?
        $role_id = $ci->session->userdata('role_id');
        
        // Ambil nama menu dari URL (segmen ke-1, misal: 'dosen')
        $menu = $ci->uri->segment(1);

        // Cari ID menu tersebut di database
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        // Cek ke tabel user_access_menu
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        // Jika tidak ada baris yang cocok, berarti dia tidak punya akses
        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
