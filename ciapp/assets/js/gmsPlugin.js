/*
 *  gmsPlugin - v1.0.0
 *  gmsPlugin untuk penggunaan beberapa fitur jquery yang sudah di recode
 *
 *  Made by Velly Tursinei
 *  @tursinei
 *  Under GMS License (dewandaru 62 Malang)
 */

/**
 * Untuk menghilangkan message
 * @param {String} text Pesan yang mw disampaikan
 * @param {Integer} timer waktu pesan akan menghilang in miliseconds
 * @returns {undefined}
 */
jQuery.fn.msgHd = function (text, timer, classs) {
    var cls = classs || '';
    var elm = $(this);
    elm.removeClass().addClass(cls);
    elm.html(text);
    setTimeout(function () {
        elm.removeClass();
        elm.html('');
    }, timer);
};

//create link download from url given
function createLinkDownload(srcDownload) {
    var iframe = document.getElementById("frmDownload");
    if (iframe == null) {
        iframe = document.createElement('iframe');
        iframe.id = "frmDownload";
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
    } else {
        $(iframe).removeAttr('src');
    }
    iframe.src = srcDownload;
}
//create link download with post data from tag form
function createLinkDownloadPost(idForm, src) {
    var form = $('#' + idForm);
    var iframe = document.getElementById("frmDownload");
    if (iframe == null) {
        iframe = document.createElement('iframe');
        iframe.id = "frmDownload";
        iframe.name = "frmDownload";
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
    }
    form.attr({'action': src, target: "frmDownload", 'method': 'POST'});
    $(iframe).attr('src', src);
    form.submit();
}

var refreshTableServerOn = function (a, url) {
    $(a).dataTable().fnDestroy();
    return $(a).dataTable({
        'bLengthChange': true,
        'aLengthMenu': [[15, 30, 50, -1], [15, 30, 50, "All"]],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": url,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Maaf, data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(dari total  _MAX_ data)"
        }
    });
//    $('.dataTables_length').last().addClass('pull-right');
};

var msgAlert = function (text) {
    var opt = {title: 'Terjadi Kesalahan', text: text, image: $('meta[name="url"]').attr('content') + "assets/img/error-icon.jpg", class_name: 'gritter-light'};
    $.gritter.add(opt);
    return false;
}
var msgSuccess = function (text) {
    var opt = {title: 'Berhasil', text: text, image: $('meta[name="url"]').attr('content') + "assets/img/success-icon.jpg", class_name: 'gritter-light'};
    $.gritter.add(opt);
}
var msgNotice = function (text) {
    var opt = {title: 'Perhatian', text: text, image: $('meta[name="url"]').attr('content') + "assets/img/warning-icon.png", class_name: 'gritter-light'};
    $.gritter.add(opt);
}

var remTr = function (a) {
    $(a).parents('tr').first().remove(0);
}

var isJSON = function (str) {
    try {
        $.parseJSON(str);
        return true;
    } catch (e) {
        return false;
    }
}

function setAutocomplete(a, url) {
    $(a).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: url + request.term,
                dataType: "json",
                success: function (data) {
                    response($.map(data, function (item) {
                        return item;
                    }));
                }
            });
        },
        minLength: 1
    });
}

var setSelect2 = function (a) {
    $(a).select2({
        width: '100%',
        formatResult: function (elm) {
            var orgOpt = elm;
            return '<i class="fa ' + $(orgOpt.element[0]).attr('data-icn') + '"></i> ' + orgOpt.text;
        }
    });
    $('.select2-hidden-accessible').remove();
};
/**
 * For upload file should add have these property
 processData: false,
 contentType: false,
 * @param Object btn elemetn or jQuery Objec
 * @param array pilihan type, url, proccessData:false,contentType:false,dtType:'text',async:false,done,beforeSend,errMsg
 * @returns {gAjax}
 */
var gAjax = function (i, pilihan) {
    var cls = '', option = {}, pst = '', heigth = 0, width = 0;
    if ((i != '') && (i != 'undefined') && (i != null)) {
        if (i.parent().hasClass('btn')) {
            i.parent().attr('disabled', 'disabled');
        }
        cls = i.attr('class');
    }
    if ($('.page-content').length > 0) {
        pst = $('body').offset(), heigth = $('body').css('height'), width = $('body').css('width');
        option = {
            position: 'absolute',
            top: pst.top,
            left: pst.left,
            height: heigth,
            width: width,
            "z-index": 9999,
            "text-align": 'center',
            "background-color": 'rgba(255,255,255,0.5)'
        };
    }
    var setting = $.extend({
        type: 'POST',
        url: '',
        dataType: 'text',
        async: false,
        data: {},
        done: function (ss) {
        },
        beforeSend: function () {
            if ((i != '') && (i != 'undefined') && (i != null)) {
                i.removeClass().addClass('fa fa-spin fa-spinner');
                if (i.parent().hasClass('btn')) {
                    i.parent().attr('disabled', 'disabled');
                }
            } else {
                $('#divOverlay').css(option).removeClass('hidden');
            }
        },
        error: function (e) {
            msgAlert('Error Message', 'Terjadi kesalahan, ' + e.status + ' : ' + e.statusText);
        }
    }, pilihan);
    $.ajax({
        url: setting.url,
        dataType: setting.dataType,
        type: setting.type,
        beforeSend: setting.beforeSend,
        processData: setting.processData,
        contentType: setting.contentType,
        success: setting.done,
        data: setting.data,
        async: setting.async,
        error: setting.error
    }).always(function () {
        if ((i != '') && (i != 'undefined') && (i != null)) {
            i.removeClass().addClass(cls);
            if (i.parent().hasClass('btn')) {
                i.parent().removeAttr('disabled');
            }
        } else {
            $('#divOverlay').addClass('hidden').removeAttr('style');
        }
    });
    return false;
};
/**
 * slide to object that u declare
 * @returns Object JQuery
 */

