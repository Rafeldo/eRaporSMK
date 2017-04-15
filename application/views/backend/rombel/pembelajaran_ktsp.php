<style>
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
<div class="row">
	<div class="col-xs-12">
	<form id="pembelajaran">
	<input type="hidden" name="rombel_id" value="<?php echo $data_rombel->id; ?>" />
	<input type="hidden" name="keahlian_id" id="keahlian_id" value="<?php echo $data_rombel->kurikulum_id; ?>" />
	<input type="hidden" name="query" id="query" value="kurikulum" />
	<?php
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
	?>
	<table class="table table-bordered table-hover" id="pembelajaran">
		<thead>
			<th class="text-center" width="5%">No</th>
			<th width="50%">Mata Pelajaran</th>
			<th width="45%">Guru Mata Pelajaran</th>
		</thead>
		<tbody id="editable">
	<?php $i=1;
		if($all_mapel){
		foreach($all_mapel as $mapel){
			$query = 'kurikulum';
	?>
		<tr>
			<td><div class="text-center"><?php echo $i; ?></div></td>
			<td>
				<input type="hidden" name="nama_mapel_alias" id="nama_mapel_alias" value="<?php echo get_nama_mapel_alias($ajaran_id,$data_rombel->id,$mapel->id_mapel); ?>" />
				<a class="nama_mapel" href="javascript:void(0)" data-name="nama_mapel_alias" data-value="<?php echo get_nama_mapel($ajaran_id,$data_rombel->id,$mapel->id_mapel); ?>" data-title="Edit Nama Mapel" title="Edit Nama Mapel"><?php echo (get_nama_mapel_alias($ajaran_id,$data_rombel->id,$mapel->id_mapel)) ? get_nama_mapel_alias($ajaran_id,$data_rombel->id,$mapel->id_mapel) : get_nama_mapel($ajaran_id,$data_rombel->id,$mapel->id_mapel); ?> (<?php echo $mapel->id_mapel; ?>)</a>
				<input type="hidden" name="mapel" id="mapel" value="<?php echo $mapel->id_mapel; ?>" class="form-control" />
			</td>
			<td>
				<input type="hidden" class="guru" name="guru" value="<?php echo get_guru_mapel($ajaran_id,$data_rombel->id,$mapel->id_mapel,'id'); ?>" />
				<a class="guru" href="javascript:void(0)" id="country" data-type="select2" data-name="guru" data-value="<?php echo get_guru_mapel($ajaran_id,$data_rombel->id,$mapel->id_mapel,'id');?>" title="Pilih Guru"></a>
			</td>
		</tr>
	<?php $i++;}
	} else { ?>
		<tr class="tr_a">
			<td colspan="3">Mata Pelajaran belum tersedia. Silahkan tambah mata pelajaran di menu referensi mata pelajaran</td>
		</tr>
	<?php } ?>
		</tbody>
	</table>
	</form>
	</div>
</div>
<?php echo link_tag('assets/plugins/bootstrap-editable/css/bootstrap-editable.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/jquery.mockjax.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-noty/packaged/jquery.noty.packaged.js"></script>
<script>
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
	$('a.simpan_pembelajaran').click(function(){
		var data = $("form#pembelajaran").serializeObject();
		var result = $.parseJSON(JSON.stringify(data));
		$.each(result.guru, function (i, item) {
			$.ajax({
				url: '<?php echo site_url('admin/rombel/simpan_pembelajaran/'); ?>',
				type: 'post',
				data: {keahlian_id:result.keahlian_id, rombel_id:result.rombel_id, query:result.query, guru_id:item,mapel_id:result.mapel[i], nama_mapel_alias:result.nama_mapel_alias[i]},
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
		});
		window.setTimeout(function() { 
			$('#datatable').dataTable().fnReloadAjax();
			$('#modal_content').modal('hide');
		}, 15000);
	});
});
</script>