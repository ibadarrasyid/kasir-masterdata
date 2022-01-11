<?php

function get_customer_type_divison($id_customer = null) {
    $CI = & get_instance();

    $arr_data_customer_type_division = [];
    $get_customer_type_division = $CI->db->select('id_division, id_customer_type')
                                            ->from('m_customer_type_division')
                                            ->where('id_customer', $id_customer)
                                            ->get()->result();
    foreach ($get_customer_type_division as $v_customer_type_division) {
        $arr_data_customer_type_division[$v_customer_type_division->id_division][$v_customer_type_division->id_customer_type] = TRUE;
    }

    $arr_list = [];
    
    $m_division = $CI->db->get('m_division')->result();
    $m_customer_type = $CI->db->get('m_customer_type')->result();

    foreach ($m_division as $v_division) {
        foreach ($m_customer_type as $v_customer_type) {
            // cek jika ada data di table m_custoemr_type_division maka selected, jika tidak maka umum menjadi default selected
            $selected = !empty($arr_data_customer_type_division[$v_division->id]) ? $arr_data_customer_type_division[$v_division->id][$v_customer_type->id] : $v_customer_type->nama == 'umum';
            $selected = !empty($selected) ? $selected : false;

            $arr_list[$v_division->id.'#'.$v_division->nama][$v_customer_type->id] = ['nama_customer_type' => $v_customer_type->nama, 'selected' => $selected];
        }
    }

    return $arr_list;
}

function save_customer_type_divison($id_customer, $data_customer_type, $data_divison, $is_update = FALSE) {
    $table_use = 'm_customer_type_division';

    $CI = & get_instance();

    // $CI->db->select_max('id');
    // $max = $CI->db->get($table_use);
    // if ($max->num_rows() > 0) {
    //     $row = $max->row_array();
    //     $new_id = $row['id'] + 1;
    // } else {
    //     $new_id = 1;
    // }
    // $data['id'] = $new_id;

    $arr_data = [];
    foreach ($data_customer_type as $key => $v_customer_type) {
        $data_insert = [
            'id' => intval($id_customer.$data_divison[$key]),
            'id_customer' => $id_customer,
            'id_customer_type' => $v_customer_type,
            'id_division' => $data_divison[$key]
        ];

        $arr_data[] = $data_insert;

        // $new_id++;
    }

    if ($is_update) {
        // $CI->db->where('id_customer', $id_customer)->delete($table_use);

        $q_save = $CI->db->update_batch($table_use, $arr_data, 'id'); 
    } else {
        $q_save = $CI->db->insert_batch($table_use, $arr_data);
    }

    return $q_save;
}

/**
 * Does something interesting
 *
 * @param string $delete_by pilih salah satu 'customer, customer_type, division'
 * @param integer $id adalah id dari $delete_by
 * 
 * @return boolean jika TRUE maka sukses di hapus, FALSE gagal di hapus
 */ 
function delete_customer_type_divison($delete_by, $id) {
    $arr_column = [
        'customer' => 'id_customer',
        'customer_type' => 'id_customer_type',
        'division' => 'id_division'
    ];

    $table_use = 'm_customer_type_division';

    $CI = & get_instance();

    $q_delete = $CI->db->where($arr_column[$delete_by], $id)->delete($table_use);

    return $q_delete;
}
