
<?= $this->extend('tema/tema'); ?> 
<?=$this->section('css');?>
<?=$this->endSection();?>

<?=$this->section('content'); ?>
<div class="page-heading">
    <h1 class="page-title">Images</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base_url('home');?>"><i class="fa fa-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?=base_url('images/index');?>">Images</a>
        </li>
        <li class="breadcrumb-item">Tambah</li>
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
                    <a href='<?=base_url('images/index')?>' class='btn btn-info btn-sm'><i class="fa fa-backward"></i> Kembali</a>
                    
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
                    <div class="ibox-title">Tambah Images</div>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->include('images/_form_images'); ?>
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
