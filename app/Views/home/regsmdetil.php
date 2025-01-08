<?= $this->extend('home/layouts') ?>

<?= $this->section('main') ?>

<?php
// dd($mail);
/**
 * @var $dispositions
 * @var $mail
 * @var $mailAttachment
 * @var $suratKodes
 * @var $alluser
 *
 **/
?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col">


            <h1 class="mt-4">Detil Surat Masuk</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/regsm') ?>">Regist</a></li>
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
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col">
                                                    <h5>Ringkasan Isi :</h5>
                                                    <p><?= $mail->isi_surat ?></p>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Agenda</th>
                                                                <th>Tgl. Agenda</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?= $mail->nomor_agenda ?></td>
                                                                <td><?= $mail->tgl_agenda ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 px-2 d-grid gap-2 mb-2">
                                                    <?php if ($mail->status_inmail == 1) : ?>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#disposisiModal"><i class="fa-solid fa-paper-plane"></i> Teruskan Surat</button>
                                                    <?php else : ?>
                                                        <a href="<?= base_url('regsm/redespoted/') . $mail->id_inmail ?>" class="btn btn-primary"><i class="fa-solid fa-plane-slash"></i> Batal Desposisi</a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 px-2 d-grid gap-2 mb-2">
                                                    <?php if ($mail->status_inmail == 1) : ?>
                                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modelEditSM"><i class="fa-regular fa-marker"></i> Edit</button>
                                                    <?php else : ?>
                                                        <button class="btn btn-info" data-bs-toggle="modal" disabled><i class="fa-regular fa-marker"></i> Edit</button>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 px-2 d-grid gap-2 mb-2">
                                                    <?php if ($mail->status_inmail == 1) : ?>
                                                        <a href="<?= base_url('regsm/delete/') . $mail->id_inmail ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                                    <?php else : ?>
                                                        <a href="#" class="btn btn-danger disabled"><i class="fa-solid fa-trash"></i> Hapus</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- row bagian bawah -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> <img src="<?= base_url('assets/img/upload.png') ?>" class="img-fluid" width="7%"> Upload Surat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">

                                        <?php if ($mail->status_inmail == 1) : ?>

                                            <?= form_open_multipart('regsm/inattach'); ?>
                                            <?= form_hidden('inmail_id', $mail->id_inmail); ?>
                                            <label for="formFile" class="form-label">Upload Berkas PDF surat</label>
                                            <input class="form-control mb-2" type="file" id="formFile" name="inmailAttachment">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                            <?= form_close() ?>
                                        <?php else : ?>
                                            <label for="formFile" class="form-label">Upload Berkas PDF surat</label>
                                            <input class="form-control mb-2" type="file" id="formFile" name="inmailAttachment" disabled>
                                            <button type="submit" class="btn btn-primary" disabled>Upload</button>
                                        <?php endif; ?>

                                    </div>
                                    <hr>
                                    <table class="table">
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($mailAttachment as $attach) : ?>
                                                <tr>
                                                    <th>
                                                        <a target="_blank" class="text-decoration-none text-reset" href="<?= base_url('uploads/inmailAttach/') . session()->year . '/' . $mail->kode_surat . '/' . $attach['attachment_file'] ?>">
                                                            <?= "Lampiran " . $i ?>
                                                        </a>
                                                    </th>
                                                    <td>
                                                        <?php if ($mail->status_inmail == 1) : ?>
                                                            <a href="<?= base_url('regsm/dellattach/') . $mail->kode_surat . '/' . $attach['attachment_file'] . '/' . $attach['id_inmail'] ?>" class="text-reset" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa-solid fa-trash"></i></a>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- baris sebelah kanan -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title"> <img src="<?= base_url("assets/img/desposisi.png") ?>" alt="" class="img-fluid" width="10%"> Catatan Desposisi</h5>
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
                </div>

            </div>




        </div>
    </div>

</div> <!-- tutup div row -->

