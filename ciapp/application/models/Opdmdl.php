<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Opdmdl extends CI_Model {

    function li_opd($orderby = 'nama_unitkerja') {
        $data = array();
        $query = $this->db->from('spg_opd a')
                ->join('spg_tipeunitkerja b', 'a.id_tipeunitkerja = b.id_tipeunitkerja')
                ->where('sub_unitkerja', 0)
                ->order_by($orderby)
                ->get();
        foreach ($query->result_array() as $val) {
            $val['base'] = 0;
            array_push($data, $val);
            $querysub = $this->db->from('spg_opd a')
                    ->join('spg_tipeunitkerja b', 'a.id_tipeunitkerja = b.id_tipeunitkerja')
                    ->where('sub_unitkerja', $val['id_opd'])
                    ->order_by($orderby)
                    ->get();
            if ($querysub->num_rows() > 0) {
                foreach ($querysub->result_array() as $valsub) {
                    $valsub['base'] = 1;
                    array_push($data, $valsub);
                }
            }
        }
        return $data;
    }

    function generate_kowil($idopd, $otherkowil = array()) {
        $query = $this->db->from('spg_opd')
                ->where('sub_unitkerja', $idopd)
                ->order_by('kowil_unitkerja')
                ->get();
        $opd = $this->db->from('spg_opd')
                ->where('id_opd', $idopd)
                ->get()
                ->row_array();
        if ($query->num_rows() == 0 && count($otherkowil) == 0) {
            return $opd['kowil_unitkerja'] . '.01';
        } elseif ($query->num_rows() == 0 && count($otherkowil) > 0) {
            $kowil = array();
            foreach ($otherkowil as $vok) {
                array_push($kowil, $vok);
            }
        } else {
            $kowil = array();
            foreach ($query->result_array() as $val) {
                array_push($kowil, $val['kowil_unitkerja']);
            }
            if (count($otherkowil) > 0) {
                foreach ($otherkowil as $vok) {
                    array_push($kowil, $vok);
                }
            }
        }
        $i = 1;        
        foreach($kowil as $kk) {            
            $i++;
        }
        $x = ($i < 10)?'0'.$i:$i; 
        return $opd['kowil_unitkerja'] . '.' . $x;
    }

}
