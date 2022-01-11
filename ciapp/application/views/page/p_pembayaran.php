<?php
$datatable_id = 'id_datatable';
?>

<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <form action="<?= base_url('pembayaran/search') ?>" method="POST">
               <div class="form-group">

                  <label class="form-control-label" for="exampleFormControlInput1">Cari pelanggan</label>
                  <input type="text" name="keyword" class="form-control">
                  <!-- <select class="form-control select2" id="ddlPassport" name="ddlPassport" data-select2-id="ddlPassport" tabindex="-1" aria-hidden="true">
                     <option value="N" data-select2-id="2">--Pilih pelanggan berdasarkan divisi/tipe customer/nama/nohp--</option>
                     <option value="Y">Outdoor, Umum, Andi, 081234566789</option>
                  </select> -->
               </div>
               <button class="btn btn-primary">Cari</button>
            </form>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="table-responsive">
               <table id="<?= $datatable_id ?>" class="table table-bordered table-striped table-hover table-sm">
                  <thead class="thead-dark">
                     <tr>
                        <th width="2px">No</th>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Transaksi</th>
                        <th>Status Transaksi</th>
                        <th width="20%">AKSI</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
      return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      }
   }

   const token = "Bearer PgL7YDNDJXeqvaEVzUHYWtBAW3yTUHWZvUSaJALpl51ItLlipFzPeVO8byEKCCC0"
   let datatable = $('#<?= $datatable_id ?>').DataTable({
      oLanguage: {
         sProcessing: "loading..."
      },
      processing: true,
      serverSide: true,
      ajax: {
         url: "http://localhost:8000/api/kasir/data",
         type: "post",
         beforeSend: function (request) {
            request.setRequestHeader("Authorization", token);
         },
      },
      columns: [
         { data: "id", orderable: false, searchable: false },
         { data: "no_trx" },
         { data: "customer.nama" },
         { data: "sub_total" },
         { data: "status" },
         { data: "id" },
      ],
      columnDefs: [
         {
            "targets": 5,
            "data": 'no_trx',
            "render": function(data, type, row, meta) {
               return `<a href="<?= base_url('pembayaran/update/') ?>${data}" class="btn btn-sm"><i class="fas fa-user-edit"></i></a>
                        <button class="btn btn-sm" onclick="delete_transaksi(${data})"><i class="fas fa-trash"></i></button>
                        <a href="<?= base_url('pembayaran/update/') ?>${data}" class="btn btn-sm"><i class="ni ni-money-coins"></i></a>
                        <button class="btn btn-sm"><i class="ni ni-paper-diploma"></i></button>`
            }
         }
      ],
      rowId: function(a) {
         return a;
      },
      rowCallback: function(row, data, iDisplayIndex) {
         let info = this.fnPagingInfo()
         let page = info.iPage
         let length = info.iLength
         let index = page * length + (iDisplayIndex + 1)
         $("td:eq(0)", row).html(index)
      }
   })

   setInterval(() => {
      datatable.ajax.reload()
   }, 5000);

   const delete_transaksi = id => {
      Swal.fire({
         title: 'Perhatikan ?',
         text: "Ingin Hapus Data Ini!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
         if (result.value) {
            new Promise((resolve, reject) => {
               $.ajax({
                  url: `<?= base_url('pembayaran/delete') ?>`,
                  data: {id},
                  method: `POST`,
                  dataType: `JSON`
               })
               .done(res => {
                  if(res.status) {
                     Swal.fire(res.message.head, res.message.body, 'success')
                  } else {
                     Swal.fire(res.message.head, res.message.body, 'error')
                  }
                  datatable.ajax.reload()
               })
            })
         }
      })
    }
</script>