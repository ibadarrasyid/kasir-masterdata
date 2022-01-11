
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h2 class="mb-0">Transaksi</h2>
                <p class="mb-0">Keranjang belanja</p>
            </div>

            <div class="card-body">
               <h3><strong>Item</strong></h3>
               <!-- <form action="" id="form-data"> -->
                  <form class="form-element" id="form-element">
                     <input type="hidden" name="customer" value="<?= $customer['id'] ?>">
                     <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger btn-sm btn-delete d-none"><i class="fas fa-trash"></i></button>
                     </div>
                     <div class="row">
                        <div class="col-md-6 form-group">
                           <label for="">Prioritas</label>
                           <select name="priority" id="priority" class="form-control priority">
                              <option value="Langsung cetak">Langsung cetak</option>
                              <option value="Urgent">Urgent</option>
                              <option value="Standard">Standard</option>
                           </select>
                        </div>
                        <div class="col-md-6 form-group">
                           <label for="">Divisi</label>
                           <select name="division_id" id="division_id" class="form-control division_id">
                              <option value="" selected disabled>== Pilih Divisi ==</option>
                              <?php foreach($division as $value) : ?>
                                 <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-12 form-group">
                           <label for="">Kategori</label>
                           <select name="category_id" id="category_id" class="form-control category_id">
                              <option>== Pilih Kategori ==</option>
                           </select>
                        </div>
                        <div class="col-md-12 form-group">
                           <div class="row fieldProperty"></div>
                        </div>
                        <div class="fieldBahanProperty ml-3"></div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-4 form-group">
                           <label for="">Finishing</label>
                           <select name="finishing_id" id="finishing_id" class="form-control finishing_id">
                              <option value="" selected disabled>== Pilih Finishing ==</option>
                              <?php foreach($finishing as $value) : ?>
                                 <option value="<?= $value['id'] ?>"><?= $value['nama'] ?> - <?= rupiah_format($value['harga']) ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-4 form-group">
                           <label for="">Desain</label>
                           <select name="design_id" id="design_id" class="form-control design_id">
                              <option value="" selected disabled>== Pilih Desain ==</option>
                              <?php foreach($design as $value) : ?>
                                 <option value="<?= $value['id'] ?>"><?= $value['nama'] ?> - <?= rupiah_format($value['harga']) ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-4 form-group">
                           <label for="">Nama File</label>
                           <input type="text" class="form-control file" name="file" placeholder="Masukkan Nama File">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12">
                           <div class="text-center">
                              <h3><strong id="priceField"></strong></h3>
                           </div>
                        </div>
                     </div>
                  </form>

                  <div id="fieldMulti"></div>

                  <div class="row">
                     <div class="col-md-2">
                        <button class="btn btn-sm btn-success" type="button" onclick="tambahTransaksi()"><i class="fas fa-plus"></i> Tambah Transaksi</button>
                     </div>
                     <div class="col-md-10">
                        <div class="float-right">
                           <a href="<?= base_url('transaction') ?>" class="btn btn-sm btn-secondary">Cancel</a>
                           <button id="submit-form" class="btn btn-sm btn-success" type="submit">Simpan</button>
                        </div>
                     </div>
                  </div>

               <!-- </form> -->
            </div>
        </div>
    </div>
</div>


