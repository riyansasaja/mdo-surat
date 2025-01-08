<?php
//get variabel typehint, mencegah error sign dari codeeditor
/** @var $mail */
/** @var $mailAttachment */
/** @var $dispositions */
/** @var $alluser */
/** @var $refPetunjuk */
/** @var $evidence */


?>


<?= $this->extend('home/layouts') ?>

<?= $this->section('main') ?>

<?php

date_default_timezone_set('Asia/Singapore');
// dd($evidence);
?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col">


            <h1 class="mt-4">Detil Surat Masuk</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('inmail') ?>">Surat Masuk</a></li>
                <li class="breadcrumb-item active">Detil Surat Masuk</li>
            </ol>


            <div class="row">
                <!-- baris sebelah kiri -->
                <div class="col-md-7 mb-2">

                    <!-- row bagian atas -->
                    <div class="row">
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <img src="<?= base_url('assets/img/message.png') ?>" alt="" class="img-fluid me-2">
                                                </div>
                                                <div class="col">
                                                    <b><?= $mail->asal_surat ?></b> <br>
                                                    <span>No. Surat : <?= $mail->no_surat ?></span> <br>
                                                    <span class="mt-0">tgl. Surat : <?= $mail->tgl_surat ?></span> <br>
                                                    <span class="badge text-bg-secondary mt-0"><?= $mail->jenis_surat ?></span>
                                                    <span class="badge text-bg-secondary mt-0"><?= $mail->sifat_surat ?></span>
                                                    <span class="badge text-bg-secondary mt-0"><?= $mail->kode_surat ?></span>
                                                    <h5 class="mt-3">Ringkasan Isi :</h5>
                                                    <p><?= $mail->isi_surat ?></p>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <table class="table">
                                                        <tbody>
                                                            <?php $a = 1; ?>
                                                            <?php foreach ($mailAttachment as $key => $attach) : ?>
                                                                <tr>
                                                                    <td>
                                                                        <h5>Lampiran <?= $a; ?></h5>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-info z text-light sawdetil" data-file="<?= $attach['attachment_file'] ?>" data-kodesurat="<?= $mail->kode_surat ?>" data-id="<?= $mail->id_inmail ?>"><i class="fa-solid fa-hurricane"></i> Lihat Surat</button>
                                                                    </td>
                                                                </tr>
                                                                <?php $a++; ?>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <?php if ($evidence) : ?>
                                                    <?php foreach ($evidence as $key => $eviden) : ?>
                                                        <div class="row">
                                                            <div class="col mt-2">
                                                                <a href="<?= base_url('uploads/inmailAttach/').date('Y').'/evidence/'.$eviden['nama_file'] ?>" target="_blank" class="btn btn-primary"> <i class="fa-solid fa-font-awesome"></i> Telah ditindak lanjuti</a>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col mt-2">
                                                            <p><?= $eviden['komentar'] ?></p>
                                                        </div>
                                                    </div>
                                                            <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- baris sebelah kanan -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">

                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#disposisiModal" <?= ($evidence)?'disabled': '' ?> >Tambah Disposisi</button>
                            <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#tindaklanjutModal" <?= ($evidence)?'disabled': '' ?>>Tindak Lanjut</button>
                            <h5 class="card-title"> <img src="<?= base_url("assets/img/desposisi.png") ?>" alt="" class="img-fluid" width="10%"> Catatan Disposisi</h5>
                            <hr>

                            <?php foreach ($dispositions as $dispo) : ?>
                                <?php $petunjuk = explode(',', $dispo['petunjuk']); ?>

                                <blockquote class="blockquote mb-2">
                                    <?php foreach ($petunjuk as $tunjuk) : ?>
                                        <span class="badge text-bg-secondary"><?= $tunjuk ?></span>
                                    <?php endforeach; ?>
                                    <span class="badge text-bg-primary"><?= $dispo['sifat'] ?></span>
                                    <p class="fs-4"><?= $dispo['catatan']; ?></p>
                                    <footer class="fw-lighter fs-6">
                                        Disposisi dari : <?= $dispo['for']; ?> <br>
                                        Disposisi ke : <?= $dispo['to']; ?> <br>
                                        Tgl Disposisi : <?= date('d/m/y H:i', strtotime($dispo['disposition_log'])) ; ?> <br>
                                        <span class="text-danger">Deadline : <?= date('d/m/y', strtotime($dispo['deadline'])); ?></span>


                                    </footer>
                                    <hr>
                                </blockquote>

                            <?php endforeach; ?>
                        </div>
                    </div>



                </div> <!-- Tutup col kanan -->

            </div>




        </div>
    </div>

</div> <!-- tutup div row -->

<!-- Modal Lihat Detil Surat-->
<div class="modal fade" id="detilsuratModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class=" modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detil Surat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-1x1">
                    <iframe id="iframesurat" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" title="YouTube video" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- desposisiModal -->
<div class="modal fade" id="disposisiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <?= form_open('inmail/despoted'); ?>
            <?= form_hidden('inmail_id', $mail->id_inmail); ?>
            <?= form_hidden('disposition_form', user()->fullname); ?>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Tujuan Disposisi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class=" mb-2">

                    <!-- Form Chek segera atau Sangat Segera -->
                    <div class=" form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sifat" id="flexRadioDefault1" value="Segera">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Segera
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sifat" id="flexRadioDefault2" value="Sangat Segera">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Sangat Segera
                        </label>
                    </div>

                </div>

                <select class="form-select mb-2" aria-label="Default select example" name="disposition_to">
                    <option selected value="">Pilih Jabatan di Bawah ini</option>
                    <?php foreach ($alluser as $user) : ?>
                        <option value="<?= $user->fullname ?>">
                          <?= $user->nama_jabatan ?> ---
                          <?= $user->fullname ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php $val = 1; ?>
                <?php foreach ($refPetunjuk as $key => $petunjuk) : ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" id="<?= $val ?>" name="petunjuk[]" type="checkbox" value=" <?= $petunjuk['list_petunjuk']; ?>">
                        <label class="form-check-label" for="<?= $val ?>">
                            <?= $petunjuk['list_petunjuk']; ?>
                        </label>
                    </div>
                    <?php $val++; ?>
                <?php endforeach; ?>
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="catatan"></textarea>
                </div>
                <div class="mb-3 mt-3">
                    <label for="deadline" class="form-label fw-bold">Deadline</label>
                    <input class="form-control" type="date" id="deadline" name="deadline"></input>
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
<!-- ### -->



    <!-- Tindak Lanjut Modal -->
    <div class="modal fade" id="tindaklanjutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Input Tindak lanjut</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!--form open-->
                <?= form_open_multipart('inmail/eviden') ?>
                <?= form_hidden('inmail_id', $mail->id_inmail); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEviden" class="form-label">Bukti Eviden</label>
                        <input class="form-control" type="file" id="inputEviden" name="file-eviden">
                    </div>
                    <div class="">
                        <label for="komentarEviden" class="form-label">Komentar/Catatan</label>
                        <textarea class="form-control" name="komentar-eviden" id="komentarEviden" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <?= form_close();?>
                <!-- end form open -->
            </div>
        </div>
    </div>

<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url() ?>js/detilInmail.js"></script>
<script>
    let message = <?= json_encode(session()->getFlashdata('message')) ?>;
    let success = <?= json_encode(session()->getFlashdata('success')) ?>;
    let error = <?= json_encode(session()->getFlashdata('error')) ?>;
    let year = <?= json_encode(session('year')) ?>;
    let path = <?= json_encode(base_url()) ?>;
</script>

<?= $this->endSection() ?>