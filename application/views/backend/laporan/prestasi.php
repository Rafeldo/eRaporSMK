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
			$rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
			$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel->id);
			?>
              <div class="box-body">
			  	<input type="hidden" id="query" name="query" value="prestasi" />
				<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
				<input type="hidden" name="rombel_id" value="<?php echo $rombel->id; ?>" />
                <div class="form-group">
                  <label for="siswa_id" class="col-sm-2 control-label">Nama Siswa</label>
				  <div class="col-sm-5">
                    <select name="siswa_id" class="select2 form-control" id="siswa" required>
						<option value="">== Pilih Nama Siswa ==</option>
						<?php foreach($data_siswa as $siswa){ ?>
						<option value="<?php echo $siswa->id; ?>"><?php echo $siswa->nama; ?></option>
						<?php } ?>
					</select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div id="result"></div>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>