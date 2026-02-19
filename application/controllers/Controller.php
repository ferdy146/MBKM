<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Controller extends CI_Controller {
    
    Public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->model("Model");
    }
    
    public function login(){
        $this->Model->login();
    }

    
    public function logout(){
        $this->session->sess_destroy();
        redirect();
    }
    
    // http://localhost/template_penerbitan/
    public function index(){
        $this->load->view('login');
    }
	
    // http://localhost/template_penerbitan/menu
    public function menu(){
        $this->load->view('header');
        $this->load->view('menu');
    }

    public function tambah(){
    $this->load->view('header');
    $this->load->view('tambah');
    }

    public function edit(){

    $id_buku = $this->input->get('id'); // ambil dari ?id=

    $data['buku'] = $this->db
        ->get_where('buku', ['id_buku' => $id_buku])
        ->row_array();

    $this->load->view('header');
    $this->load->view('edit', $data);
    }

    // public function edit($id_buku){

    // $data['buku'] = $this->Model->get_buku_by_id($id_buku);

    // $this->load->view('header');
    // $this->load->view('edit', $data);
    // }

        }
