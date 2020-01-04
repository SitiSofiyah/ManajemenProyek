<?php
class Gaji extends CI_Controller {
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
        $data['gaji'] = json_decode($this->curl->simple_get($this->API.'/Gaji'));
        $data['gt'] = json_decode($this->curl->simple_get($this->API.'/Gaji/detail'));
        $this->load->view('admin/view_gaji',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
            'gaji' => $this->input->post('gaji'));
            $insert = $this->curl->simple_post($this->API.'/gaji', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('index.php/gaji');
            }else
            {
                echo "gagal";
            }
            
              
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('admin/input_gaji',$data);
        }
    }


    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id_gaji' => $this->input->post('id_gaji'),
                'gaji' => $this->input->post('gaji'));
            $update = $this->curl->simple_put($this->API.'/gaji', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else{
                $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('index.php/gaji');
        }else{
            $params = array('id_gaji'=> $this->uri->segment(3));
            $data['gaji'] = json_decode($this->curl->simple_get($this->API.'/gaji',$params));
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));
            $this->load->view('Admin/edit_gaji',$data);
        }
    }



    function delete($id_gaji){
        if(empty($id_gaji)){
            redirect('gaji');
        }else{
            $delete = $this->curl->simple_delete($this->API.'/gaji', array('id_gaji'=>$id_gaji),
            array(CURLOPT_BUFFERSIZE => 10));
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else{
                echo "gagal";
            }
            redirect('gaji');
        }
    }

   
}

