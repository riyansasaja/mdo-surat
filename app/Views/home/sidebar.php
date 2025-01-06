<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="<?= base_url('/') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <?php if (has_permission('manage-regist')) : ?>
                    <div class="sb-sidenav-menu-heading">Registrasi</div>
                    <a class="nav-link" href="<?= base_url('/regsm') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-envelope-circle-check"></i></div>
                        Surat Masuk
                    </a>
                    <a class="nav-link" href="<?= base_url('/regso') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-paper-plane"></i></div>
                        Surat Keluar
                    </a>

                <?php endif;  ?>


                <?php if (has_permission('manage-users')) : ?>
                    <div class="sb-sidenav-menu-heading">Management</div>
                    <a class="nav-link" href="<?= base_url('/users') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Users
                    </a>
                    <a class="nav-link" href="<?= base_url('/menej/kodesurat') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Kode Surat
                    </a>
                    <a class="nav-link" href="<?= base_url('/menej/jabatan') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Jabatan
                    </a>

                <?php endif;  ?>

                <?php if (in_groups('manager')) : ?>
                    <div class="sb-sidenav-menu-heading">Surat Masuk</div>

                    <a class="nav-link " href="<?= base_url('inmailmanage') ?>" >
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-envelope"></i></i></div>
                        Dari operator
                    </a>


                <?php endif;  ?>

                <?php if (has_permission('process_inmail')) : ?>
                    <div class="sb-sidenav-menu-heading">Kelola Disposisi</div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-envelope"></i></i></div>
                        Disposisi Masuk
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('inmail/') ?>">Belum TL</a>
                            <a class="nav-link" href="<?= base_url('inmail/showdespoted') ?>">Sudah TL</a>
                        </nav>
                    </div>

                <?php endif;  ?>



            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= user()->username ?>
        </div>
    </nav>
</div>