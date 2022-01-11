<?php

class Menu extends G_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MenuMdl');
    }

    public function index() {
        if ($this->session->userdata('spg_type') > 0) {
            show_error("Anda dilarang mengakses alamat ini. <a href='" . base_url() . "'>Home</a>", 403, "Forbidden Page Access");
        }
        $header = $this->gmsfunc->headerData('Menu');
        $sys = $this->gmsfunc->getSystemInfo();
        $header['css'] = array(config_item('plugin') . 'select2/select2');
        $header['jscript'] = array(config_item('plugin') . 'select2/select2');
        $data = array(
            'datax' => $this->listMenu(),
            'url' => $sys['alamat_jfupelaksana']
        );
        $this->load->view('layout/header', $header);
        $this->load->view('layout/navi');
        $this->load->view('page/menu', $data);
        $this->load->view('layout/footer');
    }

    private function geticonUser($index) {
        $icons = array(
            0 => array('icon' => 'fa-user', 'color' => 'red', 'title' => 'Admin'),
            1 => array('icon' => 'fa-users', 'color' => 'blue', 'title' => 'Super Admin'),
            2 => array('icon' => 'fa-user', 'color' => 'green', 'title' => 'Pegawai')
        );
        return $icons[$index];
    }

    function listMenu() {
        ob_start();
        $arrMenu_ = $this->MenuMdl->getMenu();
        $no = 1;
        foreach ($arrMenu_ as $k => $mn) {
            ?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td style="padding-left:<?= ($mn['base'] * 30) ?>px;"><span class='tooltips' title="<?= $mn['urut'] ?>"><?= $mn['name'] ?></span></td>
                <td><?= '<i class="fa ' . $mn['icon'] . '"></i>&nbsp;' . $mn['icon'] ?></td>
                <td><?= $mn['id'] ?></td>
                <td><?= $mn['url'] ?></td>
                <td class="text-center">
                    <?php
                    foreach ($mn['akses'] as $aks) {
                        $prop = $this->geticonUser($aks);
                        echo "<i style='padding-right:5px;color:" . $prop['color'] . ";cursor: pointer' title='" . $prop['title'] . "' class='fa fa-lg " . $prop['icon'] . "'></i>";
                    }
                    ?>
                </td>
                <td align="center">
                    <input type="hidden" id="id_unit" value="<?= $mn['idm'] ?>">
                    <a class="btn btn-xs btn-info" id="tb_edit" onclick="editData(this)" name="<?= $mn['idm'] ?>">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a class="btn btn-xs btn-danger" id="tb_delete" onclick="delData(this)" name="<?= $mn['idm'] ?>">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
            <?php
            $no++;
        }
        $tr = ob_get_contents();
        ob_clean();
        return $tr;
    }

    private function setNbsp($kali) {
        $n = '';
        $i = 0;
        while ($i <= $kali) {
            $n .='&nbsp;';
            $i++;
        }
        return $n;
    }

    function formMenu($mnuId = 0) {
        ob_start();
        if ($mnuId > 0) {
            $user = $this->MenuMdl->selectMenu(array('mnu_id' => $mnuId))->row_array();
        }
        $icons = $this->gmsfunc->listIcon();
        $arrMenu_ = $this->MenuMdl->getMenu();
        $this->createModal('addMenu', 'Form Tambah Menu');
        ?>           
        <input value="<?= $user['mnu_id'] ?>" name="mnu_id" type="hidden">
        <div class="form-group">
            <label class="col-md-4 control-label">Induk Menu</label>
            <div class="col-sm-8">
                <select class="chosen-select" onchange="changeParent(this)" name="induk" id="induk"><option value="0">Tidak ada induk</option>
                    <?php
                    foreach ($arrMenu_ as $vd) {
                        $sel = ($vd['idm'] == $user['mnu_parent']) ? 'selected' : '';
                        echo '<option ' . $sel . ' value="' . $vd['idm'] . '">' . $this->setNbsp(($vd['base'] * 3)) . $vd['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <i ></i>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Nama</label>
            <div class="col-sm-8">
                <input autocomplete="off" value="<?= $user['mnu_nama'] ?>" name="mnu_nama" class="form-control" placeholder="Nama Menu" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Class</label>
            <div class="col-sm-8">
                <select class="chosen-select" name='mnu_class'>
                    <?php
                    foreach ($icons as $icn) {
                        echo '<optgroup label="' . $icn['label'] . '">';
                        foreach ($icn['data'] as $fa) {
                            $s = ($fa == $user['mnu_class']) ? 'selected' : '';
                            echo "<option $s data-icn='$fa' value='$fa'> $fa</option>";
                        }
                        echo '</optgroup>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Title</label>
            <div class="col-sm-8">
                <input autocomplete="off" value="<?= $user['mnu_title'] ?>"  name='mnu_title' class="form-control" placeholder="Attribute Title Element" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Href</label>
            <div class="col-sm-8">
                <input autocomplete="off" value="<?= $user['mnu_href'] ?>" name='mnu_href' class="form-control" placeholder="Attribut Href Element" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Urut</label>
            <div class="col-sm-8">
                <input autocomplete="off" value="<?= $user['mnu_urut'] ?>" name='urut' class="form-control" placeholder="Urutan Menu" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Akses</label>
            <div class="col-sm-8">
                <?php
                $arAkses = array();
                $aksesGet = $this->MenuMdl->selectAkses(array('mks_id_menu' => $mnuId));
                foreach ($aksesGet->result_array() as $vaks) {
                    $arAkses[$vaks['mks_akses']] = 'checked="true"';
                }
                $act = $id == 0 ? 'tambah' : 'edit';
                ?>
                <label class="checkbox-inline"><input <?= (isset($arAkses[0])) ? $arAkses[0] : ''; ?>  type="checkbox" value="0" name="akses[]"/><i></i> Admin</label>
                <label class="checkbox-inline"><input <?= (isset($arAkses[1])) ? $arAkses[1] : ''; ?> type="checkbox" value="1" name="akses[]"/><i></i> Sub Admin</label>
                <label class="checkbox-inline"><input <?= (isset($arAkses[2])) ? $arAkses[2] : ''; ?>  type="checkbox" value="2" name="akses[]"/><i></i> Pegawai</label>
            </div>
        </div>
        <input type="hidden" name="act" value="<?= $act ?>" />
        <?php
        $mdlBodyContent = ob_get_contents();
        ob_clean();
        $this->createModalBody($mdlBodyContent);
        $tr['mdl'] = $this->getModal(array('type' => 'button', 'onclick' => 'saveMdl(this)'));
        echo json_encode($tr);
    }

    function getUrut($parent) {
        $result['max'] = $this->MenuMdl->getMenuUrut($parent);
        echo json_encode($result);
    }

    function dlData($mnu_id) {
        echo $this->MenuMdl->deleteMenu($mnu_id);
    }

    function svData() {
        $mnu_id = $this->input->post('mnu_id');
        $mnu_nama = $this->input->post('mnu_nama');
        $mnu_class = $this->input->post('mnu_class');
        $mnu_href = $this->input->post('mnu_href');
        $mnu_idtag = 'mn_' . ((empty($mnu_href)) ? strtolower($this->input->post('mnu_nama')) : $mnu_href);
        $mnu_akses = $this->input->post('akses');
        $mnu_parent = $this->input->post('induk');
        $mnu_urut = $this->input->post('urut');
        $mnu_title = $this->input->post('mnu_title');

        if (empty($mnu_nama) || $mnu_nama == '') {
            $arr['msg'] = "<font color='red'>Nama Menu tidak boleh kosong.</font>";
            echo json_encode($arr);
            exit();
        } else if (empty($mnu_urut)) {
            $arr['msg'] = "<font color='red'>Kolom Urut harus diisi.</font>";
            $arr['ind'] = 0;
            echo json_encode($arr);
            exit();
        } else if (count($mnu_akses) == 0) {
            $arr['msg'] = "<font color='red'>Hak Akses minimal harus dicentang salh satu.</font>";
            $arr['ind'] = 0;
            echo json_encode($arr);
            exit();
        } else {
            $arrData = array(
                'mnu_id' => $mnu_id,
                'mnu_nama' => $mnu_nama,
                'mnu_parent' => $mnu_parent,
                'mnu_title' => $mnu_title,
                'mnu_class' => $mnu_class,
                'mnu_idtag' => $mnu_idtag,
                'mnu_urut' => $mnu_urut,
                'mnu_href' => $mnu_href
            );
            echo $this->MenuMdl->saveData($arrData, $mnu_akses);
        }
    }

}
