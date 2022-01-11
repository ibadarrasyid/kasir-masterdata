<?php

class Dashboardmdl extends CI_Model {

    function countPeg() {
        $ss['all'] = $this->db->where('peg_status', 1)->count_all_results('spg_pegawai');
        $gender_ = $this->db->from("spg_pegawai")->select('peg_gender, count(peg_gender) as kelamin')
                        ->where('peg_status', 1)
                        ->group_by('peg_gender')->get();
        foreach ($gender_->result() as $q) {
            $ss[$q->peg_gender] = $q->kelamin;
        }
        return $ss;
    }

    function getPendidikandb() {
        $tkpendidikan = $this->db->order_by('tpdk_id')->get('spg_tktpendidikan');
        $data = $this->db->select('peg_gender,nama, count(*) as jumlah')
                        ->from('pendidikan_pegawai_v')
                ->where('peg_status',1)->group_by('nama, peg_gender')
                        ->order_by('nama, peg_gender')->get();
        foreach ($tkpendidikan->result() as $tkt) {
            $return['tingkat'][] = $tkt->tpdk_nama;
        }
        $return['dataChart'] = $data->result_array();
        return $return;
    }

    function getAgedb() {
        $jns_ = $this->db->get_where('spg_list', array('jenis' => 'kelamin'))->row();
        $jnss = json_decode($jns_->list, TRUE);
        $jns = array_keys($jnss);
        $ag = $this->db->select('peg_gender,EXTRACT(YEAR from age(peg_tgllahir)) as age')
                        ->where('peg_status', 1)
                        ->from('spg_pegawai')->get();

        $key = array('0-25', '26-35', '36-40', '41-50','51-200');
        $ret = array();
        foreach ($key as $ks) {
            $ret[$ks] = array($jns[0] => 0, $jns[1] => 0);
        }

        foreach ($ag->result() as $a) {
            foreach ($ret as $key => $v) {
                $k = explode('-', $key);
                if (intval($k[0]) <= $a->age AND intval($k[1]) >= $a->age) {
                    $ret[$key][$a->peg_gender] += 1;
                }
            }            
        }
        
        return $ret;
    }

    function getJenisjabdb() {
        $list = $this->db->get_where('spg_list', array('jenis' => 'kelamin'))->row();
        $jk = json_decode($list->list, TRUE);
//        $jk = array_keys($jk_);        
        $jj = $this->db->select('jnsjab_id, jnsdetail_nama')
                ->from('spg_jenisjab')
                ->get()
                ->result_array();
        $jjab = array();
        foreach ($jj as $val) {
            $jjab[$val['jnsjab_id']] = $val['jnsdetail_nama'];
        }
        $pns = $this->db->select("jnsjab_id, count(peg_nip) as total, count(peg_nip) FILTER (WHERE peg_gender = 'L') AS l, count(peg_nip) FILTER (WHERE peg_gender = 'P') AS p")
                ->from('spg_pegawai a')
                ->join('spg_jabatan b', 'a.kode_jabatan = b.kode_jabatan')
                ->group_by('jnsjab_id')
                ->order_by('jnsjab_id')
                ->get()
                ->result_array();
        $ret = array();
        foreach ($pns as $val) {
            $ret[$val['jnsjab_id']] = array(
                'nama' => $jjab[$val['jnsjab_id']],
                'total' => $val['total'],
                'l' => $val['l'],
                'p' => $val['p'],
            );
        }
        return $ret;
    }

//    function getJenisjabdb() {
//        $jk = $this->db->get_where('spg_list', array('jenis' => 'kelamin'))->row();
//        $jk_ = json_decode($jk->list, TRUE);
//        $jkel = array_keys($jk_);
//        
//        $jj = $this->db->select('jnsjab_id, jnsdetail_nama')
//                ->from('spg_jenisjab')
//                ->get()
//                ->result_array();
//        $jjab = array();
//        foreach ($jj as $val) {
//            $jjab[$val['jnsjab_id']] = $val['jnsdetail_nama'];
//        }
//        
//        $ret = array();
//        foreach ($jjab as $key => $ks) {
//            $ret[$key] = array($jkel[0] => 0, $jkel[1] => 0, 'nama' => $ks);
//        }
//        $pns = $this->db->select("jnsjab_id, SUM(CASE WHEN peg_gender = 'L' ELSE 0 END) L")
//                ->from('spg_pegawai a')
//                ->join('spg_jabatan b', 'a.kode_jabatan = b.kode_jabatan')
//                ->group_by('jnsjab_id')
//                ->get()
//                ->result_array();
//        foreach ($pns as $val) {
//            
//        }
//        
//        $ag = $this->db->select('peg_gender,EXTRACT(YEAR from age(peg_tgllahir)) as age')
//                        ->where('peg_status', 1)
//                        ->from('spg_pegawai')->get();
//        $key = array('0-25', '26-35', '36-40', '51-200');
////        $key = array('0-25', '26-35', '36-40', '51-200');
//        $ret = array();
//        foreach ($key as $ks) {
//            $ret[$ks] = array($jns[0] => 0, $jns[1] => 0);
//        }
//        foreach ($ag->result() as $a) {
//            foreach ($ret as $key => $v) {
//                $k = explode('-', $key);
//                if (intval($k[0]) <= $a->age AND intval($k[1]) >= $a->age) {
//                    $ret[$key][$a->peg_gender] = $v[$a->peg_gender] + 1;
//                    break;
//                }
//            }
//        }
//        return $ret;
//    }

    function ageGol() {
        $sGol = $this->db->select("mgolongan_nama,(g.mgolongan_nama||' '||g.mgolongan_pangkat) as nama_pangkat,  p.peg_gender, count(*) as jum")
                        ->from('spg_mgolongan g')->join('spg_pegawai p', 'p.mgolongan_id = g.mgolongan_id')
                        ->where('peg_status', 1)
                        ->group_by('g.mgolongan_id,peg_gender ')->order_by('mgolongan_nama')->get();
        $data = array();
        foreach ($sGol->result() as $g) {
            $data[$g->mgolongan_nama]['names'] = $g->nama_pangkat;
            $data[$g->mgolongan_nama][$g->peg_gender] = $g->jum;
        }
        return $data;
    }

    function opdGender() {
        $sGol = $this->db->select("id_opd,nama_unitkerja,peg_gender, count(*) as jum")
                        ->from('jabatan_v v')->join('spg_pegawai p', 'p.kode_jabatan = v.kode_jabatan')
                        ->where('peg_status', 1)
                        ->group_by('v.id_opd,v.nama_unitkerja,peg_gender')->order_by('nama_unitkerja')->get();
        $data = array();
        foreach ($sGol->result() as $g) {
            $data[$g->id_opd]['names'] = $g->nama_unitkerja;
            $data[$g->id_opd][$g->peg_gender] = $g->jum;
        }
        return $data;
    }

}
