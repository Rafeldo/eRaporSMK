<?php
$id 			= $deskripsi->id;
$ajaran_id		= $deskripsi->ajaran_id;
$rombel_id		= $deskripsi->rombel_id;
$siswa_id		= $deskripsi->siswa_id;
$uraian_deskripsi= $deskripsi->uraian_deskripsi;
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
		<label for="mitra_prakrein" class="col-sm-3 control-label">Uraian Deskripsi</label>
		<div class="input-group col-sm-9">
			<textarea class="form-control editor" rows="10" id="uraian_deskripsi"><?php echo $uraian_deskripsi; ?></textarea>
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
	var uraian_deskripsi = $('#uraian_deskripsi').val();
	$.ajax({
		url: '<?php echo site_url('admin/laporan/edit_deskripsi_antar_mapel'); ?>/'+id,
		type: 'post',
		data: {id:id,ajaran_id:ajaran_id,rombel_id:rombel_id,siswa_id:siswa_id,uraian_deskripsi:uraian_deskripsi},
		success: function(response){
			swal({title:"Sukses!",text:"Data berhasil diupdate.",type:"success"}).then(function(e) {
				$('#modal_content').modal('hide');
				$('#result').html(response);
				$('#datatable').dataTable().fnDestroy();
				$('#datatable').dataTable({
					"sPaginationType"	: "bootstrap",
					"bProcessing"		: false,
					"bServerSide"		: true, 
					"iDisplayLength"	:10,
					"aoColumns"			: null,
					"bSort"				: false,
					"sAjaxSource"		: '<?php echo site_url('admin/laporan/list_deskripsi_antar_mapel'); ?>',
				});
			});
		}
	});
});
$(".editor").wysihtml5({
	"font-styles": false,
	"emphasis": true,
	"lists": false,
	"html": false,
	"link": false,
	"image": false,
	"color": false
});
</script>