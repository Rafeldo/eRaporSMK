<?php echo link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script>
<?php
$data_rombel = Datarombel::find($id_rombel);
$all_kd_alias = Kd::find_all_by_id_mapel_and_kelas_and_id_kompetensi_alias($id_mapel, $data_rombel->tingkat, $kompetensi_id);
if($all_kd_alias){
	foreach($all_kd_alias as $kd_alias){
		$result[$kd_alias->id][] = $kd_alias->id_kompetensi;
	}
} else {
	$all_kd = Kd::find_all_by_id_mapel_and_kelas($id_mapel,$data_rombel->tingkat);
	foreach($all_kd as $kd){
		$get_kd[$kd->id] = $kd->id_kompetensi;
		$get_kd_alternatif[str_replace(' ','_',$kd->kompetensi_dasar)] = $kd->id_kompetensi;
	}
	if($kompetensi_id == 1){
		$input = preg_quote('KD-03', '~'); // don't forget to quote input string!
		$input_alt = preg_quote('3.', '~'); // don't forget to quote input string!
	} elseif($kompetensi_id == 2){
		$input = preg_quote('KD-04', '~'); // don't forget to quote input string!
		$input_alt = preg_quote('4.', '~'); // don't forget to quote input string!
	} else {
		$input = preg_quote('', '~'); // don't forget to quote input string!
	}
	if(isset($get_kd)){
		$result = preg_grep('~' . $input . '~', $get_kd);
	}
	if(!isset($result) && isset($get_kd_alternatif)){
		$result = preg_grep('~' . $input_alt . '~', $get_kd_alternatif);
	}
}
//print_r($get_kd_alternatif);
$loggeduser = $this->ion_auth->user()->row();
$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_kompetensi_id($ajaran_id, $kompetensi_id);
if($loggeduser->data_guru_id){
	//$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_kompetensi_id($ajaran_id, $kompetensi_id);
	//$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_id_mapel_and_guru_id_and_kompetensi_id($ajaran_id, $id_mapel, $guru_id, $kompetensi_id);
} else {
	//$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_id_mapel_and_kompetensi_id($ajaran_id, $id_mapel, $kompetensi_id);
}
if(isset($result)){
?>
<table class="table table-hover">
	<thead>
		<th style="vertical-align: middle;">Kompetensi Dasar</th>
		<?php for ($i = 1; $i <= 5; $i++) {?>
		<th>
			<table>
				<tr>
					<td>Jenis </td>
					<td>&nbsp;:&nbsp;</td>
					<td><input size='10' name="nama_penilaian[]" value=""></td>
				</tr>
				<tr>
					<td>Metode </td>
					<td>&nbsp;:&nbsp;</td>
					<td>
						<select name='bentuk_penilaian[]'>
							<option value="">--</option>
							<?php 
								if($bentuk_penilaian){
								foreach($bentuk_penilaian as $value){ ?>
								<option value="<?php echo $value->id; ?>"><?php echo $value->nama_metode; ?></option>
								<?php } 
								} else {
								?>
								<option value="">Belum ada</option>
								<?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Bobot </td>
					<td>&nbsp;:&nbsp;</td>
					<td><input size='10' name="bobot_penilaian[]" value=""></td>
				</tr>
			</table>
		</th>
		<?php } ?>
	</thead>
	<tbody>
	<?php
	foreach($result as $key=>$kd_result){
		$kd = Kd::find($key);
	?>
		<tr>
			<td><a href="javascript:void(0)" class="tooltip-right" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo $kd->id_kompetensi; ?></a></td>
			<?php for ($i = 1; $i <= 5; $i++) {?>
			<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
			<td>
				<div class="text-center"><input type="checkbox" class="icheck" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
			</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
$('.icheck').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
});
</script>
<?php } else { ?>
Referensi KD tidak ditemukan
<style>.simpan{display:none !important;}</style>
<?php } ?>