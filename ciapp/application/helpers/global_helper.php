<?php

function new_id_table($table_name, $table_column) {
    $CI = & get_instance();

    $CI->db->select_max($table_column);
    $max = $CI->db->get($table_name);
    if ($max->num_rows() > 0) {
        $row = $max->row_array();
        $new_id = $row[$table_column] + 1;
    } else {
        $new_id = 1;
    }

    return $new_id;
}

function rupiah_format($value) {
    return 'Rp. '.number_format($value, 0, ',', '.');
}

function output_property_value($property) {
    $output_property = '<ul style="padding-left: 0;">';
    $arr_property = json_decode($property, TRUE);
    foreach ($arr_property as $k_property => $v_property) {
        $output_property .= '<li>'.$k_property.' = '.$v_property.'</li>';
    }
    $output_property .= '</ul>';

    return $output_property;
}

function active_sidebar_menu($module) {
    $CI = & get_instance();

    $module_use = $CI->router->fetch_class();

    return $module == $module_use ? 'active' : '';
}

function date_save_db($date) {
    return date('Y-m-d', strtotime($date));
}
