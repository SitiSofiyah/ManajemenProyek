<?php

require APPPATH . '/libraries/REST_Controller.php';

class Tukang extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id = $this->get('id_tukang');
        if ($id == '') {
            $tukang = $this->db->query("
            SELECT * FROM tukang ")->result();
        } else {
            $this->db->where('id_tukang', $id);
            $tukang = $this->db->query("
            SELECT * FROM tukang where id_tukang=$id")->result();
        }
        $this->response($tukang, 200);
    }

    function index_post() {
        $data = array(
                    'nama_tukang'          => $this->post('nama_tukang'),
                    'alamat'          => $this->post('alamat'),
                    'no_telp'          => $this->post('no_telp'));
        $insert = $this->db->insert('tukang', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {
        $id_tukang = $this->put('id_tukang');
        $data = array(
                    'id_tukang'      => $this->put('id_tukang'),
                    'nama_tukang'      => $this->put('nama_tukang'),
                    'no_telp'=> $this->put('no_telp'),
                    'alamat'    => $this->put('alamat'));
        $this->db->where('id_tukang', $id_tukang);
        $update = $this->db->update('tukang', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id_tukang = $this->delete('id_tukang');
        $this->db->where('id_tukang', $id_tukang);
        $delete = $this->db->delete('tukang');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}