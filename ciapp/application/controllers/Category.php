<?php
class Category extends G_Controller {

    var $url_controller;
    var $table_use = 'm_category';
    var $modal_form = 'defaultModal';

    public function __construct() {
        parent::__construct();

        $this->url_controller = base_url('category');

        $this->load->model('M_category', 'm');
    }

    public function index() {
        $data['url_controller'] = $this->url_controller;
        $data['modal_form'] = $this->modal_form;

        $content = $this->load->view("page/p_category", $data, TRUE);
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

            $arr_property = json_decode($val["property"], TRUE);
            
            $records["data"][] = array(
                $no, 
                $val["nama"],  
                implode(', ', $arr_property), 
                $val["nama_divisi"], 
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
            $data_category = $this->m->get_data($id);
            $validation = json_decode($data_category['validation'], true);
            $data['validation'] = implode('|', $validation) . "|";
            $data['validation_arr'] = $validation;
            $data["data"] = $data_category;
        }
        // var_dump($validation);
        $this->load->view("form/f_category", $data);
    }

    public function save() {
        header("Content-Type: application/json");

        if ($this->input->post('nama') != $this->input->post('nama_old')) {
            $is_unique_nama =  '|is_unique['.$this->table_use.'.nama]';
        } else {
            $is_unique_nama =  '';
        }

        $arr_return = [];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required'.$is_unique_nama);
        $this->form_validation->set_rules('id_division', 'Divisi', 'required');
        $this->form_validation->set_rules('property[]', 'Property', 'strtolower');
        $this->form_validation->set_rules('validation', 'Validation', 'strtolower');
        $this->set_formMsg();
        if ($this->form_validation->run() == false) {
            $err = $this->form_validation->error_array();
            $arr['sts'] = 2;
            $arr['msg'] = reset($err);
            echo json_encode($arr);
            exit();
        }

        $arr_property = $this->input->post('property[]');
        $check_duplicate_property = array_unique($arr_property) == $arr_property;
        if (!$check_duplicate_property && (count($arr_property) > 1)) {
            $arr_return['sts'] = 2;
            $arr_return['msg'] = 'Terdapat Nama Property yang sama';
            echo json_encode($arr_return);
            exit();
        }

        $data = [
            'nama' => $this->input->post('nama'),
            'id_division' => $this->input->post('id_division'),
            // 'property' => json_encode($arr_property)
        ];

        $validation = $this->input->post('validation');
        if($validation != '' || $validation != '|') {
            $arrValidation = explode('|', $validation);
            $data['validation'] = json_encode(array_filter($arrValidation));
        } 
        
        if(count(json_decode($data['validation'])) <= 0) {
            $data['validation'] = json_encode(['qty']);
        }

        $hidden_property = [];
        $id = $this->input->post("id");
        if (!empty($id)) {
            $arr_property = $this->remove_arr($arr_property, 'qty');
            $arr_property = $this->remove_arr($arr_property, 'pcs');
            $arr_property = $this->remove_arr($arr_property, 'jumlah');
            $arr_property = $this->remove_arr($arr_property, 'total');
            $arr_property[] = 'qty';
            $arr_property = array_values($arr_property);
            $temp_hidden_property = $arr_property;
            $temp_hidden_property = $this->remove_arr($temp_hidden_property, 'qty');
            $temp_hidden_property = array_values($temp_hidden_property);
            foreach ($temp_hidden_property as $key => $value) {
                $hidden_property[] = $value . '_min';
            }
            $data['property'] = json_encode($arr_property);
            $data['hidden_property'] = json_encode($hidden_property);
            $data['satuan'] = json_encode($this->input->post('satuan[]'));
            $q_sql = $this->m->update($id, $data);

            $arr_return['msg'] = 'Berhasil Mengubah Data';
        } else {
            $arr_property[] = 'qty';
            $arr_property = $this->remove_arr($arr_property, 'pcs');
            $arr_property = $this->remove_arr($arr_property, 'jumlah');
            $arr_property = $this->remove_arr($arr_property, 'total');
            $temp_hidden_property = $arr_property;
            $temp_hidden_property = $this->remove_arr($temp_hidden_property, 'qty');
            $arr_property = array_values($arr_property);
            foreach ($temp_hidden_property as $key => $value) {
                $hidden_property[] = $value . '_min';
            }
            $data['property'] = json_encode($arr_property);
            $data['hidden_property'] = json_encode($hidden_property);
            $data['satuan'] = json_encode($this->input->post('satuan[]'));
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

    public function get_data() {
        header("Content-Type: application/json");
        $id = $this->input->post('category_id', true);
        $this->load->model('Master_m');
        $data = $this->Master_m->get("m_bahan", ['id_category' => $id]);
        echo json_encode([
            'status' => true,
            'data' => isset($data) ? $data : []
        ]);
    }

    public function remove_arr($arr, $keyword) {
        if (($key = array_search($keyword, $arr)) !== false) {
            unset($arr[$key]);
        }
        return $arr;
    }
}