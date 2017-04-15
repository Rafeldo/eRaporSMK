<div class="row">
	<div class="col-xs-12">
	<div class="callout callout-danger" style="display:none;">
		<h4>Error!</h4>
		<p class="error" style="display:none;">Permintaan tidak bisa di proses. Silahkan ulangi lagi.</p>
		<p class="guru" style="display:none;">Guru Mata Pelajaran Tidak Boleh Kosong.</p>
		</div>
		<select id="wali_kelas" class="select2 form-control required" name="wali_kelas" style="width:100%">
		<option value="">==Pilih Wali Kelas==</option>
		<?php foreach($gurus as $guru){ ?>
			<option value="<?php echo $guru->id; ?>"><?php echo $guru->nama; ?></option>
		<?php } ?>
		</select>
	</div>
</div>
<?php 
$uri = $this->uri->segment_array();
?>
<script type="text/javascript">
$(function() {
	$('.select2').select2();
	$('.pilih_guru').click(function(){
		var id_guru = $('#wali_kelas').val();
		if(id_guru == ''){
			$('.callout').show();
			$('p.guru').show();
		} else {
			$.ajax({
				url: '<?php echo site_url('admin/rombel/wali/'.$uri[4])?>',
				type: 'post',
				data: {id:id_guru},
				success: function(response){
					var data = $.parseJSON(response);
					swal({title:data.title, html:data.text, type:data.type}).then(function() {
						if(data.type != 'error'){
							$('#modal_content').modal('hide');
							$('#datatable').dataTable().fnReloadAjax();
						}
					}).done();
					/*if(response == 'sukses'){
						$('#modal_content').modal('hide');
						//window.location.replace('<?php echo site_url('admin/rombel')?>');
						$('#datatable').dataTable().fnReloadAjax();
					}else{
						$('.callout').show();
						$('p.error').show();
					}*/
				}
			});
		}
	});
});
</script>	