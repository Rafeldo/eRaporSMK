<?php
$user = $this->ion_auth->user()->row();
if($user->data_guru_id != 0){
	$cari_rombel = Datarombel::find_by_guru_id($user->data_guru_id);
}
$nama_rombel = isset($cari_rombel->nama) ? $cari_rombel->nama : '-';
$id_rombel = isset($cari_rombel->id) ? $cari_rombel->id : 0;
?>
<div class="row">
	<div class="col-lg-12 col-xs-12">
		<section id="mata-pelajaran">
			<h4>Anda adalah Wali Kelas Rombongan Belajar <span class="btn btn-success"><?php echo $nama_rombel; ?></span></h4>
			<h5>Daftar Mata Pelajaran di Rombongan Belajar <span class="btn btn-success btn-xs"><?php echo $nama_rombel ?></span></h5>
			<div class="row">
				<div class="col-lg-12 col-xs-12" style="margin-bottom:20px;">
					<table class="table table-bordered table-striped table-hover datatable">
						<thead>
							<tr>
								<th style="width: 10px; vertical-align:middle;" class="text-center" rowspan="2">#</th>
								<th rowspan="2" style="vertical-align:middle;">Mata Pelajaran</th>
								<th rowspan="2" style="vertical-align:middle;">Guru Mata Pelajaran</th>
								<th class="text-center" rowspan="2" style="vertical-align:middle;">KKM</th>
								<th class="text-center" colspan="2">Jumlah Rencana Penilaian</th>
							</tr>
							<tr>
								<th class="text-center">Pengetahuan</th>
								<th class="text-center">Keterampilan</th>
							</tr>
						</thead>
						<tbody>
					<?php
					$all_mapel = Kurikulum::find_all_by_rombel_id($id_rombel);
					if($all_mapel){
						$count = 1;
						foreach($all_mapel as $m){
						?>
							<tr>
								<td class="text-center"><?php echo $count; ?>.</td> 
								<td><?php echo get_nama_mapel($ajaran->id,$m->rombel_id,$m->id_mapel); ?></td>
								<td><?php echo get_guru_mapel($ajaran->id,$m->rombel_id,$m->id_mapel,'nama'); ?></td>
								<td class="text-center"><?php echo get_kkm($ajaran->id,$m->rombel_id,$m->id_mapel); ?></td>
								<td class="text-center"><?php echo get_jumlah_penilaian($ajaran->id,$m->rombel_id,$m->id_mapel,1); ?></td>
								<td class="text-center"><?php echo get_jumlah_penilaian($ajaran->id,$m->rombel_id,$m->id_mapel,2); ?></td>
							</tr>
						<?php
							$count++;
						}
					}
					?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>