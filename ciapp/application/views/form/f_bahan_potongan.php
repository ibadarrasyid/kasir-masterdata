<?php
$id_form = 'form-potongan-bahan';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">

    <div class="row clearfix">
        <div class="col-sm-12">

            <div class="form-group">
                <div class="form-line">
                    <label for="">Bahan</label>
                    <select class="form-control form-control-sm" name="id_bahan">
                        <option value="">- Pilih Bahan -</option>
                        <?php 
                        $list_bahan = $this->m->get_list_bahan();
                        foreach ($list_bahan as $v_bahan) {
                            $selected_bahan = $v_bahan->id == $data['id_bahan'] ? 'selected' : '';
                            ?>
                                <option value="<?= $v_bahan->id ?>" <?= $selected_bahan ?>><?=  $v_bahan->nama ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="">Batas Bawah</label>
                            <input type="text" name="batas_bawah" value="<?= ucwords($data['batas_bawah']) ?>" id="batas_bawah" placeholder="Masukkan Batas Bawah" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="">Batas Atas</label>
                            <input type="text" name="batas_atas" value="<?= ucwords($data['batas_atas']) ?>" id="batas_atas" placeholder="Masukkan Batas Atas" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Potongan Harga</label>
                    <input type="text" name="potongan_harga" value="<?= rupiah_format($data['potongan_harga']) ?>" id="potongan_harga" data-symbol="Rp. " data-thousands="." data-decimal="," placeholder="Masukkan Potongan Harga" class="form-control form-control-sm">
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
$("#potongan_harga").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision : 0, allowZero : true})

$('form#<?= $id_form ?>').submit(function (event) {
    event.preventDefault()
    var form = $(this);
    var urlnya = $(this).attr("url");

    var formData = new FormData(this);

    let potongan_harga = formData.get('potongan_harga').replace(/Rp|\s|[.,]/g, '')
    formData.set('potongan_harga', potongan_harga)

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