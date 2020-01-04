<?php

require APPPATH . '/libraries/REST_Controller.php';

class Grup extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id_grup = $this->get('id_grup');
        if ($id_grup == '') {
            $grup = $this->db->query("
            SELECT * FROM grup inner join proyek on proyek.id_proyek=
            grup.id_proyek ")->result();
        } else {
            $grup = $this->db->query("
            SELECT * FROM grup where  id_grup=$id_grup")->result();
        }
        $this->response($grup, 200);
    }

    function grup_get() {
        $id_proyek = $this->get('id_proyek');
        if ($id_proyek == '') {
            $proyek = $this->db->query("
            SELECT * FROM grup ")->result();
        } else {
            $proyek = $this->db->query("
            SELECT * FROM grup where  id_proyek=$id_proyek")->result();
        }
        $this->response($proyek, 200);
    }

     function cari_get() {
            $id = $this->get('id_grup');
            $tukang = $this->db->query("
            SELECT * FROM tukang inner join anggota_grup on tukang.id_tukang=anggota_grup.id_tukang inner join grup on grup.id_grup = anggota_grup.id_grup inner join proyek on grup.id_proyek=proyek.id_proyek where grup.id_grup = $id")->result();
      
        $this->response($tukang, 200);
    }

    function anggota_get() {
       
            $tukang = $this->db->query("
            SELECT * FROM tukang where id_tukang NOT IN (select id_tukang from anggota_grup)")->result();
      
        $this->response($tukang, 200);
    }

    function jml_get() {
            $id = $this->get('id_grup');
            $tukang = $this->db->query("SELECT count(id_anggota) as jml FROM anggota_grup where id_grup=$id")->result();
      
        $this->response($tukang, 200);
    }

    function jmlTukang_get() {
            $id = $this->get('id_grup');
            $tukang = $this->db->query("SELECT jumlah_tukang FROM proyek inner join grup on proyek.id_proyek=grup.id_proyek WHERE grup.id_grup=$id")->result();
      
        $this->response($tukang, 200);
    }

    function index_post() {
        $data = array(
                    'id_proyek'    => $this->post('id_proyek'));
        $insert = $this->db->insert('grup', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function add_post() {
        $data = array(
                    'id_tukang' =>$this->post('id_tukang'),
                    'id_grup'    => $this->post('id_grup'));
        $insert = $this->db->insert('anggota_grup', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}