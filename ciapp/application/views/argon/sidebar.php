<?php 
$arr_sidebar_module = [
    'limit_customer' => ['icon' => 'fas fa-dolly', 'nama' => 'Customer Limit'],
    'customer_type' => ['icon' => 'ni ni-badge', 'nama' => 'Customer Tipe'],
    'customer' => ['icon' => 'ni ni-single-02', 'nama' => 'Customer'],
    'division' => ['icon' => 'ni ni-pin-3', 'nama' => 'Divisi'],
    'category' => ['icon' => 'ni ni-tag', 'nama' => 'Bahan Kategori'],
    'bahan' => ['icon' => 'ni ni-box-2', 'nama' => 'Bahan'],
    'bahan_potongan' => ['icon' => 'ni ni-scissors', 'nama' => 'Bahan Potongan'],
    'bahan_finishing' => ['icon' => 'ni ni-support-16', 'nama' => 'Finishing'],
    'bahan_finishing_potongan' => ['icon' => 'ni ni-scissors', 'nama' => 'Finishing Potongan'],
    'design' => ['icon' => 'ni ni-palette', 'nama' => 'Design'],
    // 'transaction' => ['icon' => 'ni ni-money-coins', 'nama' => 'Transaksi'],
    'jenis_pembayaran' => ['icon' => 'ni ni-money-coins', 'nama' => 'Jenis Pembayaran'],
    'promo' => ['icon' => 'ni ni-credit-card', 'nama' => 'Promo'],
    // 'pembayaran' => ['icon' => 'ni ni-money-coins', 'nama' => 'Pembayaran'],
];
?>

<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
                <img src="<?= base_url('assets/argon/img/brand/blue.png') ?>" class="navbar-brand-img" alt="...">
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/widgets.html">
                            <i class="ni ni-archive-2 text-green"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                    <?php foreach ($arr_sidebar_module as $module => $attr_module) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= active_sidebar_menu($module) ?>" href="<?= base_url($module) ?>">
                                <i class="<?= $attr_module['icon'] ?> text-primary"></i>
                                <span class="nav-link-text"><?= $attr_module['nama'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</nav>