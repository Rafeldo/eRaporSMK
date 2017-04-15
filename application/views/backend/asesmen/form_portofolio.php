<?php
$siswa_id = $_POST['siswa_id'];
$mapel = Datamapel::find_by_id_mapel($id_mapel);
$rencana_pengetahuan = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id,$id_mapel,$rombel_id,1);
$nilai_mulok_pengetahuan = Nilaimulok::find_all_by_ajaran_id_and_mapel_id_and_rombel_id_and_kompetensi_id_and_data_siswa_id($ajaran_id,$id_mapel,$rombel_id,1,$siswa_id);
if($rencana_pengetahuan){
	foreach($rencana_pengetahuan as $ren){
		$id_rencana_pengetahuan[] = $ren->id;
	}
}
if(isset($id_rencana_pengetahuan)){
?>
<div class="no-padding">
	<div id="progress" class="progress progress-striped active" style="margin-top:10px; display:none;">
		<div class="progress-bar progress-bar-success"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="50%">Penilaian Pengetahuan</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
				<th width="40%">Upload Dokumen</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$nama_penilaian = '-';
		$a=1;
		$nilai_rapor_pengetahuan = 0;
		foreach($id_rencana_pengetahuan as $irp){
			$rencana_penilaian_pengetahuan_group = Rencanapenilaian::find('all', array('group' => 'nama_penilaian','order'=>'nama_penilaian ASC', 'conditions' => array("rencana_id = $irp")));
			if($rencana_penilaian_pengetahuan_group){
				foreach($rencana_penilaian_pengetahuan_group as $rppg){
					$portofolio = Dataportofolio::find_by_ajaran_id_and_rombel_id_and_id_mapel_and_penilaian_id_and_siswa_id($ajaran_id, $rombel_id, $id_mapel, $rppg->id, $siswa_id);
					$nilai_pengetahuan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 1, $rombel_id, $id_mapel, $siswa_id, $rppg->id);
					if($nilai_pengetahuan) {
						$nilai_rapor_pengetahuan += $nilai_pengetahuan->rerata_jadi;
						$nilai_pengetahuan_rerata = $nilai_pengetahuan->rerata;
						$form_import = '<span class="btn btn-primary btn-file">Import  <input type="file" data-nilai_pengetahuan="pengetahuan-'.$a.'" name="import_pengetahuan_'.$a.'" /></span>';
					} else {
						$nilai_rapor_pengetahuan += 0;
						$nilai_pengetahuan_rerata = 0;
						$form_import = 'Belum dilakukan penilaian';						
					}
		?>
		<input type="hidden" name="nilai_pengetahuan_<?php echo $a; ?>" value="<?php echo $rppg->id; ?>" />
		<tr>
			<td><?php echo $a.'. '.$rppg->nama_penilaian; ?></td>
			<td class="text-center"><?php echo $nilai_pengetahuan_rerata;?></td>
			<td>
			<?php if($portofolio){ ?>
				<a href="<?php echo site_url('uploads/'.$portofolio->nama_portofolio); ?>" target="_blank" class="tooltip-left" title="Download file <?php echo $portofolio->nama_portofolio; ?>"><?php echo $portofolio->nama_portofolio; ?></a>
				<a href="<?php echo site_url('admin/asesmen/delete_file/'.$portofolio->id.'/'.$portofolio->nama_portofolio); ?>" class="btn btn-danger btn-sm pull-right confirm tooltip-left" title="Hapus file <?php echo $portofolio->nama_portofolio; ?>"><i class="fa fa-fw fa-trash-o"></i></a>
			<?php } else { ?>
				<?php echo $form_import; ?>
			<?php } ?>
				<div id="result"></div>
			</td>
		</tr>
		<?php $a++;
				}
			}
		}
		?>
		<tr>
			<td class="text-right">Nilai Rapor Pengetahuan</td>
			<td class="text-center"><?php echo number_format($nilai_rapor_pengetahuan,0);?></td>
			<td class="text-right"></td>
		</tr>
	</tbody>
