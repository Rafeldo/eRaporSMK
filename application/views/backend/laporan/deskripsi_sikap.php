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
							<th width="15%">Nama Siswa</th>
							<th width="50%">Catatan Sikap</th>
							<th width="35%">Deskripsi Sikap</th>
						</tr>
					</thead>
					<tbody
					<?php
					if($data_siswa){
						foreach($data_siswa as $siswa){ 
					?>
					<?php
					$deskripsi_sikap = Deskripsisikap::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id,$data_rombel->id,$siswa->id);
					if($deskripsi_sikap){
						$data_deskripsi = $deskripsi_sikap->uraian_deskripsi;
					} else {
						$data_deskripsi = '';
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
						<?php
						$all_sikap_mapel = Sikap::find('all', array('conditions' => "ajaran_id = $ajaran->id AND rombel_id = $data_rombel->id AND siswa_id = $siswa->id", 'group' => 'mapel_id',));
						$all_sikap = Sikap::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id,$data_rombel->id,$siswa->id);
						if($all_sikap){
							foreach($all_sikap as $sikap){
								$a[$sikap->mapel_id][] = butir_sikap($sikap->butir_sikap).' = '.$sikap->uraian_sikap.' ('.opsi_sikap($sikap->opsi_sikap,1).')';
								$ajaran_id[$sikap->mapel_id] = $ajaran->id;
								$rombel_id[$sikap->mapel_id] = $data_rombel->id;
							}
							foreach($a as $b=>$c){
								echo 'Guru Mata Pelajaran : '.get_guru_mapel($ajaran_id[$b],$rombel_id[$b],$b, 'nama').'<br />';
								echo '<ul>';
								foreach($c as $d){
									echo '<li>'.$d.'</li>';
								}
								echo '</ul>';
							}
						} else {
							echo 'Tidak ada catatan sikap berdasarkan observasi guru';
						}
						?>
						</td>
						<td>
							<textarea name="uraian_deskripsi[]" class="editor1" style="width: 100%; height: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" rows="8"><?php echo $data_deskripsi; ?></textarea>
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