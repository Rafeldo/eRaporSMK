<?php
$id 			= $prestasi->id;
$ajaran_id		= $prestasi->ajaran_id;
$rombel_id		= $prestasi->rombel_id;
$siswa_id		= $prestasi->siswa_id;
$jenis_prestasi	= $prestasi->jenis_prestasi;
$keterangan_prestasi 	= $prestasi->keterangan_prestasi;
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
		<label for="mitra_prakrein" class="col-sm-4 control-label">Jenis Prestasi</label>
		<div class="input-group col-sm-8">
			<input type="text" name="jenis_prestasi" id="jenis_prestasi_edit" class="form-control" value="<?php echo $jenis_prestasi; ?>" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lokasi_prakerin" class="col-sm-4 control-label">Keterangan Prestasi</label>
		<div class="input-group col-sm-8">
			<input type="text" name="keterangan_prestasi" id="keterangan_prestasi_edit" class="form-control" value="<?php echo $keterangan_prestasi; ?>" required />			
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
	var jenis_prestasi = $('#jenis_prestasi_edit').val();
	var keterangan_prestasi = $('#keterangan_prestasi_edit').val();
	$.ajax({
		url: '<?php echo site_url('admin/laporan/edit_prestasi'); ?>/'+id,
		type: 'post',
		data: {id:id,ajaran_id:ajaran_id,rombel_id:rombel_id,siswa_id:siswa_id,jenis_prestasi:jenis_prestasi,keterangan_prestasi:keterangan_prestasi},
		success: function(response){
			swal({title:"Sukses!",text:"Data berhasil diupdate.",type:"success"}).then(function(e) {
				$('#modal_content').modal('hide');
				$('#result').html(response);
			});
		}
	});
});

</script>