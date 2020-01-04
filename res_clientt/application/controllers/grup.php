<?php
class grup extends CI_Controller { 
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
        $data['grup'] = json_decode($this->curl->simple_get($this->API.'/Grup'));
        $this->load->view('admin/view_grup',$data);
    }

    function create(){
        if(isset($_POST['submit'])){
            $data = array(
            'id_proyek' => $this->input->post('proyek'));
            $insert = $this->curl->simple_post($this->API.'/grup', $data,
                array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('grup');
            }else
            {
                echo "gagal";
            }
            
        }else{
            $data['proyek'] = json_decode($this->curl->simple_get($this->API.'/Proyek'));

            $this->load->view('admin/input_grup',$data);
        }
    }

    function add(){
        if(isset($_POST['submit'])){
            $data = array(
            'id_grup' => $this->input->post('id_grup'),
            'id_tukang' => $this->input->post('id_tukang'));
            $insert = $this->curl->simple_post($this->API.'/grup/add', $data,array(CURLOPT_BUFFERSIZE => 10));
            if($insert)
            {
                  redirect('grup/add/'.$this->input->post('id_grup'));
            }else
            {
                echo "gagal";
            }    
        }else{
            $params = array('id_grup'=> $this->uri->segment(3));
            $data['grup'] = json_decode($this->curl->simple_get($this->API.'/grup/cari',$params));
            $data['jml2'] = json_decode($this->curl->simple_get($this->API.'/grup/jml',$params));    
            $data['tukang'] = json_decode($this->curl->simple_get($this->API.'/grup/anggota'));
            $data['jml1'] = json_decode($this->curl->simple_get($this->API.'/grup/jmlTukang',$params));
             $this->load->view('admin/input_anggota',$data);
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

