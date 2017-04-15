<?php if($all_siswa){ 
$settings 	= Setting::first();
?>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="20%">Nama Siswa</th>
				<th width="40%">Deskripsi Pengetahuan</th>
				<th width="40%">Deskripsi Keterampilan</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$result_kd_pengetahuan_tertinggi = '';
			$result_kd_pengetahuan_terendah = '';
			$result_kd_keterampilan_tertinggi = '';
			$result_kd_keterampilan_terendah = '';
			if($settings->desc == 1){
				$result_kd_pengetahuan_tertinggi = 'Belum dilakukan penilaian';
				$result_kd_pengetahuan_terendah = 'Belum dilakukan penilaian';
				$result_kd_keterampilan_tertinggi = 'Belum dilakukan penilaian';
				$result_kd_keterampilan_terendah = 'Belum dilakukan penilaian';
			}
			foreach($all_siswa as $key=>$siswa){
				$nilai_pengetahuan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id);
				if($nilai_pengetahuan){
					foreach($nilai_pengetahuan as $nilaipengetahuan){
						$rencana_pengetahuan_id[$key] = $nilaipengetahuan->rencana_penilaian_id;
						$get_nilai_pengetahuan[] = $nilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_tertinggi = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id, bilanganBesar($get_nilai_pengetahuan));
					if($nilai_pengetahuan_tertinggi){
						$rencana_penilaian_pengetahuan_tertinggi = Rencanapenilaian::find($nilai_pengetahuan_tertinggi->rencana_penilaian_id);
						$get_kd_pengetahuan_tertinggi = Kd::find($rencana_penilaian_pengetahuan_tertinggi->kd_id);
						$kd_pengetahuan_tertinggi_value = $get_kd_pengetahuan_tertinggi->kompetensi_dasar;
						if($get_kd_pengetahuan_tertinggi->kompetensi_dasar_alias){
							$kd_pengetahuan_tertinggi_value = $get_kd_pengetahuan_tertinggi->kompetensi_dasar_alias;
						}
						if($settings->desc == 1){
							$result_kd_pengetahuan_tertinggi = 'Sangat menonjol pada kompetensi '.strtolower($kd_pengetahuan_tertinggi_value);
						}
					}
					//space tinggi rendah
					$nilai_pengetahuan_terendah = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id, bilanganKecil($get_nilai_pengetahuan));
					if($nilai_pengetahuan_terendah){
						$rencana_penilaian_pengetahuan_terendah = Rencanapenilaian::find($nilai_pengetahuan_terendah->rencana_penilaian_id);
						$get_kd_pengetahuan_terendah = Kd::find($rencana_penilaian_pengetahuan_terendah->kd_id);
						$kd_pengetahuan_terendah_value = $get_kd_pengetahuan_terendah->kompetensi_dasar;
						if($get_kd_pengetahuan_terendah->kompetensi_dasar_alias){
							$kd_pengetahuan_terendah_value = $get_kd_pengetahuan_terendah->kompetensi_dasar_alias;
						}
						if($settings->desc == 1){
							$result_kd_pengetahuan_terendah = ' dan perlu meningkatkan kompetensi '.strtolower($kd_pengetahuan_terendah_value);
						}
					}
				}
				$nilai_keterampilan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id);
				if($nilai_keterampilan){
					foreach($nilai_keterampilan as $nilaiketerampilan){
						$rencana_keterampilan_id[$key] = $nilaiketerampilan->rencana_penilaian_id;
						$get_nilai_keterampilan[] = $nilaiketerampilan->nilai;
					}
					$nilai_keterampilan_tertinggi = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id, bilanganBesar($get_nilai_keterampilan));
					if($nilai_keterampilan_tertinggi){
						$rencana_penilaian_keterampilan_tertinggi = Rencanapenilaian::find_by_id($nilai_keterampilan_tertinggi->rencana_penilaian_id);
						if($rencana_penilaian_keterampilan_tertinggi){
							$get_kd_keterampilan_tertinggi = Kd::find($rencana_penilaian_keterampilan_tertinggi->kd_id);
							$kd_keterampilan_tertinggi_value = $get_kd_keterampilan_tertinggi->kompetensi_dasar;
							if($get_kd_keterampilan_tertinggi->kompetensi_dasar_alias){
								$kd_keterampilan_tertinggi_value = $get_kd_keterampilan_tertinggi->kompetensi_dasar_alias;
							}
							if($settings->desc == 1){
								$result_kd_keterampilan_tertinggi = 'Sangat menonjol pada kompetensi '.strtolower($kd_keterampilan_tertinggi_value);
							}
						}
					}
					//space tinggi rendah
					$nilai_keterampilan_terendah = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id, bilanganKecil($get_nilai_keterampilan));
					if($nilai_keterampilan_terendah){
						$rencana_penilaian_keterampilan_terendah = Rencanapenilaian::find_by_id($nilai_keterampilan_terendah->rencana_penilaian_id);
						if($rencana_penilaian_keterampilan_terendah){
							$get_kd_keterampilan_terendah = Kd::find_by_id($rencana_penilaian_keterampilan_terendah->kd_id);
							$keterampilan_terendah_value = $get_kd_keterampilan_terendah->kompetensi_dasar;
							if($get_kd_keterampilan_terendah->kompetensi_dasar_alias){
								$keterampilan_terendah_value = $get_kd_keterampilan_terendah->kompetensi_dasar_alias;
							}
							if($nilai_keterampilan_tertinggi <= $nilai_keterampilan_terendah){
								$test = 'asd';
							}
							if($settings->desc == 1){
								$result_kd_keterampilan_terendah = ' dan perlu meningkatkan kompetensi '.strtolower($keterampilan_terendah_value);
							}
						}
					}
				}
				?>
				<input type="hidden" name="siswa_id[]" value="<?php echo $siswa->id; ?>" />
				<tr>
					<td>
						<?php echo $siswa->nama; ?><br>
						<?php
							$link = 'umum';
							if(isset($mapel->nama_kur) && $mapel->nama_kur == 'k13_mulok' || isset($mapel->nama_kur) && $mapel->nama_kur == 'k_mulok'){
								$link = 'mulok';
							}
						?>
						<a href="<?php echo site_url('admin/ajax/get_desc/'.$ajaran_id.'/'.$rombel_id.'/'.$link.'/'.$id_mapel.'/'.$siswa->id); ?>" class="btn btn-success pull-right get_desc"><i class="fa fa-lightbulb-o"></i></a>
						<!--get_desc-->
					</td>
				<?php
				$deskripsi_mapel = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$id_mapel,$siswa->id);
					if($deskripsi_mapel){
						$deskripsi_pengetahuan_value = $deskripsi_mapel->deskripsi_pengetahuan;
						$deskripsi_keterampilan_value = $deskripsi_mapel->deskripsi_keterampilan;
					} else {
						//$deskripsi_pengetahuan_value = $result_kd_pengetahuan_tertinggi.$result_kd_pengetahuan_terendah;
						//$deskripsi_keterampilan_value = $result_kd_keterampilan_tertinggi.$result_kd_keterampilan_terendah;
						$deskripsi_pengetahuan_value = '';
						$deskripsi_keterampilan_value = '';
					}
				?>
					<td>
					<textarea name="deskripsi_pengetahuan[]" class="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $deskripsi_pengetahuan_value; ?></textarea>
					</td>
					<td>
					<textarea name="deskripsi_keterampilan[]" class="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $deskripsi_keterampilan_value; ?></textarea>
					</td>
				<?php
			}
			?>
			</tbody>
			</table>
			</div>
		<?php
		} else {
		?>
			<h4>Belum ada siswa di kelas terpilih</h4>
			<script>
			$('button.simpan').remove();
			</script>
		<?php } ?>
<script>
$('a.get_desc').bind('click',function(e) {
	var desc = '';
	e.preventDefault();
	var ini = $(this).parents('tr');
	var url = $(this).attr('href');
	$.get(url).done(function(response) {
		var data = $.parseJSON(response);
		if(data.result.length == 2){
			desc = '<tr><th width="50%">Pengetahuan</th><th width="50%">Keterampilan</th></tr><tr><td class="text-left" style="font-size:14px;">'+data.result[0]+'</td><td class="text-left" style="font-size:14px;">'+data.result[1]+'</td></tr>';
		} else {
			desc = '<tr><td>'+data.result[0]+'</td></tr>';
		}
		swal({
			type: 'info',
			html:
			'<table class="table table-bordered">' +
			desc +
			'</table>',
			width: 800,
			padding: 20,
			showCloseButton: false,
			showCancelButton: false,
			showConfirmButton: false,
		}).done();
	});
});
</script>