<?php
class Pembayaran extends G_Controller {

   public function index() {
      $data['url_controller'] = $this->url_controller;

      $content = $this->load->view("page/p_pembayaran", $data, TRUE);
      $this->template_argon->generate($content, ['datatable']);
   }

   public function search() {
      $keyword = $this->input->post('keyword', true);
      $data['url_controller'] = $this->url_controller;
      $data['keyword'] = $keyword;

      $content = $this->load->view("page/p_pembayaran_detail", $data, TRUE);
      $this->template_argon->generate($content, ['datatable']);
   }

   public function delete() {
      $id = $this->input->post('id', true);
      $this->load->model('Master_m');
      $this->Master_m->delete_data("m_transaction_detail", [
         'transaction_id' => $id
      ]);
      $this->Master_m->delete_data("m_transaction", [
         'id' => $id
      ]);

      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'http://localhost:8000/api/kasir/delete',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'DELETE',
         CURLOPT_POSTFIELDS => 'id='. $id,
         CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer PgL7YDNDJXeqvaEVzUHYWtBAW3yTUHWZvUSaJALpl51ItLlipFzPeVO8byEKCCC0',
            'Content-Type: application/x-www-form-urlencoded'
         ),
      ));
      curl_exec($curl);
      curl_close($curl);

      echo json_encode([
         'status' => true,
         'message' => [
            'head' => "Berhasil",
            'body' => "Hapus Transaksi"
         ]
      ]);
   }

   public function update($id) {
      $data['url_controller'] = $this->url_controller;

      $this->load->model('Master_m');
      $data['data'] = $this->Master_m->get("m_transaction", [
         'id' => $id
      ])[0];
      $data['pembayaran'] = $this->Master_m->get("m_jenis_pembayaran");
      $content = $this->load->view("page/p_update_pembayaran", $data, TRUE);
      $this->template_argon->generate($content);
   }

   public function bayar($id) {
      $this->load->model('Master_m');
      $this->Master_m->update("m_transaction", [
         'pay' => $this->input->post('pay', true),
         'status' => 'lunas',
         'method_id' => $this->input->post('method_id', true)
      ], [
         'id' => $id
      ]);

      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'http://localhost:8000/api/kasir/update/'.$id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS => 'pay='.$this->input->post('pay', true).'&status=lunas&method_id='.$this->input->post('method_id', true),
         CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer PgL7YDNDJXeqvaEVzUHYWtBAW3yTUHWZvUSaJALpl51ItLlipFzPeVO8byEKCCC0',
            'Content-Type: application/x-www-form-urlencoded'
         ),
      ));

      curl_exec($curl);
      curl_close($curl);

      redirect(base_url('pembayaran'));
   }
}