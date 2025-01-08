<?= $this->extend('home/layouts') ?>


<?= $this->section('main') ?>

<?php
// dd($getroles);
?>


    <div class="container-fluid px-4">
        <h1 class="mt-4">User Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('/users') ?>">User Management</a></li>
            <li class="breadcrumb-item active">User Detil</li>
        </ol>

        <?= view('App\Views\Auth\_message_block') ?>

        <?= form_open('users/editUser') ?>
        <input type="text" name="id" value="<?= user()->id ?>" hidden>
        <div class="row">
            <div class="col-md-6 mb-3">

                <div class="card">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= user()->email ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label text-secondary">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= user()->username ?>">
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label text-secondary">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= user()->fullname ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label text-secondary">NIP</label>
                            <input type="number" class="form-control" id="nip" name="nip" value="<?= user()->nip ?>">
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label text-secondary">Jabatan</label>
                            <select class="form-select" id="jabatan" name="jabatan">
                                <option selected>Open this select menu</option>
                                <?php foreach ($jabatan as $jab) : ?>
                                    <option value="<?= $jab['id_jabatan'] ?>" <?= ($jab['id_jabatan'] == user()->jabatan) ? 'selected' : '' ?>><?= $jab['nama_jabatan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label text-secondary">Nomor Whatsapp</label>
                            <input type="number" class="form-control" id="no_hp" name="no_hp" value="<?= user()->no_hp ?>">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label text-secondary">Status</label>
                            <input type="text" class="form-control" id="status" value="<?= (user()->active == 1) ? 'Active' : 'Inactive' ?>" disabled>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-primary" type="submit" name="update"><i class="fi fi-rr-assessment-alt"></i> Update User</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePassword">
                                <i class="fa-solid fa-lock-open"></i> Update Password
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?= form_close() ?>
    </div>

    <!-- Modal Update Password -->
    <div class="modal fade" id="updatePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <?= form_open('password'); ?>
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="oldPassword" aria-describedby="oldPassword" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Masukkaan Lagi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Modal add group -->
    <!-- Modal -->
    <div class="modal fade" id="addgroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Group</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open('users/addusertogroup'); ?>
                    <?= form_hidden('user_id', user()->id); ?>
                    <select class="form-select" aria-label="Default select example" name="group_id">
                        <option selected value="">-- Pilih Role User --</option>
                        <?php foreach ($groups as $key => $g) : ?>
                            <option value="<?= $g->id; ?>"><?= $g->name; ?></option>
                        <?php endforeach; ?>
                    </select>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>



<?= $this->endSection() ?>