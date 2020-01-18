<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('mLogin');
        $this->load->library('session');
        $this->load->model('mAll');
    }
	public function index(){
        $this->load->helper('url');
		$this->load->view('admin/login');
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
    public function login_action(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $where = array(
            'email_admin' => $email,
            'pass_admin' => md5($password)
        );
        $check = $this->mLogin->login_checker("tbl_admin",$where)->num_rows();
        if($check > 0){
            $data = array(
                'logged_in' => TRUE,
                'username' => $check->name_admin
            );
            $this->session->set_userdata($data);
            redirect(site_url('admin/overview'));
        }else{
            echo"nrp atau password salah";
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect(site_url("login"));
    }
}
