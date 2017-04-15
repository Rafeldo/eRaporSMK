<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
		<!-- form start -->
            <?php
			$readonly = '';
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open($form_action,$attributes);  
			$ajaran = get_ta();
			$tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';?>
              <div class="box-body">
			  	<div class="form-group">
                  <label for="ajaran_id" class="col-sm-2 control-label">Tahun Pelajaran</label>
				  <div class="col-sm-5">
				  <input type="text" class="form-control" value="<?php echo $tahun_ajaran; ?>" readonly />
				  <?php if(isset($data)){
				  $readonly = 'disabled';
				  ?>
				  	<input type="hidden" name="action" value="edit" />
				  	<input type="hidden" name="id" value="<?php echo $data->id; ?>" />
				  <?php } ?>
				  	<input type="hidden" name="query" value="ekskul" />
					<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
                  </div>
                </div>
				<div class="form-group">
                  <label for="guru" class="col-sm-2 control-label">Nama Pembinan</label>
				  <div class="col-sm-5">
                    <select name="guru_id" class="select2 form-control" id="guru" required>
						<option value="">== Pilih Nama Guru ==</option>
						<?php foreach($data_guru as $guru){ ?>
						<option value="<?php echo $guru->id;?>"<?php echo (isset($data)) ? ($data->guru_id == $guru->id ? ' selected="selected"' : '') : '';?>><?php echo $guru->nama; ?></option>
						<?php
						}
						?>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="mapel" class="col-sm-2 control-label">Nama Ekstrakurikuler</label>
				  <div class="col-sm-5">
                    <input type="text" name="nama_ekskul" class="form-control" value="<?php echo (isset($data)) ? $data->nama_ekskul : ''; ?>" />
                  </div>
                </div>
				<div class="form-group">
                  <label for="nama_kur" class="col-sm-2 control-label">Nama Ketua</label>
				  <div class="col-sm-5">
                    <input type="text" name="nama_ketua" class="form-control" value="<?php echo (isset($data)) ? $data->nama_ketua : ''; ?>" />
                  </div>
                </div>
				<div class="form-group">
                  <label for="nama_kur" class="col-sm-2 control-label">Nomor Kontak</label>
				  <div class="col-sm-5">
                    <input type="text" name="nomor_kontak" class="form-control" value="<?php echo (isset($data)) ? $data->nomor_kontak : ''; ?>" />
                  </div>
                </div>
				<div class="form-group">
                  <label for="nama_kur" class="col-sm-2 control-label">Alamat Ekstrakurikuler</label>
				  <div class="col-sm-5">
                    <input type="text" name="alamat_ekskul" class="form-control" value="<?php echo (isset($data)) ? $data->alamat_ekskul : ''; ?>" />
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div id="result"></div>
				<button type="submit" class="btn btn-success"><?php echo isset($data) ? 'Update' : 'Simpan'; ?></button>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>