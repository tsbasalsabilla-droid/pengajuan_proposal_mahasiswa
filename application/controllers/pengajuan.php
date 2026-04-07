<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    /**
     * @property CI_Form_validation $form_validation
     * @property CI_Input $input
     * @property CI_Session $session
     * @property CI_DB $db
     * @property CI_Upload $upload
     */

    class pengajuan extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('form_validation');
            // is_logged_in();
        }




        public function index()
        {
            $data['title'] = 'Pengajuan proposal';
            $data['user'] = $this->db->where(
                'email',
                $this->session->userdata('email')
            )->get('user')->row_array();

            $this->load->view('templates/headeradmin', $data);
            $this->load->view('templates/sidebaradmin', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengajuan/daftar_pengajuan', $data);
            $this->load->view('templates/footeradmin');
        }


 public function daftar()
{
    $data['title'] = 'Daftar proposal';
    $data['user'] = $this->db->where(
        'email',
        $this->session->userdata('email')
    )->get('user')->row_array();

    $data['pengajuan_proposal'] = $this->db->get('pengajuan_proposal')->result_array();
    $data['open_modal'] = false;
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    $this->form_validation->set_rules('nim', 'nim', 'required|trim');
    $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
    $this->form_validation->set_rules('link', 'Link', 'required|trim');
    $this->form_validation->set_rules('dosen1_id', 'Dosen 1', 'required|trim');
    $this->form_validation->set_rules('dosen2_id', 'Dosen 2', 'required|trim');
    $this->form_validation->set_rules('dosen3_id', 'Dosen 3', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required|trim');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim');

    if ($this->form_validation->run() == false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['open_modal'] = true;
        }
$data['dosen_list'] = $this->db->get('dosen')->result_array();


        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan/daftar_pengajuan', $data);
        $this->load->view('templates/footeradmin');
    } else {
        $this->db->insert('pengajuan_proposal', [
            'nim' => $this->input->post('nim'),
            'judul' => $this->input->post('judul'),
            'link' => $this->input->post('link'),
            'dosen1' => $this->input->post('dosen1_id'),
'dosen2' => $this->input->post('dosen2_id'),
'dosen3' => $this->input->post('dosen3_id'),
            'status' => $this->input->post('status'),
            'tanggal' => $this->input->post('tanggal'),
        ]);
        
        // Check if AJAX request
        if ($this->input->post('ajax') || $this->input->is_ajax_request()) {
            echo json_encode(['status' => true, 'message' => 'Pengajuan Proposal berhasil ditambahkan!']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengajuan Proposal berhasil ditambahkan!</div>');
            redirect('pengajuan/daftar_pengajuan');
        }
    }
}

public function getdaftarrow()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('pengajuan_proposal', ['id' => $id])->row_array();
        echo json_encode($row ?: []);
    }

    public function updatedaftar()
    {
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('nim', 'Nim', 'required|trim');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('link', 'Link', 'required|trim');
        $this->form_validation->set_rules('dosen1_id', 'Dosen 1', 'required|trim');
        $this->form_validation->set_rules('dosen2_id', 'Dosen 2', 'required|trim');
        $this->form_validation->set_rules('dosen3_id', 'Dosen 3', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => false,
                'errors' => [
                    'nim' => form_error('nim'),
                    'judul' => form_error('judul'),
                    'link' => form_error('link'),
                    'dosen1' => form_error('dosen1_id'),
                    'dosen2' => form_error('dosen2_id'),
                    'dosen3' => form_error('dosen3_id'),
                    'status' => form_error('status'),
                    'tanggal' => form_error('tanggal'),
                ]
            ]);
            return;
        }

        $id = (int)$this->input->post('id');
        $data = [
            'nim' => $this->input->post('nim'),
            'judul' => $this->input->post('judul'),
            'link' => $this->input->post('link'),
            'dosen1' => $this->input->post('dosen1_id'),
            'dosen2' => $this->input->post('dosen2_id'),
            'dosen3' => $this->input->post('dosen3_id'),
            'status' => $this->input->post('status'),
            'tanggal' => $this->input->post('tanggal'),
        ];
        $this->db->where('id', $id)->update('pengajuan_proposal', $data);
        echo json_encode(['status' => true, 'message' => 'Pengajuan berhasil diupdate']);
    }

    public function deletedaftarrow()
    {
        $id = (int)$this->input->post('id');
        if ($id) {
            $this->db->delete('pengajuan_proposal', ['id' => $id]);
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
        }
    }

    public function getdaftar()
    {
        $this->load->model('daftar_model');

        $list = $this->daftar_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            
            // Status dibuat bisa diklik untuk memicu Modal
            $status_color = ($row->status == 'Disetujui') ? 'success' : (($row->status == 'Ditolak') ? 'danger' : 'warning');
            $status_badge = '<a href="javascript:void(0)" class="badge badge-'.$status_color.' btn-status" data-id="'.$row->id.'">'.$row->status.'</a>';
            
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

    public function verifikasi()
{
    $data['title'] = 'Verifikasi proposal';
    $data['user'] = $this->db->where(
        'email',
        $this->session->userdata('email')
    )->get('user')->row_array();

    $data['pengajuan_proposal'] = $this->db->get('pengajuan_proposal')->result_array();
    $data['open_modal'] = false;
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    $this->form_validation->set_rules('nim', 'nim', 'required|trim');
    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
    $this->form_validation->set_rules('link', 'Link', 'required|trim');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required|trim');

    if ($this->form_validation->run() == false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['open_modal'] = true;
        }
        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengajuan/verifikasi', $data);
        $this->load->view('templates/footeradmin');
    } else {
        $this->db->insert('pengajuan_proposal', [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'judul' => $this->input->post('judul'),
            'link' => $this->input->post('link'),
            'tanggal' => $this->input->post('tanggal'),
            'status' => $this->input->post('status'),
        ]);
        
        // Check if AJAX request
        if ($this->input->post('ajax') || $this->input->is_ajax_request()) {
            echo json_encode(['status' => true, 'message' => 'Verifikasi berhasil ditambahkan!']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Verifikasi berhasil ditambahkan!</div>');
            redirect('pengajuan/verifikasi');
        }
    }
}

public function getverifrow()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('pengajuan_proposal', ['id' => $id])->row_array();
        echo json_encode($row ?: []);
    }

    public function updatestatus()
{
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json');
    
    $id = $this->input->post('id');
    $status = $this->input->post('status');

    if (!$id || !$status) {
        echo json_encode(['status' => false, 'message' => 'ID atau status tidak valid']);
        exit;
    }

    $this->db->where('id', $id);
    $update = $this->db->update('pengajuan_proposal', ['status' => $status]);

    if ($update) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal update status']);
    }
    exit;
}

    public function getverif()
    {
        $this->load->model('verifikasi_model');

        $list = $this->verifikasi_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            $status_class = $row->status == 'sudah disetujui' ? 'success' : 'danger';
            
            $data[] = [
                'no'          => $no,
                'nim'  => $row->nim,
                'nama'  => $row->nama,
                'judul'  => $row->judul,
                'link'     => $row->link,
                'tanggal'     => $row->tanggal,
                'status' => '<span class="badge badge-'.$status_class.' btn-status" 
    data-id="'.$row->id.'" 
    style="cursor:pointer;">
    '.$row->status.'
</span>',
            ];
        }

        echo json_encode([
            "draw"            => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal"    => $this->verifikasi_model->count_all(),
            "recordsFiltered" => $this->verifikasi_model->count_filtered(),
            "data"            => $data
        ]);
    }
    }
