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
			$data_kompetensi = Keahlian::all();
			?>
              <div class="box-body">
			  	<div class="col-sm-8">
                <div class="form-group">
                  <label for="ajaran_id" class="col-sm-3 control-label">Tahun Ajaran</label>
				  <div class="col-sm-9">
				  	<input type="hidden" name="query" id="query" value="nilai" />
                    <input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
                    <input type="text" class="form-control" value="<?php echo $tahun_ajaran; ?>" readonly />
                  </div>
                </div>
				<div class="form-group">
                  <label for="jurusan" class="col-sm-3 control-label">Kompetensi Keahlian</label>
				  <div class="col-sm-9">
                    <select name="jurusan" class="select2 form-control" id="jurusan" required>
						<option value="">== Pilih Kompentensi Keahlian ==</option>
						<?php foreach($data_kompetensi as $kompetensi){?>
						<option value="<?php echo $kompetensi->kurikulum_id; ?>"><?php echo get_kurikulum($kompetensi->kurikulum_id); ?></option>
						<?php } ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rombel_id_perencanaan" class="col-sm-3 control-label">Kelas</label>
				  <div class="col-sm-9">
                    <select name="kelas" class="select2 form-control" id="kelas">
						<option value="">== Pilih Kelas ==</option>
						<?php foreach($rombels as $rombel){?>
						<option value="<?php echo $rombel->tingkat; ?>">Kelas <?php echo $rombel->tingkat; ?></option>
						<?php } ?>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="rombel_id" class="col-sm-3 control-label">Rombongan Belajar</label>
				  <div class="col-sm-9">
                    <select name="rombel_id" class="select2 form-control" id="rombel">
						<option value="">== Pilih Rombongan Belajar ==</option>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_mapel_penilaian" class="col-sm-3 control-label">Mata Pelajaran</label>
				  <div class="col-sm-9">
                    <select name="id_mapel" class="select2 form-control" id="mapel">
						<option value="">== Pilih Mata Pelajaran ==</option>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="siswa_id" class="col-sm-3 control-label">Siswa</label>
				  <div class="col-sm-9">
                    <select name="siswa_id" class="select2 form-control" id="siswa">
						<option value="">== Pilih Nama Siswa ==</option>
					</select>
                  </div>
                </div>
				</div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer table-responsive no-padding">
				<div id="result"></div>
				<button type="submit" class="btn btn-success simpan" style="display:none;">Simpan</button>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>