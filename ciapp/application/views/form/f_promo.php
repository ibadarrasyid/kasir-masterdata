<?php
$id_form = 'form-master-promo';

$status = '';
if (isset($data['status'])) {
    if ($data['status'] == 'yes') {
        $status = 'checked';
    }
} else {
    $status = 'checked';
}
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="">Aktif</label>
                            <br>
                            <label class="custom-toggle">
                                <input type="checkbox" <?= $status ?> name="status" value="yes">
                                <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Ya"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label for="">Nama</label>
                            <input type="text" name="nama" value="<?= ucwords($data['nama']) ?>" id="nama" placeholder="Masukkan Nama" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label for="">Kode</label>
                            <input type="text" name="kode" value="<?= strtoupper($data['kode']) ?>" id="kode" placeholder="Masukkan Kode" class="form-control form-control-sm">
                            <input type="hidden" name="kode_old" value="<?= strtoupper($data['kode']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Diskon</label>

                                <div class="input-group input-group-sm">
                                    <input type="text" name="diskon" value="<?= $data['diskon'] ?>" id="diskon" placeholder="Prosentase Diskon" class="form-control form-control-sm">

                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="">Diskon Maks</label>
                                    <input type="text" name="diskon_maks" value="<?= rupiah_format($data['diskon_maks']) ?>" id="diskon_maks" data-symbol="Rp. " data-thousands="." data-decimal="," placeholder="Nilai Diskon Maksimal" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Tanggal Expired</label>

                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input name="expired" id="expired" class="form-control form-control-sm" placeholder="Pilih Tanggal Expired" type="date" value="<?= isset($data['expired']) ? date('Y-m-d', strtotime($data['expired'])) : date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Pilih Divisi : </h4>

                    <div class="form-group">
                        <?php 
                        $no_divison = 1;
                        $list_division_checkbox = get_promo_divison($data['id']);
                        foreach ($list_division_checkbox as $division) {
                            $checked = $division['checked'] ? 'checked' : '';
                            ?>
                            <div class="custom-control custom-checkbox mb-2">
                                <input id="noDivision<?= $no_divison ?>" name="id_division[]" value="<?= $division['id_division'] ?>" <?= $checked ?> class="custom-control-input" type="checkbox">
                                <label class="custom-control-label" for="noDivision<?= $no_divison ?>"><?= $division['nama'] ?></label>
                            </div>
                            <?php
                            $no_divison++;
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br>

    <div class=" " id="aksimodal">
        <center>
            <button type="submit" class="btn btn-primary btn-sm ">
                <i class="fa fa-save"></i>
                <span>Simpan Data </span>
            </button>
            <button type="reset" class="btn btn-danger  btn-sm">
                <span>Reset </span>
            </button>
            <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">
                <span>Tutup </span>
            </button>
        </center>
    </div>

    <div class="row clearfix" id="loadingmodal" style="display:none">
        <center>
            <div class="preloader pl-size-md">
                <div class="spinner-layer pl-red-grey">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div> <br> Data sedang disimpan, Mohon Tunggu ...
        </center>
    </div>
</form>

<script>
// $('#expired').datepicker({
//     format:'dd-mm-yyyy'
// });

$('#kode').keyup(function(){
    $(this).val($(this).val().toUpperCase());
});

$("#diskon_maks").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision : 0, allowZero : true})

$('form#<?= $id_form ?>').submit(function (event) {
    event.preventDefault()
    var form = $(this);
    var urlnya = $(this).attr("url");

    var formData = new FormData(this);

    let diskon_maks = formData.get('diskon_maks').replace(/Rp|\s|[.,]/g, '')
    formData.set('diskon_maks', diskon_maks)

    $("#aksimodal").hide();
    $("#loadingmodal").show();
    myAjax({
        type: "POST",
        url: urlnya,
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (json, status, xhr) {
            var ct = xhr.getResponseHeader("content-type") || "";
            if (ct == "application/json") {
                let response = JSON.parse(json);

                if (response.sts == 1) {
                    msgSuccess(response.msg);

                    $('#defaultModal').modal('hide');
                    refreshDataTableServerSide(dataTable);
                } else if (response.sts == 2) {
                    msgWarning(response.msg);
                } else {
                    msgAlert(response.msg);
                }
            } else {
                msgAlert('Terjadi Kesalahan Ketikan Menyimpan pada Server');
            }

            $("#aksimodal").show();
            $("#loadingmodal").hide();
        }
    });
});
</script>