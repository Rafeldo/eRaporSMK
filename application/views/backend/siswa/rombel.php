<div class="row">
	<div class="col-sm-12">
	<div class="callout callout-danger" style="display:none;">
		<h4>Error!</h4>
		<p></p>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
		<select id="id_rombel" class="select2 form-control required" style="width:100%;">
		<option value="">==Pilih Rombongan Belajar==</option>
		<?php foreach($rombels as $rombel){ ?>
			<option value="<?php echo $rombel->id; ?>"><?php echo $rombel->nama; ?></option>
		<?php } ?>
		</select>
		</div>
		</div>
	</div>
</div>
<?php 
$uri = $this->uri->segment_array();
?>
<script type="text/javascript">
    $(function() {
		$('.select2').select2();
		$('.pilih_guru').click(function(){
			var id_rombel = $('#id_rombel').val();
			if(id_rombel == ''){
				$('.callout').show();
				$('.callout p').text('Rombongan Belajar tidak boleh kosong.');	
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/siswa/setrombel/'.$uri[4])?>',
				type: 'post',
				data: {id:id_rombel},
				success: function(response){
					if(response == 'sukses'){
						$('#modal_content').modal('hide');
						//window.location.replace('<?php echo site_url('admin/siswa')?>');
						$('#datatable').dataTable().fnReloadAjax();
					}else{
						$('.callout').show();
						$('.callout p').text('Permintaan tidak bisa di proses. Silahkan ulangi lagi.');
					}
				}
			});
		});
	});
</script>	