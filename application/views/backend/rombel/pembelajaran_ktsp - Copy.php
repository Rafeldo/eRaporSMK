<style>
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
<div class="row">
	<div class="col-xs-12">
	<form id="pembelajaran">
	<input type="hidden" id="rombel_id" value="<?php echo $data_rombel->id; ?>" />
	<input type="hidden" name="keahlian_id" id="keahlian_id" value="<?php echo $data_rombel->kurikulum_id; ?>" />
	<?php
	$ajaran = get_ta();
	$tingkat = $data_rombel->tingkat;
	$kurikulum_id = $data_rombel->kurikulum_id;
	$kelas_X	= 0;
	$kelas_XI	= 0;
	$kelas_XII	= 0;
	$kelas_XIII	= 0;
	$k1 = 0;
	$k2 = 0;
	$k3 = 0;
	if($tingkat == 10){
		$query_kelas = 'kelas_X';
	} elseif($tingkat == 11){
		$query_kelas = 'kelas_XI';
	} elseif($tingkat == 12){
		$query_kelas = 'kelas_XII';
	} elseif($tingkat == 13){
		$query_kelas = 'kelas_XIII';
	}
	$all_mapel = Matpelkomp::find('all', array("conditions" => "kurikulum_id = $kurikulum_id AND  $query_kelas = 1"));
	$all_normatif_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'normatif'"));
	$all_adaptif_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'adaptif'"));
	$all_produktif_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'produktif'"));
	$all_mulok_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'k_mulok'"));
	foreach($all_normatif_alias as $normatif_alias){
		$get_normatif_alias[$normatif_alias->id] = $normatif_alias->id_mapel;
	}
	if(isset($get_normatif_alias)){
		$get_normatif_alias_value = $get_normatif_alias;
	} else {
		$get_normatif_alias_value = array();
	}
	foreach($all_adaptif_alias as $adaptif_alias){
		$get_adaptif_alias[$adaptif_alias->id] = $adaptif_alias->id_mapel;
	}
	if(isset($get_adaptif_alias)){
		$get_adaptif_alias_value = $get_adaptif_alias;
	} else {
		$get_adaptif_alias_value = array();
	}
	foreach($all_produktif_alias as $produktif_alias){
		$get_produktif_alias[$produktif_alias->id] = $produktif_alias->id_mapel;
	}
	if(isset($get_produktif_alias)){
		$get_produktif_alias_value = $get_produktif_alias;
	} else {
		$get_produktif_alias_value = array();
	}
	foreach($all_mulok_alias as $mulok_alias){
		$get_mulok_alias[$mulok_alias->id] = $mulok_alias->id_mapel;
	}
	if(isset($get_mulok_alias)){
		$get_mulok_alias_value = $get_mulok_alias;
	} else {
		$get_mulok_alias_value = array();
	}
	foreach($all_mapel as $allmapel){
		$get_id_mapel[] = $allmapel->id_mapel;
	}
	if(isset($get_id_mapel)){
		foreach($get_id_mapel as $abc){
			$get_id_2006[$abc] = substr($abc,0,2);
		}
	} else {
		$get_id_2006 = array();
	}
	$normatif_1 = preg_quote(10, '~'); // don't forget to quote input string!
	$normatif_2 = preg_quote(20, '~'); // don't forget to quote input string!
	$normatif_3 = preg_quote(30, '~'); // don't forget to quote input string!
	$normatif_4 = preg_quote(50, '~'); // don't forget to quote input string!
	$normatif_5 = preg_quote(84, '~'); // don't forget to quote input string!
	$adaptif_1 = preg_quote(40, '~'); // don't forget to quote input string!
	$adaptif_2 = preg_quote(80, '~'); // don't forget to quote input string!
	$produktif = preg_quote('P', '~'); // don't forget to quote input string!
	$cari_mulok = preg_quote(85, '~'); // don't forget to quote input string!
	$mapel_normatif_1 = preg_grep('~' . $normatif_1 . '~', $get_id_2006);
	$mapel_normatif_2 = preg_grep('~' . $normatif_2 . '~', $get_id_2006);
	$mapel_normatif_3 = preg_grep('~' . $normatif_3 . '~', $get_id_2006);
	$mapel_normatif_4 = preg_grep('~' . $normatif_4 . '~', $get_id_2006);
	$mapel_normatif_5 = preg_grep('~' . $normatif_5 . '~', $get_id_2006);
	$mapel_adaptif_1 = preg_grep('~' . $adaptif_1 . '~', $get_id_2006);
	$mapel_adaptif_2 = preg_grep('~' . $adaptif_2 . '~', $get_id_2006);
	$mapel_normatif = $mapel_normatif_1 + $mapel_normatif_2 + $mapel_normatif_3 + $mapel_normatif_4 + $mapel_normatif_5 + $get_normatif_alias_value;
	$mapel_adaptif = $mapel_adaptif_1 + $mapel_adaptif_2 + $get_adaptif_alias_value;
	$mapel_produktif1 = preg_grep('~' . $produktif . '~', $get_id_2006);
	$mapel_produktif = $mapel_produktif1 + $get_produktif_alias_value;
	$all_mulok1 = preg_grep('~' . $cari_mulok . '~', $get_id_2006);
	$all_mulok = $all_mulok1 + $get_mulok_alias_value;
	?>
	<table class="table table-bordered table-hover" id="pembelajaran">
		<thead>
			<th class="text-center" width="5%">No</th>
			<th width="50%">Mata Pelajaran</th>
			<th width="45%">Guru Mata Pelajaran</th>
		</thead>
		<tbody id="editable">
		<tr>
			<th colspan="3">Mata Pelajaran Normatif</th>
		</tr>
	<?php $i=1;
		if($mapel_normatif){
		foreach($mapel_normatif as $normatif => $value){
		$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran->id,$data_rombel->id,$normatif);
		if($find){
			$query = 'kurikulum';
		} else {
			$query = 'normatif';
		}
	?>
		<tr class="tr_a">
			<td><div class="text-center"><?php echo $i; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$normatif); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$normatif); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$normatif); ?> (<?php echo $normatif; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $normatif; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$normatif,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$normatif,'id'); ?>" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php $i++;}
	} else { ?>
		<tr class="tr_a">
			<td><div class="text-center"><?php echo $i; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="" />
				<input type="text" name="mapel" id="mapel" value="" class="form-control" />
				<input type="hidden" name="query" id="query" value="kurikulum" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="3"><span class="btn btn-primary button_a"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Normatif</span></td>
		</tr>
		<tr>
			<th colspan="3">Mata Pelajaran Adaptif</th>
		</tr>
	<?php 
		$a=isset($i) ? $i : 1;
		if($mapel_adaptif){
		foreach($mapel_adaptif as $adaptif => $value){
		$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran->id,$data_rombel->id,$adaptif);
		if($find){
			$query = 'kurikulum';
		} else {
			$query = 'adaptif';
		}
	?>
		<tr class="tr_b">
			<td><div class="text-center"><?php echo $a; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$adaptif); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$adaptif); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$adaptif); ?> (<?php echo $adaptif; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $adaptif; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$adaptif,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$adaptif,'id'); ?>" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php $a++;}
	} else { ?>
		<tr class="tr_b">
			<td><div class="text-center"><?php echo $a; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="" />
				<input type="text" name="mapel" id="mapel" value="" class="form-control" />
				<input type="hidden" name="query" id="query" value="kurikulum" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="3"><span class="btn btn-primary button_b"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Adaptif</span></td>
		</tr>
		<tr>
			<th colspan="3">Mata Pelajaran Produktif</th>
		</tr>
	<?php $b=isset($a) ? $a : 1;
		if($mapel_produktif){
		foreach($mapel_produktif as $produktif => $value){
		$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran->id,$data_rombel->id,$produktif);
		if($find){
			$query = 'kurikulum';
		} else {
			$query = 'produktif';
		}
	?>
		<tr class="tr_c">
			<td><div class="text-center"><?php echo $b; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$produktif); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$produktif); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$produktif); ?> (<?php echo $produktif; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $produktif; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$produktif,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$produktif,'id'); ?>" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php $b++;}
	} else { ?>
		<tr class="tr_c">
			<td><div class="text-center"><?php echo $b; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="" />
				<input type="text" name="mapel" id="mapel" value="" class="form-control" />
				<input type="hidden" name="query" id="query" value="kurikulum" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="3"><span class="btn btn-primary button_c"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Produktif</span></td>
		</tr>
		<tr>
			<th colspan="3">Mata Pelajaran Muatan Lokal</th>
		</tr>
	<?php 
		$c=isset($b) ? $b : 1;
		if($all_mulok){
		foreach($all_mulok as $mulok=>$value){
		$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran->id,$data_rombel->id,$mulok);
		if($find){
			$query = 'kurikulum';
		} else {
			$query = 'k6_mulok';
		}
		?>
		<tr class="tr_mulok">
			<td><div class="text-center"><?php echo $c; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$mulok); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mulok); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mulok); ?> (<?php echo $mulok; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mulok; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mulok,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mulok,'id'); ?>" title="Pilih Guru"></a>
			</td>
		</tr>
		<?php
		$c++;
		}
	} else {
	?>
	<tr class="tr_mulok">
			<td><div class="text-center"><?php echo $c; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="" />
				<input type="text" name="mapel" id="mapel" value="" class="form-control" />
				<input type="hidden" name="query" id="query" value="kurikulum" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php
	}
	?>
		</tbody>
	</table>
	<a class="btn btn-primary button_m"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Muatan Lokal</a>
	</form>
	</div>
