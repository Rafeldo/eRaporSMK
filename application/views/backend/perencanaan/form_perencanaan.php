<?php echo link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script>
<?php
$data_rombel = Datarombel::find($id_rombel);
$join = "INNER JOIN matpel_komps a ON(kds.id_mapel= a.id_mapel AND a.kurikulum_id = $data_rombel->kurikulum_id)";
if($kompetensi_id == 1){
	$aspek = 'P';
} else {
	$aspek = 'K';
}
$all_kd = Kd::find('all', array('conditions' => "kds.id_mapel  = '$id_mapel' AND kelas = $data_rombel->tingkat AND aspek = '$aspek'"));
if(!$all_kd){
	$all_kd = Kd::find('all', array('conditions' => "kds.id_mapel  = '$id_mapel' AND kelas = $data_rombel->tingkat AND aspek = 'PK'"));
} 
foreach($all_kd as $kd){
	$get_kd[$kd->id] = $kd->id_kompetensi;
	$get_kd_alternatif[$kd->id] = $kd->id_kompetensi;
}
$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_kompetensi_id($ajaran_id, $kompetensi_id);
if($all_kd){
?>
<table class="table table-striped table-bordered" id="clone">
	<thead>
		<tr>
			<th class="text-center" style="min-width:110px">Aktifitas Penilaian</th>
			<th class="text-center" style="min-width:110px;">Teknik</th>
			<?php //if($kompetensi_id == 1){ ?>
			<th class="text-center" width="10">Bobot</th>
			<?php //} ?>
			<?php
			foreach($all_kd as $kd){
			?>
			<th class="text-center"><a href="javascript:void(0)" class="tooltip-top" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo $kd->id_kompetensi; ?></a></th>
			<?php
			} 
			?>
			<th class="text-center">Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 1; $i <= 5; $i++) {?>
		<tr>
			<td>
				<input class="form-control input-sm" type="text" name="nama_penilaian[]" value="" placeholder="UH/UTS/UAS dll...">
			</td>
			<td>
				<select class="form-control input-sm" name="bentuk_penilaian[]">
					<option value="">- Pilih -</option>
					<?php 
					if($bentuk_penilaian){
						foreach($bentuk_penilaian as $value){ ?>
					<option value="<?php echo $value->id; ?>"><?php echo $value->nama_metode; ?></option>
					<?php } 
					} else {
					?>
					<option value="">Belum ada</option>
					<?php } ?>
				</select>
			</td>
			<?php //if($kompetensi_id == 1){ ?>
			<td>
				<input class="form-control input-sm" type="text" name="bobot_penilaian[]" value="">
			</td>
			<?php //} ?>
			<?php
			if(isset($result)){
			foreach($result as $key=>$kd_result){
				$kd = Kd::find($key);
			?>
			<td style="vertical-align:middle;">
				<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
				<div class="text-center"><input type="checkbox" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
			</td>
			<?php } 
			} else {
			if(isset($get_kd_alternatif)){ 
				foreach($get_kd_alternatif as $kd_alt => $value){
				$kd = Kd::find($kd_alt);
			 ?>
			<td style="vertical-align:middle;">
				<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
				<div class="text-center"><input type="checkbox" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
			</td>
			<?php
				}
			}
			} ?>
			<td><input class="form-control input-sm" type="text" name="keterangan_penilaian[]" value=""></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<a class="clone btn btn-danger pull-left">Tambah Aktivitas Penilaian</a>
<button type="submit" class="btn btn-success pull-right">Simpan</button>
<?php } elseif($all_kd){
$all_kd = Kd::find('all', array('conditions' => "kds.id_mapel = '$id_mapel' AND kelas = $data_rombel->tingkat AND id_kompetensi = $kompetensi_id OR kds.id_mapel = '$id_mapel' AND kelas = $data_rombel->tingkat AND id_kompetensi = 0"));
if($all_kd){?>
<table class="table table-striped table-bordered" id="clone">
	<thead>
		<tr>
			<th class="text-center">Aktifitas Penilaian</th>
			<th class="text-center">Teknik</th>
			<?php if($kompetensi_id == 1){ ?>
			<th class="text-center" width="10">Bobot</th>
			<?php } ?>
			<?php foreach($all_kd as $kd){ ?>
			<th class="text-center"><a href="javascript:void(0)" class="tooltip-top" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo ($kd->id_kompetensi_alias) ? $kd->id_kompetensi_alias : $kd->id_kompetensi; ?></a></th>
			<?php } ?>
			<th class="text-center">Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 1; $i <= 5; $i++) {?>
		<tr>
			<td>
				<input class="form-control input-sm" type="text" name="nama_penilaian[]" value="" placeholder="UH/UTS/UAS dll...">
			</td>
			<td>
				<select class="form-control input-sm" name="bentuk_penilaian[]">
					<option value="">- Pilih -</option>
					<?php 
					if($bentuk_penilaian){
						foreach($bentuk_penilaian as $value){ ?>
					<option value="<?php echo $value->id; ?>"><?php echo $value->nama_metode; ?></option>
					<?php } 
					} else {
					?>
					<option value="">Belum ada</option>
					<?php } ?>
				</select>
			</td>
			<?php if($kompetensi_id == 1){ ?>			
			<td>
				<input class="form-control input-sm" type="text" name="bobot_penilaian[]" value="">
			</td>
			<?php } ?>
			<?php foreach($all_kd as $kd){ ?>
			<td style="vertical-align:middle;">
				<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
				<div class="text-center"><input type="checkbox" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
			</td>
			<?php } ?>
			<td><input class="form-control input-sm" type="text" name="keterangan_penilaian[]" value=""></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<a class="clone btn btn-danger pull-left">Tambah Aktivitas Penilaian</a>
<button type="submit" class="btn btn-success pull-right">Simpan</button>
<?php } else { ?>
<h3 class="text-center">Kompetensi Dasar belum tersedia <br />
<a class="btn btn-sm btn-success" href="<?php echo site_url('admin/referensi/add_kd/'.$kompetensi_id.'/'.$id_rombel.'/'.$id_mapel.'/'.$kelas); ?>" target="_blank">Tambah Data Kompetensi Dasar</a></h3>
<?php } ?>
<?php } else { ?>
<h3 class="text-center">Kompetensi Dasar belum tersedia <br />
<a class="btn btn-sm btn-success" href="<?php echo site_url('admin/referensi/add_kd/'.$kompetensi_id.'/'.$id_rombel.'/'.$id_mapel.'/'.$kelas); ?>" target="_blank">Tambah Data Kompetensi Dasar</a></h3>
<?php } ?>
<script>
//$('.iCheck').iCheck({
//	checkboxClass: 'icheckbox_square-blue',
//	increaseArea: '20%' // optional
//});
$('button.simpan').remove();
var i = <?php echo isset($i) ? $i : 0; ?>;
$("a.clone").click(function() {
	$("table#clone tbody tr:last").clone().find("td").each(function() {
		$(this).find('input[type=hidden]').attr('name', 'kd_id_'+i+'[]');
		$(this).find('input[type=checkbox]').attr('name', 'kd_'+i+'[]');
	}).end().appendTo("table#clone");
	i++;
});
</script>
<?php echo link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script>