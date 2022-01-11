<?php

class Limit_customer extends G_Controller {

    var $url_controller;
    // var $table_use = 'm_promo';
    var $modal_form = 'defaultModal';

    public function __construct() {
        parent::__construct();
        
        $this->url_controller = base_url('limit_customer');

        $this->load->model('LimitCustomerMdl', 'm');
    }

    public function index() {
        $data['url_controller'] = $this->url_controller;
        $data['modal_form'] = $this->modal_form;

        $content = $this->load->view("page/p_limit_customer", $data, TRUE);
        $this->template_argon->generate($content, ['datatable', 'mask-money']);
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
            
            $records["data"][] = array(
                $no, 
                rupiah_format($val["limit"]),  
                $val["tempo"].' Hari', 
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
        $data = [];
        if (!empty($id)) {
            $data_limit = $this->db->from('m_limit_customer')->where("id", $id)->get()->row_array();

            $data["data"] = $data_limit;
        }
        $this->load->view("form/f_limit_customer", $data);
    }

    public function save() {
        header("Content-Type: application/json");

        $arr_return = [];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('limit', 'Limit', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tempo', 'Jatuh Tempo (hari)', 'trim|required|numeric');
        $this->set_formMsg();
        if ($this->form_validation->run() == false) {
            $err = $this->form_validation->error_array();
            $arr['sts'] = 2;
            $arr['msg'] = reset($err);
            echo json_encode($arr);
            exit();
        }

        $data = [
            'limit' => $this->input->post('limit'),
            'tempo' => $this->input->post('tempo'),
        ];

        $id = $this->input->post("id");
        if (!empty($id)) {
            $q_sql = $this->m->update($id, $data);
            $arr_return['msg'] = 'Berhasil Mengubah Data';
        } else {
            $q_sql = $this->m->save($data);
            $arr_return['msg'] = 'Berhasil Menambah Data';
        }

        if ($q_sql) {
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
