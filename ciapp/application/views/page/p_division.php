<?php
$id_form = 'simpancustomer';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h2 class="mb-0">Master Divisi</h2>
                <p class="mb-0">Menu untuk management divisi</p>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-2">
                        <button type="button" target="#loadform" url="<?= $url_controller . '/form' ?>" data-toggle="modal" data-target="#defaultModal" data-color="cyan" class="btn btn-primary btn-sm addmodal"><span class="fa fa-plus"></span> TAMBAH DATA </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm" id="datatableTable">
                        <thead class="thead-dark">
                            <tr>
                                <th width="2px">No</th>
                                <th>Nama</th>
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

<div id="defaultModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mb-0">Form Master Divisi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="loadform">
                <p>Loading...</p>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">
    var dataTable = generateDataTableServerSide('#datatableTable', {
        "ajax": {
            url: "<?= $url_controller . '/table' ?>",
            type: "post",
            "data": function(data) {
                // data.ajaran = $("#ajaran").val();
                // data.semester = $("#semester").val();
            }
        },
    });

    $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default mb-3');

    $(document).off("click", ".hapusdata").on("click", ".hapusdata", function() {
        var id = $(this).attr("datanya");
        confirmSweetAlert("Apakah anda yakin menghapus data ini ?", function() {
            // loading();
            $.post("<?= $url_controller . '/delete' ?>", {
                id: id
            }, function(json) {

                let response = JSON.parse(json);

                if (response.sts == 1) {
                    msgSuccess(response.msg);

                    refreshDataTableServerSide(dataTable);
                } else {
                    msgAlert(response.msg);
                }

                // unloading();
            })
        })
    })
</script>