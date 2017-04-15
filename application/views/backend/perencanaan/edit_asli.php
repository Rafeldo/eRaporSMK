<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
		<!-- form start -->
            <?php
			if($kompetensi_id == 1){
				$action = 'update_perencanaan';
			} else {
				$action = 'update_perencanaan';
			}
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open($form_action.$action,$attributes); 
			$bentuk_penilaian = Metode::find_all_by_ajaran_id_and_kompetensi_id($rencana->ajaran_id, $kompetensi_id);
			?>
			<div class="box-body">
				<div class="form-group">
					<label for="ajaran_id" class="col-sm-2 control-label">Tahun Ajaran</label>
					<div class="col-sm-5">
						<input type="hidden" name="rencana_id" id="rencana_id" value="<?php echo $rencana->id; ?>" />
						<input type="hidden" name="kompetensi_id" id="kompetensi_id" value="<?php echo $kompetensi_id; ?>" />
						<select class="select2 form-control" id="ajaran_id" disabled>
							<option value="">== Pilih Tahun Ajaran ==</option>
							<?php foreach($ajarans as $ajaran){?>
							<option value="<?php echo $ajaran->id; ?>"<?php echo ($rencana->ajaran_id == $ajaran->id) ? ' selected="selected"' : ''; ?>><?php echo $ajaran->tahun; ?></option>
							<?php } ?>
						</select>
						<input name="ajaran_id" type="hidden" value="<?php echo $rencana->ajaran_id; ?>" />
					</div>
                </div>
                <div class="form-group">
                  <label for="rombel_id_perencanaan" class="col-sm-2 control-label">Kelas</label>
				  <div class="col-sm-5">
                    <select class="select2 form-control" id="rombel_id_perencanaan" disabled>
						<option value="">== Pilih Kelas ==</option>
						<?php foreach($rombels as $rombel){?>
						<option value="<?php echo $rombel->id; ?>"<?php echo ($rencana->rombel_id == $rombel->id) ? ' selected="selected"' : ''; ?>><?php echo $rombel->nama; ?></option>
						<?php } ?>
					</select>
					<input name="rombel_id" type="hidden" value="<?php echo $rencana->rombel_id; ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_mapel_perencanaan" class="col-sm-2 control-label">Mata Pelajaran</label>
				  <div class="col-sm-5">
                    <select class="select2 form-control" id="id_mapel_perencanaan" disabled>
						<option value="">== Pilih Mata Pelajaran ==</option>
						<?php
						$all_mapel = Kurikulum::find_all_by_rombel_id($rencana->rombel_id);
						if($all_mapel){
							foreach($all_mapel as $mapel){
								$data_mapel = Datamapel::find_by_id_mapel($mapel->id_mapel);
								?>
								<option value="<?php echo $mapel->id_mapel; ?>"<?php echo ($rencana->id_mapel == $mapel->id_mapel) ? ' selected="selected"' : ''; ?>><?php echo $data_mapel->nama_mapel.' ('.$data_mapel->id_mapel.')'; ?></option>
								<?php
							}
						}
						?>
					</select>
					<input name="id_mapel" type="hidden" value="<?php echo $rencana->id_mapel; ?>" />
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer table-responsive no-padding">
				<div id="result_kd">
				<?php
				$data_rombel = Datarombel::find($rencana->rombel_id);
				$all_kd_alias = Kd::find_all_by_id_mapel_and_kelas_and_id_kompetensi_alias($rencana->id_mapel, $data_rombel->tingkat, $kompetensi_id);
				if($all_kd_alias){
					foreach($all_kd_alias as $kd_alias){
						$result[$kd_alias->id][] = $kd_alias->id_kompetensi;
					}
				} else {					
					$all_kd = Kd::find_all_by_id_mapel_and_kelas($rencana->id_mapel,$data_rombel->tingkat);
					foreach($all_kd as $kd){
						$get_kd[$kd->id] = $kd->id_kompetensi;
					}
					if($kompetensi_id == 1){
						$input = preg_quote('KD-03', '~'); // don't forget to quote input string!
					} elseif($kompetensi_id == 2){
						$input = preg_quote('KD-04', '~'); // don't forget to quote input string!
					} else {
						$input = preg_quote('', '~'); // don't forget to quote input string!
					}
					$result = preg_grep('~' . $input . '~', $get_kd);
				}
				//$get_rencana = Rencana::find_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($rencana->ajaran_id, $rencana->id_mapel, $rencana->rombel_id,$kompetensi_id);
				$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $rencana->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			?>
			<table class="table table-hover">
				<thead>
					<th style="vertical-align: middle;">Kompetensi Dasar</th>
					<?php foreach($rencana_penilaian_group as $group) {?>
					<th>
						<table>
							<tr>
								<td>Nama </td>
								<td>&nbsp;:&nbsp;</td>
								<td>
									<input size='10' value="<?php echo $group->nama_penilaian;?>" disabled="disabled">
									<input type="hidden" name="nama_penilaian[]" value="<?php echo $group->nama_penilaian;?>">
								</td>
							</tr>
							<tr>
								<td>Metode </td>
								<td>&nbsp;:&nbsp;</td>
								<td>
									<select disabled="disabled">
										<option value="">--</option>
										<?php 
											if($bentuk_penilaian){
											foreach($bentuk_penilaian as $value){ ?>
											<option value="<?php echo $value->id; ?>"<?php echo isset($group->bentuk_penilaian) ? ($group->bentuk_penilaian == $value->id) ? 'selected="selected" ' : '' : ''; ?>><?php echo $value->nama_metode; ?></option>
											<?php } 
											} else {
											?>
											<option value="">Belum ada</option>
											<?php
											}
										?>
									</select>
									<input type="hidden" name="bentuk_penilaian[]" value="<?php echo $group->bentuk_penilaian;?>">
								</td>
							</tr>
							<tr>
								<td>Bobot </td>
								<td>&nbsp;:&nbsp;</td>
								<td>
									<input size='10' value="<?php echo $group->bobot_penilaian; ?>" disabled="disabled">
									<input type="hidden" name="bobot_penilaian[]" value="<?php echo $group->bobot_penilaian; ?>">
								</td>
							</tr>
						</table>
					</th>
					<?php } ?>
				</thead>
				<tbody>
					<?php
					$checked ='';
					$no=0;
					foreach($result as $key=>$kd_result){
						$kd = Kd::find($key);
					?>
					<tr>
						<td><a href="javascript:void(0)" class="tooltip-right" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo $kd->id_kompetensi; ?></a></td>
					<?php $i=1;foreach($rencana_penilaian_group as $key=>$a) {
					$rencana_penilaian = Rencanapenilaian::find_all_by_rencana_id_and_kompetensi_id_and_nama_penilaian($rencana->id,$rencana->kompetensi_id,$a->nama_penilaian);
					?>
					<td>
					<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
						<?php 
						if(isset($rencana_penilaian[0])){
							foreach($rencana_penilaian as $rp){
								if($rp->kd_id == $kd->id){
									$checked ='checked="checked"';
									break;
								} 
								$checked ='';
							}
						}
						 ?>
						<div class="text-center"><input type="checkbox" <?php echo $checked; ?> class="icheck" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kompetensi; ?>|<?php echo $kd->id; ?>" /></div>
						</td>
						<?php
						$i++;}?>
					<?php $no++;} ?>
				</tbody>
			</table>
				</div>
				<button type="submit" class="btn btn-success simpan">Simpan</button>
			</div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>