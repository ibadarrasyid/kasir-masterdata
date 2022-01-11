<?php
$id_form = 'simpancustomer';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Nama</label>
                    <input type="text" name="nama" value="<?= $data['nama'] ?>" id="nama" placeholder="Masukkan Nama" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">No HP</label>
                    <input type="text" name="nohp" value="<?= $data['nohp'] ?>" id="nohp" placeholder="Masukkan No HP" class="form-control form-control-sm">
                    <input type="hidden" name="nohp_old" value="<?= $data['nohp'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">No Kartu</label>
                    <input type="text" name="nokartu" value="<?= $data['nokartu'] ?>" id="nokartu" placeholder="Masukkan No Kartu" class="form-control form-control-sm">
                    <input type="hidden" name="nokartu_old" value="<?= $data['nokartu'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">Limit Customer</label>
                    <select class="form-control form-control-sm" id="id_limit_customer" name="id_limit_customer">
                        <?php 
                        $m_limit_customer = $this->m->get_limit_customer();
                        foreach ($m_limit_customer as $v_limit_customer) {
                            $selected_limit_customer = $data['id_limit_customer'] == $v_limit_customer->id ? 'selected' : '';
                            ?>
                                <option value="<?= $v_limit_customer->id ?>" <?= $selected_limit_customer ?>>Rp. <?= number_format($v_limit_customer->limit) ?> - tempo (<?= $v_limit_customer->tempo ?> hari)</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row clearfix">
        <div class="col-sm-12">

            <?php 
            $m_customer_type_division = get_customer_type_divison($data['id']);

            foreach ($m_customer_type_division as $v_division => $customer_type) {
                $arr_division = explode('#', $v_division);
                ?>
                <input type="hidden" name="division[]" value="<?= $arr_division[0] ?>">
                <div class="form-group">
                    <div class="form-line">
                        <label for=""><?= $arr_division[1] ?></label>
                        <select class="form-control form-control-sm" name="customer_type[]">
                            <?php 
                            foreach ($customer_type as $id_customer_type => $v_customer_type) {
                                $selected_customer_type = $v_customer_type['selected'] ? 'selected' : '';
                                ?>
                                    <option value="<?= $id_customer_type ?>" <?= $selected_customer_type ?>><?= $v_customer_type['nama_customer_type'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

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