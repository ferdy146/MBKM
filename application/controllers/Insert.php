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
            'email_penulis'           => $this->input->post('email_penulis'),
            'penerbit'        => $this->input->post('penerbit'),
            'tanggal'           => $this->input->post('tanggal')
        );

        // insert database
        $this->Model->insertData('buku', $data);

         // simpan ke session agar bisa dibaca function kirimEmail
        $this->session->set_userdata('nama_buku', $data['nama_buku']);

        $this->kirimEmail($data['email_penulis']);

        redirect('menu');
    }

    public function kirimEmail(){
        $nama_buku = $this->session->userdata('nama_buku');
        $pesan = "
            <h3>Data Buku Berhasil Ditambahkan!</h3>
            <p>Judul Buku : <b>$nama_buku</b></p>";

        $judul = 'Verifikasi Tambah Buku';

        $this->load->library('email');
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'Codeigniter';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "smtp.gmail.com"; //ubah host email
        $config['smtp_port'] = "587"; // host port
        $config['smtp_crypto'] = "tls";
        $config['smtp_user'] = "vvensa7@gmail.com"; //ubah alamat email
        $config['smtp_pass'] = "ajuakabvnececosl"; //ubah password email
        $config['smtp_timeout'] = 120;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('vvensa7@gmail.com', 'PT Perpus'); //from: email anda, nama profil email
        $this->email->to('irgiv1204@gmail.com'); //ubah nama email penerima
        $this->email->subject($judul);

        $this->email->message($pesan);

        if ($this->email->send()) { //kirim email, if sukses:
            $this->session->set_flashdata('type', 'alert-info');
            $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Email terkirim');
        }
        else { //if gagal kirim email
            $this->session->set_flashdata('type', 'alert-danger');
            $this->session->set_flashdata('pesan', '<strong>Error!</strong> pesan error: <br><br>'.$this->email->print_debugger());
            }
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
        'email_penulis'   => $this->input->post('email_penulis'),
        'penerbit'  => $this->input->post('penerbit'),
        'tanggal'   => $this->input->post('tanggal')
    ];

    $this->db->where('id_buku', $id);
    $this->db->update('buku', $data);

    redirect('menu');
    }

}