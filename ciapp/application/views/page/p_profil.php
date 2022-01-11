<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Pegawai</a></li>
        <li class="active">Profil</li>
    </ol>
    <h1 class="page-header">Profil Identitas</h1>
    <?= $nav_search ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Profil Identitas Pegawai</h4>
                </div>
                <div class="panel-body">                    
                    <div class="row">
                        <div class="col-md-12 m-b-10">
                            <?php if ($btnCD) { ?>
                                <a data-id="-1" class="btn btn-sm btn-primary btn-success m-r-5" id="btn-add"><i class="fa fa-plus"></i>&nbsp;Tambah Pegawai</a>
                                <a data-id="<?= $pns['peg_id'] ?>" class="btn btn-sm btn-primary btn-danger m-r-5" id="btn-delete"><i class="fa fa-trash"></i>&nbsp;Hapus Pegawai</a>
                            <?php } if ($btnEDT) { ?>
                                <a data-id="<?= $pns['peg_id'] ?>" class="btn btn-sm btn-primary btn-color m-r-5 btn-edit" id="btn-edit"><i class="fa fa-edit"></i>&nbsp;Ubah Data</a>
                            <?php } ?> 
                            <a target="_blank" href="<?= base_url('profil/biodata_/') . $pns['peg_id'] ?>" class="pull-right btn btn-sm btn-primary btn-info m-r-5"><i class="fa fa-print"></i>&nbsp;Cetak Profil</a>
                        </div> 
                        <div class="col-md-12 m-t-1">
                            <div class="form-horizontal form-bordered">
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">NIP : </label>
                                    <label class="control-label col-md-10 p-5 text-muted text-left"><?php 
                                    $cls = ($pns['peg_nip'] == $sapk['nipBaru'])?1:0;
                                    echo $pns['peg_nip'] . ' / ' . $sapk['nipBaru'].$icons[$cls] ?></label>
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Nama : </label>
                                    <label class="control-label col-md-10 p-5 text-muted text-left"><?php
                                        $nama1 = trim($pns['pdk_gelardpn'] . ' ' . $pns['peg_nama'] . ' ' . $pns['pdk_gelarblkng']);
                                        $nama2 = trim($sapk['gelarDepan'] . ' ' . $sapk['nama'] . ' ' . $sapk['gelarBelakang']);
                                        $cls = ($nama1 == $nama2) ? 1 : 0;
                                        echo $nama1 . ' / ' . $nama2 . $icons[$cls];
                                        ?></label>
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Tempat, Tanggal Lahir: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?php
                                        $ttl1 = ucwords(strtolower($pns['peg_tempatlahir'])) . ', ' . $pns['peg_tgllahir'];
                                        $ttl2 = ucwords(strtolower($sapk['tempatLahir'])) . ', ' . $sapk['tglLahir'];
                                        $cls = ($ttl1 == $ttl2) ? 1 : 0;
                                        echo $ttl1 . ' / ' . $ttl2 . $icons[$cls];
                                        ?></label> 
                                    <label class="control-label col-md-2 p-5">Umur :</label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?php 
                                    $cls = ($umur == $sapk['umur'])?1:0;
                                    echo  $umur . ' / ' . $sapk['umur'].$icons[$cls] ?></label>
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Jenis kelamin:  </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?php 
                                    $cls = ($kelamin == $sapk['jenisKelamin'])?1:0;
                                    echo $kelamin . ' / ' . $sapk['jenisKelamin'].$icons[$cls] ?></label>
                                    <label class="control-label col-md-2 p-5">Gol. darah : </label>
                                    <label class="control-label col-md-3 p-5 text-muted text-left"><?= $pns['peg_darah'] ?></label>
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Agama: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?php 
                                    $cls = ($pns['peg_agama'] == $sapk['agama'])?1:0;
                                    echo $pns['peg_agama'] . ' / ' . $sapk['agama'].$icons[$cls] ?></label> 
                                    <label class="control-label col-md-2 p-5">Suku: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?= $pns['peg_suku'] ?></label>  
                                    <label class="control-label col-md-4 p-5 text-left"><?= ($pns['peg_isputradaerah'] == 't' ? '' : 'Bukan') . ' Putra Daerah'; ?></label> 
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Jenis Dokumen: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?php 
                                    $cls = ($pns['peg_jnsdok'] == $sapk['jenisIdDokumenNama'])?1:0;
                                    echo $pns['peg_jnsdok'] . ' / ' . $sapk['jenisIdDokumenNama'].$icons[$cls] ?></label> 
                                    <label class="control-label col-md-2 p-5">No Dokumen </label>
                                    <label class="control-label col-md-3 p-5 text-muted"><?php 
                                    $cls = ($pns['peg_nodok'] == $sapk['nomorIdDocument'])?1:0;
                                    echo $pns['peg_nodok'] . ' / ' . $sapk['nomorIdDocument'].$icons[$cls] ?></label> 
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Alamat: </label>
                                    <label class="control-label col-md-10 p-5 text-muted text-left"><?php 
                                    $cls = ($pns['peg_alamat'] == $sapk['alamat'])?1:0;
                                    echo $pns['peg_alamat'] . ' / ' . $sapk['alamat'].$icons[$cls] ?></label>  
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Kelurahan: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?= $pns['peg_kelurahan'] ?></label>  
                                    <label class="control-label col-md-2 p-5">Distrik: </label>
                                    <label class="control-label col-md-3 p-5 text-muted text-left"><?= $pns['peg_kecamatan'] ?></label> 
                                </div>
                                <div class="form-group m-b-5">
                                    <?php
                                    $hp = array($pns['peg_hp'], $pns['peg_telp']);
                                    $cls = ($pns['peg_hp'] == $sapk['noHp'] && $pns['peg_telp'] == $sapk['noTelp'])?1:0;
                                    ?>
                                    <label class="control-label col-md-2 p-5">No. Hp&nbsp;/&nbsp;Telp: </label>
                                    <label class="control-label col-md-2 p-5 text-muted text-left"><?= '(' . implode('&nbsp;/&nbsp;', $hp) . ')' . ' / (' . $sapk['noHp'] . '/ ' . $sapk['noTelp'] . ')'.$icons[$cls] ?></label>
                                    <label class="control-label col-md-2 p-5">Email: </label>
                                    <label class="control-label col-md-3 p-5 text-muted text-left"><?php 
                                    $cls = ($pns['peg_email'] == $sapk['email'])?1:0;
                                    echo $pns['peg_email'] . ' / ' . $sapk['email'].$icons[$cls] ?></label>
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="control-label col-md-2 p-5">Info penting: </label>
                                    <label class="control-label col-md-10 p-5 text-muted text-left"><i><?= $pns['peg_info'] ?></i></label>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '#btn-add,.btn-edit', function () {
        var b = $(this), i = b.find('i'), cls = i.attr('class');
        var param = '/' + b.attr('data-id');
        gAjax('', {
            url: '<?= base_url('profil/form_') ?>' + param,
            dataType: 'JSON',
            done: function (s) {
                if (s.sts !== 1) {
                    msgNotice(s.msg);
                    return false;
                }
                var mdl = $(s.mdl).modal({
                    backdrop: 'static',
                    keydrop: false
                }).on('hidden.bs.modal', function () {
                    $(this).remove();
                });
                mdl.find('#kode_cepat,#nama_jurusan').autocomplete({
                    source: function (request, response) {
                        var k = this.element.hasClass('kdcpt') ? 'kode' : 'jbtn';
                        $.getJSON('<?= base_url('pendidikan/keyword?k=') ?>' + k, request, function (data) {
                            response(data);
                        });
                    },
                    minlength: 2,
                    select: function (event, ui) {
                        $('#kode_cepat').val(ui.item.kode);
                        $('#nama_jurusan').val(ui.item.nama);
                        $('#tkt_pendidikan').val(ui.item.tkt);
                    }
                });
                mdl.find('#tgl_lahir').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true
                }).on('changeDate', function (e) {
                    var sp = this.value.split('-');
                    $('#thn_lulus').val(sp[2]);
                });
                mdl.find('.tanggal').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true
                });

                mdl.find('#foto').on('change', function () {
                    var prv = mdl.find('#preview');
                    readImg(this, prv);
                });
            }
        });
    }).on('click', '#btn-delete', function () {
        var b = $(this), i = b.find('i'), cls = i.attr('class');
        bootbox.confirm("Apakah anda akan menghapus data berikut?", function (vars) {
            if (vars) {
                gAjax('', {
                    url: '<?= base_url('profil/delete_') ?>/' + b.data('id'),
                    done: function (s) {
                        if (isJSON(s)) {
                            var ss = $.parseJSON(s);
                            if (ss.sts) {
                                msgSuccess(ss.msg);
                                setTimeout(function () {
                                    window.location.href = '<?= base_url('profil') ?>';
                                }, 1200);
                            } else {
                                msgAlert(ss.msg);
                            }
                        } else {
                            msgAlert('Terjadi kesalahan ketika parsing data');
                        }
                    }
                });
            }
        });
    }).on('submit', '#fo-mdl-profil', function (e) {
        e.preventDefault();
        var fo = $(this), fomd = new FormData(this);
        gAjax('', {
            url: '<?= base_url('profil/save_') ?>',
            data: fomd,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            done: function (s) {
                if (s.sts !== 1) {
                    msgAlert(s.msg);
                } else {
                    msgSuccess(s.msg);
                    setTimeout(function () {
                        fo.parents('.modal').modal('hide');
                        window.location.href = s.url;
                    }, 1000);
                }
                return false;
            }
        });
    });
</script>