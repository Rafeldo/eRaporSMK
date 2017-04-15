<div class="row">
<div class="col-md-12">
<form class="form-horizontal">
<div id="sections">
  <div class="section">
<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<?php if($query == 'rombel'){ ?>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Kelas</label>
	<div class="col-sm-5">
		<select name="kelas[]" class="select2 form-control" id="kelas">
			<option value="">== Pilih Kelas ==</option>
			<?php foreach($rombels as $rombel){?>
			<option value="<?php echo $rombel->tingkat; ?>">Kelas <?php echo $rombel->tingkat; ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Rombongan Belajar</label>
	<div class="col-sm-5">
		<select name="rombel_id" class="select2 form-control" id="rombel">
			<option value="">== Pilih Rombongan Belajar ==</option>
		</select>
	</div>
</div>
	<?php } if($query == 'guru'){ ?>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Kelas</label>
	<div class="col-sm-5">
		<select name="rombel[]" class="select2 form-control" id="rombel">
			<option value="">== Pilih Kelas ==</option>
			<?php foreach($rombels as $rombel){?>
			<option value="<?php echo $rombel->tingkat; ?>">Kelas <?php echo $rombel->tingkat; ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Kelas</label>
	<div class="col-sm-5">
		<select name="guru[]" class="select2 form-control" id="guru">
			<option value="">== Pilih Guru ==</option>
			<?php foreach($gurus as $guru){?>
			<option value="<?php echo $guru->id; ?>"><?php echo $guru->nama; ?></option>
			<?php } ?>
		</select>
	</div>
</div>
	<?php } if($query == 'kd'){ ?>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Kelas</label>
	<div class="col-sm-5">
		<select name="rombel[]" class="select2 form-control" id="kompetensi">
			<option value="">== Pilih Kompetensi ==</option>
			<option value="1">Pengetahuan</option>
			<option value="2">Keterampilan</option>
		</select>
	</div>
</div>
	<?php } if($query == 'kkm'){ ?>
<div class="form-group">
	<label for="kelas" class="col-sm-3 control-label">Kelas</label>
	<div class="col-sm-5">
		<select name="kkm[]" class="select2 form-control">
			<option value="">== Pilih Kelas ==</option>
			<?php foreach($rombels as $rombel){?>
			<option value="<?php echo $rombel->tingkat; ?>">Kelas <?php echo $rombel->tingkat; ?></option>
			<?php } ?>
		<input type="text" class="form-control" name="kkm[]" />
		</select>
	</div>
</div>
	<?php } ?>
</div>
</div>
</form>
<div class="form-group">
	<div class="col-sm-5">
		<a class="btn btn-success" id="button_clone">Tambah Data</a>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
var template = $('#sections .section:first').clone();
var sectionsCount = 1;
var checkJSON = function(m) {
	if (typeof m == 'object') { 
		try{ m = JSON.stringify(m); 
		} catch(err) { 
			return false; 
		}
	}
	if (typeof m == 'string') {
		try{ m = JSON.parse(m); 
		} catch (err) {
			return false;
		}
	}
	if (typeof m != 'object') { 
		return false;
	}
	return true;
};
$('#button_clone').click(function(){
	sectionsCount++;
	var section = template.clone().find('.form-group').each(function(){
		var newId = this.id + sectionsCount;
		$(this).next().attr('for', newId);
        this.id = newId;
	}).end().appendTo('#sections');
    return false;
});
$('#button_form').click(function(){
	$.ajax({
		url: '<?php echo site_url('admin/referensi/update_atur/'.$query.'/'.$id); ?>',
		type: 'post',
		data: $("form").serialize(),
		success: function(response){
			var data = $.parseJSON(response);
			swal({title:data.title, html:data.html, type:data.type}).then(function() {
				$('#modal_content').modal('hide');
				$('#datatable').dataTable().fnReloadAjax();
			});
		}
	});
});
$('#kelas').change(function(){
	var ini = $(this).val();
	if(ini == ''){
		return false;
	}
	$.ajax({
		url: '<?php echo site_url('admin/ajax/get_rombel');?>',
		type: 'post',
		data: $("form").serialize(),
		success: function(response){
				var data = $.parseJSON(response);
				$('#rombel').html('<option value="">== Pilih Rombongan Belajar ==</option>');
				if($.isEmptyObject(data.result)){
				} else {
				$.each(data.result, function (i, item) {
					$('#rombel').append($('<option>', { 
						value: item.value,
						text : item.text
					}));
				});
			}
		}
	});
});
$('#kompetensi').change(function(){
	var ini = $(this).val();
	if(ini == ''){
		return false;
	}
	$.ajax({
		url: '<?php echo site_url('admin/ajax/get_kd');?>',
		type: 'post',
		data: $("form").serialize(),
		success: function(response){
				console.log(response);
		}
	});
});
$('#rombel').change(function(){
	var get = '';
	var nama_kur = '';
	var ini = $(this).val();
	if(ini == ''){
		return false;
	}
	var query = $('#query').val();
	if(query == 'rapor'){
		get = 'rapor';
	} else if(query == 'legger'){
		get = 'legger';
	} else if(query == 'deskripsi_antar_mapel'){
		get = 'deskripsi_antar_mapel';
	} else if(query == 'absensi'){
		get = 'absensi';
	} else if(query == 'nama_kur_kurikulum'){
		get = 'kurikulum';
	} else {
		get = 'mapel';
	}
	$.ajax({
		url: '<?php echo site_url('admin/ajax/get_');?>'+get,
		type: 'post',
		data: $("form").serialize(),
		success: function(response){
			result = checkJSON(response);
			if(result == true){
				var data = $.parseJSON(response);
				$('#mapel').html('<option value="">== Pilih Mata Pelajaran ==</option>');
				if($.isEmptyObject(data.mapel)){
				} else {
					$.each(data.mapel, function (i, item) {
						$('#mapel').append($('<option>', { 
							value: item.value,
							text : item.text
						}));
					});
				}
			} else {
				console.log('no data');
			}
		}
	});
});
</script>