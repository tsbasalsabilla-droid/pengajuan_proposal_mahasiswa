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
            redirect('pengajuan/daftar');
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
        header('Content-Type: application/json');
        
        $this->load->model('daftar_model');

        $list = $this->daftar_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;
        
        // Debug: Cek apakah ada data
        error_log("Jumlah data dari model: " . count($list));
        error_log("Total records: " . $this->daftar_model->count_all());

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
            
            // Ambil nama dosen dari tabel dosen
            $dosen1 = $this->db->get_where('dosen', ['id_dosen' => $row->dosen1])->row('nama_dos') ?? '-';
            $dosen2 = $this->db->get_where('dosen', ['id_dosen' => $row->dosen2])->row('nama_dos') ?? '-';
            $dosen3 = $this->db->get_where('dosen', ['id_dosen' => $row->dosen3])->row('nama_dos') ?? '-';
            
            // Tombol aksi
            $aksi = '
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-warning btn-edit-daftar" data-id="'.$row->id.'">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-delete-daftar" data-id="'.$row->id.'">
                    <i class="fas fa-trash"></i>
                </button>
            </div>';
            
            $data[] = [
                'no'          => $no,
                'nim'         => $row->nim,
                'judul'       => $row->judul,
                'berkas'      => '<a href="'.$row->link.'" target="_blank" class="badge badge-info">Lihat Berkas</a>',
                'dosen1'      => $dosen1,
                'dosen2'      => $dosen2,
                'dosen3'      => $dosen3,
                'status'      => $status_badge,
                'tanggal'     => $row->tanggal ?? '-',
                'aksi'        => $aksi
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

    public function updatestatus() {
        header('Content-Type: application/json');
        
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id || !$status) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Update database
        $this->db->where('id', $id);
        $update = $this->db->update('pengajuan_proposal', ['status' => $status]);
        
        if ($update) {
            echo json_encode(['status' => true, 'message' => 'Status berhasil diubah']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal update database']);
        }
    }

    public function getverif()
    {
        $this->load->model('verifikasi_model');

        $list = $this->verifikasi_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            
            // Status badge dengan logic yang lebih baik
            $status_text = !empty($row->status) ? $row->status : 'pending';
            $status_compare = strtolower($status_text); // Kecilkan semua buat perbandingan
            
            if ($status_compare == 'disetujui' || $status_compare == 'setuju') {
                $status_color = 'success';
            } elseif ($status_compare == 'ditolak') {
                $status_color = 'danger';
            } else {
                $status_color = 'warning';
            }

            $status_badge = '
<a href="javascript:void(0)" 
   class="badge badge-'.$status_color.' btn-status" 
   data-id="'.$row->id.'" 
   style="font-size:13px; padding:6px 12px; border-radius:5px; cursor:pointer; text-decoration:none;">
   '.$status_text.'
</a>';
            
            // Format link untuk ditampilkan sebagai badge
            $link_badge = '<a href="'.$row->link.'" target="_blank" class="badge badge-info">Lihat Berkas</a>';
            
            $data[] = [
                'no'          => $no,
                'nim'         => $row->nim,
                'nama'        => $row->nama,
                'judul'       => $row->judul,
                'link'        => $link_badge,
                'tanggal'     => $row->tanggal,
                'status'      => $status_badge
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
