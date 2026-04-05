<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * @property CI_Form_validation $form_validation

 * @property CI_Input $input

 * @property CI_Session $session

 * @property CI_DB $db

 */ 



class Dashboard extends CI_Controller {



public function __construct()

{

    parent::__construct();

    $this->load->library('session');

    // is_logged_in();

}



public function index()

    {

        $data['title'] = 'Dashboard';

        $data['user'] = $this->db->where('email', 

        $this->session->userdata('email'))->get('user')->row_array();



        $this->load->view('templates/headeradmin', $data);

        $this->load->view('templates/sidebaradmin', $data);

        $this->load->view('templates/topbar', $data);

        $this->load->view('dashboard/index', $data);

        $this->load->view('templates/footeradmin');

        

    }

}