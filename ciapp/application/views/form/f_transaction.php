<?php
$id_form = 'simpantransaction';
?>

<form action="javascript:void(0)" method="post" id="<?= $id_form ?>" url="<?= $url_controller.'/save' ?>">
   <input type="hidden" name='id' value="<?= isset($data['id']) ? $data['id'] : ""; ?>">
   <input type="hidden" name="type_transaction" id="type_transaction" value="old_customer">

   <div id="non-pelanggan">
      <div class="form-group">
         <label for="">Cari Pelanggan :</label>
         <select name="customer_id" id="customer_id" class="form-control select2">
            <?php foreach($customer as $value) : ?>
               <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
            <?php endforeach; ?>
         </select>
      </div>
   </div>

   <div id="pelangan" style="display: none;">
      <div class="row clearfix">
         <div class="col-sm-12">
               <div class="form-group">
                  <div class="form-line">
                     <label for="">Nama</label>
                     <input type="text" name="nama" value="" id="nama" placeholder="Masukkan Nama" class="form-control form-control-sm">
                  </div>
               </div>
         </div>
      </div>

      <div class="row clearfix">
         <div class="col-sm-12">
               <div class="form-group">
                  <div class="form-line">
                     <label for="">No HP</label>
                     <input type="text" name="nohp" value="" id="nohp" placeholder="Masukkan No HP" class="form-control form-control-sm">
                  </div>
               </div>
         </div>
      </div>

      <div class="row clearfix">
         <div class="col-sm-12">
               <div class="form-group">
                  <div class="form-line">
                     <label for="">No Kartu</label>
                     <input type="text" name="nokartu" value="" id="nokartu" placeholder="Masukkan No Kartu" class="form-control form-control-sm">
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
                           $m_limit_customer = $this->M_customer->get_limit_customer();
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
               $m_customer_type_division = get_customer_type_divison(($data != null) ? $data['id'] : null);

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
      <button class="btn btn-sm btn-outline-primary mb-2" id="btn-customer-cancel" type="button">Batal</button>
   </div>

   <button class="btn btn-sm btn-success" id="btn-customer" type="button"><i class="fas fa-plus"></i> Pelanggan</button>

   <button class="btn btn-primary btn-sm" type="submit">Tampilkan Keranjang Belanja</button>
</form>

<script>
   $(".select2").select2()

   $("#btn-customer").on('click', () => {
      $("#non-pelanggan").hide()
      $("#btn-customer").hide()
      $("#pelangan").show()
      $("#type_transaction").val('new_customer')
   })
   
   $("#btn-customer-cancel").on('click', () => {
      $("#type_transaction").val('old_customer')
      $("#non-pelanggan").show()
      $("#btn-customer").show()
      $("#pelangan").hide()
      let input = $("#pelangan input")
      $.each(input, (i, e) => {
         $(e).val("")
      })
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
                  window.location.replace(response.redirect)
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
   })
</script>