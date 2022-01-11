<?php

class User extends G_Controller {

    var $arrlevel = array(
        'admin' => array(0, 1),
        'pns' => array(2)
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('Jabatanmdl');
    }

    public function index() { 
        $header = $this->gmsfunc->headerData('user', 'User');
        $data = array(
            'tbodyadm' => $this->list_(),
            'tbodypns' => $this->list_('pns')
        );
        $this->load->view('layout/header', $header);
        $this->load->view('layout/navi');
        $this->load->view('page/user', $data);
        $this->load->view('layout/footer');
    }

    function filter_($level) {
        $result['tbody'] = $this->list_($level);
        echo json_encode($result);
    }

    private function list_($level = 'admin') {
        $tr = '<tr> <td class="text-center" colspan="4">Tidak ada data</td></tr>';
        ob_start();
        $no = 1;
        if ($level == 'admin') {
            $arr = array(
                array('t' => 'spg_asdf a', 'j' => 'a.as_user_id = b.id')
            );
            $data = $this->gData->select_join('alluser b', $arr, array(), 'level, users', false)
                    ->where_in('level', $this->arrlevel[$level])
                    ->get();
            foreach ($data->result_array() as $val) {
                $cekCrud = ($val['as_privilages'] == 1 || $val['as_privilages'] == 3) ? 'checked=""' : '';
                $cekUpdate = ($val['as_privilages'] == 2 || $val['as_privilages'] == 3) ? 'checked=""' : '';
                $bEdt = ($this->priv_user('edt')) ? '<a id="btn-edit" data-id="' . $val['id'] . '" data-level="admin" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>' : '';
                $bDel = ($this->priv_user('cd')) ? '<a id="btn-delete" data-id="' . $val['id'] . '" data-level="admin" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>' : '';
                ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td><?= $val['users'] ?></td>
                    <td><?= ($val['level'] == 0) ? '******' : $val['pass']; ?></td>
                    <td><?= $this->login_as($val['level']) ?></td>
                    <td class="text-center"><?= ($val['level'] == 0) ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<div class="checkbox"><input ' . $cekCrud . ' type="checkbox" class="cbk-privilages" data-id="' . $val['id'] . '" value="1" /></div>' ?></td> 
                    <td class="text-center"><?= ($val['level'] == 0) ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<div class="checkbox"><input ' . $cekUpdate . ' type="checkbox" class="cbk-privilages" data-id="' . $val['id'] . '" value="2" /></div>' ?></td> 
                    <td class="text-center">
                        <?php if ($val['level'] == 1) { ?>
                            <a id="btn-listMenu" href="<?= base_url('user/formAccess/' . $val['id']) ?>" class="btn btn-xs btn-warning"><i class="fa fa-cogs"></i></a>
                        <?php } ?>
                        <?= $bEdt . '&nbsp;' . $bDel ?>
                    </td>
                </tr>
                <?php
                $no++;
            }
        } else {
            $data = $this->gData->list_column('alluser', 'level, users', '', false)
                    ->where_in('level', $this->arrlevel[$level])
                    ->get();
            foreach ($data->result_array() as $val) {
                $pns = json_decode($val['data'], TRUE);
                ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td><?= $pns['peg_nip'] . '<br>' . $pns['peg_nama'] ?></td>
                    <td><?= $val['users'] ?></td>
                    <td><?= $val['pass'] ?></td>
                    <td class="text-center">
                        <a id="btn-edit" data-id="<?= $val['id'] ?>" data-level="pns" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                        <a id="btn-delete" data-id="<?= $val['id'] ?>" data-level="pns" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php
                $no++;
            }
        }
        $getTr = ob_get_contents();
        if ($getTr != '') {
            $tr = $getTr;
        }
        ob_clean();
        return $tr;
    }

    private function login_as($level = -1) {
        switch ($level) {
            case 0:
                $as = 'Admin';
                break;
            case 1:
                $as = 'Sub Admin';
                break;
            case 2:
                $as = 'PNS';
                break;
            default:
                $as = '';
                break;
        }
        return $as;
    }

    function savePrivilages() {
        $this->hanyaAjax();
        $id = $this->input->post('id');
        $ss = $this->input->post('inp');
        $privilages = array_sum($ss);
        $this->gData->save_data('spg_asdf', array('as_privilages' => $privilages), TRUE, array('as_user_id' => $id));
    }

    function saveadmin_() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('pass', 'Password', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        $this->form_validation->set_message('required', '<strong>{field}</strong> wajib diisi. <strong>Tidak Boleh Kosong</strong>.');
        if (!$this->form_validation->run()) {
            $this->input_error();
        }
        $id = $this->input->post('id');
        $data = array(
            'as_username' => str_replace(' ', '', $this->input->post('username')),
            'as_password' => $this->input->post('pass'),
            'as_type' => $this->input->post('level')
        );
        if ($id == '') {
            $sql = $this->gData->save_data('spg_asdf', $data);
            $log = 'add';
        } else {
            $sql = $this->gData->save_data('spg_asdf', $data, TRUE, array('as_user_id' => $id));
            $log = 'edt';
        }
        if ($sql) {
            $this->log($log);
            $arr['sts'] = 1;
            $arr['tbody'] = $this->list_();
            $arr['msg'] = 'Data berhasil disimpan';
        } else {
            $arr['sts'] = 0;
            $arr['msg'] = 'Data gagal disimpan';
        }
        $this->echo_feedback($arr);
    }

