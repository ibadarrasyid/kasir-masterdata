<?php

class Tes extends G_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('Dashboardmdl');
    }

    public function index() {
        // echo "tes";
        // $header = $this->gmsfunc->headerData('Dashboard');
        // $this->load->view('layout/header');
        // $this->load->view('layout/sidebar');
        // $this->load->view('layout/main');
        // // $this->load->view('page/dashboard');
        // $this->load->view('layout/footer');

        $content = $this->load->view("page/p_tes", ['tes' => 'Tes'], TRUE);
        $this->template_argon->generate($content);
    }

}
