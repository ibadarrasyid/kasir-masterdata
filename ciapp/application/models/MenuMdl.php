<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuMdl
 *
 * @author V
 */
class MenuMdl extends CI_Model {

    private $arrmenu = array();

    function getMenu($aksesChosen = array(), $parent = 0, $base = 1) {
        return $this->setMenu($aksesChosen);
    }

    private function setMenu($aksesChosen = array(), $parent = 0, $base = 1) {
        $query = $this->db->from('tsk_menu')->where('mnu_parent', $parent)->order_by('mnu_urut')->get();
        foreach ($query->result_array() as $key => $value) {
            $arAkses = array();
            $aksesGet = $this->db->from('tsk_menuakses')->where('mks_id_menu', $value['mnu_id'])->get();
            foreach ($aksesGet->result_array() as $vaks) {
                $arAkses[] = $vaks['mks_akses'];
            }

            $arrProp = array(
                "name" => $value['mnu_nama'],
                "title" => $value['mnu_title'],
                "url" => $value['mnu_href'],
                "id" => $value['mnu_idtag'],
                "icon" => $value['mnu_class'],
                "idm" => $value['mnu_id'],
                "urut" => $value['mnu_urut'],
                "akses" => $arAkses,
                "base" => $base
            );
            if (count($aksesChosen) > 0) {
                foreach ($aksesChosen as $inakses) {
                    if (in_array($inakses, $arAkses)) {
                        array_push($this->arrmenu, $arrProp);
                        break;
                    }
                }
            } else {
                array_push($this->arrmenu, $arrProp);
            }
            $this->setMenu($aksesChosen, $value['mnu_id'], ($base + 1));
        }
        return $this->arrmenu;
    }

    function saveData($data, $mnu_akses) {
        if ($data['mnu_id'] == 0) {
//            if ($data['mnu_parent'] != '0') {
//                $mnu_class = "";
//            }
            $isi = $this->gmsfunc->getNewID('tsk_menu', 'mnu_id');
            $data['mnu_id'] = $isi;
            $sql = $this->db->insert("tsk_menu", $data);
            foreach ($mnu_akses as $aks) {
                $isia = $this->gmsfunc->getNewID('tsk_menuakses', 'mks_id');
                $sqla = $this->db->query("INSERT INTO tsk_menuakses (mks_id, mks_akses, mks_id_menu) VALUES ($isia, $aks, $isi)");
            }

            if ($sql == 'true' && $sqla == 'true') {
                $arr['msg'] = "<font color='green'>Data Telah Tersimpan.</font>";
                $arr['ind'] = 1;
                return json_encode($arr);
            } else {
                $arr['msg'] = "<font color='green'>Terjadi kesalahan, Data Gagal Tersimpan.</font>";
                $arr['ind'] = 0;
                return json_encode($arr);
            }
        } else {
//            if ($data['mnu_parent'] != '0') {
//                $data['mnu_class'] = "";
//
            $this->db->delete("tsk_menuakses", array('mks_id_menu' => $data['mnu_id']));
            foreach ($mnu_akses as $aks) {
                $isia = $this->gmsfunc->getNewID('tsk_menuakses', 'mks_id');
                $sqla = $this->db->query("INSERT INTO tsk_menuakses (mks_id, mks_akses, mks_id_menu) VALUES ($isia, $aks, " . $data['mnu_id'] . ")");
            }
            $this->db->where('mnu_id', $data['mnu_id']);
            $sql = $this->db->update('tsk_menu', $data);
            if ($sql == 'true') {
                $arr['msg'] = "<font color='green'>Data Telah Tersimpan.</font>";
                $arr['ind'] = 1;
                return json_encode($arr);
            } else {
                $arr['msg'] = "<font color='green'>Terjadi kesalahan, Data Gagal Tersimpan.</font>";
                $arr['ind'] = 0;
                return json_encode($arr);
            }
        }
    }

    function deleteMenu($mnu_id) {
        $sql = $this->db->delete("tsk_menu", array('mnu_id' => $mnu_id));
        if ($sql == 'true') {
            $arr['msg'] = "Data Telah Dihapus.";
            $arr['ind'] = 1;
            return json_encode($arr);
        } else {
            $arr['msg'] = "Terjadi kesalahan, Data Gagal Tersimpan.";
            $arr['ind'] = 0;
            return json_encode($arr);
        }
    }

    function selectMenu($arrWhere = array()) {
        $this->db->from("tsk_menu");
        if (count($arrWhere) > 0) {
            $this->db->where($arrWhere);
        }
        $query = $this->db->order_by('mnu_urut')->get();
        return $query;
    }

    function selectAkses($arrWhere = array()) {
        $this->db->from("tsk_menuakses");
        if (count($arrWhere) > 0) {
            $this->db->where($arrWhere);
        }
        $query = $this->db->get();
        return $query;
    }

    function getMenuUrut($parent) {
        $sql = $this->db->from('tsk_menu')->where('mnu_parent', $parent)->get();
        $urut = $sql->num_rows() + 1;
        return $urut;
    }

}