<!-- disini modal untuk edit Surat Masuk  -->
<!-- Modal -->
<div class="modal fade" id="modelEditSM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Detil Surat Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('regsm/edit'); ?>
            <?= form_hidden('status_inmail', $mail->status_inmail); ?>
            <?= form_hidden('inmail_id', $mail->id_inmail); ?>
            <div class="modal-body">
                <!-- form -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="noAgenda" class="form-label">No. Agenda <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="nomor_agenda" id="noAgenda" value="<?= $mail->nomor_agenda ?>">
                    </div>
                    <div class="col">
                        <label for="tglAgenda" class="form-label">Tgl Agenda <i class="text-danger">*</i></label>
                        <input type="date" class="form-control" id="tglAgenda" name="tgl_agenda" value="<?= $mail->tgl_agenda ?>">
                    </div>
                </div>


                <hr class="text-primary">
                <div class="row mb-3">
                    <div class="col">
                        <label for="noSurat" class="form-label">No. Surat <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="no_surat" id="noSurat" value="<?= $mail->no_surat ?>">
                    </div>
                    <div class="col">
                        <label for="tglSurat" class="form-label">Tgl Surat <i class="text-danger">*</i></label>
                        <input type="date" class="form-control" name="tgl_surat" id="tglSurat" value="<?= $mail->tgl_surat ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="asalSurat" class="form-label">Asal Surat <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="asal_surat" id="asalSurat" value="<?= $mail->asal_surat ?>">
                    </div>
                    <div class="col">
                        <label for="perihal" class="form-label">Perihal <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="perihal" id="perihal" value="<?= $mail->perihal ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="sifatsurat" class="form-label">Sifat Surat <i class="text-danger">*</i></label>
                        <select name="sifat_surat" id="sifatsurat" class="form-select">
                            <option value="Biasa" <?= ($mail->sifat_surat == "Biasa") ? 'selected' : ''; ?>>Biasa</option>
                            <option value="Terbatas" <?= ($mail->jenis_surat == "Terbatas") ? 'selected' : ''; ?>>Terbatas</option>
                            <option value="Sangat Terbatas" <?= ($mail->jenis_surat == "Sangat Terbatas") ? 'selected' : ''; ?>>Sangat Terbatas</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="jenissurat" class="form-label">Jenis Surat <i class="text-danger">*</i></label>
                        <select name="jenis_surat" id="jenissurat" class="form-select">
                            <option value="Arahan" <?= ($mail->jenis_surat == "Arahan") ? 'selected' : ''; ?>>Arahan</option>
                            <option value="Korespondensi" <?= ($mail->jenis_surat == "Korespondensi") ? 'selected' : ''; ?>>Korespondensi</option>
                            <option value="Khusus" <?= ($mail->jenis_surat == "Khusus") ? 'selected' : ''; ?>>Khusus</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="jenissurat" class="form-label">Kode Surat <i class="text-danger">*</i></label>
                        <select name="kode_surat" id="kode_surat" class="form-select">
                            <?php foreach ($suratKodes as $kode) : ?>
                                <option value="<?= $kode['kode'] ?>" <?= $kode['kode'] == $mail->kode_surat ? 'selected' : ''; ?>><?= $kode['kode'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="isiSurat" class="form-label">Ringkasan Isi Surat</label>
                        <textarea class="form-control" name="isi_surat" id="isiSurat" rows="3"><?= $mail->isi_surat; ?></textarea>
                    </div>
                </div>
                <!-- form end -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!-- ### -->


<!-- desposisiModal -->
<div class="modal fade" id="disposisiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('regsm/despoted'); ?>
            <?= form_hidden('inmail_id', $mail->id_inmail); ?>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Tujuan Disposisi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select" aria-label="Default select example" name="id_user_despo">
                    <option selected>Pilih Jabatan di Bawah ini</option>
                    <?php foreach ($alluser as $user) : ?>
                        <option value="<?= $user->id ?>">
                            <span><?= $user->nama_jabatan ?></span> ---
                            <span class="text-primary"><?= $user->fullname ?></span>

                        </option>
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
<!-- ### -->


<!-- modal edit surat masuk -->



<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url() ?>js/regsmdetil.js"></script>
<script>
    let message = <?= json_encode(session()->getFlashdata('message')) ?>;
    let success = <?= json_encode(session()->getFlashdata('success')) ?>;
    let error = <?= json_encode(session()->getFlashdata('error')) ?>;
    let path = <?= json_encode(base_url()) ?>;
</script>

<?= $this->endSection() ?>