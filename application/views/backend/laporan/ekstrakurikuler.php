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
			$all_ekskul = Ekskul::find_all_by_ajaran_id($ajaran->id);
			?>
			<div class="box-body">
				<input type="hidden" name="query" id="query" value="ekstrakurikuler" />
				<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
				<input type="hidden" name="rombel_id" value="<?php echo $rombel->id; ?>" />
				<div class="form-group">
                  <label for="rombel" class="col-sm-2 control-label">Ekstrakurikuler</label>
				  <div class="col-sm-5">
                    <select name="ekskul_id" class="select2 form-control" id="ekskul">
						<option value="">== Pilih Nama Ekstrakurikuler ==</option>
						<?php foreach($all_ekskul as $ekskul){ ?>
						<option value="<?php echo $ekskul->id; ?>"><?php echo $ekskul->nama_ekskul; ?></option>
						<?php } ?>
					</select>
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