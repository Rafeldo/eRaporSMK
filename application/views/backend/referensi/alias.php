<?php
$nama_mapel = '-';
$get_nama_mapel = Datamapel::find_by_id_mapel($kd->id_mapel);
if($get_nama_mapel){
	$nama_mapel = $get_nama_mapel->nama_mapel;
}
$kompetensi_dasar_alias = ($kd->kompetensi_dasar_alias) ? $kd->kompetensi_dasar_alias : $kd->kompetensi_dasar;
?>
<h4><strong>Kompetensi Dasar</strong></h4>
<table class="table">
	<tr>
		<td>Mata Pelajaran</td>
		<td><?php echo $nama_mapel; ?></td>
	</tr>
	<tr>
		<td>ID KD</td>
		<td><?php echo $kd->id_kompetensi; ?></td>
	</tr>
	<tr>
		<td>Kompetensi Dasar</td>
		<td><?php echo $kd->kompetensi_dasar; ?></td>
	</tr>
</table>
<h4><strong>Ringkasan Kompetensi</strong></h4>
<textarea id="kompetensi_dasar_alias" class="editor form-control" rows="10" required placeholder="Kompetensi Dasar Alias"><?php echo $kompetensi_dasar_alias; ?></textarea>
<script type="text/javascript">
$('#button_form').click(function(){
	var kompetensi_dasar_alias = $('#kompetensi_dasar_alias').val();
	$.ajax({
		url: '<?php echo site_url('admin/referensi/edit_kd/'.$kd->id); ?>',
		type: 'post',
		data: {kompetensi_dasar_alias:kompetensi_dasar_alias},
		success: function(response){
			swal({title:"Sukses!",text:"Data berhasil diupdate.",type:"success"}).then(function(e) {
				$('#modal_content').modal('hide');
				$('#result').html(response);
				$('#datatable').dataTable().fnReloadAjax();
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