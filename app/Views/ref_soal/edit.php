
<?= $this->extend('tema/tema'); ?> 
<?=$this->section('css');?>
<?=$this->endSection();?>

<?=$this->section('content'); ?>
<div class="page-heading">
    <h1 class="page-title">Ref Soal</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base_url('home');?>"><i class="fa fa-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?=base_url('ref_soal/index');?>">Ref Soal</a>
        </li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<!-- Container -->
<div class="page-content fade-in-up">
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <?=session()->getFlashData('message');?>
            <div class="ibox">
                <div class="ibox-body">
                    <a href='<?=base_url('ref_soal/index')?>' class='btn btn-info btn-sm'><i class="fa fa-backward"></i> Kembali</a>
                    <a href="<?=base_url('images/tambah')?>" class="btn btn-info btn-sm btn-primary" target="_blank"><i class="fa fa-image"></i> Images</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Edit Ref Soal</div>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->include('ref_soal/_form_ref_soal'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->
<?=$this->endSection();?>
<?=$this->section('js');?>

<?=$this->endSection();?>
