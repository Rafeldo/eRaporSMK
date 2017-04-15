<?php
$siswa = Datasiswa::find_by_id($user->data_siswa_id);
$kurikulum = Kurikulum::find_by_id($mapel_id);
$mapel = Datamapel::find($kurikulum->id_mapel);
$data_rombel = Datarombel::find_by_id($siswa->data_rombel_id);
?>
<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
	<div class="box-header">
		<i class="fa fa-hand-o-right"></i>
		<h3 class="box-title">Detil Nilai Pengetahuan Mata Pelajaran <?php echo $mapel->nama_mapel; ?></h3>
	</div>
    <div class="box-body">
		<?php
		$nilai_pengetahuan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran->id, 1, $siswa->data_rombel_id, $mapel->id_mapel, $siswa->id);
		$nilai_keterampilan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran->id, 2, $siswa->data_rombel_id, $mapel->id_mapel, $siswa->id);
		?>
		<table class="table table-bordered table-hover">
			<tr>
				<th width="5%" class="text-center">ID KD</th>
				<th width="85%">Kompetensi Dasar</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
			</tr>
		<?php 
		foreach($nilai_pengetahuan as $np){
			$rencana_penilaian_pengetahuan = Rencanapenilaian::find_by_id($np->rencana_penilaian_id);
			if($rencana_penilaian_pengetahuan)
			$get_pengetahun[$rencana_penilaian_pengetahuan->kd][] = $np->nilai;
		}
		if(isset($get_pengetahun)){
			ksort($get_pengetahun);
			$rerata_akhir = 0;
			$jumlah_penilaian = 0;
			foreach($get_pengetahun as $key=>$gp){
				$get_kompetensi = Kd::find_by_id_kompetensi_and_id_mapel_and_kelas($key,$mapel->id_mapel,$data_rombel->tingkat);
				$jumlah_kd = array_sum($gp);
				$rerata_nilai = number_format(($jumlah_kd / count($gp)),2);
				$rerata_akhir += $jumlah_kd;
				$jumlah_penilaian += count($gp);
			?>
				
			<tr>
				<td class="text-center"><?php echo $key; ?></td>
				<td><?php echo $get_kompetensi->kompetensi_dasar; ?></td>
				<td class="text-center"><?php echo number_format($rerata_nilai,0); ?></td>
			</tr>
		<?php 
			}
		?>
			<tr>
				<td colspan="2" class="text-right"><strong>Rerata Akhir = </strong></td>
				<td class="text-center"><?php echo number_format($rerata_akhir / $jumlah_penilaian,0); ?></td>
			</tr>
		<?php
		} else {
		?>
			<tr>
				<td colspan="3" class="text-center">Belum ada penilaian</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
	<div class="box-header">
		<i class="fa fa-hand-o-right"></i>
		<h3 class="box-title">Detil Nilai Keterampilan Mata Pelajaran <?php echo $mapel->nama_mapel; ?></h3>
	</div>
    <div class="box-body">
		<table class="table table-bordered table-hover" style="margin-top:10px;">
			<tr>
				<th width="5%" class="text-center">ID KD</th>
				<th width="85%">Kompetensi Dasar</th>
				<th width="10%" class="text-center">Rerata Nilai</th>
			</tr>
		<?php
		foreach($nilai_keterampilan as $nk){
			$rencana_penilaian_keterampilan = Rencanapenilaian::find_by_id($nk->rencana_penilaian_id);
			if($rencana_penilaian_keterampilan)
			$get_keterampilan[$rencana_penilaian_keterampilan->kd][] = $nk->nilai;
		}
		if(isset($get_keterampilan)){
			ksort($get_keterampilan);
			$rerata_akhir = 0;
			$jumlah_penilaian = 0;
			foreach($get_keterampilan as $key=>$gk){
				$get_kompetensi = Kd::find_by_id_kompetensi_and_id_mapel_and_kelas($key,$mapel->id_mapel,$data_rombel->tingkat);
				$jumlah_kd = array_sum($gk);
				$rerata_nilai = number_format(($jumlah_kd / count($gk)),2);
				$rerata_akhir += $jumlah_kd;
				$jumlah_penilaian += count($gk);
		?>
			<tr>
				<td class="text-center"><?php echo $key; ?></td>
				<td><?php echo $get_kompetensi->kompetensi_dasar; ?></td>
				<td class="text-center"><?php echo number_format($rerata_nilai,0); ?></td>
			</tr>
		<?php 
			}
		?>
			<tr>
				<td colspan="2" class="text-right"><strong>Rerata Akhir = </strong></td>
				<td class="text-center"><?php echo number_format($rerata_akhir / $jumlah_penilaian,0); ?></td>
			</tr>
		<?php 
		} else {
		?>
			<tr>
				<td colspan="3" class="text-center">Belum ada penilaian</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
	</div>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>