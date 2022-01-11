<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends G_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        // $data = $this->gmsfunc->getInfoDaerah();
        $this->load->view('login');
        // $this->load->view('login');
    }

    public function doLogin() {
        // $this->hanyaAjax();
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $users = $this->db->from('m_user')->where('username', $user)->get();
        if ($users->num_rows() > 0) {
            $cek = $this->db->from('m_user')->where(['username' => $user, 'password' => $pass])->get();
            if ($cek->num_rows() > 0) {
                $log = $cek->row();
                $data = new stdClass();
                $data->type = $log->type;
                $data->username = $user;
                $data->iduser = $log->id;
                $data->nama = $log->nama;
                $this->setSession($data);

                // $this->log_lgn('lgn');
                $echo = array('ind' => 1, 'msg' => 'Login Berhasil');
            } else {
                $echo = array('ind' => 0, 'msg' => 'Username dan Password tidak Cocok');
            }
        } else {
            $echo = array('ind' => 0, 'msg' => 'Username tidak ditemukan.');
        }
        $this->output->set_header('Content-type:Application/json');
        echo json_encode($echo);
    }

    // level : 0 : admin, 1 : sub admin, 2 : kasir
    private function setSession($data) {
        $datasession = array(
            'userid' => $data->iduser,
            'username' => $data->username,
            'nama' => $data->nama,
            'type' => $data->type
        );
        $this->session->set_userdata($datasession);
    }

    // function isStillLogin() {
    //     if ($this->session->has_userdata('skp_user')) {
    //         echo 'in';
    //     } else {
    //         $this->log_lgn('lgt');
    //         echo 'out';
    //     }
    // }

    function logout() {
        // $this->log_lgn('lgt');
        session_destroy();
        // redirect('auth', 'refresh');
        echo json_encode(['sts' => 1, 'msg' => 'Anda Berhasil Logout']);
    }

    function cekOldpass($str) {
        $id = $this->session->userdata('spg_userid');
        if ($this->session->userdata('spg_type') == 2) {
            $d = $this->gData->get_data('spg_pegawai', array('peg_id' => $id), '', FALSE)
                            ->select('peg_password', 'pass')->get()->row();
        } else {
            $d = $this->gData->get_data('spg_asdf', array('as_user_id' => $id), '', FALSE)
                            ->select('as_password', 'pass')->get()->row();
        }
        if ($d->pass == $str) {
            return TRUE;
        } else {
            $this->form_validation->set_message('cekOldpass', '<strong>{field}</strong> yang diinputkan salah.');
            return FALSE;
        }
    }

}
