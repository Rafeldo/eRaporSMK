<?php echo link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script>
<?php
$data_rombel = Datarombel::find($id_rombel);
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
$result = preg_grep('~' . $input . '~', $get_kd);
if(!$result){
$result = preg_grep('~' . $input_alt . '~', $get_kd_alternatif);
}
//print_r($result);
//print_r($get_kd_alternatif);
?>
<table class="table table-striped table-bordered" id="clone">
	<thead>
		<tr>
			<th class="text-center">Kompetensi Dasar</th>
			<?php
			foreach($result as $key=>$kd_result){
				$kd = Kd::find($key);
			?>
			<th class="text-center"><a href="javascript:void(0)" class="tooltip-top" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo $kd->id_kompetensi; ?></a></th>
			<?php /*for ($i = 1; $i <= 5; $i++) {?>
			<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
			<td>
				<div class="text-center"><input type="checkbox" class="icheck" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
			</td>
			<?php } */?>
			<?php } ?>
		</tr>
		<?php /*for ($i = 1; $i <= 5; $i++) {?>
		<th>
			<table>
				<tr>
					<td>Nama </td>
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
							if($kompetensi_id == 1){
								$bentuk_penilaian = array(1 => 'Penugasan', 2 => 'Tes Tulis', 3 => 'Tes Lisan');
							} else {
								$bentuk_penilaian = array(1 => 'Kinerja', 2 => 'Proyek');
							}
							foreach($bentuk_penilaian as $key=>$value){ ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
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
		<?php } */?>
	</thead>
	<tbody>
		<?php for ($i = 1; $i <= 5; $i++) {?>
		<tr>
			<td>
				<div class="form-group" style="margin-bottom:5px;">
					<label class="col-sm-4 control-label">Jenis</label>
					<div class="col-sm-6">
						<input class="form-control input-sm" type="text" name="nama_penilaian[]" value="">
					</div>
				</div>
				 <div class="form-group" style="margin-bottom:5px;">
					<label class="col-sm-4 control-label">Metode</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="bentuk_penilaian[]">
							<option value="">--</option>
							<?php 
							if($kompetensi_id == 1){
								$bentuk_penilaian = array(1 => 'Penugasan', 2 => 'Tes Tulis', 3 => 'Tes Lisan');
							} else {
								$bentuk_penilaian = array(1 => 'Kinerja', 2 => 'Proyek');
							}
							foreach($bentuk_penilaian as $key=>$value){ ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group" style="margin-bottom:5px;">
					<label class="col-sm-4 control-label">Bobot</label>
					<div class="col-sm-6">
						<input class="form-control input-sm" type="text" name="bobot_penilaian[]" value="">
					</div>
				</div>
			</td>
			<?php
			foreach($result as $key=>$kd_result){
				$kd = Kd::find($key);
			?>
			<td style="vertical-align:middle;">
				<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
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
	increaseArea: '20%' // optional
});
</script>