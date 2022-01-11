<?php
// config_item('version');
// config_item('css');
// config_item('plugin');
// config_item('js')
?>
<!--
=========================================================
* Argon Dashboard PRO - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro
* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Login - Nama App</title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/argon/img/brand/favicon.png') ?>" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/argon/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/argon/css/argon.css?v=1.2.0') ?>" type="text/css">

    <link rel="stylesheet" href="<?= base_url('assets/argon/vendor/bootstrap-toastr/toastr.min.css') ?>"/>
</head>

<body class="bg-default">
    <!-- Navbar -->
    
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-5 py-lg-6 pt-lg-7">
            <div class="container">
                <div class="header-body text-center mb-1">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Selamat Datang!</h1>
							<?echo base_url();?>
							<?echo site_url();?>
                            <p class="text-lead text-white"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        
        <!-- Page content -->
        <div class="container mt--6 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        
                        <div class="card-body px-lg-5 py-lg-5">
                            <div id="notif"></div>
                            
                            <form id="form-login" role="form">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        </div>
                                        <input class="form-control" name="user" placeholder="Username" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="pass" placeholder="Password" type="password">
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <!-- <footer class="py-5" id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-12 text-center">
                    <div class="copyright text-muted">&copy; 2021 - <a href="#" class="font-weight-bold ml-1">Toedjo Group</a></div>
                </div>
            </div>
        </div>
    </footer> -->
    
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?= base_url('assets/argon/vendor/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/js-cookie/js.cookie.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
    <!-- Argon JS -->
    <script src="<?= base_url('assets/argon/js/argon.js?v=1.2.0') ?>"></script>
    <!-- Demo JS - remove this in your project -->
    <!-- <script src="../../assets/js/demo.min.js"></script> -->
    <script src="<?= base_url('assets/argon/vendor/bootstrap-toastr/toastr.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/myHelper.js') ?>"></script>
    <script>
        $(document).ready(function() {
            // App.init();
        }).on('submit', '#form-signup', function(e) {
            e.preventDefault();
            var fo = $(this),
                i = fo.find('button[type="submit"]').find('i'),
                paneMsg = $('#signup-msg');
            if (fo.find('input[type=text]').val() == '') {
                paneMsg.removeClass().addClass('alert alert-danger').html('Username SKP tidak boleh kosong');
                return;
            } else if (fo.find('input[type=password]').val() == '') {
                paneMsg.removeClass().addClass('alert alert-danger').html('Password SKP tidak boleh kosong');
                return;
            }

            gAjax(i, {
                url: '<?= base_url('login/doSignUp') ?>',
                data: fo.serializeArray(),
                dataType: 'JSON',
                done: function(e) {
                    if (e.ind == 1) {
                        paneMsg.removeClass().addClass('alert alert-success').html(e.msg);
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 1300);
                    } else {
                        paneMsg.removeClass().addClass('alert alert-danger').html(e.msg);
                        setTimeout(function() {
                            paneMsg.removeClass().html('');
                        }, 5000);
                    }
                }
            });
        }).on('hidden.bs.modal', '#modal-sign-up', function() {
            $(this).find('form')[0].reset();
            $(this).find('.signup-msg').removeClass().addClass('signup-msg');
        }).on('submit', '#form-login', function(e) {
            e.preventDefault();
            var fo = $(this),
                i = fo.find('button[type="submit"]').find('i'),
                paneMsg = $('#notif');
            myAjax({
                url: '<?= base_url('auth/doLogin') ?>',
                data: fo.serializeArray(),
                dataType: 'JSON',
                success: function(e) {
                    if (e.ind == 1) {
                        paneMsg.removeClass().addClass('alert alert-success').html(e.msg);
                        setTimeout(function() {
                            paneMsg.removeClass().html('');
                        }, 5000);
                        window.location.reload();
                    } else {
                        paneMsg.removeClass().addClass('alert alert-danger').html(e.msg);
                        setTimeout(function() {
                            paneMsg.removeClass().html('');
                        }, 5000);
                    }
                }
            });
        });
    </script>
</body>

</html>