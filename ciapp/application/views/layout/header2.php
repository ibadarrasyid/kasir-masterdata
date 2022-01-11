<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8" />
        <title>SmartAdmin <?= config_item('version') ?></title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta content="<?= base_url() ?>" name="url" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        <link href="<?= config_item('css') ?>bootstrap.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>font-awesome.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>smartadmin-production-plugins.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>smartadmin-production.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>smartadmin-skins.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>smartadmin-rtl.min.css" media="screen" rel="stylesheet" />
        <link href="<?= config_item('css') ?>demo.min.css" media="screen" rel="stylesheet" />
        <!-- ================== END BASE CSS STYLE ================== -->
        <?php
        if (isset($css)) {
            foreach ($css as $cs) {
                echo '<link rel="stylesheet" href="' . $cs . '.css" type="text/css"/>';
            }
        }
        ?>

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?= config_item('plugin') ?>jquery/jquery-2.1.1.min.js"></script>
        <script src="<?= config_item('plugin') ?>jquery/jquery-ui-1.10.3.min.js"></script>
        <script src="<?= config_item('plugin') ?>pace/pace.min.js"></script>
        <script src="<?= config_item('plugin') ?>gritter/js/jquery.gritter.js"></script> 
        <!-- ================== END BASE JS ================== -->
    </head>
    <body>

        <!-- HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> <img src="img/logo.png" alt="SmartAdmin"> </span>
				<!-- END LOGO PLACEHOLDER -->

			</div>

			<!-- pulled right: nav area -->
			<div class="pull-right">
				
				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->
				
				<!-- #MOBILE -->
				<!-- Top menu profile link : this shows only when top menu is active -->
				<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
					<li class="">
						<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
							<img src="img/avatars/sunny.png" alt="John Doe" class="online" />  
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?= base_url('login/logout') ?>" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->