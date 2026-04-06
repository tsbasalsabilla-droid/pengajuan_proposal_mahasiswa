<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Panggil helper yang sudah kamu buat tadi
        is_logged_in(); 
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user.role_id = user_role.id')
            ->where('user.email', $this->session->userdata('email'))
            ->get()
            ->row_array();
        
        // Ambil data mahasiswa saja (exclude dosen dan admin)
        $this->db->select('u.*, m.nim, m.prodi_id, p.nama_prodi');
        $this->db->from('user u');
        $this->db->join('mahasiswa m', 'u.id = m.user_id', 'left');
        $this->db->join('prodi p', 'm.prodi_id = p.id_prodi', 'left');
        $this->db->where('u.role_id', 2); // Hanya mahasiswa
        $this->db->order_by('u.id', 'DESC');
        $data['mahasiswa'] = $this->db->get()->result();
        
        // Ambil statistik
        $data['total_mahasiswa'] = $this->db->get_where('user', ['role_id' => 2])->num_rows();
        $data['total_dosen'] = $this->db->get_where('user', ['role_id' => 3])->num_rows();
        $data['total_proposal'] = $this->db->get('pengajuan_proposal')->num_rows();
        
        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footeradmin');
    }

    public function role_access() {
        $data['title'] = 'Role';
        $data['user'] = $this->db->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user.role_id = user_role.id')
            ->where('user.email', $this->session->userdata('email'))
            ->get()
            ->row_array();
        
        // Ambil semua data role dari DB
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footeradmin');
    }

    public function role_access_detail($role_id) {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        // Ambil data role spesifik
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        // Ambil semua menu kecuali menu 'Admin' agar admin tidak sengaja mengunci diri sendiri
        $this->db->where('id !=', 4); 
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footeradmin');
    }

    public function proposal() {
        $data['title'] = 'Daftar Proposal';
        $data['user'] = $this->db->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user.role_id = user_role.id')
            ->where('user.email', $this->session->userdata('email'))
            ->get()
            ->row_array();
        
        // Ambil data proposal dari database
        $data['proposal'] = $this->db->get('pengajuan_proposal')->result_array();

        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/proposal', $data);
        $this->load->view('templates/footeradmin');
    }

    public function changeaccess() {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        // Debug: Log received data
        log_message('debug', 'Received: menuId=' . $menu_id . ', roleId=' . $role_id);

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            log_message('debug', 'Inserted access for role_id=' . $role_id . ', menu_id=' . $menu_id);
        } else {
            $this->db->delete('user_access_menu', $data);
            log_message('debug', 'Deleted access for role_id=' . $role_id . ', menu_id=' . $menu_id);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
}