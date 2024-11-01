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
	<hr>
	<?php $x= 1; while($x<=5): ?>
		<?php $value = isset($ref_soal['id_'.$x]) ? $ref_soal['id_'.$x] : old('id_'.$x); ?>
		<input type="hidden" name="id_<?=$x;?>" value="<?=$value;?>">
		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
						
					<?= form_label('Jawaban '.$x); ?>
								
					<?php $invalid = session('_ci_validation_errors.jawaban_'.$x) ? 'is-invalid' : ''; ?>
								
					<?php $value = isset($ref_soal['jawaban_'.$x]) ? $ref_soal['jawaban_'.$x] : old('jawaban_'.$x); ?>
								
					<?= form_textarea('jawaban_'.$x, trim($value), ['class' => 'form-control summernote '.$invalid, 'rows' => '2', 'placeholder' => 'Jawaban']); ?>
								
					<?php if(session('_ci_validation_errors.jawaban_'.$x)):?>
									
						<div class="text-danger"><?=session('_ci_validation_errors.jawaban_'.$x)?></div>
								
					<?php endif ?>
							
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<?= form_label('nilai '.$x); ?>
								
					<?php $invalid = session('_ci_validation_errors.nilai_'.$x) ? 'is-invalid' : ''; ?>
								
					<?php $value = isset($ref_soal['nilai_'.$x]) ? $ref_soal['nilai_'.$x] : old('nilai_'.$x); ?>
								
					<?= form_input('nilai_'.$x, trim($value), ['class' => 'form-control '.$invalid, 'placeholder' => 'nilai']); ?>
								
					<?php if(session('_ci_validation_errors.nilai_'.$x)):?>
									
						<div class="text-danger"><?=session('_ci_validation_errors.nilai_'.$x)?></div>
								
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php $x++; ?>
	<?php endwhile ?>
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

		$('.summernote').summernote();
    });
</script>
<?php $this->endSection(); ?>