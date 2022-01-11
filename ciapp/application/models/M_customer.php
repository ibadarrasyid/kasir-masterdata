<?php

class M_customer extends CI_Model {
    var $table_use = 'm_customer';

    public function __construct() {
        parent::__construct();

        // date_default_timezone_set("Asia/Jakarta");
    }

    public function table($paging) {
        $key = $_REQUEST["search"]["value"];

        $this->db->from($this->table_use);
        if (!empty($key)) {
            $this->db->where("nama LIKE " . strtoupper($key) . "% OR nohp LIKE " . strtoupper($key) . "% OR nokartu LIKE " . strtoupper($key) . "%");
        }
        if ($paging == true) {
            $this->db->limit($_REQUEST["length"], $_REQUEST["start"]);
        }
        return $this->db->get();
    }

    public function get_data($id = null) {
        $this->db->from($this->table_use);
        if($id)  {
            $this->db->where("id", $id);
            return $this->db->get()->row_array();
        } else {
            return $this->db->get()->result_array();
        }
    }

    public function save($data) {
        $this->db->select_max('id');
        $max = $this->db->get($this->table_use);
        if ($max->num_rows() > 0) {
            $row = $max->row_array();
            $new_id = $row['id'] + 1;
        } else {
            $new_id = 1;
        }
        $data['id'] = $new_id;

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

    // =======================================

    public function get_limit_customer() {
        return $this->db->from('m_limit_customer')->get()->result();
    }

    // public function get_division() {
    //     return $this->db->from('m_division')->get()->result();
    // }

    // public function get_customer_type() {
    //     return $this->db->from('m_customer_type')->get()->result();
    // }
}