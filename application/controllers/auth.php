<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB $db
 */ 

class Auth extends CI_Controller {

public function __construct()
    {   
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        
    }

public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('dashboard'); // Atau ke dashboard sesuai rolenya
        }
        
        $this->form_validation->set_rules('user_email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) { 
        $data = ['title' => 'Login'];
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
        
    } else {
        //validasi sukses
        $this->_login();
    }
    }

    private function _login() {
    $email = $this->input->post('user_email');
    $password = $this->input->post('user_password'); 

    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    
    if($user) {
        if($user['is_active'] == 1) {
            if(password_verify($password, $user['password'])){
                $data = [
                    'email' => $user['email'], 
                    'role_id' => $user['role_id'],
                    'nama' => $user['name']
                ];
                $this->session->set_userdata($data);
                
                // REDIRECT BERDASARKAN ROLE
                if($user['role_id'] == 1){
                    redirect('admin'); // Sesuaikan nama controller Adminmu
                } elseif($user['role_id'] == 3) {
                    redirect('dosen'); // Role 3 ke Controller Dosen (Dashboard)
                } else {
                    redirect('mahasiswa'); // Role 2 ke Controller Mahasiswa (langsung ke index)
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Email not active!</div>');
            redirect('auth');
        }
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Email not registered!</div>');
        redirect('auth');
    }
}

    public function registration()
    {
        $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'this email has already registered!'
        ]);
        $this->form_validation->set_rules('user_password1', 'password', 'required|trim|min_length[3]|matches[user_password2]', [
            'matches' => 'password dont match!',
            'min_length' => 'password too short!'
        ]);
        $this->form_validation->set_rules('user_password2', 'password', 'required|trim|matches[user_password1]');

        if ( $this->form_validation->run() == false) {
            $data['title'] = 'Register';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('user_email');
            $name = htmlspecialchars($this->input->post('user_name', true));
            $password = password_hash($this->input->post('user_password1'), PASSWORD_DEFAULT);
            $role_id = 2; // Mahasiswa (Sesuai role_id di databasemu)

            // 1. INSERT ke tabel user
            $user_insert = $this->db->insert('user', [
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'role_id' => $role_id,
                'is_active' => 1
            ]);

            if ($user_insert) {
                $user_id = $this->db->insert_id();
                log_message('debug', 'User berhasil dibuat dengan ID: ' . $user_id);

                // 2. MASUKKAN ke tabel mahasiswa (data minimal)
                $mahasiswa_insert = $this->db->insert('mahasiswa', [
                    'user_id' => $user_id,
                    'nama' => $name,
                    'prodi_id' => 1 // sementara
                ]);

                if ($mahasiswa_insert) {
                    log_message('debug', 'Data mahasiswa berhasil dibuat untuk user_id: ' . $user_id);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please login.</div>');
                } else {
                    log_message('error', 'Gagal membuat data mahasiswa: ' . $this->db->error());
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Error creating mahasiswa data.</div>');
                }
            } else {
                log_message('error', 'Gagal membuat user: ' . $this->db->error());
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Error creating user account.</div>');
            }
            
            redirect('auth');
        }
    }

        public function logout(){
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('role_id');
            $this->session->unset_userdata('nama');
            $this->session->sess_destroy(); // Wajib ada ini biar session hancur total

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
            redirect('http://localhost/pengajuan_proposal/auth');
        }

        public function blocked(){
            $this->load->view('auth/blocked');
        }
    }
