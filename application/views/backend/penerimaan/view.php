<div class="row">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group col-xs-12">
                <label>Nama</label>
                <p class="well well-sm" style="margin-top: 10px;">
                   <?php echo (isset($rombel)) ? $rombel->nama : ''; ?>
                </p>
            </div>
			<div class="form-group col-xs-12">
                <label>Wali Kelas</label>
                <p class="well well-sm" style="margin-top: 10px;">
                   <?php 
				   if($rombel->guru_id == 0){
				   	$guru = 'Wali Kelas Belum Dipilih';
					} else {
				   	$get_guru = Dataguru::find($rombel->guru_id); 
					$guru = $get_guru->nama;
				   }
				   echo $guru; ?>
                </p>
            </div>
			<div class="form-group col-xs-12">
                <label>Tingkat Pendidikan</label>
                <p class="well well-sm" style="margin-top: 10px;">
                   <?php echo (isset($rombel)) ? $rombel->tingkat : ''; ?>
                </p>
            </div>
			<div class="form-group col-xs-12">
                <label>Jurusan</label>
                <p class="well well-sm" style="margin-top: 10px;">
                   <?php //echo (isset($rombel)) ? $rombel->jurusan : ''; ?>
				   sedang dalam perbaikan
                </p>
            </div>
        </div>
     </div>
</div>