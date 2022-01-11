<?php
$id_form = 'form-category';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Divisi</label>
                    <select class="form-control form-control-sm" name="id_division">
                        <option value="">- Pilih Divisi -</option>
                        <?php 
                        $divisions = $this->m->get_list_division();
                        foreach ($divisions as $v_divisi) {
                            $selected_division = $v_divisi->id == $data['id_division'] ? 'selected' : '';
                            ?>
                                <option value="<?= $v_divisi->id ?>" <?= $selected_division ?>><?= $v_divisi->nama ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Nama Category</label>
                    <input type="text" name="nama" value="<?= ucwords($data['nama']) ?>" id="nama" placeholder="Masukkan Nama" class="form-control form-control-sm">
                    <input type="hidden" name="nama_old" value="<?= ucwords($data['nama']) ?>">
                </div>
            </div>

            <hr>

            <button type="button" id="add-property-input" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> Tambah Property Bahan</button>

            <div id="container-property-input" class="mt-3">
                <!-- <div class="form-group">
                    <div class="form-line">
                        <label for="">Property Bahan</label>
                        <input type="text" name="property[]" value="" placeholder="Masukkan Property" class="form-control form-control-sm">
                    </div>
                </div> -->

                <?php 
                $properties = json_decode($data['property'], TRUE);
                $satuan = json_decode($data['satuan'], TRUE);
                foreach ($properties as $key => $property) {
                    ?>
                    <div class="form-group">
                        <div class="form-line">
                            <div class="row">
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="property[]" value="<?= ucwords($property) ?>" placeholder="Masukkan Property" class="form-control form-control-sm property" <?= $property == 'qty' ? 'disabled' : ''  ?>>
                                        </div>
                                        <div class="col-5">
                                            <input type="text" name="satuan[]" value="<?= ucwords($satuan[$key]) ?>" placeholder="Masukkan Satuan" class="form-control form-control-sm satuan">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-1">
                                            <?php if(in_array($property, $validation_arr)) : ?>
                                                <button type="button" class="sync-validation btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                            <?php else: ?>
                                                <button type="button" class="sync-validation btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if($property != 'qty') : ?>
                                                <button type="button" class="del-property-input btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <input type="hidden" name="validation" class="validation" id="validation" value="<?= $validation ?>">
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
$(document).ready(function(){

}).on('click', '.del-property-input', function() {
    $(this).parents('.form-group').remove()
})

$('#add-property-input').on('click', function() {
    let input_html = `<div class="form-group">
                        <div class="form-line">
                            <div class="row">
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="property[]" value="" placeholder="Masukkan Property" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-5">
                                            <input type="text" name="satuan[]" value="" placeholder="Masukkan Satuan" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-1">
                                            <button type="button" class="sync-validation btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                        </div>
                                        <div>
                                            <button type="button" class="del-property-input btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`
    
    $('#container-property-input').append(input_html)
})

$('form#<?= $id_form ?>').submit(function (event) {
    event.preventDefault()
    var form = $(this);
    var urlnya = $(this).attr("url");

    var formData = new FormData(this);

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