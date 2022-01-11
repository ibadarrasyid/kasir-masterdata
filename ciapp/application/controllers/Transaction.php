<?php
class Transaction extends G_Controller {
   var $url_controller;
   var $table_use = 'm_transaction';
   var $modal_form = 'defaultModal';

   public function __construct() {
      parent::__construct();

      $this->url_controller = base_url('transaction');

      $this->load->model('M_transaction', 'm');
      $this->load->helper('division_customer_type');
   }

   public function index() {
      $data['url_controller'] = $this->url_controller;

      $content = $this->load->view("page/p_transaction", $data, TRUE);
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

         $badge_class = 'success';
         $badge_content = 'Aktif';
         if ($val["status"] == 'pending') {
            $badge_class = 'danger';
            $badge_content = 'Pending';
         } else if($val["status"] == 'belum lunas') {
            $badge_class = 'warning';
            $badge_content = 'Belum Lunas';
         } else if($val["status"] == 'lunas') {
            $badge_class = 'success';
            $badge_content = 'Lunas';
         }
         
         $records["data"][] = array(
               $no, 
               $val["id"],
               $val["customer_name"],
               rupiah_format($val["price"]),
               date("d F Y", strtotime($val["date"])),
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
      $this->load->model('M_customer');
      $data["customer"] = $this->M_customer->get_data();
      if (!empty($id)) {
         $data_category = $this->m->get_data($id);
         $data["data"] = $data_category;
      }
      echo $this->load->view("form/f_transaction", $data, true);
   }

   public function save() {
      header("Content-Type: application/json");
      $this->load->model('M_customer');

      $arr_return = [];
      // New Customer
      if($this->input->post("type_transaction") == "new_customer") {
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

         $is_update = FALSE;

         $q_sql = $this->M_customer->save($data);
         $id = $this->db->insert_id();
         $customer = $this->M_customer->get_data($id);
         $this->session->set_userdata('customer', serialize($customer));

         $arr_return['msg'] = 'Berhasil menyimpan pelanggan baru';

         if ($q_sql) {
            $data_customer_type = $this->input->post('customer_type');
            $data_division = $this->input->post('division');
            save_customer_type_divison($id, $data_customer_type, $data_division, $is_update);

            $arr_return['sts'] = 1;
         } else {
            $arr_return['sts'] = 0;
            $arr_return['msg'] = 'Terjadi Kesahalan Ketika Menyimpan pada DB';
         }

         $arr_return['redirect'] = base_url('transaction/cart');

         echo json_encode($arr_return);
      } 
      // Old Customer
      else {
         $customer = $this->M_customer->get_data($this->input->post("customer_id"));
         if(!$customer) {
            $arr['sts'] = 2;
            $arr['msg'] = "Pelanggan Tidak ada";
            echo json_encode($arr);
            exit();
         }

         $this->session->set_userdata('customer', serialize($customer));
         $arr_return['sts'] = 1;
         $arr_return['msg'] = 'Berhasil memilih pelanggan';
         $arr_return['redirect'] = base_url('transaction/cart');
         echo json_encode($arr_return);
      }
   }

   public function cart() {
      $this->load->model("M_division");
      $this->load->model("M_bahan_finishing");
      $this->load->model("M_design");
      $customer = unserialize($this->session->customer);
      
      $data['url_controller'] = $this->url_controller;
      $data['customer'] = $customer;
      $data['division'] = $this->M_division->get_data();
      $data['finishing'] = $this->M_bahan_finishing->get_data();
      $data['design'] = $this->M_design->get_data();

      $content = $this->load->view("page/p_transaction_cart", $data, TRUE);
      $this->template_argon->generate($content);
   }

   public function save_transaction() {
      header("Content-Type: application/json");
      $input = $this->input->post(null, true);
      $arr = [];
      $dataFix = [];
      $insertId = [];
      $this->db->order_by('id', "DESC");
      $last_id = $this->db->get('m_transaction')->row();
      $last_id ? $last_id->id : $last_id = 1;
      foreach ($input['form'] as $key => $value) {
         $temp = [];
         parse_str($value, $temp);
         $arr[] = $temp;
      }

      // $this->load->library('form_validation');
      // $this->form_validation->set_rules('priority', 'Prioritas', 'trim|required');
      // $this->form_validation->set_rules('customer', 'Pelanggan', 'trim|required|numeric');
      // $this->form_validation->set_rules('division_id', 'Divisi', 'trim|required|numeric');
      // $this->form_validation->set_rules('category_id', 'Kategori', 'trim|required|numeric');
      // $this->form_validation->set_rules('bahan_id', 'Bahan', 'trim|required|numeric');
      // $this->form_validation->set_rules('finishing', 'Finishing', 'numeric');
      // $this->form_validation->set_rules('design_id', 'Desain', 'numeric');
      // $this->form_validation->set_rules('property-qty', 'Jumlah', 'required|numeric');
      // $this->form_validation->set_rules('file', 'Nama File', 'required');
      // if ($this->form_validation->run() == false) {
      //    $err = $this->form_validation->error_array();
      //    $arr['sts'] = 2;
      //    $arr['msg'] = reset($err);
      //    echo json_encode($arr);
      //    exit();
      // }

      $this->db->trans_start();
      $this->load->model('Master_m');
      $this->Master_m->save_data("m_transaction", [
         'customer_id' => $arr[0]['customer'],
         'no_trx' => "TSG".date('Ymd').$last_id,
         'sub_total' => 0,
         'status' => 'pending'
      ]);
      $subTotal = 0;
      $insertIdTransaction = $this->db->insert_id();
      foreach ($arr as $key => $rawData) {
         $category = $this->Master_m->get("m_category", ['id' => $rawData['category_id']])[0];
         $propertyCategory = json_decode($category['property']);
         $propertyInput = [];
         foreach ($propertyCategory as $value) {
            if($value == 'qty') continue;
            $propertyInput[$value] = $rawData['property-' . $value];
         }

         $price = $this->get_price($rawData);
   
         $this->Master_m->save_data("m_transaction_detail", [
            'transaction_id' => $insertIdTransaction,
            'division_id' => $rawData['division_id'],
            'category_id' => $rawData['category_id'],
            'bahan_id' => $rawData['bahan'],
            'finishing_id' => $rawData['finishing_id'],
            'design_id' => $rawData['design_id'],
            'priority' => $rawData['priority'],
            'property' => json_encode($propertyInput),
            'qty' => $rawData['property-qty'],
            'file' => $rawData['file'],
            'price' => $price,
         ]);
         $subTotal += $price;

         $insertId[] = $this->db->insert_id();
      }

      $this->Master_m->update("m_transaction", ['sub_total' => $subTotal], ['id' => $insertIdTransaction]);
      
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
         $arr_return['sts'] = 2;
         $arr_return['msg'] = 'Gagal Menambah Transaksi';
         $this->db->trans_rollback();
         echo json_encode($arr_return);
         exit();
      } else {
         $this->db->trans_commit();
         foreach ($insertId as $key => $value) {
            $transaction = $this->Master_m->get("m_transaction_detail", ['id' => $value])[0];
            // $customer = $this->Master_m->get("m_customer", ['id' => $transaction['customer_id']])[0];
            $division = $this->Master_m->get("m_division", ['id' => $transaction['division_id']])[0];
            $category = $this->Master_m->get("m_category", ['id' => $transaction['category_id']])[0];
            $bahan = $this->Master_m->get("m_bahan", ['id' => $transaction['bahan_id']])[0];
            $finishing = $design = [];
            if($transaction['finishing_id']) $finishing = $this->Master_m->get("m_bahan_finishing", ['id' => $transaction['finishing_id']])[0];
            if($transaction['design_id']) $design = $this->Master_m->get("m_design", ['id' => $transaction['design_id']])[0];
   
            // $transaction['customer'] = $customer;
            $transaction['category'] = $category;
            $transaction['division'] = $division;
            $transaction['bahan'] = $bahan;
            $transaction['finishing'] = $finishing;
            $transaction['design'] = $design;

            $dataFix[] = $transaction;
         }

         $m_transaction = $this->Master_m->get("m_transaction", ['id' => $insertIdTransaction])[0];
         $customer = $this->Master_m->get("m_customer", ['id' => $m_transaction['customer_id']])[0];
         $m_transaction['customer'] = $customer;
         $m_transaction['detail'] = $dataFix;

         $curl = curl_init();

         curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:8000/api/kasir',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS => http_build_query($transaction),
            CURLOPT_POSTFIELDS => json_encode([
               'data' => $m_transaction
            ]),
            CURLOPT_HTTPHEADER => array(
               'Authorization: Bearer PgL7YDNDJXeqvaEVzUHYWtBAW3yTUHWZvUSaJALpl51ItLlipFzPeVO8byEKCCC0',
               'Content-Type: application/json'
            ),
         ));

