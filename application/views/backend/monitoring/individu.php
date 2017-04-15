<?php
$ajaran = get_ta();
$siswa_id = $user->data_siswa_id;
$siswa = Datasiswa::find_by_id($siswa_id);
$nama_siswa = isset($siswa->nama) ? $siswa->nama : '-';
$rombel_id = isset($siswa->data_rombel_id) ? $siswa->data_rombel_id : 0;
$rombel = Datarombel::find_by_id($rombel_id);
$mata_pelajaran = Kurikulum::find_all_by_ajaran_id_and_rombel_id($ajaran->id,$rombel_id);
foreach($mata_pelajaran as $allmapel){
	$get_id_mapel[] = $allmapel->id_mapel;
}
if(isset($get_id_mapel)){
$mata_pelajaran = filter_agama_mapel($ajaran->id,$rombel_id,$get_id_mapel, $get_id_mapel, $siswa->agama);
}
?>
<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
		<!-- form start -->
		<div class="col-sm-5">
		<table class="table table-bordered table-hover">
			<tr>
				<td width="45%">Nama Siswa</td>
				<td width="5%" class="text-center">:</td>
				<td width="50%"><?php echo $nama_siswa; ?></td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td width="5%" class="text-center">:</td>
				<td width="50%"><?php echo isset($rombel) ? $rombel->nama : ''; ?></td>
			</tr>
		</table>
		</div>
		<div class="clearfix"></div>
			<div class="form-group" style="margin-top:10px;">
				<label for="ajaran_id" class="col-sm-2 control-label">Mata Pelajaran</label>
				<div class="col-sm-5">
					<form>
					<input type="hidden" name="query" id="query" value="analisis_individu/<?php echo $siswa_id; ?>" />
					<select name="id_mapel" class="select2 form-control" id="mapel">
						<option value="">== Pilih Mata Pelajaran ==</option>
						<?php 
						if($mata_pelajaran){
							foreach($mata_pelajaran as $mapel){
								$get_mapel = Kurikulum::find_by_id_mapel($mapel);
						?>
						<option value="<?php echo $mapel; ?>"><?php echo get_nama_mapel($ajaran->id,$rombel_id,$mapel); ?></option>
						<?php
							} 
						}
						?>
					</select>
					</form>
                  </div>
                </div>
			</div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div id="result" style="margin-top:20px;"></div>
			</div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>