<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert extends CI_Controller {
    
    Public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->model("Model");
    }
    
    public function contoh2(){
        $inputAjax = $this->input->post('inputAjax');
		
        $this->Model->contoh2($inputAjax);
        redirect('menu');
    }

    public function tambah(){

        $data = array(
            'nama_buku'      => $this->input->post('nama_buku'),
            'penulis'           => $this->input->post('penulis'),
            'penerbit'        => $this->input->post('penerbit'),
            'tanggal'           => $this->input->post('tanggal')
        );

        $this->Model->insertData('buku', $data);

        redirect('menu');
    }

    public function delete(){
    $id = $this->input->post('id_buku');

        if($id){
            $this->Model->deleteData('buku', ['id_buku' => $id]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // public function edit($id_buku){

    // $data['buku'] = $this->Model->get_buku_by_id($id_buku);

    // $this->load->view('header');
    // $this->load->view('edit', $data);
    // }


    public function update(){

    $id = $this->input->post('id_buku');

    $data = [
        'nama_buku' => $this->input->post('nama_buku'),
        'penulis'   => $this->input->post('penulis'),
        'penerbit'  => $this->input->post('penerbit'),
        'tanggal'   => $this->input->post('tanggal')
    ];

    $this->db->where('id_buku', $id);
    $this->db->update('buku', $data);

    redirect('menu');
    }

}