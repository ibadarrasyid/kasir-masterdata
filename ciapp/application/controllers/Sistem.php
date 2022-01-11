<?php

class Sistem extends G_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Sistem_mdl');
    }

    public function index() { 
        $header = $this->gmsfunc->headerData('Sistem');
        $data = $this->gmsfunc->getInfoDaerah();
        $data['kotaoption'] = '';
        $data['skpda'] = $this->opt_opd($data['idskpd']);
        $arkot = array('PROVINSI', 'KOTA', 'KABUPATEN');
        foreach ($arkot as $ss) {
            $sel = ($ss == strtoupper($data['kota'])) ? 'selected' : '';
            $data['kotaoption'] .= "<option value='$ss' $sel>$ss</option>";
        }
        $this->load->view('layout/header', $header);
        $this->load->view('layout/navi');
        $this->load->view('page/sistem', $data);
        $this->load->view('layout/footer');
    }        
    
    function opt_opd($selected = '') {
        $this->load->model('Opdmdl');
        $this->load->helper('string');
        $data = $this->Opdmdl->li_opd();
        $opt = '<option value="0">- Pilih OPD -</option>';
        foreach ($data as $val) {
            $sel = ($selected == $val['id_opd']) ? 'selected' : '';
            $opt .= '<option data-nama="'.$val['nama_unitkerja'].'" value="' . $val['id_opd'] . '" '.$sel.'>' . str_repeat("&nbsp;",$val['base'] * 10) . $val['nama_unitkerja'] . '</option>';
        }
        return $opt;
    }
    
    function save_info() {        
        $this->hanyaAjax();
        $detail = $this->input->post('detail');
        $arr['ind'] = 0;
        if (!is_array($detail)) {
            $arr['msg'] = "Data yang diinputkan tidak valid.";
            echo json_encode($arr);
            exit();
        } else if (!strpos($detail['email'], '@') OR ! strpos($detail['email'], '.')) {
            $arr['msg'] = "Email yang diinputkan tidak valid.";
            echo json_encode($arr);
            exit();
        }
        $arr = $this->Sistem_mdl->saveDataAplikasi();
        echo json_encode($arr);
    }
    
}