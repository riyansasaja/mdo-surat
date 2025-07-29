<?= $this->extend('home/layouts') ?>
<?= $this->section('main') ?>

<?php
/**
 * @var $totalinmail
 * @var $inmailselesai
 * @var $inboxes
 * @var $totalinmail $inbox
 **/


?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Surat Masuk</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <p class="small text-white stretched-link fs-3"><?= $totalinmail ?> Surat</p>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Surat Keluar</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <p class="small text-white stretched-link fs-3">Coming Soon</p>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div> -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Surat Masuk ditindaklanjuti</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <p class="small text-white stretched-link fs-3"><?= $inmailselesai ?> Surat</p>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total Surat Masuk dalam Proses</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <p class="small text-white stretched-link fs-3"><?= $totalinmail - $inmailselesai ?> Surat</p>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Data Surat Masuk Per Bulan
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Data Surat Keluar per Bulan
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Data
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Asal/Tujuan</th>
                        <th>Perihal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Asal/Tujuan</th>
                        <th>Perihal</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($inboxes as $inbox) : ?>
                        <tr>
                            <td><?= $inbox['no_surat'] ?></td>
                            <td><?= $inbox['asal_surat'] ?></td>
                            <td><?= $inbox['perihal'] ?></td>
                            <?php if ($inbox['status_inmail'] == 1) : ?>
                                <td>Diinput</td>
                            <?php elseif ($inbox['status_inmail'] == 2) : ?>
                                <td>Disposisi</td>
                            <?php elseif ($inbox['status_inmail'] == 4) : ?>
                                <td>Selesai/Ditindaklanjuti</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script>
    let path = <?= json_encode(base_url()) ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url() ?>assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<?= $this->endSection() ?>