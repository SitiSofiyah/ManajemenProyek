<?php
class Tukang extends CI_Controller { 
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
        $data['tukang'] = json_decode($this->curl->simple_get($this->API.'/Tukang'));
        $this->load->view('Admin/view_tukang',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
            'nama_tukang' => $this->input->post('nama_tukang'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat'=> $this->input->post('alamat'));
            $insert = $this->curl->simple_post($this->API.'/tukang', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('index.php/tukang');
            }else
            {
                echo "gagal";
            }         
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('admin/input_tukang',$data);
        }
    }

    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id_tukang' => $this->input->post('id_tukang'),
                'nama_tukang' => $this->input->post('nama_tukang'),
                'alamat' => $this->input->post('alamat'),
                'no_telp'=> $this->input->post('no_telp'));
            $update = $this->curl->simple_put($this->API.'/tukang', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('tukang');
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $params = array('id_tukang'=> $this->uri->segment(3));
            $data['tukang'] = json_decode($this->curl->simple_get($this->API.'/Tukang',$params));
            $this->load->view('Admin/edit_tukang',$data);
        }
    }

    function delete($id_tukang){
        if(empty($id_tukang)){
            redirect('tukang');
        }else{
            $delete = $this->curl->simple_delete($this->API.'/tukang', array('id_tukang'=>$id_tukang),
            array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else{
                echo "gagal";
            }
            redirect('tukang');
        }
    } 
}

