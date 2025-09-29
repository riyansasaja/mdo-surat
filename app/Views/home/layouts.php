<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Persuratan</title>
    <!-- DATA TABLES ONLINE -- DIMATIKAN SEMENTARA -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- DATA TABLES OFFLINE -->
    <!-- <link href="<?= base_url() ?>css/datatables.css" rel="stylesheet" /> -->
    <!-- CUSTOM CSS -->
    <link href="<?= base_url() ?>css/styles.css" rel="stylesheet" />
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/5798309f98.js" crossorigin="anonymous"></script>

    <!-- FONT AWESOME DARI TEMPLATE AWAL -->
    <!-- <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script> -->
    <!-- <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'> -->

    <?= $this->renderSection('header') ?>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Persuratan</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- divider -->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Settings</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('logact') ?>">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <?= view('App\Views\home\sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <?= $this->renderSection('main') ?>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Sasajadev 2024</div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- BOOTSTRAP JS -->
    <script src="<?= base_url() ?>js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- CUSTOM JS -->
    <script src=<?= base_url() . "js/scripts.js" ?>></script>

    <!-- DATA TABLES ONLINE - SEMENTARA NDA PAKE NTUK TES KECEPATAN -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

    <!-- DATA TABLES OFFLINE -->
    <!-- <script src=<?= base_url() . "js/datatables.js" ?>></script> -->

    <!-- JQUERY BOOTSTRAP -->
    <script src=<?= base_url() . "js/jquery-3.7.1.js" ?>></script>

    <?= $this->renderSection('pageScripts') ?>
</body>

</html>