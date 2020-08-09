<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->model('Payment_model');
        $this->load->model('Settings_model');
        $this->load->library('cart');
    }

    public function index(){
        $data['title'] = 'Pembayaran - ' . $this->config->item('app_name');
        $data['css'] = 'payment';
        $data['provinces'] = $this->Payment_model->getProvinces();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('page/payment', $data);
        $this->load->view('templates/footerv2');
    }

    public function getLocation(){
        $id = $this->input->post('id');
        $getLocation = $this->Payment_model->getCity($id);
        $list = "";
        foreach($getLocation as $d){
            $list .= "<option value='".$d['city_id']."'>".$d['type'].' '.$d['city_name']."";
        }
        echo json_encode($list);
    }

    public function getService(){
        $courier = $this->input->post('courier');
        $service = $this->Payment_model->getService();
        $list = "";
        $cost = "";
        foreach($service as $s){
            $list .= '<option value="'.$s['cost'][0]['value']."-".$s['service'].'">'.strtoupper($courier)." ".$s['description']." (".$s['service'].")".'</option>';
        };
        echo json_encode(['list' => $list]);
    }

    public function succesfully(){
        if($this->input->post('label') == ""){
            redirect(base_url());
        }
        $suc = $this->Payment_model->succesfully();
        $rek = $this->db->get('rekening');
        $data['title'] = 'Berhasil - ' . $this->config->item('app_name');
        $data['css'] = '';
        $data['invoice_id'] = $suc;
        $data['rekening'] = $rek;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('page/succesfully', $data);
        $this->load->view('templates/footer_notmpl');
    }

}
