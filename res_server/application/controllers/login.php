<?php
require APPPATH . '/libraries/REST_Controller.php';

class login extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }
    function index_post(){
        $username      = $this->post('username');
        $password      = $this->post('password'); 
        $get_user = $this->db->query("
            SELECT
            *
            FROM admin WHERE username='$username' 
            AND password='$password'");
        if ($get_user->num_rows() === 1) {
            $this->response(
                     $get_user->row()->id_admin            
            );
        } else {
            $this->response(
                null
            );
        }
    }

    function user_post(){
        $username      = $this->post('username');
        $password      = $this->post('password'); 

        $get_user = $this->db->query("
            SELECT
            *
            FROM user WHERE username='$username' 
            AND password='$password'");

        if ($get_user->num_rows() === 1) {
            $this->response(
                     $get_user->row()->id_user           
            );
        } else {
            $this->response(
                null
            );
        }
    }
}