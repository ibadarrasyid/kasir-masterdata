<?php

class M_bahan_finishing extends CI_Model {
    var $table_use = 'm_bahan_finishing';

    public function __construct() {
        parent::__construct();

        // date_default_timezone_set("Asia/Jakarta");
    }

    public function table($paging) {
        $key = $_REQUEST["search"]["value"];

        $this->db->select('bahan_finishing.*, category.nama AS nama_category, customer_type.nama AS nama_customer_type')
                    ->from($this->table_use.' bahan_finishing')
                    ->join('m_category category', 'category.id = bahan_finishing.id_category')
                    ->join('m_customer_type customer_type', 'customer_type.id = bahan_finishing.id_customer_type');
        if (!empty($key)) {
            $this->db->where("nama LIKE " . strtoupper($key) . "% OR category.nama LIKE " . strtoupper($key) . "% OR customer_type.nama LIKE " . strtoupper($key) . "%");
        }
        if ($paging == true) {
            $this->db->limit($_REQUEST["length"], $_REQUEST["start"]);
        }
        return $this->db->get();
    }

    public function get_data($id = null) {
        $this->db->from($this->table_use);
        if($id) return $this->db->where("id", $id)->get()->row_array();
        return $this->db->get()->result_array();
    }

    public function save($data) {
        $data['id'] = new_id_table($this->table_use, 'id');

        $q_save = $this->db->insert($this->table_use, $data);
        return $q_save;
    }

    public function update($id, $data) {
        $q_update = $this->db->set($data)->where('id', $id)->update($this->table_use);
        return $q_update;
    }

    public function delete($id) {
        $q_delete = $this->db->delete($this->table_use, array('id' => $id));
        return $q_delete;
    }

    public function delete_finishing_potongan($id) {
        $q_delete = $this->db->delete('m_bahan_finishing_potongan', array('id_finishing' => $id));
        return $q_delete;
    }

    // ==============================

    public function get_list_customer_type() {
        return $this->db->from('m_customer_type')->order_by('nama')->get()->result();
    }

    public function get_list_category() {
        return $this->db->select('id, nama')->from('m_category')->order_by('nama')->get()->result();
    }

    public function get_category_data($id, $column) {
        return $this->db->select($column)->from('m_category')->where('id', $id)->order_by('nama')->get()->row();
    }
}