<?php
$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
?>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="20%">Nama Siswa</th>
				<th width="20%">Predikat</th>
				<th width="60%">Deskripsi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($data_siswa){
				foreach($data_siswa as $siswa){
				$nilai_ekskul = Nilaiekskul::find_by_ajaran_id_and_ekskul_id_and_rombel_id_and_siswa_id($ajaran_id,$ekskul_id,$rombel_id,$siswa->id);
			?>
			<tr>
				<td>
					<input type="hidden" name="siswa_id[]" value="<?php echo $siswa->id; ?>" />
					<?php echo $siswa->nama; ?>
				</td>
				<td>
					<select name="nilai[]" class="form-control" id="nilai_ekskul">
						<option value="">== Pilih Predikat ==</option>
						<option value="1"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 1) ? 'selected="selected"' : ''; ?>>Sangat Baik</option>
						<option value="2"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 2) ? 'selected="selected"' : ''; ?>>Baik</option>
						<option value="3"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 3) ? 'selected="selected"' : ''; ?>>Cukup</option>
						<option value="4"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 4) ? 'selected="selected"' : ''; ?>>Kurang</option>
					</select>
				</td>
				<td><input type="text" class="form-control" id="deskripsi_ekskul" name="deskripsi_ekskul[]" value="<?php echo isset($nilai_ekskul->deskripsi_ekskul) ? $nilai_ekskul->deskripsi_ekskul : ''; ?>" /></td>
			</tr>
			<?php
				}
			} else {
			?>
			<tr>
				<td colspan="4" class="text-center">Tidak ada data siswa di rombongan belajar terpilih</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<script>
$('select#nilai_ekskul').change(function(e) {
	e.preventDefault();
	var ini = $(this).val();
	var nama_ekskul = $("#ekskul option:selected").text();
	var nilai_ekskul = $(this).find("option:selected").text();
	if(ini == ''){
		$(this).closest('td').next('td').find('input').val('');
	} else {
		$(this).closest('td').next('td').find('input').val('Melaksanakan kegiatan '+nama_ekskul+' dengan '+nilai_ekskul);
	}
});
</script>