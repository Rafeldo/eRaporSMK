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
			echo form_open($form_action,$attributes);  ?>
              <div class="box-body">
			  <div class="col-sm-8">
                <div class="form-group">
                  <label for="ajaran_id" class="col-sm-3 control-label">Tahun Ajaran</label>
				  <div class="col-sm-9">
				  	<input type="hidden" name="kompetensi_id" value="2" />
					<input type="hidden" id="queri" value="kd_penilaian" />
                    <select name="ajaran_id" class="select2 form-control" id="ajaran_id">
						<option value="">== Pilih Tahun Ajaran ==</option>
						<?php foreach($ajarans as $ajaran){?>
						<option value="<?php echo $ajaran->id; ?>"><?php echo $ajaran->tahun; ?> (SMT <?php echo $ajaran->smt; ?>)</option>
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
                    <select name="rombel_id" class="select2 form-control" id="rombel_id_mapel">
						<option value="">== Pilih Rombongan Belajar ==</option>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_mapel_penilaian" class="col-sm-3 control-label">Mata Pelajaran</label>
				  <div class="col-sm-9">
                    <select name="id_mapel" class="select2 form-control" id="id_mapel_penilaian">
						<option value="">== Pilih Mata Pelajaran ==</option>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="penilaian_penugasan" class="col-sm-3 control-label">Penilaian</label>
				  <div class="col-sm-9">
                    <select name="penilaian_penugasan" class="select2 form-control" id="penilaian_penugasan">
						<option value="">== Pilih Penilaian ==</option>
					</select>
                  </div>
                </div>
				</div>
				<div class="col-sm-4">
					<div id="rumus"></div>
				</div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer table-responsive no-padding">
				<div id="result"></div>
				<button type="submit" class="btn btn-success simpan" style="display:none;">Simpan</button>
				<a href="javascript:void(0)" class="btn btn-success" id="rerata" style="display:none;">Hitung Rerata</a>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>