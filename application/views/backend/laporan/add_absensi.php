<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
<?php
$ajaran = get_ta();
$loggeduser = $this->ion_auth->user()->row();
$rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel->id);
$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
echo form_open($form_action,$attributes);
?>
<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
<input type="hidden" name="rombel_id" value="<?php echo $rombel->id; ?>" />
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="70%">Nama Siswa</th>
				<th width="10%">Sakit</th>
				<th width="10%">Izin</th>
				<th width="10%">Tanpa Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($data_siswa){
				foreach($data_siswa as $siswa){
				$absen = Absen::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id,$rombel->id,$siswa->id);
			?>
			<tr>
				<td>
					<input type="hidden" name="siswa_id[]" value="<?php echo $siswa->id; ?>" />
					<?php echo $siswa->nama; ?>
				</td>
				<td><input type="text" class="form-control" name="sakit[]" value="<?php echo (isset($absen->sakit)) ? $absen->sakit: ''; ?>" /></td>
				<td><input type="text" class="form-control" name="izin[]" value="<?php echo isset($absen) ? $absen->izin : ''; ?>" /></td>
				<td><input type="text" class="form-control" name="alpa[]" value="<?php echo isset($absen) ? $absen->alpa : ''; ?>" /></td>
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
			<div class="box-footer">
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
            <?php echo form_close();  ?>
</div>
</div>
</div>