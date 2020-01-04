<?php
class User extends CI_Controller { 
var $API =""; 
    function __construct() {
        parent::__construct();
        $this->API="http://localhost:8080/res_server/index.php"; 

        $user = $this->session->userdata('admin');
        
           if (!isset($user)) { 
                echo "<script> alert('Anda harus login dahulu!');
                window.location.href='admin';</script>"; 
           } 
           else { 
              return true;
           }
    }

    function index(){
    $data['user'] = json_decode($this->curl->simple_get($this->API.'/User'));
    $this->load->view('admin/view_user',$data);
    }
}

