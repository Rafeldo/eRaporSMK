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
					<?php if(isset($user)){?>
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> <?php echo $page_title; ?></a></li>
					<?php } else { ?>
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> Tambah <?php echo $page_title; ?></a></li>
					<?php if($settings->import == 1){ ?>
					<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-upload"></i> Import <?php echo $page_title; ?></a></li>
					<?php } ?>
					<?php } ?>
				</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
		<?php 
		echo form_open_multipart(uri_string()); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-6"> 
						<div class="form-group col-xs-12">
							<label for="nama">Nama</label>
							<?php 
							echo form_hidden('data_sekolah_id', $data_sekolah_id);
							echo form_input($nama);?>
						</div>
						<div class="form-group col-xs-12">
							<label>Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control required">
							<?php
						$jenis_kelamins = array('L'=>'Laki-laki','P'=>'Perempuan');
						foreach ($jenis_kelamins as $k=>$kelamin): ?>
								<option value="<?php echo $k;?>"<?php echo ($k == $jenis_kelamin) ? ' selected' : '' ; ?>><?php echo htmlspecialchars($kelamin,ENT_QUOTES,'UTF-8');?></option>
							<?php endforeach?>
							</select>
						</div>
						<div class="form-group col-xs-12">
							<label>NUPTK</label>
							<?php echo form_input($nuptk);?>
						</div>
						<div class="form-group col-xs-12">
							<label>NIP</label>
							<?php echo form_input($nip);?>
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
							<select name="agama" class="form-control required">
							<?php 
							$agamas = array(1=>'Islam',2=>'Kristen',3=>'Katholik',4=>'Hindu',5=>'Budha',6=>'Konghucu',98=>'Tidak diisi',99=>'Lainnya');
							foreach ($agamas as $k=>$a):?>
								<option value="<?php echo $k;?>"<?php echo ($k == $agama) ? ' selected' : '' ; ?>><?php echo htmlspecialchars($a,ENT_QUOTES,'UTF-8');?></option>
							<?php endforeach?>
							</select>
						</div>
						<div class="form-group col-xs-12">
							<label>Alamat Jalan</label>
							<?php echo form_input($alamat);?>
						</div>
						</div>
						<div class="col-xs-6"> 
						<div class="form-group col-xs-12">
							<label>RT</label>
							<?php echo form_input($rt);?>
						</div>
						<div class="form-group col-xs-12">
							<label>RW</label>
							<?php echo form_input($rw);?>
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
							<label>Nomor Handphone</label>
							<?php echo form_input($no_hp);?>
						</div>
						<div class="form-group col-xs-12">
							<label>Email</label>
							<?php echo form_input($email);?>
						</div>
						<?php /*div class="form-group col-xs-12">
							<label>Kodepos</label>
							<?php echo form_input($kode_pos);?>
						</div*/ ?>
						<div class="form-group col-xs-12">
							<label>Upload Foto</label>
							<input  type="file" name="guruphoto" />
						</div>
                        <div class="form-group col-xs-12">
							<label>Password</label>
							<?php echo form_input($password);?>
						</div>
							<?php if(isset($user)) echo form_hidden('id', $user->id); else echo form_hidden('id', '');?>
							<?php echo form_hidden('user_type', '3');?>
							<?php //echo form_hidden('password', '12345678');?>
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
								<p><a href="<?php echo  site_url('downloads/template_guru.xlsx'); ?>" class="btn btn-warning"> Download Template Guru</a></p>
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