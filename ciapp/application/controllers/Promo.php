<?php
class Promo extends G_Controller {

    var $url_controller;
    var $table_use = 'm_promo';
    var $modal_form = 'defaultModal';

    public function __construct() {
        parent::__construct();

        $this->url_controller = base_url('promo');

        $this->load->model('M_promo', 'm');
        $this->load->helper('promo_division');
    }

    public function index() {
        $data['url_controller'] = $this->url_controller;
        $data['modal_form'] = $this->modal_form;

        $content = $this->load->view("page/p_promo", $data, TRUE);
        $this->template_argon->generate($content, ['datatable', 'mask-money', 'datepicker']);
    }

    public function table() {
        $iTotalRecords = $this->m->table(false)->num_rows();
    
        $iDisplayLength = intval($_REQUEST["length"]);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST["start"]);
        $sEcho = intval($_REQUEST["draw"]);
        $end = $iDisplayStart + $iDisplayLength;
        $end = $iTotalRecords < $end ? $iTotalRecords : $end;
        $datatable = $this->m->table(true)->result_array();
        $i = $iDisplayStart + 1;
    
        $records = [];
        $records["data"] = [];
        foreach ($datatable as $val) {
            $no = $i++;

            $badge_class = 'success';
            $badge_content = 'Aktif';
            if ($val["status"] == 'no') {
                $badge_class = 'danger';
                $badge_content = 'Tidak Aktif';
            }
            
            $records["data"][] = array(
                $no, 
                $val["nama"],  
                $val["kode"], 
                $val["diskon"].' %', 
                rupiah_format($val["diskon_maks"]), 
                date('d / m / Y', strtotime($val["expired"])),
                '<span class="badge badge-pill badge-'.$badge_class.'">'.$badge_content.'</span>',
                '<button type="button" class="btn btn-primary btn-sm ubahmodal" datanya="' . $val["id"] . '" urlnya="' . $this->url_controller.'/form' . '" target="#loadform" data-toggle="modal" data-target="#'.$this->modal_form.'">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm hapusdata" datanya="' . $val["id"] . '" urlnya="' . $this->url_controller.'/aksi_hapuskelas' . '">
                    <i class="fas fa-trash"></i>
                </button>'
            );
        }
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function form() {
        $id = $this->input->post("id");
        $data['url_controller'] = $this->url_controller;
        if (!empty($id)) {
            $data_customer = $this->m->get_data($id);

            $data["data"] = $data_customer;
        }
        $this->load->view("form/f_promo", $data);
    }

    public function save() {
        header("Content-Type: application/json");

        if ($this->input->post('kode') != $this->input->post('kode_old')) {
            $is_unique_kode =  '|is_unique['.$this->table_use.'.kode]';
        } else {
            $is_unique_kode =  '';
        }

        $arr_return = [];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required'.$is_unique_kode);
        $this->form_validation->set_rules('diskon', 'Diskon', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('diskon_maks', 'Diskon Maks', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('expired', 'Tanggal Expired', 'trim|required');
        $this->form_validation->set_rules('id_division[]', 'Pilih Divisi', 'required');
        $this->set_formMsg();
        if ($this->form_validation->run() == false) {
            $err = $this->form_validation->error_array();
            $arr['sts'] = 2;
            $arr['msg'] = reset($err);
            echo json_encode($arr);
            exit();
        }

        $status = $this->input->post('status');
        $data = [
            'nama' => $this->input->post('nama'),
            'kode' => $this->input->post('kode'),
            'diskon' => $this->input->post('diskon'),
            'diskon_maks' => $this->input->post('diskon_maks'),
            'expired' => date_save_db($this->input->post('expired')),
            'status' => isset($status) ? 'yes' : 'no'
        ];

        $id = $this->input->post("id");
        if (!empty($id)) {
            $q_sql = $this->m->update($id, $data);

            $arr_return['msg'] = 'Berhasil Mengubah Data';
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');

            $q_sql = $this->m->save($data);
            $id = $this->db->insert_id();

            $arr_return['msg'] = 'Berhasil Menambah Data';
        }

        if ($q_sql) {
            $data_division = $this->input->post('id_division');
            save_divison_promo($id, $data_division);

            $arr_return['sts'] = 1;
        } else {
            $arr_return['sts'] = 0;
            $arr_return['msg'] = 'Terjadi Kesahalan Ketika Menyimpan pada DB';
        }

        echo json_encode($arr_return);
    }

    public function delete() {
        $arr_return = [];

        $id = $_POST['id'];

        $this->m->delete_promo_division($id);

        $q_sql = $this->m->delete($id);
        if ($q_sql) {
            $arr_return['sts'] = 1;
            $arr_return['msg'] = 'Berhasil Menghapus Data';
        } else {
            $arr_return['sts'] = 0;
            $arr_return['msg'] = 'Terjadi Kesahalan Ketika Menghapus pada DB';
        }

        echo json_encode($arr_return);
    }
}