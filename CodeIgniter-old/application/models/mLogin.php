<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class mLogin extends CI_MODEL{
    function login_checker($table,$where){
        return $this->db->get_where($table,$where);
    }

    function show_jurusan(){
        $query = $this->db->get('tbl_jurusan');
        return $query;
    }
}

?>