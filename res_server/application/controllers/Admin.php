<?php

require APPPATH . '/libraries/REST_Controller.php';

class Admin extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

     function index_get() {
          $id_admin = $this->get('id_admin');
        if ($id_admin == '') {
            $admin = $this->db->get('admin')->result();
        } else {
            $this->db->where('id_admin', $id_admin);
            $proyek = $this->db->get('admin')->result();
        }
        $this->response($admin, 200);
    }

    function user_get() {
       
            $user = $this->db->query("
            SELECT count(id_user) as jml1 FROM user")->result();
        $this->response($user, 200);
    }

     function tukang_get() {
        $tukang = $this->db->query("
            SELECT count(id_tukang) as jml2 FROM tukang")->result();
        $this->response($tukang, 200);
    }

     function proyek_get() {
         $proyek = $this->db->query("
            SELECT count(id_proyek) as jml3 FROM proyek")->result();
        $this->response($proyek, 200);
    }

     function mp_get() {
         $proyek = $this->db->query("
            SELECT count(id_order) as jml4 FROM order_tukang")->result();
        $this->response($proyek, 200);
    }
}