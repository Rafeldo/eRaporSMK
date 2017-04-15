<?php
$id 			= $sikap->id;
$ajaran_id		= $sikap->ajaran_id;
$rombel_id		= $sikap->rombel_id;
$siswa_id		= $sikap->siswa_id;
$butir_sikap	= $sikap->butir_sikap;
$opsi_sikap 	= $sikap->opsi_sikap;
$uraian_sikap	= $sikap->uraian_sikap;
?>
<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
			  	<div class="form-group" style="margin-bottom:10px;">
                  <label for="butir_sikap_edit" class="col-sm-3 control-label">Butir Sikap</label>
				  <div class="col-sm-4">
				  	<input type="hidden" id="id_sikap_edit" value="<?php echo $id; ?>" />
					<input type="hidden" id="ajaran_id_edit" value="<?php echo $ajaran_id; ?>" />
					<input type="hidden" id="rombel_id_edit" value="<?php echo $rombel_id; ?>" />
					<input type="hidden" id="siswa_id_id" value="<?php echo $siswa_id; ?>" />
				  	<select id="butir_sikap_edit" class="form-control" required>
						<option value="">== Pilih Butir Sikap ==</option>
						<?php foreach($data_sikap as $datasikap){?>
						<option value="<?php echo $datasikap->id; ?>" <?php echo ($butir_sikap == $datasikap->id) ? ' selected="selected"' : '';?>><?php echo $datasikap->butir_sikap; ?></option>
						<?php
						}
						?>
					</select>
                  </div>
				  <div class="col-sm-4">
				  	<select id="opsi_sikap_edit" class="form-control" required>
						<option value="1"<?php echo ($opsi_sikap == 1) ? ' selected="selected"' : '';?>>Positif</option>
						<option value="2"<?php echo ($opsi_sikap == 2) ? ' selected="selected"' : '';?>>Negatif</option>
					</select>
                  </div>
				  <div style="clear:both;"></div>
                </div>
				<div class="form-group">
                  <label for="uraian_sikap_edit" class="col-sm-3 control-label">Catatan Perilaku</label>
				  <div class="col-sm-9">
				  	<textarea id="uraian_sikap_edit" class="form-control" required><?php echo $uraian_sikap; ?></textarea>
                  </div>
				  <div style="clear:both;"></div>
                </div>
				<div style="margin-top:20px;"></div>
				<div class="col-sm-3"></div>
</div>
</div>
<script>
$('#button_form').click(function(){
	var id = $('#id_sikap_edit').val();
	var ajaran_id = $('#ajaran_id_edit').val();
	var rombel_id = $('#rombel_id_edit').val();
	var siswa_id = $('#siswa_id_id').val();
	var butir_sikap = $('#butir_sikap_edit').val();
	var opsi_sikap = $('#opsi_sikap_edit').val();
	var uraian_sikap = $('#uraian_sikap_edit').val();
	console.log(butir_sikap);
	console.log(opsi_sikap);
	console.log(uraian_sikap);
	$.ajax({
		url: '<?php echo site_url('admin/asesmen/edit_sikap'); ?>/'+id,
		type: 'post',
		data: {id:id,ajaran_id:ajaran_id,rombel_id:rombel_id,siswa_id:siswa_id,butir_sikap:butir_sikap,opsi_sikap:opsi_sikap,uraian_sikap:uraian_sikap},
		success: function(response){
			swal({title:"Sukses!",text:"Data berhasil diupdate.",type:"success"}).then(function(e) {
				$('#modal_content').modal('hide');
				$('#result').html(response);
			});
		}
	});
});

</script>