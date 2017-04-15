<?php 
$attributes = array('class' => '', 'id' => 'myform');
echo form_open($form_action,$attributes);  ?>
<div class="form-group col-sm-12">
	<div class="col-sm-12">
		<textarea class="form-control editor required" rows="10" name="uraian" id="uraian"><?php echo $catatan->uraian; ?></textarea>
	</div>
</div>
<div class="form-group col-sm-12">
	<button type="submit" class="btn btn-primary  pull-right">Simpan</button>
</div>