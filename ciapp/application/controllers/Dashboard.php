<?php

class Dashboard extends G_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('Dashboardmdl');
    }

    public function index() {
        // $header = $this->gmsfunc->headerData('Dashboard');
        $this->load->view('layout/header');
        $this->load->view('layout/navi');
        $this->load->view('page/dashboard');
        $this->load->view('layout/footer');
    }

}
