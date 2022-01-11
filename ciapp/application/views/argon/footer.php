    <!-- Argon JS -->
    <script src="<?= base_url('assets/argon/js/argon.js?v=1.2.0') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Demo JS - remove this in your project -->
    <!-- <script src="../../assets/js/demo.min.js"></script> -->

    <script>
        $(document).ready(function() {
            $('.select2').select2()
        }).on('click', '#btn-logout', function() {
            confirmSweetAlert("Apakah anda yakin akan keluar ?", function() {
                $.get("<?= base_url('auth/logout') ?>", function(json) {
                    let response = JSON.parse(json);
    
                    if (response.sts == 1) {
                        // msgSuccess(response.msg);

                        window.location = "<?= base_url() ?>";
                    } else {
                        msgAlert('Gagal Logout');
                    }
                })
            }, 'keluar')
        })
    </script>
    </body>

</html>