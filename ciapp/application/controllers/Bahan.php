<?php
class Bahan extends G_Controller {

    var $url_controller;
    var $table_use = 'm_bahan';
    var $modal_form = 'defaultModal';

    public function __construct() {
        parent::__construct();

        $this->url_controller = base_url('bahan');

        $this->load->model('M_bahan', 'm');
    }

    public function index() {
        $data['url_controller'] = $this->url_controller;
        $data['modal_form'] = $this->modal_form;

        $content = $this->load->view("page/p_bahan", $data, TRUE);
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
                $val["nama"],  
                rupiah_format($val["harga"]), 
                output_property_value($val["property"]), 
                $val["nama_category"], 
                $val["nama_customer_type"], 
                '<button type="button" class="btn btn-primary btn-sm ubahmodal" datanya="' . $val["id"] . '" urlnya="' . $this->url_controller.'/form' . '" target="#loadform" data-toggle="modal" data-target="#'.$this->modal_form.'">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm hapusdata" datanya="' . $val["id"] . '" urlnya="' . $this->url_controller.'/aksi_hapuskelas' . '">
                    <i class="fas fa-trash"></i>
                </button>',
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
            $data_bahan = $this->m->get_data($id);

            $data["data"] = $data_bahan;
        }
        $this->load->view("form/f_bahan", $data);
    }

    public function get_category_property($id_category) {
        header("Content-Type: application/json");

        $category = $this->m->get_category_data($id_category, 'property');
        echo $category->property;
    }

    public function get_category_property_hidden($id_category) {
        header("Content-Type: application/json");

        $category = $this->m->get_category_data($id_category, 'hidden_property');
        echo $category->hidden_property;
    }

    public function save() {
        header("Content-Type: application/json");

        $arr_return = [];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('id_customer_type', 'Customer Type', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('id_category', 'Category', 'required');
        $this->form_validation->set_rules('formula', 'Rumus', 'trim|required');
        $this->set_formMsg();
        if ($this->form_validation->run() == false) {
            $err = $this->form_validation->error_array();
            $arr['sts'] = 2;
            $arr['msg'] = reset($err);
            echo json_encode($arr);
            exit();
        }

        $arr_property = [];
        $category_property_nama = $this->input->post('property_nama[]');
        $category_property_value = $this->input->post('property_value[]');
        foreach ($category_property_nama as $k_property_nama => $v_property_nama) {
            $arr_property[$v_property_nama] = $category_property_value[$k_property_nama];
        }

        $arr_property_hidden = [];
        $category_property_hidden_nama = $this->input->post('property_hidden_nama[]');
        $category_property_hidden_value = $this->input->post('property_hidden_value[]');
        foreach ($category_property_hidden_nama as $k_property_nama => $v_property_nama) {
            $arr_property_hidden[$v_property_nama] = $category_property_hidden_value[$k_property_nama];
        }

        $is_minimum = $this->input->post('is_minimum');
        $data = [
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga'),
            'id_customer_type' => $this->input->post('id_customer_type'),
            'id_category' => $this->input->post('id_category'),
            'property' => json_encode($arr_property),
            'hidden_property' => json_encode($arr_property_hidden),
            'is_minimum' => isset($is_minimum) ? 1 : 0,
            'formula' => $this->input->post('formula')
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
            $this->m->delete_bahan_potongan($id);

            $arr_return['sts'] = 1;
            $arr_return['msg'] = 'Berhasil Menghapus Data';
        } else {
            $arr_return['sts'] = 0;
            $arr_return['msg'] = 'Terjadi Kesahalan Ketika Menghapus pada DB';
        }

        echo json_encode($arr_return);
    }

    public function search_validation() {
        $this->load->model('Master_m');
        $input = $this->input->post(null, true);
        $category = $this->Master_m->get("m_category", [
            'id' => $input['category']
        ])[0];
        $arrValidate = json_decode($category['validation'], true);
        $bahan = $this->Master_m->get("m_bahan", [
            'id_category' => $input['category']
        ]);
        $bahanValidate = [];

        $inputProperty = [];
        foreach ($arrValidate as $value) {
            $inputProperty[$value] = $input['property-'. $value]; 
        }

        $tempBahan = [];
        foreach ($bahan as $key => $value) {
            $propertyBahan = json_decode($value['property'], true);
            if(isset($tempBahan)) $tempProperty = json_decode($tempBahan['property'], true);
            $status = true;
            $statusCompare = false;
            foreach ($arrValidate as $k => $v) {
                if($inputProperty[$v] > $propertyBahan[$v]) {
                    $status = false;
                }
                if(isset($tempProperty)) {
                    if($tempProperty[$v] <= $propertyBahan[$v]) {
                        $statusCompare = true;
                    } else $statusCompare = false;
                }
            }
            if($status) {
                $bahanValidate[] = $value;
            }
            if($key == 0) $tempBahan[0] = $value;
            if($statusCompare) $tempBahan[0] = $value;
        }
        echo json_encode(empty($bahanValidate) ? $tempBahan : $bahanValidate);
    }
}