<?php
require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id_user = $this->get('id_user');
        if ($id_user == '') {
            $user = $this->db->get('user')->result();
        } else {
            $this->db->where('id_user', $id_user);
            $user = $this->db->get('user')->result();
        }
        $this->response($user, 200);
    }

    function index_post() {
        $data = array(
                    'nama'          => $this->post('nama'),
                    'username'           => $this->post('username'),
                    'password'          => $this->post('password'),
                    'no_telp'    => $this->post('no_telp'),
                    'alamat'        => $this->post('alamat'));
        $insert = $this->db->insert('user', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {
        $id_user = $this->put('id_user');
        $data = array(
                    'nama'          => $this->put('nama'),
                    'username'           => $this->put('username'),
                    'password'          => $this->put('password'),
                    'no_telp'    => $this->put('no_telp'),
                    'alamat'        => $this->put('alamat'));
        $this->db->where('id_user', $id_user);
        $update = $this->db->update('user', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}