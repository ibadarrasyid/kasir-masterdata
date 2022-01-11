<form action="javascript:void(0)" method="post" id="simpanlimitcustomer" url="<?= site_url("limit_customer/save"); ?>">
    <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">


    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">
                        Limit Angka 
                        <!-- <small class="text-warning">*KKM kelas mengambil referensi dari KKM Kompetensi Dasar pada mata pelajaran yang bersangkutan.</small> -->
                    </label>
                    <input type="text" name="limit" value="<?= rupiah_format($data['limit']) ?>" id="limit" data-symbol="Rp. " data-thousands="." data-decimal="," placeholder="Masukkan Jumlah Limit" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="form-line">
                    <label for="">
                        Jatuh Tempo (hari)
                        <!-- <small class="text-warning">*KKM kelas mengambil referensi dari KKM Kompetensi Dasar pada mata pelajaran yang bersangkutan.</small> -->
                    </label>
                    <input type="text" name="tempo" value="<?= $data['tempo'] ?>" id="tempo" placeholder="Masukkan Berapa Hari Jatuh Tempo" class="form-control form-control-sm">
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
$("#limit").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision : 0, allowZero : true})

// $(document).on('submit', 'form#simpanlimitcustomer', function (event) {
$('form#simpanlimitcustomer').submit(function (event) {
	event.preventDefault()
	var form = $(this);
	var urlnya = $(this).attr("url");

	var formData = new FormData(this);

    let limit = formData.get('limit').replace(/Rp|\s|[.,]/g, '')
    formData.set('limit', limit)

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
                console.log(response);

                if (response.sts == 1) {
                    msgSuccess(response.msg);

                    $('#defaultModal').modal('toggle');
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