</table>
</div>
<?php } elseif($nilai_mulok_pengetahuan) { ?>
<div class="no-padding">
	<div id="progress" class="progress progress-striped active" style="margin-top:10px; display:none;">
		<div class="progress-bar progress-bar-success"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="50%">Penilaian Pengetahuan</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
				<th width="40%">Upload Dokumen</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$nilai_mulok_pengetahuan_value = 0;
		$total_bobot_mulok_pengetahuan = 0;
		$nilai_pengetahuan_rerata = 0;
		$a=1;
		foreach($nilai_mulok_pengetahuan as $mulok_pengetahuan){
			$total_bobot_mulok_pengetahuan += $mulok_pengetahuan->bobot_penilaian;
			$portofolio = Dataportofolio::find_by_ajaran_id_and_rombel_id_and_id_mapel_and_penilaian_id_and_siswa_id($ajaran_id, $rombel_id, $id_mapel, $mulok_pengetahuan->id, $siswa_id);
			$nilai_pengetahuan_value = $mulok_pengetahuan->nilai;
			$nilai_pengetahuan_rerata += $mulok_pengetahuan->nilai *  $mulok_pengetahuan->bobot_penilaian;
			$form_import = '<span class="btn btn-primary btn-file">Import  <input type="file" data-nilai_pengetahuan="pengetahuan-'.$a.'" name="import_pengetahuan_'.$a.'" /></span>';
		?>
		<input type="hidden" name="nilai_pengetahuan_<?php echo $a; ?>" value="<?php echo $mulok_pengetahuan->id; ?>" />
		<tr>
			<td><?php echo $a.'. '.$mulok_pengetahuan->nama_penilaian; ?></td>
			<td class="text-center"><?php echo $nilai_pengetahuan_value;?></td>
			<td>
			<?php if($portofolio){ ?>
				<a href="<?php echo site_url('uploads/'.$portofolio->nama_portofolio); ?>" target="_blank" class="tooltip-left" title="Download file <?php echo $portofolio->nama_portofolio; ?>"><?php echo $portofolio->nama_portofolio; ?></a>
				<a href="<?php echo site_url('admin/asesmen/delete_file/'.$portofolio->id.'/'.$portofolio->nama_portofolio); ?>" class="btn btn-danger btn-sm pull-right confirm tooltip-left" title="Hapus file <?php echo $portofolio->nama_portofolio; ?>"><i class="fa fa-fw fa-trash-o"></i></a>
			<?php } else { ?>
				<?php echo $form_import; ?>
			<?php } ?>
				<div id="result"></div>
			</td>
		</tr>
		<?php $a++;} ?>
		<tr>
			<th class="text-right">Nilai Rapor Pengetahuan</th>
			<th class="text-center"><?php echo number_format($nilai_pengetahuan_rerata / $total_bobot_mulok_pengetahuan,0);?></th>
			<th class="text-right"></th>
		</tr>
		</tbody>
	</table>
</div>
<?php } else { ?>
<h4>Nilai Pengetahuan Belum di Entry</h4>
<?php } 
$rencana_keterampilan = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id,$id_mapel,$rombel_id,2);
$nilai_mulok_keterampilan = Nilaimulok::find_all_by_ajaran_id_and_mapel_id_and_rombel_id_and_kompetensi_id_and_data_siswa_id($ajaran_id,$id_mapel,$rombel_id,2,$siswa_id);
if($rencana_keterampilan){
	foreach($rencana_keterampilan as $ren){
		$id_rencana_keterampilan[] = $ren->id;
	}
}
if(isset($id_rencana_keterampilan)){
?>
<div class="no-padding">
	<div id="progress" class="progress progress-striped active" style="margin-top:10px; display:none;">
		<div class="progress-bar progress-bar-success"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="50%">Penilaian Keterampilan</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
				<th width="40%">Upload Dokumen</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$nama_penilaian = '-';
		$a=1;
		$nilai_rapor_keterampilan = 0;
		foreach($id_rencana_keterampilan as $irk){
			$rencana_penilaian_keterampilan_group = Rencanapenilaian::find('all', array('group' => 'nama_penilaian','order'=>'nama_penilaian ASC', 'conditions' => array("rencana_id = $irk")));
			if($rencana_penilaian_keterampilan_group){
				foreach($rencana_penilaian_keterampilan_group as $rpkg){
					$portofolio = Dataportofolio::find_by_ajaran_id_and_rombel_id_and_id_mapel_and_penilaian_id_and_siswa_id($ajaran_id, $rombel_id, $id_mapel, $rpkg->id, $siswa_id);
					$nilai_keterampilan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 2, $rombel_id, $id_mapel, $siswa_id, $rpkg->id);
					if($nilai_keterampilan){
						$nilai_rapor_keterampilan += $nilai_keterampilan->rerata_jadi;
						$nilai_keterampilan_rerata = $nilai_keterampilan->rerata;
						$form_import = '<span class="btn btn-primary btn-file">Import  <input type="file" data-nilai_keterampilan="keterampilan-'.$a.'" name="import_keterampilan_'.$a.'" /></span>';	
					} else {
						$nilai_rapor_keterampilan += 0;
						$nilai_keterampilan_rerata = 0;
						$form_import = 'Belum dilakukan penilaian';	
					}
		?>
			<input type="hidden" name="nilai_keterampilan_<?php echo $a; ?>" value="<?php echo $rpkg->id; ?>" />
			<tr>
				<td><?php echo $a.'. '.$rpkg->nama_penilaian; ?></td>
				<td class="text-center"><?php echo $nilai_keterampilan_rerata; ?></td>
				<td>
				<?php if($portofolio){ ?>
					<a href="<?php echo site_url('uploads/'.$portofolio->nama_portofolio); ?>" target="_blank" class="tooltip-left" title="Download file <?php echo $portofolio->nama_portofolio; ?>"><?php echo $portofolio->nama_portofolio; ?></a>
					<a href="<?php echo site_url('admin/asesmen/delete_file/'.$portofolio->id.'/'.$portofolio->nama_portofolio); ?>" class="btn btn-danger btn-sm pull-right confirm tooltip-left" title="Hapus file <?php echo $portofolio->nama_portofolio; ?>"><i class="fa fa-fw fa-trash-o"></i></a>
				<?php } else { ?>
					<?php echo $form_import; ?>
				<?php } ?>
					<div id="result"></div>
				</td>
			</tr>
			<?php
				$a++;
				}
			}
		}
		?>
			<tr>
				<td class="text-right">Nilai Rapor keterampilan</td>
				<td class="text-center"><?php echo number_format($nilai_rapor_keterampilan,0);; ?></td>
				<td class="text-right"></td>
			</tr>
		</tbody>
	</table>
