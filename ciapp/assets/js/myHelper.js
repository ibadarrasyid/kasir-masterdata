function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        // You do not need to check if i is larger than splitStr length, as your for does that for you
        // Assign it back to the array
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
    }
    // Directly return the joined string
    return splitStr.join(' '); 
}

// =============================================================================


$(document).off("click", ".addmodal").on("click", ".addmodal", function () {
	var target = $(this).attr("target");
	$(target).html('<center><br> Mohon Tunggu ...</center>');

	var url = $(this).attr("url");

	$.post(url, function (data) {
		$(target).html(data);
	})
})

$(document).off("click", ".ubahmodal").on("click", ".ubahmodal", function () {
	var target = $(this).attr("target");
	$(target).html('<center><br> Mohon Tunggu ...</center>');

	var url = $(this).attr("urlnya");
	var id = $(this).attr("datanya");

	$.post(url, {
		id: id
	}, function (data) {
		$(target).html(data);
	})
})

// =============================================================================

/**
* For upload file should add have these property
processData: false,
contentType: false,
* @param array pilihan type, url, proccessData:false,contentType:false,dtType:'text',async:false,done,beforeSend,errMsg
* @returns {gAjax}
*/
var myAjax = function (option) {
	var setting = $.extend({
		type: 'POST',
		url: '',
		dataType: 'text',
		async: false,
		data: {},
		done: function (ss) {
			return true;
		},
		beforeSend: function () {

		},
		error: function (e) {
			msgAlert('Error Message', 'Terjadi kesalahan, ' + e.status + ' : ' + e.statusText);
		}
	}, option);
	$.ajax({
		url: setting.url,
		dataType: setting.dataType,
		type: setting.type,
		beforeSend: setting.beforeSend,
		processData: setting.processData,
		contentType: setting.contentType,
		success: setting.success,
		data: setting.data,
		async: setting.async,
		error: setting.error
	})
	// .always(function () {

	// });
	return false;
};

// =============================================================================

var settingToastr = {
	"timeOut": "0",
	"extendedTImeout": "0",
	"closeButton": true,
	"debug": false,
	"positionClass": "toast-top-right",
	"onclick": null,
	"showDuration": "1000",
	"hideDuration": "1000",
	"timeOut": "2000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
}

var msgAlert = function (text) {
	toastr.error(text, "Gagal, perhatikan!!", settingToastr);
}

var msgSuccess = function (text) {
	toastr.success(text, "Sukses!!", settingToastr);
}

var msgWarning = function (text) {
	toastr.warning(text, "Perhatian!!", settingToastr);
}

var confirmSweetAlert = function (text, action_confirm, action = 'hapus') {
	Swal.fire({
		title: 'Perhatikan !',
		text: text,
		icon: 'warning',
		showCancelButton: true,
		cancelButtonColor: '#d33',
		cancelButtonText : 'Batal',
		confirmButtonColor: '#3085d6',
		confirmButtonText: action == 'hapus' ? 'Ya, Hapus!' : 'Ya, Keluar!'
	}).then((result) => {
		if (result.value) {
			action_confirm()
		}
		// if (result.isConfirmed) {
		// 	action_confirm()
		// }
	})
}

// =============================================================================

var generateDataTableServerSide = function (obj_table, option) {
	var config = $.extend({
		"processing": true,
		"language": {
			"processing": '<div class="preloader pl-size-l"><div class="spinner-layer pl-red-grey"><div class="circle-clipper left"> <div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>',
			"oPaginate": {
				"sFirst": "<i class='fas fa-angle-double-left'></i>",
				"sLast": "<i class='fas fa-angle-double-right'></i>",
				"sNext": "<i class='fas fa-angle-right'>",
				"sPrevious": "<i class='fas fa-angle-left'>"
			},
			"sInfo": "Total Data :  _TOTAL_ dan ini (_START_ - _END_)",
			"sInfoEmpty": "Tidak ada data yang di tampilkan",
			"sZeroRecords": '<p class="text-center mb-0">Data kosong</p>',
			"sLengthMenu": "&nbsp;&nbsp; Menampilkan _MENU_"
		},
		"serverSide": true,
		// "searching": true,
		"responsive": false,
		"lengthMenu": [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, "All"]
		],
		"sPaginationType": "full_numbers",
		// "dom": 'Blfrtip',
		// "buttons": [{
		// 	extend: 'colvis',
		// 	text: ' Pengaturan Kolom ',
		// }],
		// "ajax": {
		// 	url: "<?php echo site_url("classteacher/ grid");?>",
		// 	type: "post",
		// 	"data": function (data) {
		// 		data.ajaran = $("#ajaran").val();
		// 		data.semester = $("#semester").val();
		// 	}
		// },
		"rowCallback": function (row, data) {
		}
	}, option);

    var table = $(obj_table).DataTable(config);
    return table;
}

var refreshDataTableServerSide = function (obj_table) {
	obj_table.ajax.reload(null,false); 
}

// =============================================================================

var isJSON = function (str) {
    try {
        $.parseJSON(str);
        return true;
    } catch (e) {
        return false;
    }
}