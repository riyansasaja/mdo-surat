<?php
/**
 * @var $inmails
 **/

echo $this->extend('home/layouts');
echo $this->section('main');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Surat Masuk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">List Surat Dari Operator</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Surat Masuk Siap untuk Disposisi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table id="tbInmailShow" class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Asal Surat</th>
                            <th scope="col">Nomor Surat</th>
                            <th scope="col">Tentang</th>
                            <th scope="col">Status</th>

                            <th scope="col">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($inmails as $key => $inmail) : ?>
                            <tr>
                                <td><?= $inmail['asal_surat'] ?></td>
                                <td><?= $inmail['no_surat'] ?></td>
                                <td><?= $inmail['isi_surat'] ?></td>
                                <?php $status = getStatus($inmail['id_inmail']) ?>
                                <td>
                                <?php foreach ($status as $stat): ?>
                                    <?= $stat['status'] ?>
                                    <br>
                                    - <?= date('d-m-y H:i:s', strtotime($stat['status_log'])) ?>
                                    <br>
                                <?php endforeach; ?>
                                </td>

                                <td>
                                    <a href="<?= base_url('inmail/detilmail/') .  $inmail['id_inmail'] ?>" class="badge rounded-pill text-bg-success" title='Detil'><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>


                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url() ?>js/inmail.js"></script>
<script>
    let message = <?= json_encode(session()->getFlashdata('message')) ?>;
    let success = <?= json_encode(session()->getFlashdata('success')) ?>;
    let error = <?= json_encode(session()->getFlashdata('error')) ?>;
    let path = <?= json_encode(base_url()) ?>;
</script>

<?= $this->endSection() ?>