</div>
<?php echo link_tag('assets/plugins/bootstrap-editable/css/bootstrap-editable.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/jquery.mockjax.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-noty/packaged/jquery.noty.packaged.js"></script>
<script>
var i = <?php echo isset($c) ? $c : $b; ?>;
$("a.button_m").click(function() {
  $("table#pembelajaran tbody tr.tr_mulok:last")//.clone().find("input[name=mapel]").each(function() {
    .clone().find("td").each(function() {
	//.clone().find("input[name=mapel]").each(function() {
	var $this     = $(this),
		$parentTR = $this.closest('tr');
	$($parentTR).show();
    $(this).find('div.text-center').text(i);
	$(this).find('a.nama_mapel').remove();
	$(this).find('input[name=id_mulok]').attr('value', 0);
	$(this).find('input[name=mapel]').attr('type', 'text');
	$(this).find('input[name=mapel]').attr('value', '');
	$(this).find('input[name=guru]').attr('value', '');
	$(this).find('input[name=query]').attr('value', 'k_mulok');
	$(this).find('a#country').attr('data-value', '0');
	$(this).find('a#country').text('Pilih Guru');
	$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
	$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
		var data = $.parseJSON(response);
		var guru = [];
		$.each(data, function(i, item) {
        	guru.push({id: item.id, text: item.text});
    	});
		$('tbody#editable tr td a.guru').editable({
	        source: guru,
			emptytext : 'Pilih Guru',
			//showbuttons: false,
    	    select2: {
				dropdownAutoWidth : true,
        	    width: 300,
            	placeholder: '== Pilih Guru ==',
	            allowClear: true
    	    },
		    success: function(response, newValue) {
				$(this).prev().val(newValue);
    		}
	    });
		$('tbody#editable tr td a.mulok').editable({
			type: 'text',
			pk: 1,
			name: 'mapel',
			title: 'Masukkan Mapel Mulok',
		    success: function(response, newValue) {
				$(this).prev().val(newValue);
    		}
	    });
	});
  }).end().appendTo("table#pembelajaran");
  i++;
});
var a = <?php echo isset($i) ? $i : 1; ?>;
$("span.button_a").click(function() {
  	var $this     = $(this),
		$parentTR = $this.closest('tr').prev('tr.tr_a');
	$parentTR.clone().insertAfter($parentTR).find("td").each(function() {
		$(this).first('td').find('div.text-center').text(a);
		$(this).next('td').find('a.nama_mapel').remove();
		$(this).next('td').find('input[name=mapel]').attr('type', 'text');
		$(this).next('td').find('input[name=mapel]').attr('value', '');
		$(this).next('td').find('input[name=guru]').attr('value', '');
		$(this).next('td').find('input[name=query]').attr('value', 'normatif');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			$.each(data, function(a, item) {
				guru.push({id: item.id, text: item.text});
			});
			$('tbody#editable tr td a.nama_mapel').editable({
				type: 'text',
				pk: 1,
				name: 'nama_mapel_alias',
				title: 'Edit Nama Mapel',
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
			$('tbody#editable tr td a.guru').editable({
				source: guru,
				emptytext : 'Pilih Guru',
				//showbuttons: false,
				select2: {
					dropdownAutoWidth : true,
					width: 300,
					placeholder: '== Pilih Guru ==',
					allowClear: true
				},
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
		});
	});
	a++;
});
$("span.button_b").click(function() {
  	var $this     = $(this),
		$parentTR = $this.closest('tr').prev('tr');
	var b = <?php echo isset($a) ? $a : 1; ?>;
	$parentTR.clone().insertAfter($parentTR).find("td").each(function() {
		$(this).first('td').find('div.text-center').text(b);
		$(this).next('td').find('a.nama_mapel').remove();
		$(this).next('td').find('input[name=mapel]').attr('type', 'text');
		$(this).next('td').find('input[name=mapel]').attr('value', '');
		$(this).next('td').find('input[name=guru]').attr('value', '');
		$(this).next('td').find('input[name=query]').attr('value', 'adaptif');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			$.each(data, function(a, item) {
				guru.push({id: item.id, text: item.text});
			});
			$('tbody#editable tr td a.nama_mapel').editable({
				type: 'text',
				pk: 1,
				name: 'nama_mapel_alias',
				title: 'Edit Nama Mapel',
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
			$('tbody#editable tr td a.guru').editable({
				source: guru,
				emptytext : 'Pilih Guru',
				//showbuttons: false,
				select2: {
					dropdownAutoWidth : true,
					width: 300,
					placeholder: '== Pilih Guru ==',
					allowClear: true
				},
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
		});
		b++;
	});
});
var c = <?php echo isset($b) ? $b : 1; ?>;
$("span.button_c").click(function() {
  	var $this     = $(this),
		$parentTR = $this.closest('tr').prev('tr');
	$parentTR.clone().insertAfter($parentTR).find("td").each(function() {
		$(this).first('td').find('div.text-center').text(c);
		$(this).next('td').find('a.nama_mapel').remove();
		$(this).next('td').find('input[name=mapel]').attr('type', 'text');
		$(this).next('td').find('input[name=mapel]').attr('value', '');
		$(this).next('td').find('input[name=guru]').attr('value', '');
		$(this).next('td').find('input[name=query]').attr('value', 'produktif');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			$.each(data, function(a, item) {
				guru.push({id: item.id, text: item.text});
			});
			$('tbody#editable tr td a.guru').editable({
				source: guru,
				emptytext : 'Pilih Guru',
				//showbuttons: false,
				select2: {
					dropdownAutoWidth : true,
					width: 300,
					placeholder: '== Pilih Guru ==',
					allowClear: true
				},
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
			$('tbody#editable tr td a.nama_mapel').editable({
				type: 'text',
				pk: 1,
				name: 'nama_mapel_alias',
				title: 'Edit Nama Mapel',
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
		});
	});
	c++;
});
$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(function(){
	$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
	$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
		var data = $.parseJSON(response);
		var guru = [];
		$.each(data, function(i, item) {
        	guru.push({id: item.id, text: item.text});
    	});
		$('tbody#editable tr td a').editable({
	        source: guru,
			emptytext : 'Pilih Guru',
			//showbuttons: false,
    	    select2: {
				dropdownAutoWidth : true,
        	    width: 300,
            	placeholder: '== Pilih Guru ==',
	            allowClear: true
    	    },
		    success: function(response, newValue) {
				$(this).prev().val(newValue);
    		}
	    });   
	});
	$('.simpan_pembelajaran').click(function(){
		//e.preventDefault();
		var rombel_id = $('#rombel_id').val();
		var query = $('#query').val();
		var data = $("form#pembelajaran").serializeObject();
		var result = $.parseJSON(JSON.stringify(data));
		console.log(result);
		if(result.guru.length > 1) {
			$.each(result.guru, function (i, item) {
				//if(item){
				$.ajax({
					url: '<?php echo site_url('admin/rombel/simpan_pembelajaran/'); ?>',
					type: 'post',
					data: {keahlian_id:result.keahlian_id,query:result.query[i],rombel_id:rombel_id,guru_id:item,mapel_id:result.mapel[i],id_mulok:result.id_mulok[i], nama_mapel_alias:result.nama_mapel_alias[i]},
					success: function(response){
						var view = $.parseJSON(response);
						noty({
							text        : view.text,
							type        : view.type,
							timeout		: 1500,
							dismissQueue: true,
							layout      : 'topLeft',
							animation: {
								open: {height: 'toggle'},
								close: {height: 'toggle'}, 
								easing: 'swing', 
								speed: 500 
							}
						});
					}
				});
				//}
			});
		}
		window.setTimeout(function() { 
			$('#datatable').dataTable().fnReloadAjax();
			$('#modal_content').modal('hide');
		}, 5000);
	});
});
</script>