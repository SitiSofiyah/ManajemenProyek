<?php
class manajemen extends CI_Controller { 
var $API =""; 
    function __construct() {
        parent::__construct();
        $this->API="http://localhost:8080/res_server/index.php"; 
        $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->helper('url');

        $user = $this->session->userdata('admin');

           if (!isset($user)) { 
                echo "<script> alert('Anda harus login dahulu!');
                window.location.href='admin';</script>"; 
           } 
           else { 
              return true;
           }
    }

    function index(){
        $data['manajemen'] = json_decode($this->curl->simple_get($this->API.'/manajemen'));
        $this->load->view('admin/view_manajemen',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
            'id_proyek' => $this->input->post('id_proyek'),
            'gaji' => $this->input->post('gaji'));
            $insert = $this->curl->simple_post($this->API.'/gaji', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('gaji');
            }else
            {
                echo "gagal";
            }
            
              
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('admin/input_gaji',$data);
        }
    }

    function add(){
        if(isset($_POST['submit'])){
            $data = array(
            'id_grup' => $this->input->post('id_grup'),
            'id_order' => $this->input->post('id_order'));
            $insert = $this->curl->simple_post($this->API.'/gaji', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('gaji');
            }else
            {
                echo "gagal";
            }
            
              
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('admin/input_gaji',$data);
        }
    }

    function detail(){
         if(isset($_POST['submit'])){
            $data = array(
            'id_grup' => $this->input->post('id_grup'),
            'id_order' => $this->input->post('id_order'));
            $insert = $this->curl->simple_post($this->API.'/manajemen/orderDetail', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('manajemen');
            }else
            {
                echo "gagal";
            }
            
              
        }else{
            $params1 = array('id_order'=> $this->uri->segment(3));
            $id = json_decode($this->curl->simple_get($this->API.'/manajemen/cekGrup',$params1));
            foreach ($id as $key) {
                 $data['id']  = $key->id_order;
                 $parameter2 = array('id_grup' =>  $key->id_grup);
             } 
            
            $lihat = json_decode($this->curl->simple_get($this->API.'/manajemen/grup',$params1));
            $params = array('id_proyek'=>$lihat[0]->id_proyek);
            $data['grup'] = json_decode($this->curl->simple_get($this->API.'/grup/grup',$params));
            if(!empty($parameter2)){
                 $data['tukang'] = json_decode($this->curl->simple_get($this->API.'/grup/cari',$parameter2));
            }
            $this->load->view('admin/detail_order',$data);
        }
    }


    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id_gaji' => $this->input->post('id_proyek'),
                'id_proyek' => $this->input->post('id_proyek'),
                'gaji' => $this->input->post('gaji'));
            $update = $this->curl->simple_put($this->API.'/gaji', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('gaji');
        }else{
            $params = array('id_gaji'=> $this->uri->segment(3));
            $data['gaji'] = json_decode($this->curl->simple_get($this->API.'/gaji',$params));
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('Admin/edit_gaji',$data);
        }
    }

    function terima($id_order){
            $data = array(
                'id_order' => $id_order,
                'status' => "terima"
            );
            $update = $this->curl->simple_put($this->API.'/manajemen/terima', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                 redirect('index.php/manajemen');
            }else{
                echo "gagal";
            }          
    }

    function delete($id){
        if(empty($id)){
            redirect('manajemen');
        }else{
            $delete = $this->curl->simple_delete($this->API.'/manajemen', array('id_order'=>$id),
            array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else{
                echo "gagal";
            }
            redirect('manajemen');
        }
    }   
}

