<?= $this->extend('home/layouts') ?>
<?= $this->section('main') ?>


<div class="container-fluid px-4">
    <h1 class="mt-4">User Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">User Management</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            List Of User
        </div>
        <div class="card-body">
            <div class="mb-3">

                <?= view('App\Views\Auth\_message_block') ?>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add User
                </button>
            </div>



            <table id="datatablesUsers">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>email</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php foreach ($allusers as $user) : ?>
                        <tr>
                            <td><?= $user->username ?></td>
                            <td><?= $user->fullname ?></td>
                            <td><?= $user->nama_jabatan ?></td>
                            <td>
                                <a href="<?= base_url('users/user/') . $user->id ?>"><span class="badge text-bg-warning">Detil</span></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('users/addUser') ?>

            <div class="modal-body">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" id="username" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= old('fullname') ?>">
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="number" class="form-control" id="nip" name="nip" value="<?= old('nip') ?>">
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select class="form-control form-select" name="jabatan" id="jabatan" value="<?= old('jabatan') ?>">
                        <option selected value="">Pilih salah satu</option>
                        <?php foreach ($jabatan as $j) : ?>>
                        <option value="<?= $j['id_jabatan'] ?>"><?= $j['nama_jabatan'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. Whatsapp</label>
                    <input type="number" class="form-control <?php if (session('errors.no_hp')) : ?>is-invalid<?php endif ?>" id="no_hp" name="no_hp" placeholder="0823xxxx" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" id="password" name="password" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="pass_confirm" class="form-label">Password Confirmation</label>
                    <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>




<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url() ?>js/users.js"></script>
<script>
    let message = <?= json_encode(session()->getFlashdata('message')) ?>;
    let error = <?= json_encode(session()->getFlashdata('error')) ?>;
    let success = <?= json_encode(session()->getFlashdata('success')) ?>
</script>
<?= $this->endSection() ?>