<script>
   $(document).on('change', '.division_id', function() {
      let parent = $(this).parents('.form-element')
      let division_id = parent.find(".division_id").val()
      $.ajax({
         type: "POST",
         url: `<?= base_url('division/get_data') ?>`,
         data: {division_id},
         dataType: 'JSON',
         success: function (json, status, xhr) {
            var ct = xhr.getResponseHeader("content-type") || ""
            if (ct == "application/json") {
               response = json
               if (response.status) {
                  let data = response.data
                  let html = `<option selected disable>== Pilih Kategori ==</option>`
                  if(data.length > 0) {
                     data.forEach(element => {
                        html += `<option value="${element.id}" data-property='${element.property}' data-validation='${element.validation}'>${element.nama}</option>`
                     })
                  } else {
                     msgWarning('Kategori Belum Ada')
                  }
                  parent.find(".category_id").html(html)
               } else if (response.sts == 2) {
                  msgWarning('Terjadi Kesalahan Ketikan pada Server')
               } else {
                  msgAlert('Terjadi Kesalahan Ketikan pada Server')
               }
            } else {
               msgAlert('Terjadi Kesalahan Ketikan pada Server')
            }
         }
      })
   })

   $(document).on('change', ".category_id", function() {
      let parent = $(this).parents('.form-element')
      parent.find(".fieldBahanProperty").html(``)
      // let category_id = parent.find(".category_id").val()
      let dropDown = parent.find('.category_id :selected')
      let property = dropDown.data('property')
      let validation = dropDown.data('validation')
      htmlProperty = ``
      property.forEach(element => {
         let isValidation = ``
         if(validation) {
            if(validation.includes(element)) {
               isValidation = 'changeValidation'
            }
         }
         htmlProperty += `<div class="col-md col-sm-12 form-group">
                     <label for="">${element}</label>
                     <input type="number" class="form-control property-${element} ${isValidation}" id="property-${element}" name="property-${element}" placeholder="Masukkan ${element}" required min="1">
                  </div>`
      })
      parent.find(".fieldProperty").html(htmlProperty)
      // $.ajax({
      //    type: "POST",
      //    url: `<?= base_url('category/get_data') ?>`,
      //    data: {category_id},
      //    dataType: 'JSON',
      //    success: function (json, status, xhr) {
      //       var ct = xhr.getResponseHeader("content-type") || ""
      //       if (ct == "application/json") {
      //          response = json
      //          if (response.status) {
      //             let data = response.data
      //             let html = `<option selected disable>== Pilih Barang ==</option>`
      //             if(data.length > 0) {
      //                data.forEach(element => {
      //                   html += `<option value="${element.id}" data-property=${element.property} data-propertyhidden=${element.hidden_property}>${element.nama}</option>`
      //                })
      //             } else {
      //                msgWarning('Barang Belum Ada')
      //             }
      //             $("#bahan_id").html(html)
      //          } else if (response.sts == 2) {
      //             msgWarning('Terjadi Kesalahan Ketikan pada Server')
      //          } else {
      //             msgAlert('Terjadi Kesalahan Ketikan pada Server')
      //          }
      //       } else {
      //          msgAlert('Terjadi Kesalahan Ketikan pada Server')
      //       }
      //    }
      // })
   })

   // $(document).on('change', ".bahan_id", function() {
   //    let dropDown = $('#bahan_id').find(":selected")
   //    let property = dropDown.data('property')
   //    let propertyhidden = dropDown.data('propertyhidden')
   //    htmlProperty = ``
   //    for (let element in property) {
   //       htmlProperty += `${element} : ${property[element]} `   
   //    }
   //    for(let element in propertyhidden) {
   //       let keyword = element.split('_')
   //       $(`#fieldProperty #property-${keyword[0]}`).attr('min', propertyhidden[element])
   //    }
   //    $("#fieldBahanProperty").html(`<p>${htmlProperty}</p>`)
   // })

   $("#submit-form").on('click', e => {
      e.preventDefault()
      swal.fire({
         html: '<h5>Data Sedang Disimpan. Harap Tunggu</h5>',
         showConfirmButton: false,
         allowOutsideClick: false,
         onRender: function() {
               $('.swal2-content').prepend(sweet_loader)
         }
      })
      // priceProcess()
      //    .then(() => {
            let form = $(".form-element")
            let formData = new FormData()
            $.each(form, (i, e) => {
               let tempForm = $(e).serialize()
               // new FormData()
               console.log(tempForm)
               formData.append(`form[]`, tempForm)
            })
            $.ajax({
               url: `<?= base_url('transaction/save_transaction') ?>`,
               type: "POST",
               dataType: "JSON",
               data: formData,
               processData: false,
               contentType: false,
               success: function(json, status, xhr) {
                  var ct = xhr.getResponseHeader("content-type") || ""
                  if (ct == "application/json") {
                     let response = json
                     if (response.sts == 1) {
                        swal.close()
                        msgSuccess(response.msg)
                        setTimeout(() => {
                           window.location.href = `<?= base_url('transaction') ?>`
                        }, 500);
                     } else if (response.sts == 2) {
                        swal.close()
                        msgWarning(response.msg)
                     } else {
                        swal.close()
                        msgAlert(response.msg)
                     }
                  } else {
                     swal.close()
                     msgAlert('Terjadi Kesalahan Ketikan Menyimpan pada Server');
                  }
               },
               error: function( jqXHR, textStatus, errorThrown ) {
                  swal.close()
               }
            })
         // })
   })

   const priceProcess = () => {
      return new Promise(resolve => {
         $.ajax({
            url: `<?= base_url('transaction/get_price') ?>`,
            type: "POST",
            dataType: "JSON",
            data: $("#form-data").serialize()
         })
         .done(res => {
            if (res.sts == 1) {
               $("#price").val(res.msg.non_format)
               $("#priceField").html(res.msg.format)
            } else if (res.sts == 2) {
               msgWarning(res.msg)
            } else {
               msgAlert(res.msg)
            }
            resolve(res)
         })
      })
   }

   $(document).on('click', ".btn-delete", e => {
      $(e.currentTarget).parents('.form-element').remove()
   })

   const tambahTransaksi = () => {
      let form_element = $("#form-element").clone()
      form_element.find('.btn-delete').removeClass('d-none')
      form_element.find('.category_id').html(`<option selected="" disable="">== Pilih Kategori ==</option>`)
      form_element.find('.fieldProperty').html(``)
      form_element.find('.fieldBahanProperty').html(``)
      $("#fieldMulti").append(form_element)
   }

   let statusAjax = false
   $(document).on('change', '.changeValidation', function() {
      let parent = $(this).parents('.form-element')
      let validation = parent.find('.changeValidation')
      let category = parent.find('.category_id').val()
      let status = false
      let request = []
      $.each(validation, (index, element) => {
         if($(element).val() == '' || $(element).val() == 0 || $(element).val() == null) {
            status = false
         } else {
            status = true
            request.push(encodeURIComponent($(element).attr('name')) + "=" + encodeURIComponent($(element).val()))
         }
      })
      if(status) {
         if(!statusAjax) {
            statusAjax = true
            request.push(encodeURIComponent('category') + "=" + encodeURIComponent(category))
            $.ajax({
               url: `<?= base_url('bahan/search_validation') ?>`,
               type: 'POST',
               data: request.join("&").replace(/%20/g, "+"),
               dataType: 'JSON',
               success: function(result) {
                  statusAjax = false
                  let fieldBahan = parent.find('.fieldBahanProperty')
                  let html = ''
                  result.forEach((element, index) => {
                     html += `<div class="custom-control custom-radio mb-3">
                                 <input name="bahan" class="custom-control-input" id="bahan-${element.nama}-${index}" type="radio" value="${element.id}">
                                 <label class="custom-control-label" for="bahan-${element.nama}-${index}">${element.nama}</label>
                              </div>`
                  })

                  fieldBahan.html(html)
               }
            })
         }
      }
   })
</script>