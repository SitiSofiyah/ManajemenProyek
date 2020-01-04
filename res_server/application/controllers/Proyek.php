<?php

require APPPATH . '/libraries/REST_Controller.php';

class Proyek extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id_proyek = $this->get('id_proyek');
        if ($id_proyek == '') {
            $proyek = $this->db->get('proyek')->result();
        } else {
            $this->db->where('id_proyek', $id_proyek);
            $proyek = $this->db->get('proyek')->result();
        }
        $this->response($proyek, 200);
    }

    function user_get() {
        $id_user = $this->get('id_user');
        
            $proyek = $this->db->query("
            SELECT * FROM proyek INNER JOIN order_tukang where proyek.id_proyek=order_tukang.id_proyek and id_user=$id_user")->result();
        
        $this->response($proyek, 200);
    }

    function index_post() {
        $data = array(
                    'jenis_proyek'          => $this->post('jenis_proyek'),
                    'jumlah_tukang'    => $this->post('jumlah_tukang'),
                    'waktu_pengerjaan'        => $this->post('waktu_pengerjaan'));
        $insert = $this->db->insert('proyek', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function user_post() {
        $data = array(
                'id_user' => $this->post('id_user'),
                'id_proyek' => $this->post('id_proyek'),
                'total_biaya' => $this->post('total_biaya'),
                'tanggal_order' => $this->post('tanggal_order'),
                'status'=> $this->post('status'),
                'pesan' => $this->post('pesan'));
        $insert = $this->db->insert('order_tukang', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {
        $id_proyek = $this->put('id_proyek');
        $data = array(
                    'id_proyek'      => $this->put('id_proyek'),
                    'jenis_proyek'      => $this->put('jenis_proyek'),
                    'jumlah_tukang'=> $this->put('jumlah_tukang'),
                    'waktu_pengerjaan'    => $this->put('waktu_pengerjaan'));
        $this->db->where('id_proyek', $id_proyek);
        $update = $this->db->update('proyek', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id_proyek = $this->delete('id_proyek');
        $this->db->where('id_proyek', $id_proyek);
        $delete = $this->db->delete('proyek');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}