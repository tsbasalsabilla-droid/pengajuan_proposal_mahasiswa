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

        // Ambil semua submenu yang active (ini yang 5 submenu)
        $this->db->select('usm.*, um.menu as menu_name');
        $this->db->from('user_sub_menu usm');
        $this->db->join('user_menu um', 'usm.menu_id = um.id', 'left');
        $this->db->where('usm.is_active', 1);
        $this->db->order_by('um.menu', 'ASC');
        $this->db->order_by('usm.title', 'ASC');
        $data['submenu'] = $this->db->get()->result_array();
        
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

    public function getproposals()
    {
        header('Content-Type: application/json');
        
        $this->load->model('daftar_model');
        
        // Debug: Log request data
        error_log("GETPROPOSALS REQUEST: " . print_r($_POST, true));
        
        $list = $this->daftar_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;
        
        error_log("TOTAL RECORDS: " . $this->daftar_model->count_all());
        error_log("FILTERED RECORDS: " . $this->daftar_model->count_filtered());

        foreach ($list as $row) {
            $no++;
            
            // Status badge dengan logic yang lebih baik
            $status_text = !empty($row->status) ? $row->status : 'Pending';
            $status_color = 'secondary'; // Default abu-abu
            
            if ($status_text == 'Disetujui') {
                $status_color = 'success';
            } elseif ($status_text == 'Ditolak') {
                $status_color = 'danger';
            } elseif ($status_text == 'Pending') {
                $status_color = 'warning';
            }

            $status_badge = '
<a href="javascript:void(0)" 
   class="badge badge-'.$status_color.' btn-status" 
   data-id="'.$row->id.'" 
   style="font-size:13px; padding:6px 12px; border-radius:5px; cursor:pointer; text-decoration:none;">
   '.$status_text.'
</a>';
            
            $data[] = [
                'no'          => $no,
                'nim'         => $row->nim,
                'judul'       => $row->judul,
                'berkas'      => '<a href="'.$row->link.'" target="_blank" class="badge badge-info">Lihat Berkas</a>',
                'status'      => $status_badge
            ];
        }

        echo json_encode([
            "draw"            => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal"    => $this->daftar_model->count_all(),
            "recordsFiltered" => $this->daftar_model->count_filtered(),
            "data"            => $data
        ]);
    }

    public function changeaccess() {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            $action = 'inserted';
        } else {
            $this->db->delete('user_access_menu', $data);
            $action = 'deleted';
        }

        // Return JSON response for AJAX
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'action' => $action,
            'message' => 'Access berhasil diubah'
        ]);
        exit;
    }
}