<?= $this->extend('home/layouts') ?>
<?= $this->section('main') ?>

<?php
//dd($inmaildespo);
?>

    <div class="container-fluid px-4">
        <img class="img-fluid" src="<?= base_url('assets/img/background-under-construction-download.png') ?>" alt="bg_underConstruction">
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