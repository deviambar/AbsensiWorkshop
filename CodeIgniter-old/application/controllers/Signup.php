<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Signup extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('mLogin');
        $this->load->library('session');
        $this->load->model('mAll');
    }
    public function signup(){
        $this->load->helper('url');
        $data['jurusan'] = $this->mLogin->show_jurusan()->result();
        $this->load->view('admin/signup',$data);
    }

    public function signup_action(){
        $nama = $this->input->post('nama');
        $password = $this->input->post('password');
        $nrp = $this->input->post('nrp');
        $id_jurusan = $this->input->post('id_jurusan');

        $data = array (
            'nrp_siswa' => $nrp,
            'nama_siswa' => $nama,
            'id_jurusan' => $id_jurusan,
            'password_siswa' => md5($password)
            );
        $this->mAll->inputData($data, 'tbl_siswa');
        $this->load->view('admin/signup',$data);

    }
}