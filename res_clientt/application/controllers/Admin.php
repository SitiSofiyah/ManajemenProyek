<?php
class Admin extends CI_Controller { 
var $API =""; 
    function __construct() {
        parent::__construct();
        $this->API="http://localhost:8080/res_server/index.php"; 
    }

    function index(){
        $this->load->view('login_admin');
    }

    function proses_login(){
        if (isset($_POST['submit'])) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $params = array('username'=> $username,
                            'password'=>$password);            
            $loginadmin = $this->curl->simple_post($this->API.'/login', $params,array(CURLOPT_BUFFERSIZE => 10));
            $a = json_decode($loginadmin);    
            if($a > 0){
                    $session = array(
                    'id_admin'  =>  $a,
                    'username'  =>  $username,
                    'password'       =>  $password);
                    $this->session->set_userdata('admin',$session);
                    redirect("index.php/admin_dash");                                      
            }
            else{
                 echo "<script> alert('username dan Password anda salah');
                window.location.href='../admin';</script>";
            }
        } else {
            echo "gagal";
        }        
    }
         
    function logout() {
            $this->session->sess_destroy();
            redirect('index.php/admin');
    }
  
    
}

