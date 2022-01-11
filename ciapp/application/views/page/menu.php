<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?= base_url('dashboard') ?>">Home</a></li>
        <li><a href="javascript:;">Master</a></li>
        <li class="active">Menu</li>
    </ol>
    <h1 class="page-header">Menu</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
<!--                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>-->
                    </div>
                    <h4 class="panel-title">Menu</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-sm btn-primary" style="margin-bottom: 10px" id="addModal"><i class="fa fa-plus"></i> Tambah data</a>
                            <table id="dt_basic" class="table table-hover table-bordered table-condensed table-header-center">
                                <thead>
                                    <tr>
                                        <th style="width:1%" align="center"> No</th>
                                        <th style="width:25%"> Nama</th>
                                        <th style="width:10%"> Menu Class</th>
                                        <th style="width:10%"> Menu ID Tag </th>
                                        <th style="width:10%"> Menu href</th>
                                        <th style="width:10%"> Akses</th>
                                        <th style="width:14%"> *</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $datax;
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#addModal').click(function () {
            var b = $(this), i = b.find('i'), cls = i.attr('class');
            gAjax('', {
                url: '<?= base_url('menu/formMenu') ?>',
                done: function (s) {
                    if (isJSON(s)) {
                        var ss = $.parseJSON(s);
                        var mdl = $(ss.mdl);
                        mdl.find('#induk').trigger('change');
                        setSelect2(mdl.find('.chosen-select'));
                        mdl.modal({
                            backdrop: 'static',
                            keydrop: false
                        }).on('hidden.bs.modal', function () {
                            $(this).remove();
                        });
                    } else {
                        msgAlert('Terjadi kesalahan ketika parsing data');
                    }
                    i.removeClass().addClass(cls);
                    b.removeAttr('disabled');
                }
            });
        });        
    });

    function editData(a) {
        var b = $(a), i = b.find('i'), cls = i.attr('class'), id = b.attr('name');
        gAjax('', {
            url: '<?= base_url('menu/formMenu') ?>/' + id,
            done: function (s) {
                if (isJSON(s)) {
                    var ss = $.parseJSON(s);
                    var mdl = $(ss.mdl);
                    setSelect2(mdl.find('.chosen-select'));
                    mdl.modal({
                        backdrop: 'static',
                        keydrop: false
                    });
                } else {
                    msgAlert('Terjadi kesalahan ketika parsing data', 'Error Message');
                }
                i.removeClass().addClass(cls);
                b.removeAttr('disabled');
            }
        });
    }

    function changeParent(a) {
        var cb = $(a), i = cb.parent().next('i');
        i.removeClass().addClass('fa fa-spin fa-spinner');
        $.post('menu/getUrut/' + cb.val(), function (sd) {
            if (isJSON(sd)) {
                var ss = $.parseJSON(sd);
                cb.parents('form').find('input[name=urut]').val(ss.max);
            } else {
                msgAlert('Error Transfer data. Cek parameter', 'Warning Message');
            }
            i.removeClass();
        }).error(function () {
            msgAlert('Terjadi kesalahan. Cek Koneksi', 'Warning Message');
            i.removeClass();
        });
    }

    function saveMdl(a) {
        var b = $(a), i = b.find('i'), cls = i.attr('class'), msg = b.parent().find('span#msg');
        var form = b.parents('div.modal').find('#fo-addMenu');
        var dt = form.serializeArray();
        i.removeClass().addClass('fa fa-spin fa-spinner');
        $.post('menu/svData', dt, function (sd) {
            if (isJSON(sd)) {
                var ss = $.parseJSON(sd);
                if (ss.ind == 1) {
                    msg.msgHd(ss.msg, 1200);
                    window.location.reload();
                } else {
                    msgAlert(ss.msg);
                }
            } else {
                msgAlert('<font color="red">Error Transfer data. Cek parameter</font>', 2300);
            }
            i.removeClass().addClass(cls);
        }).error(function () {
            msgAlert('<font color="red">Terjadi kesalahan. Cek Koneksi</font>', 5000);
            i.removeClass().addClass(cls);
        });
    }

    function delData(a) {
        var b = $(a), i = b.find('i'), cls = i.attr('class'), mnu_id = b.attr('name');
        bootbox.confirm("Apakah anda akan menghapus data berikut ?", function (vars) {
            if (vars) {
                i.removeClass().addClass('fa fa-spin fa-spinner');
                $.get('menu/dlData/' + mnu_id, function (sd) {
                    if (isJSON(sd)) {
                        var ds = $.parseJSON(sd);
                        if (ds.ind == 1) {
                            window.location.reload();
                        } else {
                            msgAlert(ds.msg, 'Warning Message');
                        }
                    } else {
                        msgAlert('Error Transfer data. Cek parameter', 'Warning Message');
                    }
                    i.removeClass().addClass(cls);
                }).error(function () {
                    msgAlert('Terjadi kesalahan. Cek Koneksi', 'Error Message');
                    i.removeClass().addClass(cls);
                });
            }
        });
    }
</script>


