<?php

/**
 * @var $mails;
 * @var $suratKodes;
 * @var $lastMail;
 * @var $status;
 **/


?>


<?= $this->extend('home/layouts') ?>

<?= $this->section('main') ?>



<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Surat Masuk Belum Ditindak Lanjuti</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Surat Masuk non TL</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <h5>Data Surat Masuk belum TL</h5>
        </div>
        <div class="card-body">
            <table class="table" id="tabelsuratmasuk">
                <thead>
                    <tr>
                        <th>Asal Surat</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mails as $mail): ?>
                        <tr>
                            <td>
                                <b><?= $mail['asal_surat'] ?></b>
                            </td>
                            <td><?= $mail['no_surat'] ?></td>
                            <td> <?= $mail['perihal'] ?></td>
                            <?php $status = getStatus($mail['id_inmail']) ?>
                            <td>
                                <?php foreach ($status as $stat): ?>
                                    <?= $stat['status'] ?>
                                    <br>
                                    - <?= date('d-m-y H:i:s', strtotime($stat['status_log'])) ?>
                                    <br>
                                <?php endforeach; ?>
                            </td>

                            <td>
                                <a href="<?= base_url('regsm/regsmdetil/') . $mail['id_inmail']; ?>">
                                    <span class="badge rounded-pill text-bg-dark"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>

<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url() ?>js/regsm.js"></script>
<script>
    let message = <?= json_encode(session()->getFlashdata('message')) ?>;
    let error = <?= json_encode(session()->getFlashdata('error')) ?>;
    let success = <?= json_encode(session()->getFlashdata('success')) ?>
</script>
<?= $this->endSection() ?>