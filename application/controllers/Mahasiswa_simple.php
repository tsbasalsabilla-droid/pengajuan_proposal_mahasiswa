<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_simple extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }

    public function index()
    {
        redirect('mahasiswa_simple/dashboard');
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard Mahasiswa';
        
        // Simple user data
        $email = $this->session->userdata('email');
        $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
        
        if ($user_data) {
            $data['user'] = (object)[
                'nim' => '',
                'nama' => $user_data['name'],
                'prodi' => 'Teknik Informatika'
            ];
        }

        $this->load->view('templates/headermahasiswa', $data);
        $this->load->view('mahasiswa/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function pengajuan()
    {
        $data['title'] = 'Pengajuan Proposal';
        
        // Simple user data
        $email = $this->session->userdata('email');
        $user_data = $this->db->get_where('user', ['email' => $email])->row_array();
        
        if ($user_data) {
            $data['user'] = (object)[
                'nim' => '',
                'nama' => $user_data['name'],
                'prodi' => 'Teknik Informatika'
            ];
        }

        // Simple dosen data
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

        $this->load->view('templates/headermahasiswa', $data);
        $this->load->view('mahasiswa/pengajuan', $data);
        $this->load->view('templates/footer');
    }
}
