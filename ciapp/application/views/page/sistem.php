<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Dashboard</a></li>
        <li class="active">Sistem</li>
    </ol>
    <h1 class="page-header">Info Sistem</h1>
    <div class="row">
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                <div class="panel-heading p-0">
                    <div class="panel-heading-btn m-r-10 m-t-10">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <!-- begin nav-tabs -->
                    <div class="tab-overflow">
                        <ul class="nav nav-tabs nav-tabs-inverse">
                            <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                            <li class="active"><a href="#nav-tab-1" data-toggle="tab">Info</a></li>
                            <li class=""><a href="#nav-tab-2" data-toggle="tab">Modul</a></li>
                            <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-tab-1">
                        <form id="form-info" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <div class="form-group text-center">
                                        <label style="margin-bottom: 10px;">Logo Daerah</label>
                                        <div>
                                            <img style="height: 160px; margin-bottom: 10px;display: inline;" class="thumbnail" src="<?= config_item('img') . 'app/' . $logo ?>" id="preview"><br>
                                            <input type="file" name="logo" id="logo" class="btn btn-default" style="margin-left: 10%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-md-4">Kota/Kabupaten</label>
                                        <div class="col-md-4">
                                            <select id="kota" class="form-control" name="kota">
                                                <?= $kotaoption ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Nama Daerah</label>
                                        <div class="col-md-8">
                                            <input id="nama" class="form-control" name="nama" value="<?= $nama ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Nama Kepala Daerah</label>
                                        <div class="col-md-8">
                                            <input id="kepaladaerah" class="form-control" name="kepaladaerah" value="<?= $kepalaDaerah ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Nama Wakil Kepala Daerah</label>
                                        <div class="col-md-8">
                                            <input id="nm_wakil" class="form-control" name="nm_wakil" value="<?= $namawakil ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Nama Sekretaris Daerah</label>
                                        <div class="col-md-8">
                                            <input id="nm_sekda" class="form-control" name="nm_sekda" value="<?= $namasekda ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Telp</label>
                                        <div class="col-md-8">
                                            <input id="nomer" class="form-control" name="nomer" value="<?= $nomer ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Email</label>
                                        <div class="col-md-8">
                                            <input id="email" class="form-control" name="email" value="<?= $email ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">Alamat</label>
                                        <div class="col-md-8">
                                            <textarea id="alamat" class="form-control" name="alamat"><?= $alamat ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">OPD</label>
                                        <div class="col-md-8">
                                            <select id="skpd" class="form-control" name="skpd"> 
                                                <?= $skpda ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button class="btn btn-sm btn-primary pull-right" type="submit" ><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-tab-2">
                        <h3 class="m-t-10">Nav Tab 2</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor, 
                            est diam sagittis orci, a ornare nisi quam elementum tortor. 
                            Proin interdum ante porta est convallis dapibus dictum in nibh. 
                            Aenean quis massa congue metus mollis fermentum eget et tellus. 
                            Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien, 
                            nec eleifend orci eros id lectus.
                        </p>
                        <p>
                            Aenean eget odio eu justo mollis consectetur non quis enim. 
                            Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet. 
                            Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula, 
                            at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                            Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum. 
                            Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat. 
                            Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form-info').on('submit', function (e) {
            e.preventDefault();
            var frm = $(this);
            var dt = new FormData();
            var skpd = $('#skpd').find('option:selected');
            var nm_daerah = frm.find('input[name=nama]').val();
            dt.append('detail[kota]', frm.find('select[name=kota]').val());
            dt.append('detail[nama]', nm_daerah.toUpperCase());
            dt.append('detail[skpd]', skpd.data('nama'));
            dt.append('detail[idskpd]', skpd.val());
            dt.append('detail[alamat]', frm.find('textarea[name=alamat]').val());
            dt.append('detail[nomer]', frm.find('input[name=nomer]').val());
            dt.append('detail[email]', frm.find('input[name=email]').val());
            dt.append('detail[kepalaDaerah]', frm.find('input[name=kepaladaerah]').val());
            dt.append('detail[namawakil]', frm.find('input[name=nm_wakil]').val());
            dt.append('detail[namasekda]', frm.find('input[name=nm_sekda]').val());
            dt.append('imgFile', frm.find('#logo')[0].files[0]);
            gAjax('', {
                contentType: false,
                processData: false,
                data: dt,
                url: '<?= base_url('Sistem/save_info') ?>',
                done: function (s) {
                    if (isJSON(s)) {
                        var ss = $.parseJSON(s);
                        if (ss.ind == 1) {
                            msgSuccess(ss.msg);
                        } else {
                            msgAlert(ss.msg);
                        }
                    }
                }
            });
        });
    });
</script>