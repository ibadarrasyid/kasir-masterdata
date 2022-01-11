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
	<title>Tujuh Master Data</title>
	<!-- Favicon -->
	<link rel="icon" href="<?= base_url('assets/argon/img/brand/favicon.png') ?>" type="image/png">
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/argon/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/argon/css/bootstrap/bootstrap.min.css') ?>" type="text/css">
	<!-- Page plugins -->
    <link rel="stylesheet" href="<?= base_url('assets/argon/vendor/bootstrap-toastr/toastr.min.css') ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<?php
    if (isset($css)) {
        foreach ($css as $cs) {
            echo '<link rel="stylesheet" href="' . $cs . '.css" type="text/css"/>';
        }
    }
    ?>
	<!-- Argon CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/argon/css/argon.css?v=1.2.0') ?>" type="text/css">
    <style>
        .navbar-vertical.navbar-expand-xs .navbar-nav > .nav-item > .nav-link.active { background: #b1d8ff; }
        .table .thead-dark th { color: #fff; }
    </style>

	<!----------------------------------- Argon Scripts ----------------------------------->
    <!-- Core -->
    <script src="<?= base_url('assets/argon/vendor/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/js-cookie/js.cookie.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
    <!-- Optional JS -->
    <script src="<?= base_url('assets/argon/vendor/chart.js/dist/Chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/chart.js/dist/Chart.extension.js') ?>"></script>
    <script src="<?= base_url('assets/argon/vendor/bootstrap-toastr/toastr.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/myHelper.js') ?>"></script>
    
    <?php
    if (isset($js)) {
        foreach ($js as $js) {
            echo '<script src="' . $js . '.js"></script>';
        }
    }
    ?>
</head>

<body>