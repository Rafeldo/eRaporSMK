<?php
$setting = Setting::first();
?>
<div class="row">
	<div class="col-md-12">
		<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
		<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
		<div class="box box-primary">
			<form role="form" method="POST" action="<?php echo site_url('admin/config/update'); ?>" enctype="multipart/form-data">
				<div class="box-body">
					<?php
					/*
					<div class="form-group col-xs-12"><h4>Predikat Capaian Prestasi</h4></div>
					<div class="col-md-7 no-padding">
					<?php foreach (range('a', 'd') as $char) { ?>
						<div class="row">
							<div class="form-group col-md-12">
								<label class="col-sm-3">Maksimal Nilai <?php echo strtoupper($char); ?></label>
								<div class="col-xs-3 input-group" style="float:left;">
									<span class="input-group-btn"><a class="minus_max btn btn-danger btn-flat"><i class="fa fa-minus-circle"></i></a></span>
									<input name="<?php echo $char.'_max'; ?>" type="text" id="<?php echo $char.'_max'; ?>" class="<?php echo $char.'_max'; ?> form-control" value="<?php echo ${$char . "_max"} ?>" readonly>
									<span class="input-group-btn"><a class="add_max btn btn-success btn-flat"><i class="fa fa-plus-circle"></i></a></span>
								</div>
								<label class="col-sm-3 text-right">Minimal Nilai <?php echo strtoupper($char); ?></label>
								<div class="col-xs-3 input-group" style="float:left;">
									<span class="input-group-btn"><a class="minus_min btn btn-danger btn-flat"><i class="fa fa-minus-circle"></i></a></span>
									<input name="<?php echo $char.'_min'; ?>" type="text" id="<?php echo $char.'_min'; ?>" class="<?php echo $char.'_min'; ?> form-control" value="<?php echo ${$char . "_min"} ?>" readonly>
									<span class="input-group-btn"><a class="add_min btn btn-success btn-flat"><i class="fa fa-plus-circle"></i></a></span>
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
					*/
					?>
					<div class="col-xs-12 no-padding">
						<div class="form-group col-md-6">
							<label>Periode Aktif</label>
							<select class="form-control" name="periode" required>
								<?php
								$tahun = array(0,0,1,1,2,2);
								$i=0;
								foreach($tahun as $t){
									if($i%2){
										$periode = 'Genap';
									} else {
										$periode = 'Ganjil';
									}
									$t1 = (date('Y')+$t)-2;
									$t2 = (date('Y')+$t)-1;
									$t3 = 'Semester '.$periode;
									$value = $t1.'/'.$t2.' | '.$t3;
									?>
									<option value="<?php echo (date('Y')+$t)-2; ?>/<?php echo (date('Y')+$t)-1; ?> | Semester <?php echo $periode; ?>"<?php echo ($settings->periode == $value) ? ' selected="selected"' : '';?>><?php echo (date('Y')+$t)-2; ?>/<?php echo (date('Y')+$t)-1; ?> Semester <?php echo $periode; ?></option>
								<?php 
									$i++;
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Tampilkan Menu Sinkronisasi</label>
							<select class="form-control" name="sinkronisasi" required>
								<option value="0"<?php echo ($setting->sinkronisasi == 0) ? ' selected="selected"' : ''; ?>>Tidak</option>
								<option value="1"<?php echo ($setting->sinkronisasi == 1) ? ' selected="selected"' : ''; ?>>Ya</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Tampilkan Rumus di Laman Penilaian</label>
							<select class="form-control" name="rumus" required>
								<option value="0"<?php echo ($setting->rumus == 0) ? ' selected="selected"' : ''; ?>>Tidak</option>
								<option value="1"<?php echo ($setting->rumus == 1) ? ' selected="selected"' : ''; ?>>Ya</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Tampilkan Menu Import (Siswa &amp; Guru)</label>
							<select class="form-control" name="import" required>
								<option value="0"<?php echo ($setting->import == 0) ? ' selected="selected"' : ''; ?>>Tidak</option>
								<option value="1"<?php echo ($setting->import == 1) ? ' selected="selected"' : ''; ?>>Ya</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Otomatis Tampilkan Deskripsi Per Mata Pelajaran</label>
							<select class="form-control" name="desc" required>
								<option value="0"<?php echo ($setting->desc == 0) ? ' selected="selected"' : ''; ?>>Tidak</option>
								<option value="1"<?php echo ($setting->desc == 1) ? ' selected="selected"' : ''; ?>>Ya</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Zona Waktu</label>
							<select class="form-control" name="zona" required>
								<option value="1"<?php echo ($setting->zona == 1) ? ' selected="selected"' : ''; ?>>Waktu Indonesia Barat (WIB)</option>
								<option value="2"<?php echo ($setting->zona == 2) ? ' selected="selected"' : ''; ?>>Waktu Indonesia Tengah (WITA)</option>
								<option value="3"<?php echo ($setting->zona == 3) ? ' selected="selected"' : ''; ?>>Waktu Indonesia Timur (WIT)</option>
							</select>
						</div>
					</div>
				</div>
				<div class="box-footer clearfix">
					<button type="submit" class="btn btn-primary pull-right">Simpan</button>
					<div class="col-xs-12" style="margin-top:20px;">
						<label>Log Akses</label>
						<?php
						$hits = '';
						$filename = "./log.txt";
						if (file_exists($filename)) {
							$hits = file_get_contents($filename);
						} else {
							$hits = file_put_contents($filename, '');
						}
						?>
						<textarea class="form-control" rows="3"><?php echo $hits; ?></textarea>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(function () {
	function nextChar(c) {
		return String.fromCharCode(c.charCodeAt(0) - 1);
	}
	function ThisChar(c) {
		return String.fromCharCode(c.charCodeAt(0));
	}
    $('.add_max').on('click',function(){
        var $qty=$(this).closest('div.input-group').find('.form-control');
        var currentVal = parseInt($qty.val());
		var className = $($qty).attr('id');
		var className_next = className.replace(className.substr(1),'_min');
		if (!isNaN(currentVal) && currentVal >= 100) {
			swal(
				'Oops...',
				'Nilai maksimal tidak boleh di atas 100',
				'error'
			);
        } else{
			if(className == 'a_min'){
				$qty.val(currentVal + 1);
				return false;
			}
			if(className != 'a_max'){
				var minimal = $('#'+className).val();
				var minimal_plus = (parseInt(minimal) + 1);
				var maksimal = $('#'+nextChar(className.substr(0,1))+'_min').val();
				if(minimal_plus >= maksimal){
					swal(
						'Oops...',
						'Maksimal Nilai '+ ThisChar(className.substr(0,1)).toUpperCase() +' tidak boleh sama atau lebih besar dari Minimal Nilai '+ nextChar(className.substr(0,1)).toUpperCase(),
						'error'
					);
					return false;
				}
			}
			$qty.val(currentVal + 1);
		}
    });
    $('.minus_max').on('click',function(){
        var $qty=$(this).closest('div.input-group').find('.form-control');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 0) {
            $qty.val(currentVal - 1);
        }
    });
	$('.add_min').on('click',function(){
        var $qty=$(this).closest('div.input-group').find('.form-control');
        var currentVal = parseInt($qty.val());
		var className = $($qty).attr('id');
		var classNameBefore = className.replace(className.substr(1),'_max');
		if (!isNaN(currentVal) && currentVal >= 100) {
			swal(
				'Oops...',
				'Nilai maksimal tidak boleh di atas 100',
				'error'
			);
        } else{
			if(className == 'a_min'){
				$qty.val(currentVal + 1);
				return false;
			}
			if(className == 'd_min'){
				swal(
					'Oops...',
					'Minimal Nilai D tidak boleh lebih besar dari 0',
					'error'
				);
				return false;
			}
			if(className != 'a_max'){
				var minimal = $('#'+className).val();
				var minimal_plus = (parseInt(minimal) + 1);
				var maksimal = $('#'+ThisChar(classNameBefore.substr(0,1))+'_max').val();
				if(minimal_plus >= maksimal){
					swal(
						'Oops...',
						'Minimal Nilai '+ ThisChar(className.substr(0,1)).toUpperCase() +' tidak boleh sama atau lebih besar dari Maksimal Nilai '+ ThisChar(className.substr(0,1)).toUpperCase(),
						'error'
					);
					return false;
				}
			}
			$qty.val(currentVal + 1);
		}
    });
    $('.minus_min').on('click',function(){
        var $qty=$(this).closest('div.input-group').find('.form-control');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 0) {
            $qty.val(currentVal - 1);
        }
    });
});
</script>