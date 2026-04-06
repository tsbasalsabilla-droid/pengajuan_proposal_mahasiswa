<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        
        // SIMPLE CHECK - NO HELPER NEEDED
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        
        // CHECK IF USER IS MAHASISWA (role_id = 2)
        $role_id = $this->session->userdata('role_id');
        if ($role_id != 2) {
            redirect('auth/blocked');
        }
    }

    public function index()
    {
        // Redirect ke dashboard untuk menjaga konsistensi URL
        redirect('mahasiswa/dashboard');
    }

    public function pengajuan()
    {
        // Ambil data user dari database berdasarkan session
        $email = $this->session->userdata('email');
        $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
        
        // Gunakan data dari tabel user sebagai base, lalu coba ambil data mahasiswa
        if ($user_data) {
            $data['user'] = (object)[
                'nim' => '',
                'nama' => $user_data['name'],
                'prodi' => ''
            ];
            
            // Coba ambil data mahasiswa (asumsi ada relasi yang belum diketahui)
            try {
                // Coba relasi via nama (asumsi nama sama)
                $this->db->where('nama', $user_data['name']);
                $mahasiswa_query = $this->db->get('mahasiswa');
                $mahasiswa_data = $mahasiswa_query->row_array();
                
                if ($mahasiswa_data) {
                    $data['user']->nim = $mahasiswa_data['nim'];
                    // Ambil nama prodi dari tabel prodi
                    if (isset($mahasiswa_data['prodi_id'])) {
                        $prodi = $this->db->get_where('prodi', ['id_prodi' => $mahasiswa_data['prodi_id']])->row_array();
                        if ($prodi) {
                            $data['user']->prodi = $prodi['nama_prodi'];
                        }
                    }
                }
            } catch (Exception $e) {
                // If query fails, continue with default values
            }
        }

        // Ambil data dosen dari tabel dosen
        $dosen_query = $this->db->get('dosen');
        $data['dosen'] = [];
        if ($dosen_query) {
            foreach ($dosen_query->result() as $row) {
                $data['dosen'][] = (object)[
                    'id' => $row->id_dosen,
                    'nama_dosen' => $row->nama_dos,
                    'gelar' => $row->gelar
                ];
            }
        }

        // Cek apakah user sudah pernah mengajukan proposal
        $proposal_query = $this->db->get_where('pengajuan_proposal', ['nim' => $data['user']->nim]);
        $data['sudah_pengajuan'] = $proposal_query->num_rows() > 0;
        
        $data['css'] = 'pengajuan';

        $data['menu'] = 'dashboard';

        $this->load->view('templates/headermahasiswa', $data);
        $this->load->view('mahasiswa/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    public function submit_pengajuan()
{
    // 1. Ambil data dari form (Pastikan "name" di view sesuai dengan ini)
    $judul  = $this->input->post('judul');
    $link   = $this->input->post('link');
    $dosen1 = $this->input->post('dosen1');
    $dosen2 = $this->input->post('dosen2');
    $dosen3 = $this->input->post('dosen3');
    
    // 2. Ambil data user dari session
    $email = $this->session->userdata('email');
    $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
    
    if ($user_data) {
        // Ambil data mahasiswa untuk mendapatkan NIM
        $mahasiswa_data = $this->db->get_where('mahasiswa', ['nama' => $user_data['name']])->row_array();
        
        if ($mahasiswa_data) {
            $nim = $mahasiswa_data['nim'];

            // 3. Siapkan data untuk dimasukkan ke tabel pengajuan_proposal
            $data_insert = [
                'nim'     => $nim,
                'judul'   => $judul,
                'link'    => $link,
                'dosen1'  => $dosen1,
                'dosen2'  => $dosen2,
                'dosen3'  => $dosen3,
                'status'  => 'belum disetujui', // Status awal
                'tanggal' => date('Y-m-d H:i:s')
            ];

            // 4. Proses Simpan
            $insert = $this->db->insert('pengajuan_proposal', $data_insert);

            if ($insert) {
                // Set notifikasi sukses
                $this->session->set_flashdata('message', '<div class="alert alert-success">Proposal berhasil diajukan!</div>');
                
                // 5. REDIRECT ke halaman detail pengajuan
                redirect('mahasiswa/detail_pengajuan');
            }
        }
    }
    
    // Jika gagal total, balik ke form
    $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal mengajukan proposal. Silakan coba lagi.</div>');
    redirect('mahasiswa/index');
}

    public function detail_pengajuan()
    {
        $data['title'] = 'Detail Pengajuan';
        
        // Ambil data user dari database berdasarkan session
        $email = $this->session->userdata('email');
        $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
        
        // Gunakan data dari tabel user sebagai base, lalu coba ambil data mahasiswa
        if ($user_data) {
            $data['user'] = (object)[
                'nim' => '',
                'nama' => $user_data['name'],
                'prodi' => ''
            ];
            
            // Coba ambil data mahasiswa (asumsi ada relasi yang belum diketahui)
            try {
                // Coba relasi via nama (asumsi nama sama)
                $this->db->where('nama', $user_data['name']);
                $mahasiswa_query = $this->db->get('mahasiswa');
                $mahasiswa_data = $mahasiswa_query->row_array();
                
                if ($mahasiswa_data) {
                    $data['user']->nim = $mahasiswa_data['nim'];
                    // Ambil nama prodi dari tabel prodi
                    if (isset($mahasiswa_data['prodi_id'])) {
                        $prodi = $this->db->get_where('prodi', ['id_prodi' => $mahasiswa_data['prodi_id']])->row_array();
                        if ($prodi) {
                            $data['user']->prodi = $prodi['nama_prodi'];
                        }
                    }
                }
            } catch (Exception $e) {
                // If query fails, continue with default values
            }
        }

        // Ambil data proposal terakhir dari user yang sedang login
        $this->db->order_by('tanggal', 'DESC');
        $proposal_query = $this->db->get_where('pengajuan_proposal', ['nim' => $data['user']->nim], 1);
        $proposal_data = $proposal_query->row_array();
        
        if ($proposal_data) {
            // Ambil nama dosen pembimbing
            $dosen1 = $dosen2 = $dosen3 = null;
            
            if ($proposal_data['dosen1']) {
                $dosen1_query = $this->db->get_where('dosen', ['id_dosen' => $proposal_data['dosen1']])->row_array();
                if ($dosen1_query) {
                    $dosen1 = $dosen1_query['nama_dos'] . ', ' . $dosen1_query['gelar'];
                }
            }
            
            if ($proposal_data['dosen2']) {
                $dosen2_query = $this->db->get_where('dosen', ['id_dosen' => $proposal_data['dosen2']])->row_array();
                if ($dosen2_query) {
                    $dosen2 = $dosen2_query['nama_dos'] . ', ' . $dosen2_query['gelar'];
                }
            }
            
            if ($proposal_data['dosen3']) {
                $dosen3_query = $this->db->get_where('dosen', ['id_dosen' => $proposal_data['dosen3']])->row_array();
                if ($dosen3_query) {
                    $dosen3 = $dosen3_query['nama_dos'] . ', ' . $dosen3_query['gelar'];
                }
            }
            
            $data['proposal'] = (object)[
                'nim' => $proposal_data['nim'],
                'judul' => $proposal_data['judul'],
                'link' => $proposal_data['link'],
                'status' => $proposal_data['status'],
                'tanggal' => $proposal_data['tanggal'],
                'dosen1' => $dosen1,
                'dosen2' => $dosen2,
                'dosen3' => $dosen3
            ];
        } else {
            // Jika tidak ada proposal, redirect ke halaman dashboard
            redirect('mahasiswa/dashboard');
        }

        $data['menu'] = 'dashboard';
        $data['css'] = 'detail_pengajuan';

        $this->load->view('templates/headermahasiswa', $data);
        $this->load->view('mahasiswa/detail_pengajuan', $data);
        $this->load->view('templates/footer');
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard Mahasiswa';
        
        // Ambil data user dari database berdasarkan session
        $email = $this->session->userdata('email');
        $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
        
        // Gunakan data dari tabel user sebagai base, lalu coba ambil data mahasiswa
        if ($user_data) {
            $data['user'] = (object)[
                'nim' => '',
                'nama' => $user_data['name'],
                'prodi' => ''
            ];
            
            // Coba ambil data mahasiswa (asumsi ada relasi yang belum diketahui)
            try {
                // Coba relasi via nama (asumsi nama sama)
                $this->db->where('nama', $user_data['name']);
                $mahasiswa_query = $this->db->get('mahasiswa');
                $mahasiswa_data = $mahasiswa_query->row_array();
                
                if ($mahasiswa_data) {
                    $data['user']->nim = $mahasiswa_data['nim'];
                    // Ambil nama prodi dari tabel prodi
                    if (isset($mahasiswa_data['prodi_id'])) {
                        $prodi = $this->db->get_where('prodi', ['id_prodi' => $mahasiswa_data['prodi_id']])->row_array();
                        if ($prodi) {
                            $data['user']->prodi = $prodi['nama_prodi'];
                        }
                    }
                }
            } catch (Exception $e) {
                // If query fails, continue with default values
            }
        }

        // Ambil data proposal berdasarkan email user yang sedang login
        $this->db->order_by('tanggal', 'DESC');
        $proposal_query = $this->db->get_where('pengajuan_proposal', ['nim' => $data['user']->nim]);
        $data['proposals'] = $proposal_query->result();
        
        // Hitung statistik
        $data['total_proposals'] = $proposal_query->num_rows();
        $data['proposals_disetujui'] = 0;
        $data['proposals_ditolak'] = 0;
        $data['proposals_aktif'] = 0;
        
        foreach ($data['proposals'] as $proposal) {
            if ($proposal->status == 'sudah disetujui') {
                $data['proposals_disetujui']++;
            } elseif ($proposal->status == 'belum disetujui') {
                $data['proposals_aktif']++;
            }
        }

        $data['sudah_pengajuan'] = $data['total_proposals'] > 0;
        $data['menu'] = 'dashboard';
        $data['css'] = 'dashboard';
        
        $this->load->view('templates/headermahasiswa', $data);
        $this->load->view('mahasiswa/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
