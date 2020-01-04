<?php

require APPPATH . '/libraries/REST_Controller.php';

class manajemen extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $proyek = $this->db->query("
            SELECT * FROM proyek INNER JOIN order_tukang on proyek.id_proyek=order_tukang.id_proyek 
            inner join user on user.id_user=order_tukang.id_user")->result();
        
        $this->response($proyek, 200);
    }

    function grup_get() {
        $id_order = $this->get('id_order');
       
            $order = $this->db->query("
            SELECT id_proyek FROM order_tukang where  id_order=$id_order")->result();
        
        $this->response($order, 200);
    }

    function cekGrup_get() {
        $id_order = $this->get('id_order');
       
            $order = $this->db->query("
            SELECT * FROM  detail_order_tukang where id_order=$id_order")->result();
        
            $this->response($order, 200);
       
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

    function orderDetail_post() {
        $data = array(
                'id_order'=> $this->post('id_order'),
                'id_grup' => $this->post('id_grup'));
        
        $insert = $this->db->insert('detail_order_tukang', $data);
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

     function terima_put() {

        $id_order = $this->put('id_order');
        $data = array(
                    'status'  => $this->put('status'));
        $this->db->where('id_order', $id_order);
        $update = $this->db->update('order_tukang', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('id_order');
        $this->db->where('id_order', $id);
        $delete = $this->db->delete('order_tukang');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}