</div>
<?php } elseif($nilai_mulok_keterampilan) { ?>
<div class="no-padding">
	<div id="progress" class="progress progress-striped active" style="margin-top:10px; display:none;">
		<div class="progress-bar progress-bar-success"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="50%">Penilaian Keterampilan</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
				<th width="40%">Upload Dokumen</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$nilai_mulok_keterampilan_value = 0;
		$total_bobot_mulok_keterampilan = 0;
		$nilai_keterampilan_rerata = 0;
		$a=1;
		foreach($nilai_mulok_keterampilan as $mulok_keterampilan){
			$total_bobot_mulok_keterampilan += $mulok_keterampilan->bobot_penilaian;
			$portofolio = Dataportofolio::find_by_ajaran_id_and_rombel_id_and_id_mapel_and_penilaian_id_and_siswa_id($ajaran_id, $rombel_id, $id_mapel, $mulok_pengetahuan->id, $siswa_id);
			$nilai_keterampilan_value = $mulok_keterampilan->nilai;
			$nilai_keterampilan_rerata += $mulok_keterampilan->nilai *  $mulok_keterampilan->bobot_penilaian;
			$form_import = '<span class="btn btn-primary btn-file">Import  <input type="file" data-nilai_pengetahuan="pengetahuan-'.$a.'" name="import_pengetahuan_'.$a.'" /></span>';
		?>
		<input type="hidden" name="nilai_pengetahuan_<?php echo $a; ?>" value="<?php echo $mulok_keterampilan->id; ?>" />
		<tr>
			<td><?php echo $a.'. '.$mulok_keterampilan->nama_penilaian; ?></td>
			<td class="text-center"><?php echo $nilai_keterampilan_value;?></td>
			<td>
			<?php if($portofolio){ ?>
				<a href="<?php echo site_url('uploads/'.$portofolio->nama_portofolio); ?>" target="_blank" class="tooltip-left" title="Download file <?php echo $portofolio->nama_portofolio; ?>"><?php echo $portofolio->nama_portofolio; ?></a>
				<a href="<?php echo site_url('admin/asesmen/delete_file/'.$portofolio->id.'/'.$portofolio->nama_portofolio); ?>" class="btn btn-danger btn-sm pull-right confirm tooltip-left" title="Hapus file <?php echo $portofolio->nama_portofolio; ?>"><i class="fa fa-fw fa-trash-o"></i></a>
			<?php } else { ?>
				<?php echo $form_import; ?>
			<?php } ?>
				<div id="result"></div>
			</td>
		</tr>
		<?php $a++;} ?>
		<tr>
			<th class="text-right">Nilai Rapor Keterampilan</th>
			<th class="text-center"><?php echo number_format($nilai_keterampilan_rerata / $total_bobot_mulok_keterampilan,0);?></th>
			<th class="text-right"></th>
		</tr>
		</tbody>
	</table>
</div>
<?php } else { ?>
<h4>Nilai Keterampilan Belum di Entry</h4>
<?php } ?>
<script src="<?php echo base_url();?>assets/js/tooltip-viewport.js"></script>
<script>
$('a.confirm').bind('click',function(e) {
	e.preventDefault();
	var url = $(this).attr('href');
	swal({
		title: "Anda Yakin?",
		text: "Tindakan ini tidak bisa dikembalikan!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Hapus!",
		showLoaderOnConfirm: true,
		preConfirm: function(a) {
			return new Promise(function(resolve) {
				$.get(url).done(function(e, data) {
					$('#result').html('');
					$('.simpan').hide();
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function(data) {
						$.post( "<?php echo site_url('admin/asesmen/get_nilai');?>", $('form').serialize()).done(function( data ) {
							$('#result').html(data);
						});
					});
				})
			})
		}
	});
});
var url = '<?php echo site_url('import/portofolio'); ?>';
$('.btn-file').each(function () {
	$(this).fileupload({
		url: url,
		dataType: 'json'
	}).on('fileuploadprogress', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css('width',progress + '%');
	}).on('fileuploadsubmit', function (e, data) {
		$('#gagal').hide();
		var form_data = $('form').serialize();
		data.formData = {'costum_name' : data.paramName, 'form_data' : form_data};
		$('#progress').show();
	}).on('fileuploaddone', function (e, data) {
		window.setTimeout(function() { 
			$('#progress').hide();
			$('#progress .progress-bar').css('width','0%');
		}, 1000);
		swal({title:data.result.title, html:data.result.text, type:data.result.type}).then(function() {
			/*if(data.result.type != 'error'){
				$(e.target).hide();
			}
			$(e.target).next().html(data.result.record);*/
			$.post( "<?php echo site_url('admin/asesmen/get_nilai');?>", $('form').serialize()).done(function( data ) {
				$('#result').html(data);
			});
		});
	}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>