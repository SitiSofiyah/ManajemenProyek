<?php

require APPPATH . '/libraries/REST_Controller.php';

class Gaji extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id_gaji = $this->get('id_gaji');
        if ($id_gaji == '') {
            $gaji = $this->db->query("
            SELECT * FROM gaji ")->result();
        } else {
            $gaji = $this->db->query("
            SELECT * FROM gaji where  id_gaji=$id_gaji")->result();
        }
        $this->response($gaji, 200);
    }

     function detail_get() {
       $detail = $this->db->query("
            SELECT dot.*, tukang.*, total_biaya/jumlah_tukang as gaji  FROM detail_order_tukang dot inner join grup on dot.id_grup=grup.id_grup inner join anggota_grup ag on grup.id_grup=ag.id_grup inner join tukang on ag.id_tukang = tukang.id_tukang inner join proyek on grup.id_proyek=proyek.id_proyek inner join order_tukang ot on dot.id_order = ot.id_order")->result();

       $this->response($detail, 200);
    }

    function index_put() {
        $id_gaji = $this->put('id_gaji');
        $data = array(
                    'id_gaji'      => $this->put('id_gaji'),
                    'gaji'=> $this->put('gaji'));
        $this->db->where('id_gaji', $id_gaji);
        $update = $this->db->update('gaji', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}