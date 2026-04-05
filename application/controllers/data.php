<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    /**
     * @property CI_Form_validation $form_validation
     * @property CI_Input $input
     * @property CI_Session $session
     * @property CI_DB $db
     * @property CI_Upload $upload
     */

    class Data extends CI_Controller
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
            $data['title'] = 'Data dosen';
            $data['user'] = $this->db->where(
                'email',
                $this->session->userdata('email')
            )->get('user')->row_array();

            $this->load->view('templates/headeradmin', $data);
            $this->load->view('templates/sidebaradmin', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/data_dosen', $data);
            $this->load->view('templates/footeradmin');
        }


 public function datados()
{
    $data['title'] = 'Data dosen';
    $data['user'] = $this->db->where(
        'email',
        $this->session->userdata('email')
    )->get('user')->row_array();

    $data['dosen'] = $this->db->get('dosen')->result_array();
    $data['open_modal'] = false;
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    $this->form_validation->set_rules('nidn', 'NIDN', 'required|trim');
    $this->form_validation->set_rules('nama_dos', 'Nama', 'required|trim');
    $this->form_validation->set_rules('gelar', 'Gelar', 'required|trim');

    if ($this->form_validation->run() == false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['open_modal'] = true;
        }
        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/data_dos', $data);
        $this->load->view('templates/footeradmin');
    } else {
        $this->db->insert('dosen', [
            'nidn' => $this->input->post('nidn'),
            'nama_dos' => $this->input->post('nama_dos'),
            'gelar' => $this->input->post('gelar'),
        ]);
        
        // Check if AJAX request
        if ($this->input->post('ajax') || $this->input->is_ajax_request()) {
            echo json_encode(['status' => true, 'message' => 'Dosen berhasil ditambahkan!']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Dosen berhasil ditambahkan!</div>');
            redirect('data/datados');
        }
    }
}

public function getdatadosrow()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('dosen', ['id_dosen' => $id])->row_array();
        echo json_encode($row ?: []);
    }

    public function updatedos()
    {
        $this->form_validation->set_rules('id_dosen', 'ID', 'required|integer');
        $this->form_validation->set_rules('nidn', 'NIDN', 'required|trim');
        $this->form_validation->set_rules('nama_dos', 'Nama', 'required|trim');
        $this->form_validation->set_rules('gelar', 'Gelar', 'required|trim');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => false,
                'errors' => [
                    'nidn' => form_error('nidn'),
                    'nama_dos' => form_error('nama_dos'),
                    'gelar' => form_error('gelar'),
                ]
            ]);
            return;
        }

        $id = (int)$this->input->post('id_dosen');
        $data = [
            'nidn' => $this->input->post('nidn'),
            'nama_dos' => $this->input->post('nama_dos'),
            'gelar' => $this->input->post('gelar'),
        ];
        $this->db->where('id_dosen', $id)->update('dosen', $data);
        echo json_encode(['status' => true, 'message' => 'Dosen berhasil diupdate']);
    }

    public function deletedatadosrow()
    {
        $id = (int)$this->input->post('id');
        if ($id) {
            $this->db->delete('dosen', ['id_dosen' => $id]);
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
        }
    }

    public function getdatados()
    {
        $this->load->model('datados_model');

        $list = $this->datados_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            $data[] = [
                'no'          => $no,
                'nidn'  => $row->nidn,
                'nama_dos'  => $row->nama_dos,
                'gelar'     => $row->gelar,
                'aksi'        => '<a href="#" class="badge badge-success btn-edit-dosen" data-id="'.$row->id_dosen.'">edit</a> '
                                   .'<a href="#" class="badge badge-danger btn-delete-dosen" data-id="'.$row->id_dosen.'">delete</a>'
            ];
        }

        echo json_encode([
            "draw"            => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal"    => $this->datados_model->count_all(),
            "recordsFiltered" => $this->datados_model->count_filtered(),
            "data"            => $data
        ]);
    }


public function datasiswa()
{
    $data['title'] = 'Data Mahasiswa';
    $data['user'] = $this->db->where(
        'email',
        $this->session->userdata('email')
    )->get('user')->row_array();

    $data['mahasiswa'] = $this->db->get('mahasiswa')->result_array();
    $data['prodi_list'] = $this->db->get('prodi')->result_array();
    $data['open_modal'] = false;
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }
    if (isset($this->security)) {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('prodi_id', 'Prodi', 'required|trim');

    if ($this->form_validation->run() == false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['open_modal'] = true;
        }
        $this->load->view('templates/headeradmin', $data);
        $this->load->view('templates/sidebaradmin', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/data_mahasiswa', $data);
        $this->load->view('templates/footeradmin');
    } else {
        $this->db->insert('mahasiswa', [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'prodi_id' => $this->input->post('prodi_id'),
        ]);
        
        if ($this->input->post('ajax') || $this->input->is_ajax_request()) {
            echo json_encode(['status' => true, 'message' => 'Mahasiswa berhasil ditambahkan!']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Mahasiswa berhasil ditambahkan!</div>');
            redirect('data/datasiswa');
        }
    }
}

public function getdatamahasiswarow()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('mahasiswa', ['id_mahasiswa' => $id])->row_array();
        echo json_encode($row ?: []);
    }

    public function updatemahasiswa()
    {
        $this->form_validation->set_rules('id_mahasiswa', 'ID', 'required|integer');
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('prodi_id', 'Prodi', 'required|trim');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => false,
                'errors' => [
                    'nim' => form_error('nim'),
                    'nama' => form_error('nama'),
                    'prodi_id' => form_error('prodi_id'),
                ]
            ]);
            return;
        }

        $id = (int)$this->input->post('id_mahasiswa');
        $data = [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'prodi_id' => $this->input->post('prodi_id'),
        ];
        $this->db->where('id_mahasiswa', $id)->update('mahasiswa', $data);
        echo json_encode(['status' => true, 'message' => 'Mahasiswa berhasil diupdate']);
    }

    public function deletedatasiswarow()
    {
        $id = (int)$this->input->post('id');
        if ($id) {
            $this->db->delete('mahasiswa', ['id_mahasiswa' => $id]);
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
        }
    }

    public function getdatasiswa()
    {
        $this->load->model('datasiswa_model');

        $list = $this->datasiswa_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            $data[] = [
                'no'          => $no,
                'nim'  => $row->nim,
                'nama'  => $row->nama,
                'nama_prodi'     => $row->nama_prodi,
                'aksi'        => '<a href="#" class="badge badge-success btn-edit-siswa" data-id="'.$row->id_mahasiswa.'">edit</a> '
                                   .'<a href="#" class="badge badge-danger btn-delete-siswa" data-id="'.$row->id_mahasiswa.'">delete</a>'
            ];
        }

        echo json_encode([
            "draw"            => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal"    => $this->datasiswa_model->count_all(),
            "recordsFiltered" => $this->datasiswa_model->count_filtered(),
            "data"            => $data
        ]);
    }


    }

