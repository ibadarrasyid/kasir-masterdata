<?php
$id_form = 'formBahan';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">
    <?php 
        $customer_type = $this->m->get_list_customer_type();
        foreach($customer_type as $v_customer_type) : 
    ?>
    <?php 
        if (isset($data['id'])) { ?>
        <?php if ($v_customer_type->id == $data['id_customer_type']) { ?>
            <!-- <input type="text" name="customer_type" value="<?= $v_customer_type->id ?>"> -->
        <?php } ?>
    <?php } else { ?>
        <!-- <input type="text" name="customer_type[]" value="<?= $v_customer_type->id ?>"> -->
    <?php } ?>
    <?php endforeach; ?>

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

            <div class="form-group">
                <div class="form-line">
                    <label for="">Harga</label>
                    <input type="text" name="harga" value="<?= rupiah_format($data['harga']) ?>" id="harga" placeholder="Masukkan Harga"  data-symbol="Rp. " data-thousands="." data-decimal="," class="form-control form-control-sm">
                </div>
            </div>

            <?php 
            // foreach ($customer_type as $v_customer_type) { 
            //     if (isset($data['id'])) {
            //         if ($v_customer_type->id == $data['id_customer_type']) { 
            //             ?>
            //             <!-- <div class="form-group">
            //                 <div class="form-line">
            //                     <label for="">Harga untuk <?= $v_customer_type->nama ?></label>
            //                     <input type="text" value="<?= $data['harga'] ?>" class="form-control form-control-sm harga" name="harga-<?= $v_customer_type->id ?>" data-symbol="Rp. " data-thousands="." data-decimal="," required min="1">
            //                 </div>
            //             </div> -->
            //             <?php
            //         }
            //     } else { 
            //         ?>
            //         <!-- <div class="form-group">
            //             <div class="form-line">
            //                 <label for="">Harga untuk <?= $v_customer_type->nama ?></label>
            //                 <input type="text" value="<?= $data['harga'] ?>" class="form-control form-control-sm harga" name="harga-<?= $v_customer_type->id ?>" data-symbol="Rp. " data-thousands="." data-decimal="," required min="1">
            //             </div>
            //         </div> -->
            //         <?php 
            //     }
            // } 
            ?>
        
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
            <div id="container-category-property-hidden"></div>
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

var temp_category_property_hidden_value_json = '<?= $data['hidden_property'] ?>'
var temp_category_property_hidden_value = !temp_category_property_hidden_value_json ? {} : JSON.parse('<?= $data['hidden_property'] ?>')

function generate_form(category_property, property_value, required = ``, value = `property_value`, name = `property_nama`) {
    if(category_property == 'qty') return ``
    return `<div class="form-group">
                <div class="form-line">
                    <label for="">${titleCase(category_property.replace(/_/g, " "))}</label>
                    <input type="text" name="${value}[]" value="${property_value}" placeholder="Nilai ${titleCase(category_property.replace(/_/g, " "))}" class="form-control form-control-sm" ${required}>
                    <input type="hidden" name="${name}[]" value="${category_property}">
                </div>
            </div>`
}

$(".harga").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision : 0, allowZero : true})

$(document).ready(function() {
    $('#id_category').trigger('change')
});

$('#id_category').on('change', function() {
    $("#aksimodal").hide();
    $("#loadingmodal").show();

    if (!$(this).val()) {
        $('#container-category-property').html('')
    } else {
        $.ajax({
            url: "<?= $url_controller ?>/get_category_property/" + $(this).val(),
            dataType: "json"
        }).done(function(response) {
            let form_category_property = ``
            $.each(response, function( index, category_property ) {
                let property_value = temp_category_property_value[category_property]
                let get_property_value = temp_category_property_value[category_property] === undefined ? '' : property_value
                form_category_property += generate_form(category_property, get_property_value, 'required')
            });
            $('#container-category-property').html(form_category_property)
        });

        $.ajax({
            url: "<?= $url_controller ?>/get_category_property_hidden/" + $(this).val(),
            dataType: "json"
        }).done(function(response) {
            let form_category_property = ``
            $.each(response, function( index, category_property ) {
                // Gak muncul"
                let property_value = temp_category_property_hidden_value[category_property]
                let get_property_value = temp_category_property_hidden_value[category_property] === undefined ? '' : property_value
                form_category_property += generate_form(category_property, get_property_value, ``, `property_hidden_value`, `property_hidden_nama`)
            });
            $('#container-category-property-hidden').html(form_category_property)
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

    let fieldHarga = $('.harga')
    $.each(fieldHarga, (index, element) => {
        let harga = $(element).val()
        let newHarga = harga.replace(/Rp|\s|[.,]/g, '')
        formData.set($(element).attr('name'), newHarga)
    });


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