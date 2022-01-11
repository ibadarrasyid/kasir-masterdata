<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Perangkat Daerah</a></li>
        <li class="active">User</li>
    </ol>
    <h1 class="page-header">User</h1>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <ul class="nav nav-pills">
                <li class="active"><a href="#nav-admin" data-toggle="tab">Admin</a></li>
                <li><a href="#nav-pns" data-toggle="tab">PNS</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="nav-admin">
                    <h3 class="m-t-10">Form</h3>
                    <div class="col-md-6">
                        <form id="fo-admin" class="form-horizontal">
                            <input autocomplete="off" value="" id="id" name="id" class="form-control" type="hidden">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="username" name="username" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="pass" name="pass" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Level</label>
                                <div class="col-md-8">
                                    <select class="form-control input-sm" id="level" name="level">
                                        <option value="">-Pilih Level-</option>
                                        <option value="0">Admin</option>
                                        <option value="1">Sub Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <a id="btn-reset" class="btn btn-default btn-sm">Batal</a>
                                    <button id="btn-save" type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <h3 class="m-t-10">Daftar User</h3>
                    <table id="dt_admin" class="table table-hover table-bordered table-condensed table-header-center">
                        <thead>
                            <tr>
                                <th style="width:3%">No</th>
                                <th style="width:20%">Username</th>
                                <th style="width:20%">Password</th>
                                <th style="width:20%">Level</th>
                                <th style="width:10%">CRUD</th>
                                <th style="width:10%">Update</th>
                                <th style="width:12%">*</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $tbodyadm ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="nav-pns">
                    <h3 class="m-t-10">Form</h3>
                    <div class="col-md-6">
                        <form id="fo-pns" class="form-horizontal">
                            <input autocomplete="off" value="" id="id" name="id" class="form-control input-sm" type="hidden">
                            <div class="form-group">
                                <label class="col-md-4 control-label">NIP</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="nip" readonly="" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Pegawai</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="nama" readonly="" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="username" name="username" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-8">
                                    <input autocomplete="off" value="" id="pass" name="pass" class="form-control input-sm" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <a id="btn-reset" class="btn btn-default btn-sm">Batal</a>
                                    <button id="btn-save" disabled="" type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <h3 class="m-t-10">Daftar User PNS</h3>
                    <table id="dt_pns" class="table table-hover table-bordered table-condensed table-header-center">
                        <thead>
                            <tr>
                                <th style="width:3%">No</th>
                                <th style="width:40%">PNS</th>
                                <th style="width:20%">Username</th>
                                <th style="width:20%">Password</th>
                                <th style="width:12%">*</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $tbodypns ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setTable('#dt_admin');
        setTable('#dt_pns');
        $('#fo-admin').submit(function (e) {
            e.preventDefault();
            var form = $(this), dt = form.serializeArray();
            var b = form.find('#btn-save'), i = b.find('i'), cls = i.attr('class');
            gAjax('', {
                url: '<?= base_url('User/saveadmin_') ?>',
                data: dt,
                done: function (s) {
                    if (isJSON(s)) {
                        var ss = $.parseJSON(s);
                        if (ss.sts) {
                            msgSuccess(ss.msg);
                            refreshTable('#dt_admin', ss.tbody);
                            form.find('#btn-reset').trigger('click');
                        } else {
                            msgAlert(ss.msg);
                        }
                    } else {
                        msgAlert('Terjadi kesalahan ketika parsing data');
                    }
                    i.removeClass().addClass(cls);
                    b.removeAttr('disabled');
                }
            });
        });
        $('#fo-pns').submit(function (e) {
            e.preventDefault();
            var form = $(this), dt = form.serializeArray();
            var b = form.find('#btn-save'), i = b.find('i'), cls = i.attr('class');
            if (b.is(':disabled')) {
                return true;
            }
            gAjax('', {
                url: '<?= base_url('User/save_') ?>',
                data: dt,
                done: function (s) {
                    if (isJSON(s)) {
                        var ss = $.parseJSON(s);
                        if (ss.sts) {
                            msgSuccess(ss.msg);
                            refreshTable('#dt_pns', ss.tbody);
                            form.find('#btn-reset').trigger('click');
                        } else {
                            msgAlert(ss.msg);
                            b.removeAttr('disabled');
                        }
                    } else {
                        msgAlert('Terjadi kesalahan ketika parsing data');
                        b.removeAttr('disabled');
                    }
                    i.removeClass().addClass(cls);
                }
            });
        });
    }).on('submit', '#fo-mdl-menuakses', function (e) {
        e.preventDefault();
        var f = $(this), dt = f.serializeArray();
        gAjax('', {
            data: dt,
            url: '<?= base_url('User/saveAccesSubAdmin') ?>',
            dataType: 'JSON',
            done: function (s) {
                if(s.ind == 1){
                    msgSuccess(s.msg);
                    f.parents('.modal').modal('hide');
                }else{
                    msgAlert(s.msg);
                }
            }
        });
    }).on('click', '.cbk-privilages', function () {
        var c = $(this), inp = c.parents('tr:first').find(':input[type="checkbox"]'), id = c.data('id');
        var data = new FormData();
        data.append('id', id);
        if (inp[0].checked === true) {
            data.append('inp[0]', inp[0].value);
        }
        if (inp[1].checked === true) {
            data.append('inp[1]', inp[1].value);
        }
        gAjax('', {
            contentType: false,
            processData: false,
            url: '<?= base_url('User/savePrivilages') ?>',
            data: data,
            done: function (s) {
            }
        });
    }).on('click', '#btn-listMenu', function (e) {
        e.preventDefault();
        var b = $(this);
        gAjax('', {
            url: b.attr('href'),
            done: function (s) {
                if (isJSON(s)) {
                    var ss = $.parseJSON(s);
                    var mdl = $(ss.mdl);
                    mdl.find('div.modal-body').css({
                        'max-height': '350px',
                        'overflow-y': 'auto'
                    });
                    var mm = mdl.modal({
                        backdrop: 'static',
                        keydrop: false
                    }).on('hidden.bs.modal', function () {
                        $(this).remove();
                    }).on('shown.bs.modal', function () {

                    });
                } else {
                    msgAlert('Terjadi kesalahan ketika parsing data');
                }
            }
        });
    }).on('click', '#btn-reset', function () {
        var form = $(this).parents('form:first');
        form.find('.form-control').val('');
        if (form.attr('id') == 'fo-pns') {
            form.find('#btn-save').prop('disabled', true);
        }
    }).on('click', '#btn-edit', function () {
        var b = $(this), i = b.find('i'), cls = i.attr('class');
        gAjax('', {
            url: '<?= base_url('User/edit_') ?>/' + b.data('level') + '/' + b.data('id'),
            done: function (s) {
                if (isJSON(s)) {
                    var ss = $.parseJSON(s);
                    var form = $('#fo-' + b.data('level'));
                    if (b.data('level') == 'admin') {
                        form.find('#id').val(ss.as_user_id);
                        form.find('#username').val(ss.as_username);
                        form.find('#pass').val(ss.as_password);
                        form.find('#level').val(ss.as_type);
                    } else {
                        form.find('#id').val(ss.peg_id);
                        form.find('#nip').val(ss.peg_nip);
                        form.find('#nama').val(ss.peg_nama);
                        form.find('#username').val(ss.peg_username);
                        form.find('#pass').val(ss.peg_password);
                        form.find('#btn-save').prop('disabled', false);
                    }
                } else {
                    msgAlert('Terjadi kesalahan ketika parsing data');
                }
                i.removeClass().addClass(cls);
                b.removeAttr('disabled');
            }
        });
    }).on('click', '.ceksubmenu', function () {
        cekFromChild(this);
    }).on('click', '#btn-delete', function () {
        var b = $(this), i = b.find('i'), cls = i.attr('class');
        bootbox.confirm("Apakah anda akan menghapus data berikut?", function (vars) {
            if (vars) {
                gAjax('', {
                    url: '<?= base_url('User/delete_') ?>/' + b.data('level') + '/' + b.data('id'),
                    done: function (s) {
                        if (isJSON(s)) {
                            var ss = $.parseJSON(s);
                            if (ss.sts) {
                                msgSuccess(ss.msg);
                                refreshTable('#dt_' + b.data('level'), ss.tbody);
                                $('#fo-' + b.data('level')).find('#btn-reset').trigger('click');
                            } else {
                                msgAlert(ss.msg);
                            }
                        } else {
                            msgAlert('Terjadi kesalahan ketika parsing data');
                        }
                        i.removeClass().addClass(cls);
                        b.removeAttr('disabled');
                    }
                });
            }
        });
    });
    function cekFromChild(a) {
        var ck = $(a), idparent = ck.data('parent'), elParent = $('.ceksubmenu[value="' + idparent + '"]');
        setColor(ck);
        if (!ck.is(':checked') && $('.cekParent' + ck.val()).length > 0) {
            $('.cekParent' + ck.val()).each(function () {
                $(this).prop('checked', false);
                setColor($(this));
            });
        }
        if (elParent.length > 0) {
            elParent.prop('checked', ck.prop('checked'));
            if (!ck.is(':checked') && ($('.cekParent' + idparent + ':checked').length > 0)) {
                elParent.prop('checked', true);
            }
            setColor(elParent);
        }
    }

    function setColor(ck) {
        if (ck.is(':checked')) {
            ck.parent().css('background-color', 'powderblue');
        } else {
            ck.parent().css('background-color', '');
        }
    }
</script>