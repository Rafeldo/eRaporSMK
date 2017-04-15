<?php
$id 			= $prakerin->id;
$ajaran_id		= $prakerin->ajaran_id;
$rombel_id		= $prakerin->rombel_id;
$siswa_id		= $prakerin->siswa_id;
$mitra_prakerin	= $prakerin->mitra_prakerin;
$lokasi_prakerin 	= $prakerin->lokasi_prakerin;
$lama_prakerin = $prakerin->lama_prakerin;
$keterangan_prakerin	= $prakerin->keterangan_prakerin;
?>
<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<input type="hidden" id="id_prakerin_edit" value="<?php echo $id; ?>" />
<input type="hidden" id="ajaran_id_edit" value="<?php echo $ajaran_id; ?>" />
<input type="hidden" id="rombel_id_edit" value="<?php echo $rombel_id; ?>" />
<input type="hidden" id="siswa_id_edit" value="<?php echo $siswa_id; ?>" />
<div class="col-sm-12" id="form">
	<div class="form-group">
		<label for="mitra_prakrein" class="col-sm-4 control-label">Mitra DU/DI</label>
		<div class="input-group col-sm-8">
			<input type="text" name="mitra_prakerin" id="mitra_prakerin_edit" class="form-control" value="<?php echo $mitra_prakerin; ?>" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lokasi_prakerin" class="col-sm-4 control-label">Lokasi</label>
		<div class="input-group col-sm-8">
			<input type="text" name="lokasi_prakerin" id="lokasi_prakerin_edit" class="form-control" value="<?php echo $lokasi_prakerin; ?>" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lama_prakerin" class="col-sm-4 control-label">Lamanya (bulan)</label>
		<div class="input-group col-sm-8">
			<input type="text" class="form-control" name="lama_prakerin" id="lama_prakerin_edit" value="<?php echo $lama_prakerin; ?>" required />
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan_prakerin" class="col-sm-4 control-label">Keterangan</label>
		<div class="input-group col-sm-8">
			<input type="text" class="form-control" name="keterangan_prakerin" id="keterangan_prakerin_edit" value="<?php echo $keterangan_prakerin; ?>" required />
		</div>
	</div>
</div>
</div>
<script>
$('#button_form').click(function(){
	var id = $('#id_prakerin_edit').val();
	var ajaran_id = $('#ajaran_id_edit').val();
	var rombel_id = $('#rombel_id_edit').val();
	var siswa_id = $('#siswa_id_edit').val();
	var mitra_prakerin = $('#mitra_prakerin_edit').val();
	var lokasi_prakerin = $('#lokasi_prakerin_edit').val();
	var lama_prakerin = $('#lama_prakerin_edit').val();
	var keterangan_prakerin = $('#keterangan_prakerin_edit').val();
	$.ajax({
		url: '<?php echo site_url('admin/laporan/edit_prakerin'); ?>/'+id,
		type: 'post',
		data: {id:id,ajaran_id:ajaran_id,rombel_id:rombel_id,siswa_id:siswa_id,mitra_prakerin:mitra_prakerin,lokasi_prakerin:lokasi_prakerin,lama_prakerin:lama_prakerin,keterangan_prakerin:keterangan_prakerin},
		success: function(response){
			swal({title:"Sukses!",text:"Data berhasil diupdate.",type:"success"}).then(function(e) {
				$('#modal_content').modal('hide');
				$('#result').html(response);
			});
		}
	});
});

</script>