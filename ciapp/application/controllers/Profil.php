<?php

class Profil extends G_Controller {

    public function index() {
        $header = $this->gmsfunc->headerData('pendidikan', 'Pendidikan');
        $data['nav_search'] = $this->viewNavPns();
        $pns = $this->dataPns();
        $data['umur'] = $this->countAge($pns['peg_tgllahir']);
        $pns['peg_tgllahir'] = is_null($pns['peg_tgllahir']) ? '-' : date('d-m-Y', strtotime($pns['peg_tgllahir']));
        if (!empty($pns['peg_nip'])) {
            $this->load->library('sapkws');
            $sapk_data_ = $this->sapkws->getSapk("api/pns/data-utama/" . $pns['peg_nip']);
            $sapk_decode = json_decode($sapk_data_, true);
            $sapk_data = json_decode($sapk_decode['data'], true);
            $sapk_data['umur'] = $this->countAge($sapk_data['tglLahir']);
            $data['sapk'] = $sapk_data;
            $data['icons'] = array(0 => '&nbsp;<i class="fa fa-times text-danger"></i>', 1 => '&nbsp;<i class="fa fa-check text-success"></i>');
        }
        $header['pns'] = $pns;
        $gender = $this->opt_list('kelamin', '', TRUE, TRUE);
        $data['kelamin'] = $gender[$pns['peg_gender']];
        $data['btnCD'] = $this->priv_user('cd');
        $data['btnEDT'] = $this->priv_user('edt');
        $header['css'] = array(config_item('plugin') . 'bootstrap-datepicker/css/bootstrap-datepicker');
        $header['jscript'] = array(config_item('plugin') . 'bootstrap-datepicker/js/bootstrap-datepicker');
        $this->load->view('layout/header', $header);
        $this->load->view('layout/navi');
        $this->load->view('page/p_profil', $data);
        $this->load->view('layout/footer');
    }

    private function dataPns() {
        $pns = $this->getSearchPns();
        if (!$pns) {
            $data = array();
        } else {
            $pdk_ = $this->gData->get_data('spg_pendidikan d', array('d.peg_id' => $pns['nav_id']), 'pdk_tgllulus DESC', FALSE)
                            ->limit(1)->get();
            $pdk = $pdk_->num_rows() > 0 ? $pdk_->row_array() : array();
            $peg = $this->gData->get_data('spg_pegawai d', array('d.peg_id' => $pns['nav_id']))->row_array();
            $data = array_merge($peg, $pdk);
        }
        return $data;
    }

    function countAge($tglLahir) {
        $d1 = new DateTime($tglLahir);
        $d2 = new DateTime();
        $int = $d1->diff($d2);
        $val = (empty($tglLahir) || is_null($tglLahir)) ? array('y' => 0, 'm' => 0) : array('y' => $int->y,
            'm' => $int->m);
        return $val['y'] . ' tahun ' . $val['m'] . ' bulan';
    }

