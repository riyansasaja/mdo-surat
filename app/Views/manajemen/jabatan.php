<?= $this->extend('home/layouts') ?>
<?= $this->section('main') ?>


    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Jabatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Manajemen Jabatan</li>
        </ol>

        <div class="card mb-4" style="width: 48rem;">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List Of Jabatan
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Add Jabatan
                    </button>
                </div>



                <table id="datatablesUsers">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Jabatan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Nama Jabatan</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($jabatans as $jabatan) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $jabatan['nama_jabatan'] ?></td>
                            <td>
                                <a href="<?= base_url('menej/deletejabatan/') . $jabatan['id_jabatan'] ?>"><span class="badge text-bg-danger">Delete</span></a>

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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Jabatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= form_open('menej/addjabatan') ?>

                <div class="modal-body">

                    <input type="text" class="form-control" placeholder="Nama Jabatan" name="nama_jabatan">

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