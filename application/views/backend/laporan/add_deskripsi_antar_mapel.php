<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
		<!-- form start -->
            <?php 
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open($form_action,$attributes);
			$ajaran = get_ta();
			$loggeduser = $this->ion_auth->user()->row();
			$data_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
			$data_siswa = Datasiswa::find_all_by_data_rombel_id($data_rombel->id);
			?>
			<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
			<input type="hidden" name="rombel_id" value="<?php echo $data_rombel->id; ?>" />
			<div class="table-responsive no-padding">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="20%">Nama Siswa</th>
							<th width="80%">Deskripsi</th>
						</tr>
					</thead>
					<tbody
					<?php 
					if($data_siswa){
						foreach($data_siswa as $siswa){ 
					?>
					<?php
					$deskripsi_antar_mapel = Catatanwali::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id,$data_rombel->id,$siswa->id);
					$data_deskripsi = '';
					if($deskripsi_antar_mapel){
						$data_deskripsi .= $deskripsi_antar_mapel->uraian_deskripsi;
					} else {
						$get_deskripsi_per_mapel = Deskripsi::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id,$data_rombel->id,$siswa->id);
						if($get_deskripsi_per_mapel){
							foreach($get_deskripsi_per_mapel as $gdpm){
								$data_deskripsi .= 'Pengetahuan : '.$gdpm->deskripsi_pengetahuan;
								$data_deskripsi .= '<br />Keterampilan : '.$gdpm->deskripsi_keterampilan;
							}
						} else {
							$data_deskripsi .= '';//'Belum dilakukan penilaian';
						}
					}
					?>
					<tr>
						<td>
							<input type="hidden" name="siswa_id[]" value="<?php echo $siswa->id; ?>" /> 
							<?php echo $siswa->nama.'<br />'; ?>
							<?php echo $siswa->nisn.'<br />'; ?>
							<?php $date = date_create($siswa->tanggal_lahir);
							echo date_format($date,'d/m/Y'); ?>
						</td>
						<td>
							<textarea name="uraian_deskripsi[]" class="editor" style="width: 100%; height: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data_deskripsi; ?></textarea>
						</td>
					</tr>
				<?php } }?>
				</tbody>
			</table>
		</div>
              <!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>