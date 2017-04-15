<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
		<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
		<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
		<?php echo (isset($message) && $message != '') ? error_msg($message) : '';?>
		<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<?php if(isset($rombel)){?>
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> <?php echo $page_title; ?></a></li>
					<?php } else { ?>
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> Tambah <?php echo $page_title; ?></a></li>
					<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-upload"></i> Import <?php echo $page_title; ?></a></li>
					<?php } ?>
				</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
		<?php $loggeduser = $this->ion_auth->user()->row();
		echo form_open_multipart(uri_string()); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group col-xs-12">
								<label>Tingkat</label>
								<?php
								$default = array(''=>'== Pilih Tingkat Pendidikan ==');
								$extra = 'class="form-control required"';
								$options = array(
											10 =>'Kelas 10',
											11 =>'Kelas 11',
											12 =>'Kelas 12',
											13 =>'Kelas 13'
										);
								echo form_dropdown('tingkat', $default + $options, $tingkat, $extra) 
								?>
							</div> 
						<div class="form-group col-xs-12">
							<label for="nama">Nama Rombel</label>
							<?php echo form_input($nama);?>
						</div>
						</div>
						<div class="col-xs-6"> 
							<div class="form-group col-xs-12">
								<label>Kompetensi Keahlian</label>
								<?php
								$extra1 = 'class="select2 form-control required"';
								$default = array(''=>'== Pilih Kompetensi Keahlian ==');
								foreach ($keahlian as $v){
									$data_kurikulum = Datakurikulum::find_by_kurikulum_id($v->kurikulum_id);
									$kompetensi[$v->kurikulum_id] = $data_kurikulum->nama_kurikulum;
								}
								echo form_dropdown('kurikulum_id', $default + $kompetensi, $kurikulum_id, $extra1) 
								?>
							</div>
							<div class="form-group col-xs-12">
								<label>Wali Kelas</label>
								<?php
								$extra1 = 'class="select2 form-control required"';
								$default = array(''=>'== Pilih Wali Kelas ==');
								foreach ($gurus as $v){
									$data_guru[$v->id] = $v->nama;
								}
								$get_data_guru = isset($data_guru) ? $data_guru : array();
								echo form_dropdown('guru_id', $default + $get_data_guru, $guru_id, $extra1) 
								?>
							</div>
							<?php echo form_hidden('data_sekolah_id', $loggeduser->data_sekolah_id);?>
							<?php if(isset($rombel)) echo form_hidden('id', $rombel->id);?>
							<?php echo form_hidden('petugas', $loggeduser->username);?>
							<?php echo form_hidden(isset($csrf)); ?>
					</div>
				</div>
			</div>
			<div class="box-footer clearfix">
				<div class="form-group col-xs-7">
					<button type="submit" class="btn btn-primary  pull-right">Simpan</button>
				</div>
			</div>
			<?php echo form_close();?>
			</div><!--/tab_1 active-->
				<div style="clear:both"></div>
				<div class="tab-pane" id="tab_2">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12 text-center">
								<p><a href="<?php echo  site_url('downloads/template_rombel.xlsx'); ?>" class="btn btn-warning"> Download Template Rombongan Belajar</a></p>
								<p><span class="btn btn-primary btn-file">								
									Browse  <input type="file" id="fileupload" name="import" />
								</span></p>
								<div id="result"></div>
								<div id="files" class="files"></div>
							</div>
						</div>
					</div>
					<div class="box-footer clearfix">
						<div id="progress" class="progress" style="margin-top:10px; display:none;">
							<div class="progress-bar progress-bar-success"></div>
						</div>
					</div>
				</div><!-- /.tab-pane --> 
			</div>
		</div>
	</div>
</div>