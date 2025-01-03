<?php

/**
 * @var $mails;
 * @var $suratKodes;
 * @var $lastMail;
 **/


?>


<?= $this->extend('home/layouts') ?>

<?= $this->section('main') ?>



<div class="container-fluid px-4">
    <h1 class="mt-4">Registrasi Surat Masuk</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Regist. Surat Masuk</li>
    </ol>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalSM">+ Registrasi Surat Masuk</button>
    <div class="card mb-4">
        <div class="card-header">
            <h5>Data Surat Masuk</h5>
        </div>
        <div class="card-body">
            <table class="table" id="tabelsuratmasuk">
                <thead>
                    <tr>
                        <th>Asal/No. Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Perihal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mails as $mail): ?>
                        <tr>
                            <td>
                                <b><?= $mail['asal_surat'] ?></b>
                                <br> <?= $mail['no_surat'] ?>
                            </td>
                            <td> <?= date('d/m/Y', strtotime($mail['tgl_surat']))  ?></td>
                            <td><?= $mail['jenis_surat'] ?></td>
                            <td>
                                <a href="<?= base_url('regsm/regsmdetil/') . $mail['id_inmail']; ?>">
                                    <span class="badge rounded-pill text-bg-dark"><?= $mail['status_inmail'] == 1 ? 'Belum Diteruskan' : 'Diteruskan' ?></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>


<!-- disini modal untuk Registrasi Surat Masuk  -->
<!-- Modal -->
<div class="modal fade" id="modalSM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrasi Surat Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- form -->

                <?= form_open('regsm/add') ?>
                <?= form_hidden('username', user()->username); ?>
                <?= form_hidden('status_inmail', '1'); ?>
                <div class="row mb-3">
                    <div class="col">
                        <label for="noAgenda" class="form-label">No. Agenda | No. Agenda Terakhir <span class="text-primary ml-3">--<?=$lastMail ?>--</span>  <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="noAgenda" name="nomor_agenda" required>
                    </div>
                    <div class="col">
                        <label for="tglAgenda" class="form-label">Tgl Agenda <i class="text-danger">*</i></label>
                        <input type="date" class="form-control" id="tglAgenda" name="tgl_agenda" required>
                    </div>
                </div>


                <hr class="text-primary">
                <div class="row mb-3">
                    <div class="col">
                        <label for="noSurat" class="form-label">No. Surat <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="noSurat" name="no_surat" required>
                    </div>
                    <div class="col">
                        <label for="tglSurat" class="form-label">Tgl Surat <i class="text-danger">*</i></label>
                        <input type="date" class="form-control" id="tglSurat" name="tgl_surat" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="asalSurat" class="form-label">Asal Surat <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="asalSurat" name="asal_surat" required>
                    </div>
                    <div class="col">
                        <label for="perihal" class="form-label">Perihal <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="perihal" name="perihal" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="sifatsurat" class="form-label">Sifat Surat <i class="text-danger">*</i></label>
                        <select name="sifat_surat" id="sifatsurat" class="form-select">
                            <option value="Biasa">Biasa</option>
                            <option value="Terbatas">Terbatas</option>
                            <option value="Sangat Terbatas">Sangat Terbatass</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="jenissurat" class="form-label">Jenis Surat <i class="text-danger">*</i></label>
                        <select name="jenis_surat" id="jenissurat" class="form-select">
                            <option value="Arahan">Arahan</option>
                            <option value="Korespondensi">Korespondensi</option>
                            <option value="Khusus">Khusus</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="jenissurat" class="form-label">Kode Surat <i class="text-danger">*</i></label>
                        <select name="kode_surat" id="kode_surat" class="form-select">
                            <?php foreach ($suratKodes as $kode) : ?>
                                <option value="<?= $kode['kode'] ?>"><?= $kode['kode'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="isiSurat" class="form-label">Ringkasan Isi Surat</label>
                        <textarea class="form-control" id="isiSurat" name="isi_surat" rows="3"></textarea>
                    </div>
                </div>
                <!-- form end -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <!-- ### -->


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