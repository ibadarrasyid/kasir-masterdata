<?php

class G_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->session_cek();
    }

    function input_error() {
        $json['sts'] = 0;
        $json['msg'] = "<div class='alert alert-warning error_validasi'>" . validation_errors() . "</div>";
        echo json_encode($json);
        exit();
    }

    function pesan_error($pesan = "Terjadi kesalahan, coba lagi !") {
        $json['sts'] = 0;
        $json['msg'] = $pesan;
        echo json_encode($json);
        exit();
    }

    function pesan_akses($option) {
        if (!$this->priv_user($option)) {
            $this->pesan_error('Maaf anda tidak memiliki hak akses untuk menambah data');
        }
    }

    function echo_feedback($pesan) {
        $json['sts'] = 0;
        $json['msg'] = $pesan;
        if (is_array($pesan)) {
            $json = $pesan;
        }
        echo json_encode($json);
        exit();
    }

    function tdk_sama($str, $val) {
        if ($str == $val) {
            $this->form_validation->set_message('tdk_sama', "<strong>{field}</strong> harus ditentukan terlebih dahulu.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function set_formMsg($arrMsg = array()) {
        $default = array(
            'required' => '<strong>{field}</strong> wajib diisi. <strong>Tidak Boleh Kosong</strong>.',
            'greater_than' => '<strong>{field}</strong> harus ditentukan terlebih dahulu.',
            'max_length' => 'Maksimal karakter yang diperbolehkan untuk kolom <strong>{field}</strong> sebesar {param} karakter.',
            'is_unique' => '<strong>{field}</strong> tidak boleh sama, karena sudah digunakan.'
        );
        $setArr = array_merge($default, $arrMsg);
        foreach ($setArr as $key => $msg) {
            $this->form_validation->set_message($key, $msg);
        }
    }

    function hanyaAjax() {
        if (!$this->input->is_ajax_request()) {
            show_error('No Direct Script Access Allowed');
        }
    }

    // function session_cek() {
    //     $controller = $this->router->fetch_class();
    //     $method = $this->router->fetch_method();
    //     if (strtolower($controller) == 'login') {
    //         $pageAfterLogin = $this->session->userdata('tsk_type') == 2 ? base_url('profil') : base_url('dashboard');
    //         $aksesAllUser = array('logout', 'modalprofil_', 'saveprofil_');
    //         if ($this->session->has_userdata('tsk_userid') && !in_array($method, $aksesAllUser)) {
    //             $uri = ($this->session->has_userdata('tsk_reload_uri')) ? $this->session->userdata('tsk_reload_uri') :
    //                     $pageAfterLogin;
    //             $this->session->unset_userdata('tsk_reload_uri');
    //             redirect($uri);
    //         }
    //     } else {
    //         if (!$this->session->has_userdata('tsk_userid')) {
    //             $this->session->set_userdata('tsk_reload_uri', $this->uri->uri_string());
    //             redirect(base_url());
    //         }
    //         if ($this->session->userdata('tsk_type') != 2) {
    //             $usr = $this->gData->get_data('tsk_asdf', array('as_user_id' => $this->session->userdata('tsk_userid')))->row();
    //             $this->session->set_userdata('tsk_hak', $usr->as_privilages);
    //         }
    //         $menuAdmin = json_decode($this->session->userdata('tsk_menu'), TRUE);
    //         $isMethodAllAccess = $this->gmsfunc->endsWith($method, '_all'); 
    //         if ((!in_array(strtolower($controller), $menuAdmin) AND $this->session->userdata('tsk_type') > 0 && !$isMethodAllAccess)) {
    //             show_error("Anda dilarang mengakses alamat ini. <a href='" . base_url() . "'>Home</a>", 403, "Forbidden Page Access");
    //         }
    //     }
    // }

    function clean_tag_input($str) {
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        $t = trim($t);
        return $t;
    }

    /**
     * 
     * @param String $option 'cd' = Create Delete , 'edt' = Edit
     * @return boolean
     */
    function priv_user($option) {
        $hak = $this->session->userdata('spg_hak');
        if ($this->session->userdata('spg_type') == 0) {
            return TRUE;
        }
        $return = FALSE;
        switch ($option) {
            case 'cd': // create delete
                $return = ($hak == 1 || $hak == 3);
                break;
            case 'edt': // edt
                $return = ($hak == 2 || $hak == 3);
                break;
        }
        return $return;
    }

    /**
     * Konversi tanggal insert db
     * @param type $tanggal format d-m-Y
     */
    function convtanggal($tanggal) {
        if ($tanggal == '') {
            return NULL;
        } else {
            return date('Y-m-d', strtotime($tanggal));
        }
    }

    /**
     * Menyimpan log aktivitas user
     * @param String $option 'add','edt','del'. JIka diisi selain itu 3 option tersebut 
     * maka dianggap sebagai keterangan / aktivitas. Ex : Mengurutkan data
     * @param boolean $pagePns Default FALSE, Set TRUE jika fungsi untuk page PNS
     * @param String $setModul Default '', Berarti mengambil nama controller dari kelas router sebagai modul, 
     * @param array $column Nama kolom field data yg ada perubahan. use log_setkolom function
     * Jika diisi maka set Modul ke Nilai yang diberikan
     */
    function log($option, $column = array(), $pagePns = FALSE, $setModul = '') {
        $aksi = ($option == 'add' ? '<b class="text-success">Menambah</b>' :
                        ($option == 'edt' ? '<b class="text-warning">Merubah</b>' :
                                ($option == 'del' ? '<b class="text-danger">Menghapus</b>' :
                                        '<b class="text-info">' . $option . '</b>')));
        $modul = ($setModul == '') ? $this->router->fetch_class() : $setModul;
        $nip = $suffix = $kolom = '';
        if ($this->session->userdata('spg_type') == 2) {
            $data['lga_nip'] = $this->session->userdata('spg_nip');
            $nip = '(' . $this->session->userdata('spg_nip') . ') ';
        }
        if ($this->session->userdata('spg_type') < 2 && $pagePns) {
            // $nipsearch = $this->getSearchPns();
            // $suffix = ' ' . ucwords(strtolower($nipsearch['nav_nama'])) . ' (' . $nipsearch['nav_nip'] . ')';
        }

        if (count($column) > 0) {
            $column_ = array_filter($column);
            $kolom = '(' . implode(',', $column_) . ')';
        }

        $data['lga_timestamp'] = date('Y-m-d h:i:s');
        $data['lga_username'] = $this->session->userdata('spg_username');
        $data['lga_id'] = md5($data['lga_username'] . $data['lga_timestamp']);
        $data['lga_aksi'] = $this->session->userdata('spg_username') . ' ' . $nip . '' . $aksi . ' ' . $modul . ' ' . $kolom . $suffix;
        $this->gData->save_data('spg_logaktivitas', $data);
    }

    function log_setkolom($label = array(), $old_value = array(), $new_value = array()) {

        $diff = array_diff($old_value, $new_value);

        foreach ($diff as $key => $value) {
            $diff[$key] = $label[$key];
        }

        return $diff;
    }

    /**
     * Menyimpan log login user
     * @param String $option 'lgn' or 'lgt'
     */
    function log_lgn($option) {
        $aksi = ($option == 'lgn' ? '<b class="text-success">Login</b>' :
                        '<b class="text-danger">Logout</b>' );
        if ($this->session->userdata('spg_type') == 2) {
            $data['log_nip'] = $this->session->userdata('spg_nip');
        }
        $data['log_timestamp'] = date('Y-m-d h:i:s');
        $data['log_username'] = $this->session->userdata('spg_username');
        $data['log_id'] = md5($data['log_username'] . $data['log_timestamp']);
        $data['log_aksi'] = $aksi;
        $this->gData->save_data('spg_loglogin', $data);
    }

}
