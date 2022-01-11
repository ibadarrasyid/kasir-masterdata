<?php
$id_form = 'formBahanFinishing';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Nama</label>
                    <input type="text" name="nama" value="<?= ucwords($data['nama']) ?>" id="nama" placeholder="Masukkan Nama" class="form-control form-control-sm">
                    <input type="hidden" name="nama_old" value="<?= ucwords($data['nama']) ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Harga</label>
                    <input type="text" name="harga" value="<?= rupiah_format($data['harga']) ?>" id="harga" placeholder="Masukkan Harga"  data-symbol="Rp. " data-thousands="." data-decimal="," class="form-control form-control-sm">
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Customer Type</label>
                    <select class="form-control form-control-sm" name="id_customer_type">
                        <option value="">- Pilih Customer Type -</option>
                        <?php 
                        $customer_type = $this->m->get_list_customer_type();
                        foreach ($customer_type as $v_customer_type) {
                            $selected_division = $v_customer_type->id == $data['id_customer_type'] ? 'selected' : '';
                            ?>
                                <option value="<?= $v_customer_type->id ?>" <?= $selected_division ?>><?= $v_customer_type->nama ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Category</label>
                    <select class="form-control form-control-sm" id="id_category" name="id_category">
                        <option value="">- Pilih Category -</option>
                        <?php 
                        $categories = $this->m->get_list_category();
                        foreach ($categories as $category) {
                            $selected_division = $category->id == $data['id_category'] ? 'selected' : '';
                            ?>
                                <option value="<?= $category->id ?>" <?= $selected_division ?>><?= $category->nama ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div id="container-category-property">
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Rumus</label>

                    <div class="mb-2">
                        <input type="button" value="(" class="operator btn btn-primary btn-sm">
                        <input type="button" value=")" class="operator btn btn-primary btn-sm">
                        <input type="button" value="*" class="operator btn btn-primary btn-sm">
                        <input type="button" value="/" class="operator btn btn-primary btn-sm">
                        <input type="button" value="+" class="operator btn btn-primary btn-sm">
                        <input type="button" value="-" class="operator btn btn-primary btn-sm">
                        <input type="button" value="C" class="operator btn btn-primary btn-sm">
                    </div>

                    <input type="text" name="formula" value="<?= $data['formula'] ?>" id="formula" placeholder="Masukkan Rumus" class="form-control form-control-sm">
                    <input type="hidden" name="formula_old" id="formula_old" value="<?= $data['formula'] ?>">
                    <input type="hidden" name="id_category_old" id="id_category_old" value="<?= $data['id_category'] ?>">
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

var temp_category_property_value_json = '<?= $data['property'] ?>'
var temp_category_property_value = !temp_category_property_value_json ? {} : JSON.parse('<?= $data['property'] ?>')

function generate_form(category_property, property_value) {
    return `<div class="form-group">
                <div class="form-line">
                    <i data-property="${category_property}" class="add-to-rumus fas fa-arrow-circle-down text-success" style="cursor: pointer; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="Tambahkan Property pada Rumus"></i>
                    <label for="">${titleCase(category_property)}</label>
                    <input type="text" name="property_value[]" value="${property_value}" placeholder="Nilai ${titleCase(category_property)}" class="form-control form-control-sm" required>
                    <input type="hidden" name="property_nama[]" value="${category_property}">
                </div>
            </div>`
}

$("#harga").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision : 0, allowZero : true})

$(document).ready(function() {
    $('#id_category').trigger('change')
});

$('form#<?= $id_form ?>')
    .on('click', '.add-to-rumus', function() {
        let property = '[' + $(this).data('property') + ']';
        let formula = $('form#<?= $id_form ?>').find('#formula').val();
        $('form#<?= $id_form ?>').find('#formula').val(formula + property);
    }).on('click', '.operator', function () {
        var operasi = $(this).val();
        if (operasi === 'C') {
            $('form#<?= $id_form ?>').find('#formula').val('');
        } else {
            var formula = $('form#<?= $id_form ?>').find('#formula').val();
            $('form#<?= $id_form ?>').find('#formula').val(formula + operasi);
        }
    });

$('#id_category').on('change', function() {
    $("#aksimodal").hide();
    $("#loadingmodal").show();

    if ($(this).val() == $('#id_category_old').val()) {
        $('#formula').val($('#formula_old').val())
    }

    if (!$(this).val()) {
        $('#container-category-property').html('')
        $('#formula').val('')
    } else {
        $.ajax({
            url: "<?= $url_controller ?>/get_category_property/" + $(this).val(),
            dataType: "json"
        }).done(function(response) {
            let form_category_property = ``
            $.each(response, function( index, category_property ) {
                let property_value = temp_category_property_value[category_property]
                let get_property_value = temp_category_property_value[category_property] === undefined ? '' : property_value
                form_category_property += generate_form(category_property, get_property_value)
            });
            $('#container-category-property').html(form_category_property)
        });
    }

    $("#aksimodal").show();
    $("#loadingmodal").hide();
})

$('form#<?= $id_form ?>').submit(function (event) {
    event.preventDefault()
    var form = $(this);
    var urlnya = $(this).attr("url");

    var formData = new FormData(this);

    let harga = formData.get('harga').replace(/Rp|\s|[.,]/g, '')
    formData.set('harga', harga)

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