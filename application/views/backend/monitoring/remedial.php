<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<?php 
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open('',$attributes);
			$ajaran = get_ta();
			$tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
			$data_kompetensi = Keahlian::all();
			?>
			<div class="box-body">
				<div class="form-group">
					<label for="ajaran_id" class="col-sm-2 control-label">Tahun Ajaran</label>
					<div class="col-sm-5">
						<input type="hidden" name="query" id="query" value="analisis_remedial" />
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
					<label for="rombel" class="col-sm-2 control-label">Rombongan Belajar</label>
					<div class="col-sm-5">
						<select name="rombel_id" class="select2 form-control" id="rombel" required>
							<option value="">== Pilih Rombongan Belajar ==</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mapel" class="col-sm-2 control-label">Mata Pelajaran</label>
					<div class="col-sm-5">
						<select name="id_mapel" class="select2 form-control" id="mapel">
							<option value="">== Pilih Mata Pelajaran ==</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mapel" class="col-sm-2 control-label">Kompetensi Penilaian</label>
					<div class="col-sm-5">
						<select name="kompetensi_id" class="select2 form-control" id="kompetensi">
							<option value="">== Pilih Kompetensi Penilaian ==</option>
						</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div id="result"></div>
			</div>
			<?php echo form_close();  ?>
		</div><!-- /.box -->
	</div>
</div>