         curl_exec($curl);
         curl_close($curl);

         $arr_return['sts'] = 1;
         $arr_return['msg'] = 'Berhasil Menambah Transaksi';
         echo json_encode($arr_return);
         exit();
      }

   }

   public function get_price($data) {
      header("Content-Type: application/json");
      // $input = $this->input->post(null, true);

      // $this->load->library('form_validation');
      // $this->form_validation->set_rules('finishing', 'Finishing', 'numeric');
      // $this->form_validation->set_rules('design_id', 'Desain', 'numeric');
      // $this->form_validation->set_rules('property-qty', 'Jumlah', 'required|numeric');
      // if ($this->form_validation->run() == false) {
      //    $err = $this->form_validation->error_array();
      //    $arr['sts'] = 2;
      //    $arr['msg'] = reset($err);
      //    echo json_encode($arr);
      //    exit();
      // }

      $this->load->model('Master_m');
      $bahan = $this->Master_m->get("m_bahan", ['id' => $data['bahan']])[0];
      $bahanPotongan = $this->Master_m->get("m_bahan_potongan", ['id_bahan' => $data['bahan']]);
      $price = 0;
      $price += $bahan['harga'];
      if($data['finishing_id']) {
         $finishing = $this->Master_m->get("m_bahan_finishing", ['id' => $data['finishing_id']])[0];
         $total_finishing = $finishing['harga'] * $data['property-qty'];
         $price += $total_finishing;
      }
      if($data['design_id']) {
         $design = $this->Master_m->get("m_design", ['id' => $data['design_id']])[0];
         $price += $design['harga'];
      }

      $price *= $data['property-qty'];

      if(count($bahanPotongan) > 0) {
         foreach ($bahanPotongan as $value) {
            $batas_atas = false;
            if($value['batas_atas'] != null || $value['batas_atas'] != '') $batas_atas = $value['batas_atas'];
            if($data['property-qty'] >= $value['batas_bawah']) {
               if($batas_atas) {
                  if($data['property-qty'] < $batas_atas) {
                     $price -= $value['potongan_harga'];
                     break;
                  } else {
                     continue;
                  }
               } else {
                  $price -= $value['potongan_harga'];
               }
            }
         }
      }

      return $price;
   }
}