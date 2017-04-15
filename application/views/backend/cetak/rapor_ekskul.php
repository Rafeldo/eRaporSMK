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
<div class="strong">E.&nbsp;&nbsp;Ekstrakurikuler</div>
<table<?php echo $atribute; ?>>
	<thead>
		<tr>
			<th style="width: 5%;" align="center">No</th>
			<th style="width: 35%;" align="center">Kegiatan Ekstrakurikuler</th>
			<th style="width: 60%;" align="center">Keterangan</th>
		</tr>
	</thead>
	<tbody>
	<?php $ekskul= Nilaiekskul::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa_id);
	if($ekskul){
		$i=1;
		foreach($ekskul as $eks){
			$nama_ekskul = Ekskul::find($eks->ekskul_id);
			if($eks->deskripsi_ekskul){
		?>
		<tr>
			<td align="center"><?php echo $i; ?></td>
			<td><?php echo $nama_ekskul->nama_ekskul; ?></td>
			<td><?php echo $eks->deskripsi_ekskul; ?></td>
		</tr>
		<?php
		}
		$i++;
		}
	} else {
	?>
		<tr>
			<td colspan="3" align="center">Belum ada data untuk ditampilkan</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>