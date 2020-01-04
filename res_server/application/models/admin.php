<?php

class admin extends CI_Model {

   
   
    function login($username,$password){
        $this->db->where('username',$username);
        $this->db->where('password',  md5($password));
        $user = $this->db->get('admin')->row_array();
        return $user;
    }

}