    function form_($id = 0) {
        $pns = FALSE;
        $this->hanyaAjax();
        if ($id > -1) {
            $pns = $this->getSearchPns();
        }
        if ($pns == FALSE AND $id == 0) {
            $this->pesan_error('Cari PNS terlebih dahulu');
        }
        $conten = array();
        if ($id > 0) {
            $conten = $this->gData->get_data('spg_pegawai', array('peg_id' => $id))->row_array();
            $conten['peg_tgllahir'] = is_null($conten['peg_tgllahir']) ? '' : date('d-m-Y', strtotime($conten['peg_tgllahir']));
            $title = 'Form Ubah';
            $img = 'img/pns/' . $conten['peg_foto'];
            $urlGbr = (is_file('assets/' . $img)) ? config_item('assets') . $img : config_item('assets') . 'img/default.jpg';
            $oldNip = "<input type='hidden' value='$conten[peg_nip]' id='old_nip' name='old_nip' />";
        } else {
            $title = 'Form Tambah';
        }
        $this->createModal('mdl-profil', $title . ' Profil Pegawai');
        $listopt = $this->opt_list(FALSE);
        $optagama = $this->set_optlist($listopt['agama'], $conten['peg_agama']);
        $optdok = $this->set_optlist($listopt['dokumen'], $conten['peg_jnsdok']);
        $optgender = $this->set_optlist($listopt['kelamin'], $conten['peg_gender'], TRUE);
        $optsuku = $this->set_optlist($listopt['suku'], $conten['peg_suku']);
        $optInfo = $this->set_optlist($listopt['infoPegawai'], $conten['peg_info']);
        ob_start();
        ?>
        <input type="hidden" name="idpeg" value="<?= $pns['nav_id'] ?>" />
        <div class="form-group">
            <div class="col-md-7">
                <div class="form-group">
                    <label class="control-label col-md-4">NIP <sup><span class="text-danger">*</span></sup></label>
                    <div class="col-md-8">
                        <?= $oldNip ?>
                        <input type="text" value="<?= $conten['peg_nip'] ?>" placeholder="NIP Pegawai" id="nip" name="nip" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">            
                    <label class="control-label col-md-4">Nama <sup><span class="text-danger">*</span></sup></label>
                    <div class="col-md-8">
                        <input type="text" value="<?= $conten['peg_nama'] ?>" placeholder="Nama Pegawai" id="nama" name="nama" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">            
                    <label class="control-label col-md-4">Tempat Lahir</label>
                    <div class="col-md-8">
                        <input type="text" value="<?= $conten['peg_tempatlahir'] ?>" id="tmpt_lahir" name="tmpt_lahir" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Lahir</label>
                    <div class="col-md-4 p-r-0">
                        <input type="text" value="<?= $conten['peg_tgllahir'] ?>" id="tgl_lahir" name="tgl_lahir" class="form-control input-sm"/>
                    </div>
                    <div class="col-md-4 p-l-5">
                        <select name="gender" class="form-control input-sm">                            
                            <?= $optgender ?>
                        </select>
                    </div>
                </div>                
            </div>
            <div class="col-md-5 text-center">
                <img style="height: 125px;width: 110px; margin-bottom: 10px;display: inline;" class="thumbnail" src="<?= $urlGbr ?>" id="preview"><br>
                <input type="file" name="foto" style="width: 100%" id="foto" class="btn btn-default btn-sm" />                
            </div>
        </div>
        <div class="form-group">            
            <label class="control-label col-md-3">Agama</label>
            <div class="col-md-3">
                <select name="agama" class="form-control">
                    <option value="">--Pilih Agama--</option>
                    <?= $optagama ?>
                </select>
            </div>
            <label class="control-label col-md-2 p-r-0 p-l-0">Gol. Darah</label>
            <div class="col-md-4">
                <select name="darah" id="darah" class="form-control input-sm"> 
                    <option value="">--Pilih Gol. Darah--</option>
                    <?php
                    $gol = array('A', 'B', 'AB', 'O');
                    foreach ($gol as $value) {
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Suku</label>
            <div class="col-md-3">
                <select name="suku" class="form-control">
                    <option value="">--Pilih Suku--</option>
                    <?= $optsuku ?>
                </select>
            </div>         
            <label class="control-label col-md-2 p-r-0 p-l-0">Putra Daerah</label>
            <div class="col-md-4">
                <input type="checkbox" class="checkbox" value="1" <?= ($conten['peg_isputradaerah'] == 't') ? 'checked="true"' : '' ?> id="putradaerah" name="putradaerah"/>                
            </div>            
        </div>
        <div class="form-group">            
            <label class="control-label col-md-3">Jenis Dokumen</label>
            <div class="col-md-3">
                <select name="jns_dok" class="form-control">
                    <option value="">Pilih Jenis Dokumen</option>
                    <?= $optdok ?>
                </select>
            </div>
            <label class="control-label col-md-2 p-r-0 p-l-0">No Dokumen</label>
            <div class="col-md-4">
                <input type="text" value="<?= $conten['peg_nodok'] ?>" id="no_dok" name="no_dok" class="form-control input-sm"/>
            </div>
        </div>        
        <div class="form-group">
            <label class="control-label col-md-3">Alamat</label>
            <div class="col-md-9">
                <textarea rows="2" class="form-control" name="alamat"><?= $conten['peg_alamat'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Kelurahan</label>
            <div class="col-md-3">
                <input type="text" value="<?= $conten['peg_kelurahan'] ?>" id="kelurahan" name="kelurahan" class="form-control input-sm" />
            </div>         
            <label class="control-label col-md-3">Distrik</label>
            <div class="col-md-3">
                <input type="text" value="<?= $conten['peg_kecamatan'] ?>" id="kecamatan" name="kecamatan" class="form-control input-sm" />
            </div>            
        </div>                
        <div class="form-group">
            <label class="control-label col-md-3">No. Hp</label>
            <div class="col-md-3">
                <input type="text" value="<?= $conten['peg_hp'] ?>" id="nohp" name="nohp" class="form-control input-sm" />
            </div>         
            <label class="control-label col-md-3">No. Telp</label>
            <div class="col-md-3">
                <input type="text" value="<?= $conten['peg_telp'] ?>" id="notelp" name="notelp" class="form-control input-sm" />
            </div>            
        </div>                
        <div class="form-group">
            <label class="control-label col-md-3">Email</label>
            <div class="col-md-9">
                <input type="text" value="<?= $conten['peg_email'] ?>" id="email" name="email" class="form-control input-sm"/>
            </div>  
        </div>                        
        <div class="form-group">
            <label class="control-label col-md-3">No. Kartu Pegawai</label>
            <div class="col-md-9">
                <input type="text" value="<?= $conten['peg_karpeg'] ?>" id="karpeg" name="karpeg" class="form-control input-sm" />
            </div>  
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Info Penting</label>
            <div class="col-md-9">
                <select name="info" class="form-control input-sm">
                    <option value="">--Pilih Info --</option>
                    <?= $optInfo ?>
                </select>
            </div>  
        </div>
        <?php
        $mdlBodyContent = ob_get_contents();
        ob_clean();
        $this->createModalBody($mdlBodyContent);
        $tr['sts'] = 1;
        $tr['mdl'] = $this->getModal();
        echo json_encode($tr);
    }

    function save_() {
        $peg_nip = $this->input->post('nip');
        $old_peg_nip = $this->input->post('old_nip');

        $this->load->library('form_validation');
        if ($peg_nip != $old_peg_nip) {
            $this->form_validation->set_rules('nip', 'NIP Pegawai', 'required|max_length[20]|is_unique[spg_pegawai.peg_nip]', array('is_unique' => '<strong>NIP</strong> telah digunakan'));
        } else {
            $this->form_validation->set_rules('nip', 'NIP Pegawai', 'required|max_length[20]');
        }
        $this->form_validation->set_rules('nama', 'Nama Pegawai', 'required|max_length[150]|strtoupper', array('required' => '<strong>Nama Pegawai</strong> wajib di isi'));
        $this->form_validation->set_rules('tmpt_lahir', 'Tempat lahir', 'trim|max_length[50]|strtoupper');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal lahir', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[80]');
        $this->form_validation->set_rules('no_dok', 'Email', 'trim|max_length[35]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('kelurahan', 'Alamat', 'trim|max_length[100]');
        $this->form_validation->set_rules('kecamatan', 'Alamat', 'trim|max_length[100]');
        $this->form_validation->set_rules('nohp', 'No. HP', 'trim|max_length[20]');
        $this->form_validation->set_rules('notelp', 'No. Telp', 'trim|max_length[20]');
        $this->set_formMsg();
        if (!$this->form_validation->run()) {
            $this->input_error();
        }

        $id = $this->input->post('idpeg');
        $tgllahir_ = $this->input->post('tgl_lahir');
        $tgl_lhr = ($this->input->post('tgl_lahir')) ? date('Y-m-d', strtotime($tgllahir_)) : NULL;

        $data = array(
            'peg_nama' => $this->input->post('nama'),
            'peg_nip' => $this->input->post('nip'),
            'peg_jnsdok' => $this->input->post('jns_dok'),
            'peg_nodok' => $this->input->post('no_dok'),
            'peg_tempatlahir' => $this->input->post('tmpt_lahir'),
            'peg_tgllahir' => $tgl_lhr,
            'peg_alamat' => $this->input->post('alamat'),
            'peg_kelurahan' => $this->input->post('kelurahan'),
            'peg_kecamatan' => $this->input->post('kecamatan'),
            'peg_email' => $this->input->post('email'),
            'peg_hp' => $this->input->post('nohp'),
            'peg_telp' => $this->input->post('notelp'),
            'peg_gender' => $this->input->post('gender'),
            'peg_agama' => $this->input->post('agama'),
            'peg_suku' => $this->input->post('suku'),
            'peg_isputradaerah' => ($this->input->post('putradaerah') == 1),
            'peg_karpeg' => $this->input->post('karpeg'),
            'peg_darah' => $this->input->post('darah'),
            'peg_info' => $this->input->post('info')
        );
        if (empty($id)) {
            $newid = $this->gData->get_max_val('spg_pegawai', 'peg_id');
            $data['peg_id'] = $newid + 1;
        }
        if (!empty($_FILES["foto"]["name"])) {
            $config = array(
                'upload_path' => 'assets/img/pns/',
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 1024
            );
            $prefix = $data['peg_gender'] == 'Pria' ? 'L' : 'W';
            $config['file_name'] = $prefix . '_' . $id;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                $msg = $this->upload->display_errors();
                $this->pesan_error($msg);
            }
            $data['peg_foto'] = $this->upload->data('file_name');
        }

        $label = array(
            'peg_nama' => 'Nama',
            'peg_nip' => 'NIP',
            'peg_jnsdok' => 'Jenis Dokumen',
            'peg_nodok' => 'No Dokumen',
            'peg_tempatlahir' => 'Tempat Lahir',
            'peg_tgllahir' => 'Tanggal Lahir',
            'peg_alamat' => 'Alamat',
            'peg_kelurahan' => 'Kelurahan',
            'peg_kecamatan' => 'Kecamatan',
            'peg_email' => 'Email',
            'peg_hp' => 'No HP',
            'peg_telp' => 'No Telp',
            'peg_gender' => 'Jenis Kelamin',
            'peg_agama' => 'Agama',
            'peg_suku' => 'Suku',
            'peg_isputradaerah' => 'Putra Daerah',
            'peg_karpeg' => 'Kartu Pegawai',
            'peg_darah' => 'Gol Darah',
            'peg_info' => 'Info'
        );

        if (empty($id)) {
            $sql = $this->gData->save_data('spg_pegawai', $data);
            $this->setSearchPns($data['peg_nip']);
            $logs = 'add';
            // $column = array($data['peg_nama']);
        } else {
            $oldData = $this->gData->get_data('spg_pegawai', array('peg_id' => $id))->row_array();
            ($oldData['peg_isputradaerah'] == 't') ? $oldData['peg_isputradaerah'] = TRUE : $oldData['peg_isputradaerah'] = 0;
            if (empty($data['peg_isputradaerah']) && ($oldData['peg_isputradaerah'] == 0 )) {
                $oldData['peg_isputradaerah'] = NULL;
            }

            $sql = $this->gData->save_data('spg_pegawai', $data, TRUE, array('peg_id' => $id));
            $logs = 'edt';

            $column = $this->log_setkolom($label, $oldData, $data);
        }
        if ($sql) {
            $this->log($logs, $column, TRUE);
            $arr['sts'] = 1;
            $arr['msg'] = 'Data berhasil disimpan';
            $arr['url'] = base_url('profil?cari_nip=' . $data['peg_nip']);
        } else {
            $arr['sts'] = 0;
            $arr['msg'] = 'Data gagal disimpan';
            $arr['sql'] = $this->db->last_query();
        }
        $this->echo_feedback($arr);
    }

    function delete_($id = '') {
        $this->hanyaAjax();
        $pns = $this->getSearchPns();
        if ($pns == FALSE AND $id == 0) {
            $this->pesan_error('Cari PNS terlebih dahulu');
        }
        $im = $this->gData->get_data('spg_pegawai', array('peg_id' => $id), "", FALSE)->select('peg_foto')->get()->row();
        $sql = $this->gData->delete_data('spg_pegawai', array('peg_id' => $id));
        $imgDir = 'assets/img/pns/';
        if ($sql) {
            if (is_file($imgDir . $im->peg_foto)) {
                unlink($imgDir . $im->peg_foto);
            }
            $return = array(
                'nav_foto' => config_item('assets') . '/img/default.jpg'
            );
            $this->log('del', TRUE);
            $this->session->set_userdata('spg_nipsearch', json_encode($return));
            $this->session->unset_userdata('spg_nipsearch');
            $arr['sts'] = 1;
            $arr['msg'] = 'Data berhasil dihapus';
        } else {
            $arr['sts'] = 0;
            $arr['msg'] = 'Data gagal dihapus';
        }
        $this->echo_feedback($arr);
    }

    function biodata_($id = '') {
        $this->load->helper(array('dompdf', 'file'));
        $data = $this->gmsfunc->getInfoDaerah();
        $arrJoin = array(
            array('t' => 'spg_mgolongan g', 'j' => 'p.mgolongan_id = g.mgolongan_id', 'o' => 'left'),
            array('t' => 'spg_pns pns', 'j' => 'pns.peg_id = p.peg_id', 'o' => 'left'),
            array('t' => 'spg_cpns cp', 'j' => 'cp.peg_id = p.peg_id', 'o' => 'left'),
            array('t' => 'jabatan_v j', 'j' => 'j.kode_jabatan = p.kode_jabatan'),
        );
        $sql = $this->gData->select_join('spg_pegawai p', $arrJoin, array('p.peg_id' => $id), 'p.peg_nama', false);

        $data['peg'] = $sql->select('p.*, g.mgolongan_nama, g.mgolongan_pangkat, 
                                        pns.mgolongan_id AS pns_gol, 
                                        pns.pns_tmt, 
                                        pns.pns_nosk, 
                                        pns.pns_tglsk, 
                                        pns.mket_pejabat AS pns_pejabat, 

                                        cp.cpns_nosk, 
                                        cp.cpns_tglsk, 
                                        cp.cpns_nopertek, 
                                        cp.cpns_tglpertek, 
                                        cp.cpns_tmt,
                                        cp.mgolongan_id AS cpns_mgolongan_id,
                                        cp.mket_pejabat AS cpns_pejabat,
                                    j.*')->get()->row_array();

        $s_kp = $this->gData->select_join('spg_golongankp a', array(array('t' => 'spg_mgolongan b', 'j' => 'a.mgolongan_id = b.mgolongan_id')), array('a.peg_id' => $id), 'gol_tglsk desc', false);
        $data['kp'] = $s_kp->limit(1)->get()->row_array(); // kenaikan pangkat

        // $data['kgb'] = $this->gData->get_data('spg_kgb', array('peg_id' => $id), 'kgb_tglskgb DESC', false)->limit(1)->get()->row_array(); // kenaikan gaji berkala
        $imgName = $data['peg']['peg_foto'];
        $pathImg = FCPATH . 'assets/img/pns/';
        if (!file_exists($pathImg . $imgName) || empty($imgName)) {
            $data['peg']['peg_foto'] = config_item('img') . 'default.jpg'; 
        } else {
            $data['peg']['peg_foto'] = config_item('img') . 'pns/' . $imgName; 
        }
        $data['peg']['pns_tmt'] = (is_null($data['peg']['pns_tmt'])) ? NULL : $this->gmsfunc->format_tglSimpan($data['peg']['pns_tmt'], '/', false);
        $data['peg']['cpns_tmt'] = $this->gmsfunc->format_tglSimpan($data['peg']['cpns_tmt'], '/', false);
        $data['kp']['gol_tmtgol'] = $this->gmsfunc->format_tglSimpan($data['kp']['gol_tmtgol'], '/', false);
        // $data['kgb']['kgb_tglskgb'] = $this->gmsfunc->format_tglSimpan($data['kgb']['kgb_tglskgb'], '-', false);
        // $data['kgb']['kgb_tmt'] = $this->gmsfunc->format_tglSimpan($data['kgb']['kgb_tmt'], '-', false);
        $arrJoinKepeg = array(
            array('t' => 'spg_mket m', 'j' => 'k.mket_keadaanterkini = m.mket_id')
        );
        $data['kepeg'] = $this->gData->select_join('spg_kepegawaian k', $arrJoinKepeg, array('k.peg_id' => $id), "", false)->select('m.mket_keterangan')->get()->row_array();
        
        $data['peg']['sts_menikah'] = $this->cekStatusMenikah($id, $data['peg']['peg_gender']);

        // riwayat jabatan
        $tmtjab = $this->gData->get_data('spg_riwayatjabatan', array('peg_id' => $id), 'rj_tmtjabatan DESC', false)->get();
        $s_tmtjab = $tmtjab->row_array();
        $data['peg']['tmtjabatan'] = !empty($s_tmtjab['rj_tmtjabatan']) ? date('d-m-Y', strtotime($s_tmtjab['rj_tmtjabatan'])) : '';
        $data['rj'] = $tmtjab->result_array();

        // riwayat pendidikan
        $data['pdk'] = $this->gData->get_data('spg_pendidikan', array('peg_id' => $id), 'pdk_tgllulus ASC')->result_array();

        // Riwayat Diklat Struktural
        $arj = array(
            array('t' => 'spg_mket k', 'j' => 'k.mket_id = d.dmj_pejabat')
        );
        $data['diklat_struktural'] = $this->gData->select_join('spg_diklat d', $arj, array('d.peg_id' => $id), 'dmj_tglpenetapan ASC')->result_array();

        // Riwayat Diklat Teknis
        $data['diklat_teknis'] = $this->gData->get_data('spg_diklat_teknis', array('peg_id' => $id), 'ks_tglsertifikat ASC')->result_array();

        // Riwayat KGB
        $arj = array(
            array('t' => 'spg_mgolongan g', 'j' => 'k.mgolongan_id = g.mgolongan_id'),
            array('t' => 'spg_mket p', 'j' => 'k.kgb_pejabat = p.mket_id')
        );
        $data['kgb'] = $this->gData->select_join('spg_kgb k', $arj, array('k.peg_id' => $id), 'kgb_tglskgb ASC')->result_array();

        // Riwayat Angka Kredit
        $data['ak'] = $this->gData->get_data('spg_pak', array('peg_id' => $id), 'pak_tglstart_penilaian DESC')->result_array();

        // Data Suami/Istri
        $data['pasangan'] = $this->gData->select_join('spg_pasangan a', array(array('t' => 'spg_orang b', 'j' => 'a.org_id = b.org_id')), array('a.peg_id' => $id), 'psg_tglmenikah')->result_array();

        // Data Anak
        $data['anak'] = $this->gData->select_join('spg_anak a', 
                                            array(
                                                array('t' => 'spg_orang b', 'j' => 'a.org_id = b.org_id'), 
                                                array('t' => 'spg_pasangan c', 'j' => 'a.psg_id = c.psg_id', 'o' => 'left')
                                            ), 
                                            array('a.peg_id' => $id), 'ank_urut', FALSE)->select('a.*,b.*,c.psg_id')->get()->result_array();

        $html = $this->load->view('pdf/biodata', $data, false);
//        pdf_create($html, 'Biodata PNS', "potrait");
    }

    private function cekStatusMenikah($idpeg, $gender) {
        $join = array(
            array('t' => 'spg_orang o', 'j' => 'o.org_id = p.org_id')
        );
        $s_pasangan = $this->gData->select_join('spg_pasangan p', $join, array('peg_id' => $idpeg));
        $return = $gender == 'L' ? 'Duda' : 'Janda';
        foreach ($s_pasangan->result_array() as $r) {
            if (strtolower($r['psg_statuskarsu']) == 'menikah' && $r['org_aktamati'] == '') {
                $return = 'Menikah';
                break;
            }
        }
        return $return;
    }

    function qrCode($idpeg) {
        $this->load->library('ciqrcode');
        header("Content-Type: image/png");
        $user = $this->session->userdata('spg_username');
        $peg = $this->gData->get_data('spg_pegawai', array('peg_id' => $idpeg))->row();
        $params['data'] = 'Profil ' . $peg->peg_nip . ' / ' . $peg->peg_nama . "\nPrinted by $user\n@" . date('Y') . " - " . $_SERVER['HTTP_HOST'];
        $this->ciqrcode->generate($params);
    }

}