    function edit_($level = 'admin', $id = '') {
        if ($level == 'admin') {
            $data = $this->gData->get_data('spg_asdf', array('as_user_id' => $id))->row_array();
        } else {
            $data = $this->gData->get_data('spg_pegawai', array('peg_id' => $id))->row_array();
        }
        echo json_encode($data);
    }

    function delete_($level = 'admin', $id = '') {
        if ($level == 'admin') {
            $sql = $this->gData->delete_data('spg_asdf', array('as_user_id' => $id));
            $logs = 'del';
        } else {
            $sql = $this->gData->save_data('spg_pegawai', array('peg_username' => NULL, 'peg_password' => NULL), TRUE, array('peg_id' => $id));
            $logs = 'Merubah user pass pegawai dengan ID ' . $id;
        }
        if ($sql) {
            $this->log($logs);
            $arr['sts'] = 1;
            $arr['tbody'] = $this->list_($level);
            $arr['msg'] = 'Data berhasil dihapus';
        } else {
            $arr['sts'] = 0;
            $arr['msg'] = 'Data gagal dihapus';
        }
        $this->echo_feedback($arr);
    }

    function save_() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('pass', 'Password', 'required');
        $this->form_validation->set_message('required', '<strong>{field}</strong> wajib diisi. <strong>Tidak Boleh Kosong</strong>.');
        if (!$this->form_validation->run()) {
            $this->input_error();
        }
        $id = $this->input->post('id');
        $data = array(
            'peg_username' => str_replace(' ', '', $this->input->post('username')),
            'peg_password' => $this->input->post('pass')
        );
        $sql = $this->gData->save_data('spg_pegawai', $data, TRUE, array('peg_id' => $id));
        if ($sql) {
            $this->log('edt');
            $arr['sts'] = 1;
            $arr['tbody'] = $this->list_('pns');
            $arr['msg'] = 'Data berhasil disimpan';
        } else {
            $arr['sts'] = 0;
            $arr['msg'] = 'Data gagal disimpan';
        }
        $this->echo_feedback($arr);
    }

    function formAccess($idUsrSubAdmin) {
        $this->hanyaAjax();
        $this->load->helper('form');
        $user = $this->db->get_where('spg_asdf', array('as_user_id' => $idUsrSubAdmin))->row();
        $subAkses = $this->db->get_where('spg_menusubadmin', array('as_user_id' => $idUsrSubAdmin));
        $idCekedMenu = array();
        foreach ($subAkses->result() as $ids) {
            $idCekedMenu[] = $ids->mnu_id;
        }
        $this->createModal('mdl-menuakses', 'List Menu Akses User Sub Admin (' . strtoupper($user->as_username) . ')');
        $mdlContent = '<input name="iduser" value="' . $idUsrSubAdmin . '" type="hidden"/>"<table class="tabel table-noBorder"> ';
        $mdlContent .= $this->listMenuSubOpd($idCekedMenu)['ss'];
        $mdlContent .= "</table>";
        $this->createModalBody($mdlContent);
        $tr['mdl'] = $this->getModal();
        echo json_encode($tr);
    }

    function saveAccesSubAdmin() {
        $this->hanyaAjax();
        $idusr = $this->input->post('iduser');
        $idmenu = $this->input->post('menuid');
        $ss = $this->db->delete('spg_menusubadmin', array('as_user_id' => $idusr));
        $data = array();
        if ($this->input->post('menuid')) {
            foreach ($idmenu as $vid) {
                $data[] = array('mnu_id' => $vid, 'as_user_id' => $idusr);
            }
            $ss = $this->db->insert_batch('spg_menusubadmin', $data);
        }
        if ($ss) {
            $this->log('Merubah hak akses user ID = ' . $idusr);
            $arr = array('ind' => 1, 'msg' => 'Data berhasil disimpan');
        } else {
            $arr = array('ind' => 0, 'msg' => 'Data gagal disimpan', 'sq' => $this->db->last_query());
        }
        echo json_encode($arr);
    }

    private function listMenuSubOpd($ceked = array(), $parent = 0, $base = 0) {
        $row = $this->db->where('mnu_parent', $parent)->order_by('mnu_urut')->get('spg_menu');
        $return['ss'] = '';
        $return['count'] = $row->num_rows();
        foreach ($row->result_array() as $menu) {
            $sub = $this->listMenuSubOpd($ceked, $menu['mnu_id'], $base + 1);
            $ceked_ = in_array($menu['mnu_id'], $ceked) ? 'checked="true"' : '';
            $tdStyle = in_array($menu['mnu_id'], $ceked) ? "background-color:powderblue" : '';
//                $btn = $sub['count'] > 0 ?'<a clsass="btn btn-xs btn-expand" id="prn-' . $menu['mnu_id'] . '"><i class="fa fa-caret-right"></i></a>':'';
            $return['ss'] .= '<tr>'//<td>'.$btn.'</td>
                    . '<td style="' . $tdStyle . ' "><input name="menuid[]" type="checkbox" ' . $ceked_ . ' class="ceksubmenu cekParent' . $menu['mnu_parent'] . '" '
                    . 'value="' . $menu['mnu_id'] . '" data-parent="' . $menu['mnu_parent'] . '" />'
                    . str_repeat('&nbsp;', (($base + 1) * 5)) . $menu['mnu_nama'] . "</td></tr>";
            $return['ss'] .= $sub['ss'];
        }
        return $return;
    }        

}
