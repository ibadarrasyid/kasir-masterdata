<?php

class M_promo extends CI_Model {
    var $table_use = 'm_promo';

    public function __construct() {
        parent::__construct();

        // date_default_timezone_set("Asia/Jakarta");
    }

    public function table($paging) {
        $key = $_REQUEST["search"]["value"];

        $this->db->from($this->table_use);
        if (!empty($key)) {
            $this->db->where("nama LIKE " . strtoupper($key) . "% OR kode LIKE %" . strtoupper($key) . "%");
        }
        if ($paging == true) {
            $this->db->limit($_REQUEST["length"], $_REQUEST["start"]);
        }
        return $this->db->order_by('created_at', 'desc')->get();
    }

    public function get_data($id) {
        return $this->db->from($this->table_use)->where("id", $id)->get()->row_array();
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

    public function delete_promo_division($id) {
        $q_delete = $this->db->delete('m_promo_division', array('id_promo' => $id));
        return $q_delete;
    }
}