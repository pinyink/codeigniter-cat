<?= form_open_multipart($url, [], ['id' => $id, 'method' => $method]); ?>
	<div class="form-group">
                    
		<?php $invalid = session('_ci_validation_errors.images') ? 'is-invalid' : ''; ?>
                    
		<?php $value = isset($images['images']) ? $images['images'] : 'assets/admincast/dist/assets/img/image.jpg'; ?>
                    
		<img src="<?=base_url($value);?>" style="width: 230px; height: 230px" class="img img-thumbnail" id='img-gambar-images'><br>

                    
		<?= form_label('Images', '', ['class' => 'mt-2']); ?>
                    
			<?= form_upload('images', trim($value), ['class' => 'form-control '.$invalid, 'accept' => ".png,.jpg,.jpeg", 'onchange' => "readURL(this, 'img-gambar-images');"]); ?>
                    
		<?php if(session('_ci_validation_errors.images')):?>
                        
			<div class="text-danger"><?=session('_ci_validation_errors.images')?></div>
                    
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