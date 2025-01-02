<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="<?= base_url() ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <?= view('App\Views\Auth\_message_block') ?>

                                    <!-- strat form -->
                                    <form action="<?= url_to('login') ?>" method="post">
                                        <?= csrf_field() ?>

                                        <?php if ($config->validFields === ['email']): ?>
                                            <div class="form-floating mb-3">
                                                <input class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" id="inputEmail" type="email" name="login" placeholder="<?= lang('Auth.email') ?>" />
                                                <label for="inputEmail"><?= lang('Auth.email') ?></label>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.login') ?>
                                                </div>
                                            </div>
                                        <?php else: ?>

                                            <div class="form-floating mb-3">
                                                <input class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" id="inputEmailOrUsernmae" type="text" name="login" placeholder="<?= lang('Auth.email') ?>" />
                                                <label for="inputEmailOrUsernmae"><?= lang('Auth.emailOrUsername') ?></label>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.login') ?>
                                                </div>
                                            </div>

                                        <?php endif; ?>


                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="<?= lang('Auth.password') ?>" name="password" <?php if (session('errors.password')) : ?>is-invalid<?php endif ?> />
                                            <label for="inputPassword"><?= lang('Auth.password') ?></label>
                                            <div class="invalid-feedback">
                                                <?= session('errors.password') ?>
                                            </div>
                                        </div>
                                        <div class="form-floatin mb-3">
                                            <div class="form-group">
                                                <select class="form-control" id="year" name="year">
                                                    <?php
                                                    $tahun = 2024; ?>
                                                    <?php for ($tahun; $tahun < date('Y') + 3; $tahun++) : ?>
                                                        <option value="<?= $tahun ?>" <?= $tahun == date('Y') ? 'selected' : '' ?>> <?= $tahun; ?> </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php if ($config->allowRemembering): ?>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" name="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                                <label class="form-check-label" for="inputRememberPassword"><?= lang('Auth.rememberMe') ?></label>

                                            </div>

                                        <?php endif; ?>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button>
                                        </div>



                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>js/scripts.js"></script>
</body>

</html>