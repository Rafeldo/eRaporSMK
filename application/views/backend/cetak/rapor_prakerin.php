<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$atribute = ' class="table table-bordered"';
	} else {
		$atribute = ' border="1" class="table"';
	}
}
$s = Datasiswa::find($siswa_id);
$sekolah = Datasekolah::first();
$setting = Setting::first();
$rombel = Datarombel::find($rombel_id);
$ajaran = Ajaran::find($ajaran_id);
?>
<div class="strong">D.&nbsp;&nbsp;Praktik Kerja Lapangan</div>
<table<?php echo $atribute; ?>>
	<thead>
		<tr>
			<th style="width: 2px;" align="center">No</th>
			<th style="width: 400px;" align="center">Mitra DU/DI</th>
			<th style="width: 100px;" align="center">Lokasi</th>
			<th style="width: 100px;" align="center">Lamanya<br>(bulan)</th>
			<th style="width: 100px;" align="center">Keterangan</th>
		</tr>
	</thead>
	<tbody>
	<?php $prakerin = Prakerin::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa_id);
	if($prakerin){
		$i=1;
		foreach($prakerin as $prak){
		?>
		<tr>
			<td align="center"><?php echo $i; ?></td>
			<td><?php echo $prak->mitra_prakerin; ?></td>
			<td align="center"><?php echo $prak->lokasi_prakerin; ?></td>
			<td align="center"><?php echo $prak->lama_prakerin; ?></td>
			<td><?php echo $prak->keterangan_prakerin; ?></td>
		</tr>
		<?php
		$i++;
		}
	} else {
	?>
		<tr>
			<td colspan="5" align="center">Belum ada data untuk ditampilkan</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>