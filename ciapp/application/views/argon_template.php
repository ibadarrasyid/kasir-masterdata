<?php

$data_header = array('css' => $css, 'js' => $js);
$this->load->view('argon/header', $data_header);
$this->load->view('argon/sidebar');
$data_content = array('main_content' => $content);
$this->load->view('argon/main', $data_content);
$this->load->view('argon/footer');

?>