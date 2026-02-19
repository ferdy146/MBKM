<?php

class model extends CI_Model
{
    // contoh login
    public function login(){
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        
        $query = "SELECT id, password FROM masuk WHERE id = '".$id."'";
        $user = $this->db->query($query)->row_array();
        
        // jika user ditemukan
        if ($user) {
            if (md5($password) == $user['password']){
                $_SESSION['login'] = true;
                $_SESSION['id'] = $user['id'];
				
                $this->session->set_flashdata('type', 'alert-success');
                $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Anda berhasil login.');
                redirect('menu');
            }
            // jika password salah
            else {
                $this->session->set_flashdata('type', 'alert-danger');
                $this->session->set_flashdata('pesan', '<strong>Gagal!</strong>Password salah');
                redirect();
            }
        }
        // jika user tidak ditemukan
        else {
            $this->session->set_flashdata('type', 'alert-danger');
            $this->session->set_flashdata('pesan', '<strong>Gagal!</strong> ID tidak ditemukan');
            redirect();
        }
    }
	
    //contoh query biasa
    public function contoh1(){
        $query = "SELECT id_buku, nama_buku, email_penulis, penerbit, tanggal FROM buku";
        return $this->db->query($query);
    }
	
    //contoh query dengan input dari AJAX
    public function contoh2($inputAjax){
        $query = "SELECT id_buku, nama_buku, email_penulis, penerbit, tanggal FROM buku WHERE tanggal = '".$inputAjax."'";
        return $this->db->query($query);
    }

    public function insertData($table, $data){
        return $this->db->insert($table, $data);
    }
    
    public function deleteData($table, $where){
    return $this->db->delete($table, $where);
    }

}

