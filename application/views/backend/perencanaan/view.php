<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered table striped">
			<tr>
				<td width="50%">Mata Pelajaran</td>
				<td width="5%" class="text-center">:</td>
				<td width="45%"><?php echo get_nama_mapel($rencana->ajaran_id, $rencana->rombel_id, $rencana->id_mapel); ?></td>
			</tr>
			<tr>
				<td>KB (KKM)</td>
				<td class="text-center">:</td>
				<td><?php echo get_kkm($rencana->id_mapel); ?></td>
			</tr>
		</table>
		<table class="table table-bordered table-striped">
			<tr>
				<th colspan="4">Detil Rencana Penilaian</th>
			</tr>
			<tr>
				<th>Nama Penilaian</th>
				<th>Bentuk Penilaian</th>
				<th>Bobot Penilaian</th>
				<th>Kompetensi Dasar</th>
			</tr>
			<?php
			if($rencana->rencanapenilaian){
			foreach($rencana->rencanapenilaian as $rp){
			$kd = Kd::find_by_id($rp->kd_id);
			?>
				<tr>
					<td><?php echo $rp->nama_penilaian; ?></td>
					<td><?php echo get_bentuk_penilaian($rp->bentuk_penilaian); ?></td>
					<td><?php echo $rp->bobot_penilaian; ?></td>
					<td><?php echo isset($kd->id_kompetensi_alias) && ($kd->id_kompetensi_alias) ? $kd->id_kompetensi_alias : $kd->id_kompetensi; ?></td>
				</tr>
			<?php } 
			} else { ?>
				<tr>
					<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>