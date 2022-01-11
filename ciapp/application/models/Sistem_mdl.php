<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistem_mdl extends CI_Model {

    public function saveDataAplikasi() {
        $detail = $this->input->post('detail');
        foreach ($detail as $key => $val) {
            $this->db->where(array('sys_what' => 'info', 'sys_id' => 'inf_' . $key));
            $this->db->update('spg_sys', array('sys_value' => $val));
        }
        $arr = array('ind' => 1, 'msg' => 'Data Berhasil disimpan');
        if (isset($_FILES["imgFile"]["name"])) {
            $extension = array('jpg', 'jpeg', 'png');
            $uploaddir = 'assets/img/app/';
            $fileName = basename($_FILES['imgFile']['name']);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $fileNew = 'logo.' . $ext;
            $fileDir = $uploaddir . $fileNew;
            $arr['ind'] = 0;
            if (is_numeric(array_search($ext, $extension)) and ( intval($_FILES["imgFile"]["size"] / 1024) <= 1024)) {
                if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $fileDir)) {
                    try {
                        $exec = $this->db->where(array('sys_what' => 'info', 'sys_id' => 'inf_logo'))
                                ->update('spg_sys', array('sys_value' => $fileNew));
                        if (!$exec) {
                            $arr['msg'] = "Data belum tersimpan.<br>Ada kesalahan ketika menyimpan data !";
                            unlink($fileDir);
                        } else {
                            $arr['ind'] = 1;
                            $arr['msg'] = 'Data sudah tersimpan';
                            $arr['img'] = base_url() . $fileDir . "?" . microtime();
                        }
                    } catch (Exception $e) {
                        $arr['msg'] = "Terjadi kesalahan ketika menyimpan data gambar.";
                    }
                } else {
                    $arr['msg'] = "Terjadi kesalahan ketika menyimpan data gambar.";
                }
            } else {
                if (($_FILES["imgFile"]["size"] / 1024) > 1024) {
                    $arr['msg'] = "Data belum tersimpan.<br>Ukuran tidak boleh melebihi 1 Mb !";
                } else {
                    $arr['msg'] = "Data belum tersimpan.<br>File extensi yang diperbolehkan hanyalah jpg, jpeg dan png !";
                }
            }
        }
        return $arr;
    }

    public function saveDataFoto($inf, $val) {
        if ($inf == 'slider') {
            $sqlx = $this->db->select('sys_value')->from('spg_sys')->where('sys_id', 'inf_slider')->get()->row_array();
            $valx = ($sqlx['sys_value'] == "") ? $val : $sqlx['sys_value'] . '/' . $val;
            $sql = $this->db->where(array('sys_what' => 'info', 'sys_id' => 'inf_slider'))->update('spg_sys', array('sys_value' => $valx));
        } else {
            $sql = $this->db->where(array('sys_what' => 'info', 'sys_id' => 'inf_' . $inf))->update('spg_sys', array('sys_value' => $val));
        }
        return $sql;
    }

    function get_nmr_slide($jml_slide) {
        $sqlx = $this->db->select('sys_value')->from('spg_sys')->where('sys_id', 'inf_slider')->get()->row_array();
        $dt = explode('/', $sqlx['sys_value']);
        $nama = $dt[$jml_slide - 1];
        $nmr = explode('.', $nama);
        $new = $nmr[0] + 1;
        return $new;
    }

    public function del_dtslide($id) {
        $sqlx = $this->db->select('sys_value')->from('spg_sys')->where('sys_id', 'inf_slider')->get()->row_array();
        $dt = explode('/', $sqlx['sys_value']);
        $no = array_search($id, $dt);
        unlink('assets/img/slider/' . $dt[$no]);
        unset($dt[$no]);
        $new = implode('/', $dt);
        $sql = $this->db->where(array('sys_what' => 'info', 'sys_id' => 'inf_slider'))->update('spg_sys', array('sys_value' => $new));
        return $sql;
    }

}
