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
			$tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
			//ata_rombel = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
			$data_rombel = Datarombel::all();
			?>
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
				  	<input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
				  	<input type="hidden" name="query" id="query" value="dataspp" />
                  </div>
                </div>
				<div class="form-group">
                  <label for="butir_sikap" class="col-sm-2 control-label">Rombel / Kelas</label>
				  <div class="col-sm-5">
                   <select name="rombel_id" class="select2 form-control" id="rombel" required>
						<option value="">== Pilih Rombongan Belajar ==</option>
					
						<?php foreach($data_rombel as $r){?>
						<option value="<?php echo $r->id; ?>"<?php echo (isset($data)) ? ($data->rombel_id == $r->id ? ' selected="selected"' : '') : ''; ?>><?php echo $r->nama; ?></option>						
						<?php } ?>
					
					</select>
				</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="nilai_dataspp" class="col-sm-2 control-label">Biaya SPP</label>
				  <div class="col-sm-5">
                    <input type="text" name="nilai_dataspp" class="form-control" value="<?php echo (isset($data)) ? $data->nilai : ''; ?>" />
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div id="result_alt"></div>
				<button type="submit" class="btn btn-success simpan">Simpan</button>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>