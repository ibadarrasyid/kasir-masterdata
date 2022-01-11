<?php

class LimitCustomerMdl extends CI_Model {
    public function __construct() {
        parent::__construct();
        // date_default_timezone_set("Asia/Jakarta");
    }

    public function table($paging) {
        // $ajaran = $_POST["ajaran"];
        // $semester = $_POST["semester"];

        $key = $_REQUEST["search"]["value"];

        $this->db->from("m_limit_customer");
        if (!empty($key)) {
            $this->db->where("limit LIKE " . strtoupper($key) . "% OR tempo LIKE " . strtoupper($key) . "%");
        }
        if ($paging == true) {
            $this->db->limit($_REQUEST["length"], $_REQUEST["start"]);
        }
        return $this->db->get();
    }

    public function save($data) {
        $this->db->select_max('id');
        $max = $this->db->get('m_limit_customer');
        if ($max->num_rows() > 0) {
            $row = $max->row_array();
            $new_id = $row['id'] + 1;
        } else {
            $new_id = 1;
        }
        $data['id'] = $new_id;

        $q_save = $this->db->insert('m_limit_customer', $data);
        return $q_save;
    }

    public function update($id, $data) {
        $q_update = $this->db->set($data)->where('id', $id)->update('m_limit_customer');
        return $q_update;
    }

    public function delete($id) {
        $q_delete = $this->db->delete('m_limit_customer', array('id' => $id));
        return $q_delete;
    }
}