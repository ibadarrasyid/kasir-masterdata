<?php
class M_transaction extends CI_Model {
   var $table_use = 'm_transaction';

   public function __construct() {
      parent::__construct();
   }

   public function table($paging) {
      $key = $_REQUEST["search"]["value"];

      $this->db->select($this->table_use . ".*, m_customer.nama customer_name");
      $this->db->from($this->table_use);
      $this->db->join('m_customer', $this->table_use . '.customer_id = m_customer.id', 'left');
      if (!empty($key)) {
         $this->db->where("nama LIKE %" . strtoupper($key) . "%");
      }
      if ($paging == true) {
         $this->db->limit($_REQUEST["length"], $_REQUEST["start"]);
      }
      return $this->db->get();
  }
}