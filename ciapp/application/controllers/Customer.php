<?php

class Customer extends G_Controller {

    var $url_controller;
    var $table_use = 'm_customer';

    public function __construct() {
        parent::__construct();

        $this->url_controller = base_url('customer');

        $this->load->model('M_customer', 'm');
        $this->load->helper('division_customer_type');
    }

    public function index() {
        $data['url_controller'] = $this->url_controller;

        $content = $this->load->view("page/p_customer", $data, TRUE);
        $this->template_argon->generate($content, ['datatable']);
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
                $val["nama"],  
                $val["nohp"], 
                $val["nokartu"], 
                '<button type="button" class="btn btn-primary btn-sm ubahmodal" datanya="' . $val["id"] . '" urlnya="' . $this->url_controller.'/form' . '" target="#loadform" data-toggle="modal" data-target="#defaultModal">
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
        $this->load->view("form/f_customer", $data);
    }

    public function save() {
        header("Content-Type: application/json");

        if ($this->input->post('nohp') != $this->input->post('nohp_old')) {
            $is_unique_nohp =  '|is_unique[m_customer.nohp]';
        } else {
            $is_unique_nohp =  '';
        }

        if ($this->input->post('nokartu') != $this->input->post('nokartu_old')) {
            $is_unique_nokartu =  '|is_unique[m_customer.nokartu]';
        } else {
            $is_unique_nokartu =  '';
        }

        $arr_return = [];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nohp', 'No HP', 'trim|required'.$is_unique_nohp);
        $this->form_validation->set_rules('nokartu', 'No Kartu', 'trim|required'.$is_unique_nokartu);
        $this->form_validation->set_rules('id_limit_customer', 'Limit Customer', 'required');
        $this->set_formMsg();
        if ($this->form_validation->run() == false) {
            $err = $this->form_validation->error_array();
            $arr['sts'] = 2;
            $arr['msg'] = reset($err);
            echo json_encode($arr);
            exit();
        }

        $data = [
            'nama' => $this->input->post('nama'),
            'nohp' => $this->input->post('nohp'),
            'nokartu' => $this->input->post('nokartu'),
            'id_limit_customer' => $this->input->post('id_limit_customer')
        ];

        $id = $this->input->post("id");
        if (!empty($id)) {
            $is_update = TRUE;

            $q_sql = $this->m->update($id, $data);

            $arr_return['msg'] = 'Berhasil Mengubah Data';
        } else {
            $is_update = FALSE;

            $q_sql = $this->m->save($data);
            $id = $this->db->insert_id();

            $arr_return['msg'] = 'Berhasil Menambah Data';
        }

        if ($q_sql) {
            $data_customer_type = $this->input->post('customer_type');
            $data_division = $this->input->post('division');
            save_customer_type_divison($id, $data_customer_type, $data_division, $is_update);

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

        delete_customer_type_divison('customer', $id);

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
