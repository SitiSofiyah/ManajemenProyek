<?php
class Admin_dash extends CI_Controller { 
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
        $session_data=$this->session->userdata("admin");
        $data['username']=$session_data['username'];
    	$data['tukang'] = json_decode($this->curl->simple_get($this->API.'/Admin/tukang'));
      $data['mp'] = json_decode($this->curl->simple_get($this->API.'/Admin/mp'));
    	$data['user'] = json_decode($this->curl->simple_get($this->API.'/Admin/user'));
    	$data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Admin/proyek'));
   		$this->load->view('admin/dashboard',$data);
    }  
 
}
