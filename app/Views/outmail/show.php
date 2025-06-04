<?= $this->extend('home/layouts') ?>
<?= $this->section('main') ?>


<div class="row ms-3 mt-4">

    <div class="col-md-3 ">
        di sini torang mo bekeng depe card 3 x 3
    </div>
    <div class="col-md-3">
        di sini torang mo bekeng depe card 3 x 3
    </div>
    <div class="col-md-3">
        di sini torang mo bekeng depe card 3 x 3
    </div>
    <div class="col-md-3">
        di sini torang mo bekeng depe card 3 x 3
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