<?php
$settings 	= Setting::first();
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
		<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
		<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
		<?php echo (isset($message) && $message != '') ? error_msg($message) : '';?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> <?php echo $page_title; ?></a></li>
					<?php 
					if($settings->import == 1){
						if(!isset($user->id)){ ?>
							<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-upload"></i> Import Data Siswa</a></li>
					<?php 
						} 
					} 
					?>
				</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<?php echo form_open_multipart(uri_string()); ?>
						<div class="box-body">
							<div class="row">
								<div class="col-xs-4">
									<div class="form-group col-xs-12">
										<label>Rombongan Belajar</label>
										<?php
										$default = array(''=>'== Pilih Rombel ==');
										$extra = 'class="select2 form-control required"';
										foreach ($rombels as $v){
											if($v->guru_id == 0){
												$nama_wali_kelas = 'Belum Dipilih';
											} else {
												$wali = Dataguru::find($v->guru_id);
												$nama_wali_kelas = $wali->nama;
											}
											$options[$v->id] = $v->nama.' || Wali Kelas : '.$nama_wali_kelas;
										}
										$get_options = isset($options) ? $options : array();
										echo form_dropdown('rombel_id', $default + $get_options, $rombel,$extra); ?>
									</div>
									<div class="form-group col-xs-12">
										<label for="nama">Nama</label>
										<?php echo form_input($nama);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Nomor Induk</label>
										<?php echo form_input($no_induk);?>
									</div>
									<div class="form-group col-xs-12">
										<label>NISN</label>
										<?php echo form_input($nisn);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Jenis Kelamin</label>
										<?php
										$jenis_kelamins = array('L'=>'Laki-laki','P'=>'Perempuan');
										echo form_dropdown('jenis_kelamin', $jenis_kelamins, $jenis_kelamin,$extra);
										?>
									</div>
									<div class="form-group col-xs-12">
										<label>Tempat Lahir</label>
										<?php echo form_input($tempat_lahir);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Tanggal Lahir</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<?php echo form_input($tanggal_lahir);?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label>Agama</label>
										<?php
										$agamas = array(1=>'Islam',2=>'Kristen',3=>'Katholik',4=>'Hindu',5=>'Budha',6=>'Konghucu',98=>'Tidak diisi',99=>'Lainnya');
										echo form_dropdown('agama', $agamas, $agama_id,$extra);
										?>
									</div>
									<div class="form-group col-xs-12">
										<label>Status dalam Keluarga</label>
										<?php
										$status = array(
											'Anak Kandung' 		=> 'Anak Kandung',
											'Anak Angkat'		=> 'Anak Angkat',
											'Anak Asuh'			=> 'Anak Asuh'
											);
										echo form_dropdown('status', $status, $status_id,$extra);
										?>
									</div>
									<div class="form-group col-xs-12">
										<label>Anak Ke</label>
										<?php echo form_input($anak_ke);?>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group col-xs-12">
										<label>Alamat/Jalan</label>
										<?php echo form_input($alamat);?>
									</div>
									<div class="form-group col-xs-12">
										<div class="row">
											<label class="col-xs-12">RT / RW</label>
											<span class="col-xs-3">
												<?php echo form_input($rt);?>
											</span>
											<span class="col-xs-1">/</span>
											<span class="col-xs-3">
												<?php echo form_input($rw);?>
											</span>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label>Desa/Kelurahan</label>
										<?php echo form_input($desa_kelurahan);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Kecamatan</label>
										<?php echo form_input($kecamatan);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Kodepos</label>
										<?php echo form_input($kode_pos);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Nomor Telepon</label>
										<?php echo form_input($no_telp);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Sekolah Asal</label>
										<?php echo form_input($sekolah_asal);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Diterima dikelas</label>
										<?php echo form_input($diterima_kelas);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Diterima pada tanggal</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<?php echo form_input($diterima);?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label>Email</label>
										<?php echo form_input($email);?>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="form-group col-xs-12">
										<label>Nama Ayah</label>
										<?php echo form_input($nama_ayah);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Pekerjaan Ayah</label>
										<?php echo form_input($kerja_ayah);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Nama Ibu</label>
										<?php echo form_input($nama_ibu);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Pekerjaan Ibu</label>
										<?php echo form_input($kerja_ibu);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Nama Wali</label>
										<?php echo form_input($nama_wali);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Alamat Wali</label>
										<?php echo form_input($alamat_wali);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Nomor Telepon Wali</label>
										<?php echo form_input($telp_wali);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Pekerjaan Wali</label>
										<?php echo form_input($kerja_wali);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Password</label>
										<?php echo form_input($password);?>
									</div>
									<div class="form-group col-xs-12">
										<label>Upload Foto</label>
										<input  type="file" name="siswaphoto" />
									</div>
									<?php echo form_hidden('id', isset($user->id));?>
									<?php echo form_hidden('user_type', '4');?>
									<?php echo form_hidden('petugas', $this->session->userdata('username'));?>
									<?php echo form_hidden('data_sekolah_id', $data_sekolah_id);?>
									<?php echo form_hidden(isset($csrf)); ?>
								</div>
							</div>
						</div>
						<div class="box-footer clearfix">
							<button type="submit" class="btn btn-primary  pull-right">Simpan</button>
						</div>
					<?php echo form_close();?>
				</div><!--/tab_1 active-->
				<div class="tab-pane" id="tab_2">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12 text-center">
								<p><a href="<?php echo  site_url('downloads/template_siswa.xlsx'); ?>" class="btn btn-warning"> Download Template Siswa</a></p>
							</div>
						</div>
					</div>
					<div class="box-footer clearfix">
						<p class="text-center"><span class="btn btn-primary btn-file">								
									Browse  <input type="file" id="fileupload" name="import" />
								</span></p>
								<div id="result"></div>
								<div id="gagal" class="alert alert-danger" style="margin-top:20px; display:none;"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Import Data Error!</b> Silahkan pilih Mata Pelajaran terlebih dahulu.</div>
						<div id="progress" class="progress" style="margin-top:10px; display:none;">
							<div class="progress-bar progress-bar-success"></div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
			</div>
		</div>
	</div>
</div>