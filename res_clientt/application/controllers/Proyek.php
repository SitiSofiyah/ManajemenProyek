<?php
class Proyek extends CI_Controller { 
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
        $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
        $this->load->view('admin/view_proyek',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
            'jenis_proyek' => $this->input->post('jenis_proyek'),
            'jumlah_tukang' => $this->input->post('jumlah_tukang'),
            'waktu_pengerjaan'=> $this->input->post('waktu_pengerjaan'));
            $insert = $this->curl->simple_post($this->API.'/proyek', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('proyek');
            }else
            {
                echo "gagal";
            }        
        }else{
            $this->load->view('admin/input_proyek');
        }
    }

    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id_proyek' => $this->input->post('id_proyek'),
                'jenis_proyek' => $this->input->post('jenis_proyek'),
                'jumlah_tukang' => $this->input->post('jumlah_tukang'),
                'waktu_pengerjaan'=> $this->input->post('waktu_pengerjaan'));
            $update = $this->curl->simple_put($this->API.'/proyek', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('proyek');
        }else{
            $params = array('id_proyek'=> $this->uri->segment(3));
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/proyek',$params));
            $this->load->view('Admin/edit_proyek',$data);
        }
    }

    function delete($id_proyek){
        if(empty($id_proyek)){
            redirect('proyek');
        }else{
            $delete = $this->curl->simple_delete($this->API.'/proyek', array('id_proyek'=>$id_proyek),
            array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else{
                echo "gagal";
            }
            redirect('proyek');
        }
    } 
}

