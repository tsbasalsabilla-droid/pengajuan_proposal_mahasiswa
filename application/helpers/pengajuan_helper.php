<?php 
function check_access($role_id, $menu_id) {
    $ci = get_instance();
    
    $result = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    $has_access = $result->num_rows() > 0;
    
    if ($has_access) {
        return "checked='checked'";
    }
}

function is_logged_in() {
    $ci = get_instance();
    
    // 1. Cek Login
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        
        // 2. Ambil segment ke-2 dari URL (Misal: mahasiswa/pengajuan -> 'pengajuan')
        // Ini lebih akurat karena 'pengajuan' adalah Menu, sedangkan 'mahasiswa' adalah Role
        $menu_url = $ci->uri->segment(2); 

        // Jika segment 2 kosong (hanya dashboard), kita cek segment 1
        if (!$menu_url) {
            $menu_url = $ci->uri->segment(1);
        }

        // 3. Cari di tabel user_sub_menu (karena di sana daftar halaman/link berada)
        $userSubMenu = $ci->db->get_where('user_sub_menu', ['url' => $ci->uri->segment(1) . '/' . $ci->uri->segment(2)])->row_array();
        
        if ($userSubMenu) {
            $menu_id = $userSubMenu['menu_id'];

            // 4. Cek apakah Role ID user ini punya akses ke Menu ID tersebut
            $userAccess = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ]);

            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }
        }
        // Jika halaman tidak terdaftar di sub_menu, biarkan lewat selama sudah login (atau sesuaikan)
    }
}