<?= form_open_multipart($url, [], ['id' => $id, 'method' => $method]); ?>
	<div class="form-group">
                    
		<?= form_label('Jenis Soal'); ?>
                    
		<?php $invalid = session('_ci_validation_errors.ref_jenis_soal') ? 'is-invalid' : ''; ?>
                    
		<?php $value = isset($ref_soal['ref_jenis_soal']) ? $ref_soal['ref_jenis_soal'] : old('ref_jenis_soal'); ?>
                    
		<div class="input-group">
			
			<?=form_dropdown('ref_jenis_soal', dropdown($ref_jenis_soal, 'id', 'nama'), trim($value), ['class' => 'form-control '.$invalid, 'placeholder' => 'Jenis Soal'])?>
                    
		</div>
                    
		<?php if(session('_ci_validation_errors.ref_jenis_soal')):?>
                        
			<div class="text-danger"><?=session('_ci_validation_errors.ref_jenis_soal')?></div>
                    
		<?php endif ?>
                
	</div>
	<div class="form-group">
                    
		<?= form_label('Soal'); ?>
                    
		<?php $invalid = session('_ci_validation_errors.soal') ? 'is-invalid' : ''; ?>
                    
		<?php $value = isset($ref_soal['soal']) ? $ref_soal['soal'] : old('soal'); ?>
                    
		<?= form_textarea('soal', trim($value), ['class' => 'form-control '.$invalid, 'placeholder' => 'Soal']); ?>
                    
		<?php if(session('_ci_validation_errors.soal')):?>
                        
			<div class="text-danger"><?=session('_ci_validation_errors.soal')?></div>
                    
		<?php endif ?>
                
	</div>
<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> <?=$button;?></button>
<?= form_close(); ?>

<?php $this->section('css'); ?>
<link href="<?=base_url('assets/admincast/dist/assets/vendors/summernote/dist/summernote.css')?>" rel="stylesheet" />
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script src="<?=base_url('assets/admincast/dist/assets/vendors/summernote/dist/summernote.min.js')?>" type="text/javascript"></script>
<script>
    $(function() {
        $('[name="soal"]').summernote({
			height: 240,
		});
    });
</script>
<?php $this->endSection(); ?>