<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB $db
 * @property CI_Upload $upload
 * @property Datados_model $datados_model
 * @property Datasiswa_model $datasiswa_model
 */

class Data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        $this->load->model(['datados_model', 'datasiswa_model']);
        // is_logged_in(); // Aktifkan jika sudah ada helpernya
    }

    public function index()
    {
        redirect('data/datados');
    }

    // =========================================================================
    // SECTION: DATA DOSEN
    // =========================================================================

    public function datados()
    {
        $data['title'] = 'Data dosen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['dosen'] = $this->db->get('dosen')->result_array();
        $data['open_modal'] = false;

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
            $this->load->view('data/data_dosen', $data);
            $this->load->view('templates/footeradmin');
        } else {
            $insert = [
                'nidn' => $this->input->post('nidn'),
                'nama_dos' => $this->input->post('nama_dos'),
                'gelar' => $this->input->post('gelar'),
            ];
            $this->db->insert('dosen', $insert);

            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => true, 'message' => 'Dosen berhasil ditambahkan!']);
                exit;
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Dosen berhasil ditambahkan!</div>');
                redirect('data/datados');
            }
        }
    }

    // Fungsi untuk Server-side DataTables Dosen
    public function getdatados()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $list = $this->datados_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            $data[] = [
                'no'       => $no,
                'nidn'     => $row->nidn ?? '',
                'nama_dos' => $row->nama_dos,
                'gelar'    => $row->gelar,
                'aksi'     => '<a href="javascript:void(0)" class="badge badge-success btn-edit-dosen" data-id="'.$row->id_dosen.'">edit</a> '
                             .'<a href="javascript:void(0)" class="badge badge-danger btn-delete-dosen" data-id="'.$row->id_dosen.'">delete</a>'
            ];
        }

        $output = [
            "draw"            => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal"    => $this->datados_model->count_all(),
            "recordsFiltered" => $this->datados_model->count_filtered(),
            "data"            => $data
        ];

        echo json_encode($output);
        exit;
    }

    // Fungsi Ambil 1 Baris Data Dosen (Untuk Edit)
    public function getdatadosrow()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $data = $this->datados_model->get_by_id($id);
        echo json_encode($data ?: []);
        exit;
    }

    public function updatedatadosrow()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        
        $id = $this->input->post('e_id_dosen');
        $data = [
            'nidn' => $this->input->post('e_nidn'),
            'nama_dos' => $this->input->post('e_nama_dos'),
            'gelar' => $this->input->post('e_gelar')
        ];
        $result = $this->datados_model->update($id, $data);
        echo json_encode(['status' => (bool)$result]);
        exit;
    }

    public function deletedatadosrow()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $result = $this->datados_model->delete($id);
        echo json_encode(['status' => (bool)$result]);
        exit;
    }

    // =========================================================================
    // SECTION: DATA MAHASISWA
    // =========================================================================

    public function datasiswa()
    {
        $data['title'] = 'Data mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['prodi_list'] = $this->db->get('prodi')->result_array();
        $data['open_modal'] = false;

        $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('prodi_id', 'Prodi', 'required|trim');

        if ($this->form_validation->run() == false) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') $data['open_modal'] = true;
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
            redirect('data/datasiswa');
        }
    }

    public function getdatasiswa()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        $list = $this->datasiswa_model->get_datatables();
        $data = [];
        $no = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($list as $row) {
            $no++;
            $data[] = [
                'no' => $no,
                'nim' => $row->nim,
                'nama' => $row->nama,
                'nama_prodi' => $row->nama_prodi,
                'aksi' => '<a href="#" class="badge badge-success btn-edit-siswa" data-id="'.$row->id_mahasiswa.'">edit</a> '
                         .'<a href="#" class="badge badge-danger btn-delete-siswa" data-id="'.$row->id_mahasiswa.'">delete</a>'
            ];
        }

        echo json_encode([
            "draw" => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
            "recordsTotal" => $this->datasiswa_model->count_all(),
            "recordsFiltered" => $this->datasiswa_model->count_filtered(),
            "data" => $data
        ]);
        exit;
    }

    public function getdatamahasiswarow()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('mahasiswa', ['id_mahasiswa' => $id])->row_array();
        echo json_encode($row ?: []);
    }

    public function deletedatasiswarow()
    {
        $id = $this->input->post('id');
        $this->db->delete('mahasiswa', ['id_mahasiswa' => $id]);
        echo json_encode(['status' => true]);
    }

    public function updatemahasiswa()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $id = $this->input->post('id_mahasiswa');
        $data = [
            'nim'      => $this->input->post('nim'),
            'nama'     => $this->input->post('nama'),
            'prodi_id' => $this->input->post('prodi_id'),
        ];

        $this->db->update('mahasiswa', $data, ['id_mahasiswa' => $id]);
        echo json_encode(['status' => true]);
        exit;
    }

    }