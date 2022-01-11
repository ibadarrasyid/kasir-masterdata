<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <h3>Update Pembayaraan</h3>
         </div>
         <div class="card-body">
            <form action="<?= base_url('pembayaran/bayar/').$data['id'] ?>" method="post">
               <div class="row">
                  <div class="col-md-6">
                     <label for="">Nomer Transaksi</label>
                     <input type="text" readonly disabled value="<?= $data['no_trx'] ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                     <label for="">Jumlah Bayar</label>
                     <input type="text" readonly disabled value="Rp. <?= number_format($data['sub_total']) ?>" class="form-control">
                  </div>

                  <div class="col-md-12">
                     <label for="">Metode Pembayaraan</label>
                     <select name="method_id" id="method_id" class="form-control" required>
                        <option value="" selected disabled>== Pilih Metode Pembayaraan ==</option>
                        <?php foreach($pembayaran as $value) : ?>
                           <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="">Bayar</label>
                     <input type="number" name="pay" class="form-control">
                  </div>
                  <div class="col-12">
                     <?php if($data['sub_total'] == $data['pay']) : ?>
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-success">Kembali</a>
                     <?php else : ?>
                        <button class="btn btn-primary" type="submit">Bayar</button>
                     <?php endif; ?>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>