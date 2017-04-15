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
			$tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
			?>
              <div class="box-body">
			  	<div class="form-group">
                  <label for="ajaran_id" class="col-sm-2 control-label">Tahun Ajaran</label>
				  <div class="col-sm-5">
					<input type="hidden" name="query" id="query" value="sikap" />
					<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
                    <input type="text" class="form-control" value="<?php echo $tahun_ajaran; ?>" readonly />
                  </div>
                </div>
				<div class="form-group">
                  <label for="kelas" class="col-sm-2 control-label">Kelas</label>
				  <div class="col-sm-5">
                    <select name="kelas" class="select2 form-control" id="kelas">
						<option value="">== Pilih Kelas ==</option>
						<?php foreach($rombels as $rombel){?>
						<option value="<?php echo $rombel->tingkat; ?>">Kelas <?php echo $rombel->tingkat; ?></option>
						<?php } ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rombel_id" class="col-sm-2 control-label">Rombongan Belajar</label>
				  <div class="col-sm-5">
                    <select name="rombel_id" class="select2 form-control" id="rombel" required>
						<option value="">== Pilih Rombongan Belajar ==</option>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="id_mapel" class="col-sm-2 control-label">Mata Pelajaran</label>
				  <div class="col-sm-5">
                    <select name="id_mapel" class="select2 form-control" id="mapel">
						<option value="">== Pilih Mata Pelajaran ==</option>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="siswa" class="col-sm-2 control-label">Nama Siswa</label>
				  <div class="col-sm-5">
                    <select name="siswa_id" class="select2 form-control" id="siswa" required>
						<option value="">== Pilih Nama Siswa ==</option>
					</select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div style="margin-top:20px;"></div>
				<div class="col-sm-2"></div>
				<a class="btn btn-success btn-block btn-lg add" href="javascript:void(0);" style="display:none;">Tambah Data</a>
				<div id="result" style="margin-top:20px;"></div>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>