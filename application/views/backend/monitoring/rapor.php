<?php
$siswa = Datasiswa::find($user->data_siswa_id);
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<form>
				<div class="box-body">
					<div class="form-group">
						<label for="ajaran_id" class="col-sm-2 control-label">Tahun Ajaran</label>
						<div class="col-sm-5">
							<input type="hidden" name="query" id="query" value="rapor" />
							<input type="hidden" name="rombel_id" value="<?php echo $siswa->data_rombel_id; ?>" />
							<input type="hidden" name="siswa_id" value="<?php echo $user->data_siswa_id; ?>" />
							<select name="ajaran_id" class="select2 form-control" id="rombel">
								<option value="">== Pilih Tahun Ajaran ==</option>
								<?php foreach($ajarans as $ajaran){?>
								<option value="<?php echo $ajaran->id; ?>"><?php echo $ajaran->tahun; ?> (SMT <?php echo $ajaran->smt; ?>)</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div id="result"></div>
				</div>
			</form>
		</div>
	</div>
</div>