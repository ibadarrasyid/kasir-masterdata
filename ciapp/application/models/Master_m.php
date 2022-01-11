<?php

/**
 * Description of Master_m
 *
 * @author V
 */
class Master_m extends CI_Model {

    function list_column($table, $orderby, $select = "", $get = TRUE) {
        $query = $this->db->from($table)->order_by($orderby);
        if ($select != "") {
            $query->select($select);
        }
        if ($get) {
            return $query->get();
        } else {
            return $query;
        }
    }
    
    function get_num_row($table, $arrwhere){
        $row = $this->db->where($arrwhere)->from($table)->get()->num_rows();      
        return $row;
    }
    
    function get_data($table, $arrwhere, $orderby = "", $get = TRUE) {
        $query = $this->db->where($arrwhere)->from($table);
        if ($orderby != "") {
            $query->order_by($orderby);
        }
        if ($get) {
            return $query->get();
        } else {
            return $query;
        }
    }

    public function get($table, $where = null, $select = null){
        if (isset($select)) {
            $this->db->select($select);
        }
        if (isset($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $value) {
                $data[] = $value;
            }
            $query->free_result();
        }else{
            return NULL;
        }
        return $data;
    }

    public function update($table, $data, $where = NULL){
        if(isset($where)){
            $this->db->where($where);
        }
        return $this->db->update($table, $data);
    }

    function get_max_val($table, $column, $where = "") {
        $this->db->select_max($column, 'max');
        if ($where !== "") {
            $this->db->where($where);
        }
        $m = $this->db->get($table);
        return $m->row()->max;
    }

    function save_data($table, $data, $isUpdate = false, $arrwhere = array()) {
        if (!$isUpdate) {
            $query = $this->db->insert($table, $data);
        } else {
            $query = $this->db->where($arrwhere)->update($table, $data);
        }
        return $query;
    }

    function delete_data($table, $arrwhere) {
        $query = $this->db->delete($table, $arrwhere);
        return $query;
    }

    /**
     * Fungsi select JOIN
     * @param String $table nama table utama
     * @param Array $arr_join array 2 dimensi join ex : array(array('t'=>'','j'=>'','o'=>)).
     *         <ul>
     *              <li>t : Nama table</li>
     *              <li>j : fungsi join ex : kode_jabatan = kode_jabatan</li>
     *              <li>o : (Optional / bisa kosong) isinya : left, right, outer, inner, left outer, and right outer. </li>
     *         </ul>                    
     * @param Array $arrwhere fungsi where pake array
     * @param String $orderby fungsi order pake string 
     * @return Object db get()
     */
    function select_join($table, $arr_join, $arrwhere = array(), $orderby = "", $get = true) {
        $query = $this->db->from($table);
        foreach ($arr_join as $s) {
            if (isset($s['o'])) {
                $query->join($s['t'], $s['j'], $s['o']);
            } else {
                $query->join($s['t'], $s['j']);
            }
        }
        if (count($arrwhere) > 0) {
            $query->where($arrwhere);
        }
        $query->order_by($orderby);
        if ($get) {
            return $query->get();
        } else {
            return $query;
        }
    }

}
