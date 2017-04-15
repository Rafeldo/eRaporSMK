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
	$all_mapel_a_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'kurikulum_a'"));
	$all_mapel_b_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'kurikulum_b'"));
	$all_mapel_c_alias = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'kurikulum_c'"));
	$all_mapel_mulok = Kurikulumalias::find('all', array("conditions" => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND nama_kur = 'k13_mulok'"));
	foreach($all_mapel_a_alias as $mapel_a_alias){
		$get_mapel_a_alias[$mapel_a_alias->id] = $mapel_a_alias->id_mapel;
	}
	if(isset($get_mapel_a_alias)){
		$get_get_mapel_a_alias_value = $get_mapel_a_alias;
	} else {
		$get_get_mapel_a_alias_value = array();
	}
	foreach($all_mapel_b_alias as $mapel_b_alias){
		$get_mapel_b_alias[$mapel_b_alias->id] = $mapel_b_alias->id_mapel;
	}
	if(isset($get_mapel_b_alias)){
		$get_get_mapel_b_alias_value = $get_mapel_b_alias;
	} else {
		$get_get_mapel_b_alias_value = array();
	}
	foreach($all_mapel_c_alias as $mapel_c_alias){
		$get_mapel_c_alias[$mapel_c_alias->id] = $mapel_c_alias->id_mapel;
	}
	if(isset($get_mapel_c_alias)){
		$get_get_mapel_c_alias_value = $get_mapel_c_alias;
	} else {
		$get_get_mapel_c_alias_value = array();
	}
	foreach($all_mapel_mulok as $mapel_mulok){
		$get_mapel_mulok[$mapel_mulok->id] = $mapel_mulok->id;
	}
	if(isset($get_mapel_mulok)){
		$get_mapel_mulok_value = $get_mapel_mulok;
	} else {
		$get_mapel_mulok_value = array();
	}
	$kelompok_a = preg_quote('A0', '~'); // don't forget to quote input string!
	$kelompok_b = preg_quote('B0', '~'); // don't forget to quote input string!
	$kelompok_c = preg_quote('C', '~'); // don't forget to quote input string!
	foreach($all_mapel as $allmapel){
		$get_id_mapel[$allmapel->id_mapel] = $allmapel->id_mapel;
	}
	$mapel_a1 = preg_grep('~' . $kelompok_a . '~', $get_id_mapel);
	$mapel_b1 = preg_grep('~' . $kelompok_b . '~', $get_id_mapel);
	$mapel_c1 = preg_grep('~' . $kelompok_c . '~', $get_id_mapel);
	$mapel_a = $mapel_a1 + $get_get_mapel_a_alias_value;
	$mapel_b = $mapel_b1 + $get_get_mapel_b_alias_value;
	$mapel_c = $mapel_c1 + $get_get_mapel_c_alias_value;
	?>
	<table class="table table-bordered table-hover" id="pembelajaran">
		<thead>
			<th class="text-center" width="5%">No</th>
			<th width="50%">Mata Pelajaran</th>
			<th width="45%">Guru Mata Pelajaran</th>
		</thead>
		<tbody id="editable">
		<tr>
			<th colspan="3">Mata Pelajaran Kelompok A</th>
		</tr>
	<?php $i=1;
		if($mapel_a){
		foreach($mapel_a as $mapela => $value){
		$find = Kurikulumalias::find_by_id_and_ajaran_id_and_rombel_id($mapela, $ajaran->id,$data_rombel->id);
		if($find){
			$query = 'kurikulum_a';
		} else {
			$query = 'kurikulum';
		}
	?>
		<tr class="tr_a">
			<td><div class="text-center"><?php echo $i; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$mapela); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapela); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapela); ?> (<?php echo $mapela; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mapela; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapela,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapela,'id'); //$guru_id;?>" title="Pilih Guru"></a>
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
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" data-title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<!--tr>
			<td colspan="3"><span class="btn btn-primary button_a"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Kelompok A</span></td>
		</tr-->
		<tr>
			<th colspan="3">Mata Pelajaran Kelompok B</th>
		</tr>
	<?php 
		$a=isset($i) ? $i : 1;
		if($mapel_b){
		foreach($mapel_b as $mapelb => $value){
		$find = Kurikulumalias::find_by_id_and_ajaran_id_and_rombel_id($mapelb, $ajaran->id,$data_rombel->id);
		if($find){
			$query = 'kurikulum_b';
		} else {
			$query = 'kurikulum';
		}
	?>
		<tr class="tr_b">
			<td><div class="text-center"><?php echo $a; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$mapelb); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapelb); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapelb); ?> (<?php echo $mapelb; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mapelb; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapelb,'id'); //$guru_id;?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapelb,'id'); //$guru_id;?>" title="Pilih Guru"></a>
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
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" data-title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<!--tr>
			<td colspan="3"><span class="btn btn-primary button_b"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Kelompok B</span></td>
		</tr-->
		<tr>
			<th colspan="3">Mata Pelajaran Kelompok C</th>
		</tr>
	<?php $b=isset($a) ? $a : 1;
		if($mapel_c){
		foreach($mapel_c as $mapelc => $value){
		$find = Kurikulumalias::find_by_id_and_ajaran_id_and_rombel_id($mapelc, $ajaran->id,$data_rombel->id);
		if($find){
			$query = 'kurikulum_c';
		} else {
			$query = 'kurikulum';
		}
	?>
		<tr class="tr_c">
			<td><div class="text-center"><?php echo $b; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$mapelc); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapelc); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mapelc); ?> (<?php echo $mapelc; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mapelc; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="<?php echo $query; ?>" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapelc,'id'); //$guru_id;?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mapelc,'id'); //$guru_id;?>" title="Pilih Guru"></a>
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
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="0" data-title="Pilih Guru"></a>
			</td>
		</tr>
	<?php } ?>
		<!--tr>
			<td colspan="3"><span class="btn btn-primary button_c"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Kelompok C</span></td>
		</tr-->
		<tr>
			<th colspan="3">Mata Pelajaran Muatan Lokal</th>
		</tr>
	<?php 
		$c=isset($b) ? $b : 1;
		if($get_mapel_mulok_value){
		foreach($get_mapel_mulok_value as $key=>$mulok){
		?>
		<tr class="tr_mulok">
			<td><div class="text-center"><?php echo $c; ?></div></td>
			<td>
				<input type="hidden" name="id_mulok" id="id_mulok" value="0" />
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran->id,$data_rombel->id,$mulok); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mulok); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo get_nama_mapel($ajaran->id,$data_rombel->id,$mulok); ?> (<?php echo $mulok; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mulok; ?>" class="form-control" />
				<input type="hidden" name="query" id="query" value="k13_mulok" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mulok,'id'); //$guru_id;?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran->id,$data_rombel->id,$mulok,'id');?>" title="Pilih Guru"></a>
			</td>
		</tr>
		<?php
		$c++;
		}
	} else {
	?>
	<?php
	}
	?>
		</tbody>
	</table>
	<!--a class="btn btn-primary button_m"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Muatan Lokal</a-->
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
	$(this).find('a#country').attr('data-value', '0');
	$(this).find('a#country').text('Pilih Guru');
	$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
	$.get('<?php echo site_url('admin/rombel/guru/'.$data_rombel->id); ?>', function( response ) {
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
		$(this).next('td').find('input[name=query]').attr('value', 'kurikulum_a');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'.$data_rombel->id); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			$.each(data.guru, function(a, item) {
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
var b = <?php echo isset($a) ? $a : 1; ?>;
$("span.button_b").click(function() {
  	var $this     = $(this),
		$parentTR = $this.closest('tr').prev('tr.tr_b');
	$parentTR.clone().insertAfter($parentTR).find("td").each(function() {
		$(this).first('td').find('div.text-center').text(b);
		$(this).next('td').find('a.nama_mapel').remove();
		$(this).next('td').find('input[name=mapel]').attr('type', 'text');
		$(this).next('td').find('input[name=mapel]').attr('value', '');
		$(this).next('td').find('input[name=guru]').attr('value', '');
		$(this).next('td').find('input[name=query]').attr('value', 'kurikulum_b');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'.$data_rombel->id); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			$.each(data.guru, function(a, item) {
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
	b++;
});
var c = <?php echo isset($b) ? $b : 1; ?>;
$("span.button_c").click(function() {
  	var $this     = $(this),
		$parentTR = $this.closest('tr').prev('tr.tr_c');
	$parentTR.clone().insertAfter($parentTR).find("td").each(function() {
		$(this).first('td').find('div.text-center').text(c);
		$(this).next('td').find('a.nama_mapel').remove();
		$(this).next('td').find('input[name=mapel]').attr('type', 'text');
		$(this).next('td').find('input[name=mapel]').attr('value', '');
		$(this).next('td').find('input[name=guru]').attr('value', '');
		$(this).next('td').find('input[name=query]').attr('value', 'kurikulum_c');
		$(this).next('td').find('a#country').attr('data-value', '0');
		$(this).next('td').find('a#country').text('Pilih Guru');
		$.fn.editable.defaults.url = '<?php echo site_url('admin/rombel/simpan_guru_mapel'); ?>';
		$.get('<?php echo site_url('admin/rombel/guru/'); ?>', function( response ) {
			var data = $.parseJSON(response);
			var guru = [];
			var mapel = [];
			$.each(data.guru, function(a, item) {
				guru.push({id: item.id, text: item.text});
			});
			$.each(data.mapel, function(a, item) {
				mapel.push({id: item.id, text: item.text});
			});
			$('tbody#editable tr td a.nama_mapel').editable({
				source: mapel,
				emptytext : 'Pilih Mata Pelajaran',
				select2: {
					dropdownAutoWidth : true,
					width: 300,
					placeholder: '== Pilih Mata Pelajaran ==',
					allowClear: true
				},
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
			});
			$('tbody#editable tr td a.guru').editable({
				source: guru,
				emptytext : 'Pilih Guru',
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
		}, 15000);
	});
});
</script>