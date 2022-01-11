<?php

function get_promo_divison($id_promo = null) {
    $CI = & get_instance();

    $arr_data_promo_division = [];
    $get_promo_division = $CI->db->select('id_division')
                                            ->from('m_promo_division')
                                            ->where('id_promo', $id_promo)
                                            ->get()->result();
    foreach ($get_promo_division as $v_promo_division) {
        $arr_data_promo_division[] = $v_promo_division->id_division;
    }

    $arr_list = [];
    
    $m_division = $CI->db->get('m_division')->result();
    foreach ($m_division as $v_division) {
        // cek jika ada data di table m_promo_division maka checked
        $checked = in_array($v_division->id, $arr_data_promo_division);

        $arr_list[] = ['id_division' => $v_division->id, 'checked' => $checked, 'nama' => $v_division->nama];
    }

    return $arr_list;
}

function save_divison_promo($id_promo, $data_divison) {
    $table_use = 'm_promo_division';

    $CI = & get_instance();

    $arr_data = [];
    foreach ($data_divison as $id_division) {
        $data_insert = [
            'id' => intval($id_promo.$id_division),
            'id_promo' => $id_promo,
            'id_division' => $id_division
        ];

        $arr_data[] = $data_insert;
    }

    // menghapus promo_division yang di uncheck
    $get_id_division_old = $CI->db->select('id_division')->from($table_use)->where('id_promo', $id_promo)->get()->result_array();
    $arr_id_division_old = array_column($get_id_division_old, 'id_division');
    $CI->db->where('id_promo', $id_promo)->where_in('id_division', $arr_id_division_old)->delete($table_use);

    $q_save = $CI->db->insert_batch($table_use, $arr_data);

    return $q_save;
}