<?php
$mulok = Mulok::find_by_id($id_mapel);
$all_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
if($all_siswa){
?>
<div class="no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="30%" style="vertical-align: middle;">Nama Siswa</th>
				<?php 
				for ($i = 1; $i <= 10; $i++) {
					$nama_penilaian_mulok = Nilaimulok::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_kompetensi_id_and_bentuk_penilaian($ajaran_id,$rombel_id,$id_mapel,$kompetensi_id,$i);
					if($nama_penilaian_mulok){
						$nama_penilaian = $nama_penilaian_mulok->nama_penilaian;
						$bobot_penilaian = $nama_penilaian_mulok->bobot_penilaian;
					} else {
						$nama_penilaian = '';
						$bobot_penilaian = '';
					}
				?>
				<th>Penilaian <?php echo $i; ?>
					<table>
						<tr>
							<td>Nama </td>
							<td>&nbsp;:&nbsp;</td>
							<td><input size="10" name="nama_penilaian[]" value="<?php echo $nama_penilaian; ?>"></td>
						</tr>
						<input type="hidden" name="bentuk_penilaian[]" value="<?php echo $i; ?>" />
						<tr>
							<td>Bobot </td>
							<td>&nbsp;:&nbsp;</td>
							<td><input size="10" name="bobot_penilaian[]" value="<?php echo $bobot_penilaian; ?>"></td>
						</tr>
					</table>
				</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php
		$no=1;
		foreach($all_siswa as $siswa){
		?>
			<input type="hidden" name="siswa_id[]" value="<?php echo $siswa->id; ?>" />
			<tr>
				<td><?php echo $siswa->nama; ?></td>
				<?php for ($i = 1; $i <= 10; $i++) {
					$nilai_mulok = Nilaimulok::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_kompetensi_id_and_bentuk_penilaian($ajaran_id, $rombel_id, $id_mapel, $siswa->id, $kompetensi_id, $i);
					if($nilai_mulok){
						$nilai_value = $nilai_mulok->nilai;
					} else {
						$nilai_value = '';
					}
				?>
				<td><input type="text" name="kd_<?php echo $i; ?>[]" size="10" class="form-control" value="<?php echo $nilai_value; ?>" /></td>
				<?php } ?>
			<tr>
		<?php $no++;
		}
		?>
		</tbody>
	</table>
</div>
<?php } ?>