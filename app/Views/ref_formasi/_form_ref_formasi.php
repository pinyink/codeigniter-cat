<?= form_open_multipart($url, [], ['id' => $id, 'method' => $method]); ?>
	<div class="form-group">
                    
		<?= form_label('Formasi'); ?>
                    
		<?php $invalid = session('_ci_validation_errors.nama') ? 'is-invalid' : ''; ?>
                    
		<?php $value = isset($ref_formasi['nama']) ? $ref_formasi['nama'] : old('nama'); ?>
                    
		<div class="input-group">
                        
			<?= form_input('nama', trim($value), ['class' => 'form-control '.$invalid, 'placeholder' => 'Formasi']); ?>
                    
		</div>
                    
		<?php if(session('_ci_validation_errors.nama')):?>
                        
			<div class="text-danger"><?=session('_ci_validation_errors.nama')?></div>
                    
		<?php endif ?>
                
	</div>

	<div class="form-group">
                    
		<?= form_label('Waktu (Menit)'); ?>
                    
		<?php $invalid = session('_ci_validation_errors.waktu') ? 'is-invalid' : ''; ?>
                    
		<?php $value = isset($ref_formasi['waktu']) ? $ref_formasi['waktu'] : old('waktu'); ?>
                    
		<div class="input-group">
                        
			<?= form_input('waktu', trim($value), ['class' => 'form-control '.$invalid, 'placeholder' => 'Waktu'], 'number'); ?>
                    
		</div>
                    
		<?php if(session('_ci_validation_errors.waktu')):?>
                        
			<div class="text-danger"><?=session('_ci_validation_errors.waktu')?></div>
                    
		<?php endif ?>
                
	</div>
<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> <?=$button;?></button>
<?= form_close(); ?>

<?php $this->section('css'); ?>

<?php $this->endSection(); ?>

<?php $this->section('js'); ?>

<script>
</script>
<?php $this->endSection(); ?>