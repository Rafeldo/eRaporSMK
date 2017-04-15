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
			if(isset($data)){
				$kurikulum_id = $data->kurikulum_id;
				$id_mapel = $data->id_mapel;
				$kelas_x = $data->kelas_x;
				$kelas_xi = $data->kelas_xi;
				$kelas_xii = $data->kelas_xii;
				$kelas_xiii = $data->kelas_xiii;
				$user_id = $data->user_id;
				$nama_mapel = Datamapel::find_by_id_mapel($id_mapel);
				$nama_mapel = isset($nama_mapel->nama_mapel) ? $nama_mapel->nama_mapel : '';
			}
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open($form_action,$attributes);
			$data_kompetensi = Keahlian::all();
			?>
			<input type="hidden" name="user_id" class="form-control" value="<?php echo isset($data) ? $user_id : $user->id; ?>" />
            <input type="hidden" name="query" class="form-control" value="matpel_komp" />
              <div class="box-body">
			  	<div class="form-group">
                  <label for="jurusan" class="col-sm-2 control-label">Kompetensi Keahlian</label>
				  <div class="col-sm-6">
                    <select name="kur" class="select2 form-control" required>
						<option value="">== Pilih Kompentensi Keahlian ==</option>
						<?php foreach($data_kompetensi as $kompetensi){?>
						<option value="<?php echo $kompetensi->kurikulum_id; ?>#<?php echo get_kurikulum($kompetensi->kurikulum_id,'id'); ?>"<?php echo isset($data) && $kurikulum_id == $kompetensi->kurikulum_id ? ' selected="selected"' : ''; ?>><?php echo get_kurikulum($kompetensi->kurikulum_id); ?></option>
						<?php } ?>
					</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="kelas" class="col-sm-2 control-label">Nama Mata Pelajaran</label>
				  <div class="col-sm-6">
                    <input name="nama_mapel" class="form-control" value="<?php echo isset($data) ? $nama_mapel : ''; ?>" required />
                  </div>
                </div>
                <div class="form-group">
					<label for="rombel" class="col-sm-2 control-label">Kelas</label>
					<div class="col-sm-6">
						<input type="checkbox" class="icheck" name="kelas_x" value="1"<?php echo isset($data) && $kelas_x == 1 ? 'checked="checked"' : ''; ?> /> Kelas X<br style="margin-bottom:5px;" />
						<input type="checkbox" class="icheck" name="kelas_xi" value="1"<?php echo isset($data) && $kelas_xi == 1 ? 'checked="checked"' : ''; ?> /> Kelas XI<br style="margin-bottom:5px;" />
						<input type="checkbox" class="icheck" name="kelas_xii" value="1"<?php echo isset($data) && $kelas_xii == 1 ? 'checked="checked"' : ''; ?> /> Kelas XII<br style="margin-bottom:5px;" />
						<input type="checkbox" class="icheck" name="kelas_xiii" value="1"<?php echo isset($data) && $kelas_xiii == 1 ? 'checked="checked"' : ''; ?> /> Kelas XIII
					</div>
                </div>
              </div>
              <!-- /.box-body -->
			<div class="box-footer">
				<div id="result_alt"></div>
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
            <?php echo form_close();  ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>