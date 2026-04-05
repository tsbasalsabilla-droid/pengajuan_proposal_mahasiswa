<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        // Pastikan helper is_logged_in sudah ada untuk cek session & akses
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
        
        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('dashboard/index', $data); // Use dashboard view
        $this->load->view('templates/footeradmin');
    }

    public function proposal()
    {
        $data['title'] = 'Daftar Proposal Mahasiswa';
        $data['user'] = $this->db->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user.role_id = user_role.id')
            ->where('user.email', $this->session->userdata('email'))
            ->get()
            ->row_array();

        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('dosen/proposal', $data);
        $this->load->view('templates/footeradmin');
    }

    public function update_proposal() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        $this->db->where('id', $id);
        $update = $this->db->update('pengajuan_proposal', ['status' => $status]);
        
        echo json_encode(['status' => $update]);
    }

    public function get_data_proposal() {
        // Server-side processing untuk DataTable
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];

        $this->db->from('pengajuan_proposal');
        
        // Search
        if($search) {
            $this->db->like('nim', $search);
            $this->db->or_like('judul', $search);
        }
        
        $total = $this->db->count_all_results('', false);
        
        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = $query->result_array();
        
        $result = [];
        $i = $start + 1;
        foreach($data as $row) {
            // Status dibuat bisa diklik untuk memicu Modal
            $status_color = ($row['status'] == 'Disetujui') ? 'success' : (($row['status'] == 'Ditolak') ? 'danger' : 'warning');
            $status_badge = '<a href="javascript:void(0)" class="badge badge-'.$status_color.' btn-status" data-id="'.$row['id'].'">'.$row['status'].'</a>';
            
            $result[] = [
                'no' => $i++,
                'nim' => $row['nim'],
                'judul' => $row['judul'],
                'berkas' => '<a href="'.$row['link'].'" target="_blank" class="badge badge-info text-white">Lihat Berkas</a>',
                'status' => $status_badge
            ];
        }
        
        $response = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $result
        ];
        
        echo json_encode($response);
    }

    public function delete_proposal() {
        $id = $this->input->post('id');
        $delete = $this->db->delete('pengajuan_proposal', ['id' => $id]);
        echo json_encode(['status' => $delete]);
    }
}
