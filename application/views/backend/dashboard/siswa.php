<?php
$siswa = Datasiswa::find_by_id($user->data_siswa_id);
if($siswa->data_rombel_id != 0){
$rombel = Datarombel::find_by_id($siswa->data_rombel_id);
$rombel_id = isset($rombel->guru_id) ? $rombel->guru_id : 0;
$wali = Dataguru::find_by_id($rombel->guru_id);
$mata_pelajaran = Kurikulum::find_all_by_rombel_id($siswa->data_rombel_id);
foreach($mata_pelajaran as $allmapel){
	$get_id_mapel[] = $allmapel->id_mapel;
	//$get_nama_mapel[] = get_nama_mapel($ajaran->id, $siswa->data_rombel_id, $allmapel->id_mapel);
}
$mata_pelajaran = filter_agama_mapel($ajaran->id, $siswa->data_rombel_id, $get_id_mapel, $get_id_mapel, $siswa->agama);
?>
<h4 class="box-title">Anda sedang berada di Rombongan Belajar <span class="btn btn-success"><?php echo (isset($rombel)) ? $rombel->nama: ''; ?></span> Wali Kelas <span class="btn btn-success"><?php echo (isset($wali)) ? $wali->nama: 'Belum Ditentukan'; ?></span></h4>
<section id="mata-pelajaran">
	<h4 class="page-header">Daftar Mata Pelajaran</h4>
	<div class="row">
		<div class="col-lg-12 col-xs-12" style="margin-bottom:20px;">
			<table class="table table-bordered table-striped table-hover datatable">
				<thead>
					<tr>
						<th style="width: 10px; vertical-align:middle;" class="text-center" rowspan="2">#</th>
						<th style="vertical-align:middle;" rowspan="2">Mata Pelajaran</th>
						<th style="vertical-align:middle;" rowspan="2">Guru Mata Pelajaran</th>
						<th class="text-center" colspan="2">Nilai Pengetahuan</th>
						<th class="text-center" colspan="2">Nilai Keterampilan</th>
						<th style="vertical-align:middle;" class="text-center" rowspan="2">Detil Nilai</th>
					</tr>
					<tr>
						<td class="text-center">Angka</td>
						<td class="text-center">Predikat</td>
						<td class="text-center">Angka</td>
						<td class="text-center">Predikat</td>
					</tr>
				</thead>
				<?php 
				if($mata_pelajaran){
					$count = 1;
					foreach ($mata_pelajaran as $mapel) {
						$get_mapel = Kurikulum::find_by_id_mapel($mapel);
						//$nama_guru = Dataguru::find_by_id($get_mapel->guru_id);
						//$nama_guru = isset($nama_guru->nama) ? $nama_guru->nama : '-';
						$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran->id,1,$siswa->data_rombel_id,$mapel,$siswa->id);
						if($all_nilai_pengetahuan){
							$nilai_pengetahuan = 0;
							foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
								$nilai_pengetahuan += $allnilaipengetahuan->nilai;
							}
							$nilai_pengetahuan_value = number_format($nilai_pengetahuan,0);
						} else {
							$nilai_pengetahuan_value = '-';
						}
						$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran->id,2,$siswa->data_rombel_id,$mapel,$siswa->id);
						if($all_nilai_keterampilan){
							$nilai_keterampilan = 0;
							foreach($all_nilai_keterampilan as $allnilaiketerampilan){
								$nilai_keterampilan += $allnilaiketerampilan->nilai;
							}
							$nilai_keterampilan_value = number_format($nilai_keterampilan,0);
						} else {
						$nilai_keterampilan_value = '-';
						}
				?>
					<tr>
						<td class="text-center"><?php echo $count; ?></td> 
						<td><?php echo get_nama_mapel($ajaran->id, $siswa->data_rombel_id, $mapel); ?></td>  
						<td><?php echo get_guru_mapel($ajaran->id, $siswa->data_rombel_id, $mapel, 'nama'); ?></td>  
						<td class="text-center" class="text-center"><?php echo $nilai_pengetahuan_value; ?></td>
						<td class="text-center" class="text-center"><?php echo konversi_huruf(get_kkm($ajaran->id, $siswa->data_rombel_id,$mapel),$nilai_pengetahuan_value); ?></td>
						<td class="text-center" class="text-center"><?php echo $nilai_keterampilan_value; ?></td>
						<td class="text-center" class="text-center"><?php echo konversi_huruf(get_kkm($ajaran->id, $siswa->data_rombel_id,$mapel), $nilai_keterampilan_value); ?></td>
						<td class="text-center" class="text-center">
							<a href="<?php echo site_url('admin/monitoring/prestasi/'.$get_mapel->id); ?>" class="btn btn-block btn-xs btn-success">Detil Nilai</a>
						</td>
					</tr>
				<?php
						$count++;
						//die();
					}
				} ?>
			</table>
		</div>
	</div>
</section>
<?php } else { ?>
<h4 class="box-title">Rombongan belajar belum di update!</h4>
<?php } ?>