//$('nav').find('a').click(function (e) {
//    e.preventDefault();
//    var attr = $(this).attr('href');
//    if (typeof attr !== typeof undefined && attr !== false) {
//        getPage(attr, $(this).text());
//        return false;
//    }
//
//
//});
//
//function getPage(url, title, data) {
//    if (data === undefined) {
//        data = {'getpage': 'page', url:url, title:title};
//    } else {
//        data.push({name: 'getpage', value: 'page'});
//        data.push({name: 'url', value: url});
//        data.push({name: 'title', value: title});
//    }
//    gAjax('', {
//        data: data,
//        url: url,
//        done: function (s) {
//            $('div#main').replaceWith(s);
//            history.pushState(data, title, url);
//        }
//    });
//}
//onpopstate = function (oEvent) {
//    console.log(oEvent);
//    var title = oEvent.state.title;
//    var url = oEvent.state.url;
//    getPage(url, title);
//};

$.fn.scrollToObj = function () {
    $('html, body').animate({scrollTop: this.offset().top}, 1500);
    return this;
};

var readImg = function (input, preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

var openTab = function (idtabpane, liContent, tabContent) {
    var ulNav = $('ul.nav-tabs'), dvContent = $('div.tab-content');
    var title = "<li><a data-toggle='tab' title='" + liContent + "' href='#" + idtabpane + "'>" + liContent + "<div class='pull-right' style='margin-left: 10px;color:red;cursor: pointer;' ><i onclick='remTab(this)' name='" + idtabpane + "' class='fa fa-times red'></i></div></a></li>";
    var content = "<div class='tab-pane fade' id='" + idtabpane + "'>" + tabContent + "</div>";
    if ($('a[href=#' + idtabpane + ']').length == 0) {
        ulNav.append(title);
        dvContent.append(content);
    }
    $('.nav-tabs a[href="#' + idtabpane + '"]').tab('show').focus();
}

function remTab(a) {
    var btn = $(a), id = btn.attr('name'), ul = btn.parents('ul'), li = btn.parents('li'), ulLength = ul.children().length;
    var chil = ul.children();
    var ind = $(chil[ulLength - 1]).find('a').attr('href');
    if ($(li).hasClass('active')) {
        $(li).toggle('slide', function () {
            if ($(li).find('a').attr('href') == ind) {
                var idd = $(chil[ulLength - 2]).find('a').attr('href');
                $(chil[ulLength - 2]).tab('show').focus();
                $(idd).addClass('active in');
            } else {
                var next = $(li).next('li'), tab = $(next.find('a').attr('href'));
                next.tab('show').focus();//addClass('active');
                $(tab).addClass('active in');
            }
            $(li).remove();
        });
        $('#' + id).toggle('explode', function () {
            $('#' + id).remove();
        });
    } else {
        $(li).remove();
        $('#' + id).remove();
    }
}

var setInitTableFixed = function () {
    var tble = $('.header-fixed'), tableOffset = tble.offset(), $header = $('.header-fixed > thead').clone();
    var fixedHeader = $('.hdr-fixed').append($header).addClass(tble.attr('class')).css('width', tble.width());
    $('.hdr-fixed').css('left', tableOffset.left);
    $(window).bind('scroll', function () {
        var offset = $(this).scrollTop();
        if (offset >= tableOffset.top && fixedHeader.is(":hidden")) {
            fixedHeader.show();
        } else if (offset < tableOffset.top) {
            fixedHeader.hide();
        }
    });
};

/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function (n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

var setTable = function (a, arrDisableCol, option) { 
    var tbd = $(a).find('tbody');
    if (tbd.length == 0) {
        $(a).append('<tbody></tbody>');
    } 
    var config = $.extend({
        'bLengthChange': true,
        'aLengthMenu': [[15, 30, 50, -1], [15, 30, 50, "All"]],
        'iDisplayLength': 15,
        'autoWidth': false,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "<font style='font-size:12px'>Maaf, Tidak ada data yang ditampilkan</font>",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(dari total _MAX_ data)"
        },
        "columnDefs": arrDisableCol
    }, option); 
    var table = $(a).dataTable(config);
    return table;
};

var refreshTable = function (a, tbody, arrDisableCol, option) { 
    if ($.fn.dataTable.isDataTable(a)) {
        $(a).dataTable().fnDestroy();
    }
    var tbd = $(a).find('tbody');
    if (tbd.length == 0) {
        $(a).append('<tbody></tbody>');
    }
    tbd.html(tbody);
    var config = $.extend({
        'bLengthChange': true,
        'aLengthMenu': [[15, 30, 50, -1], [15, 30, 50, "All"]],
        'iDisplayLength': 15,
        'autoWidth': false,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "<font style='font-size:12px'>Maaf, Tidak ada data yang ditampilkan</font>",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(dari total _MAX_ data)"
        },
        "columnDefs": arrDisableCol
    }, option);
    var table = $(a).dataTable(config);
    return table;
};

var removeRow = function (tr, thereIsNumberColumn) {
    var otr = $(tr), tbl = tr.parents('table').first().dataTable();
    console.log(tbl);
    tbl.row(otr).remove();
    thereIsNumberColumn = thereIsNumberColumn || true;
    if (thereIsNumberColumn) {
        tbl.rows().every(function (rowIndex, tableLoop, rowLoop) {

        });
    }
};

function initModalorang(mdl) {
    mdl.find('.tanggal').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    mdl.find('.tanggal').each(function () {
        $(this).datepicker("update", $(this).val());
    });
}
