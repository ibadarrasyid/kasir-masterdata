<!-- ================== BEGIN BASE JS ================== -->
<script src="<?= config_item('plugin') ?>bootstrap/bootstrap.min.js"></script>
<script src="<?= config_item('plugin') ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= config_item('plugin') ?>datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?= config_item('plugin') ?>datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?= config_item('plugin') ?>datatables/responsive/js/dataTables.responsive.min.js"></script>
<!--[if lt IE 9]>
        <script src="assets/crossbrowserjs/html5shiv.js"></script>
        <script src="assets/crossbrowserjs/respond.min.js"></script>
        <script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?= config_item('plugin') ?>jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?= config_item('js') ?>app.config.js"></script>
<script src="<?= config_item('js') ?>app.min.js"></script>
<script src="<?= config_item('js') ?>gmsPlugin.js"></script>
<script src="<?= config_item('plugin') ?>notification/bootbox.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<?php
if (isset($jscript)) {
    foreach ($jscript as $js) {
        echo '<script src="' . $js . '.js"></script>';
    }
}
?>
<script>
    $(document).ready(function () {
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        pageSetUp();
        
        $('.tooltips').tooltip({placement: 'right'});
        $('li.active').parents('li').addClass('active');
    }).on('click', '#btn-chprofil', function () {
        var b = $(this), i = b.find('i'), cls = i.attr('class');
        gAjax('', {
            url: '<?= base_url('Login/modalprofil_') ?>',
            done: function (s) {
                if (isJSON(s)) {
                    var ss = $.parseJSON(s);
                    if (ss.sts == 0) {
                        msgAlert(ss.msg);
                        return true;
                    }
                    var mdl = $(ss.mdl);
                    mdl.modal({
                        backdrop: 'static',
                        keydrop: false
                    }).on('hidden.bs.modal', function () {
                        $(this).remove();
                    }).on('change', '#foto', function () {
                        readImg(this, mdl.find('#preview'));
                    }).on('submit', '#fo-mdlprofiluser', function (e) {
                        e.preventDefault();
                        var frm = $(this);
                        var dt = new FormData(frm[0]); 
                        gAjax('', {
                            contentType: false,
                            processData: false,
                            data: dt,
                            url: '<?= base_url('Login/saveprofil_') ?>',
                            done: function (r) {
                                if (isJSON(r)) {
                                    var rr = $.parseJSON(r);
                                    if (rr.sts == 1) {
                                        msgSuccess(rr.msg);
                                        mdl.modal('hide');
                                        setTimeout(function(){
                                            window.location.reload();
                                        },1000);
                                    } else {
                                        msgAlert(rr.msg);
                                    }
                                }
                            }
                        });
                    });
                } else {
                    msgAlert('Terjadi kesalahan ketika parsing data');
                }
                i.removeClass().addClass(cls);
                b.removeAttr('disabled');
            }
        });
    });
</script>
<script>
    $(document).on('focus', function () {
        $.get('login/isStillLogin', function (s) {
            if (s === 'out') {
                window.location.reload();
            }
        });
    });

</script>
<div id="divOverlay" class="hidden"><img style="position: fixed;top: 0;right: 0;bottom: 0;left:0;margin: auto;z-index: 9999" src="<?= config_item('assets') ?>img/spinner.svg" /></div>
</body>
</html>
