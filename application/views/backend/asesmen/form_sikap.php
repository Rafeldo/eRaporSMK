<?php echo link_tag('assets/plugins/datepicker/datepicker3.css', 'stylesheet', 'text/css'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<div class="col-sm-12" id="form" style="display:none;">
	<div class="form-group">
		<label for="tanggal_sikap" class="col-sm-2 control-label">Tanggal</label>
		<div class="input-group col-sm-2">
			<input type="text" name="tanggal_sikap" id="tanggal_sikap" class="form-control datepicker" data-date-format="dd-mm-yyyy" required />
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
	</div>
	<div style="margin-left:-20px;">
		<div class="form-group">
			<label for="butir_sikap" class="col-sm-2 control-label">Butir Sikap</label>
			<div class="col-sm-3">
				<select name="butir_sikap" class="form-control" id="butir_sikap" required>
					<option value="">== Pilih Butir Sikap ==</option>
					<?php foreach($data_sikap as $datasikap){?>
					<option value="<?php echo $datasikap->id; ?>"><?php echo $datasikap->butir_sikap; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-3">
				<select name="opsi_sikap" class="form-control" id="opsi_sikap" required>
					<option value="1">Positif</option>
					<option value="2">Negatif</option>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group" style="margin-top:20px;">
		<label for="uraian_sikap" class="col-sm-2 control-label">Catatan Perilaku</label>
		<div class="input-group col-sm-8">
			<input type="text" class="form-control" name="uraian_sikap" id="uraian_sikap" required />
			<input type="hidden" class="form-control" name="mapel_id" id="mapel_id" value="<?php echo $mapel_id; ?>" required />
		</div>
	</div>
</div>
<div class="row" style="margin-bottom:10px;">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
		<button type="submit" class="btn btn-success simpan" style="display:none;">Simpan</button>
		<a class="btn btn-danger cancel" href="javascript:void(0);" style="display:none;">Batal</a>
	</div>
</div>
<div style="clear:both"></div>
	<table class="table table-bordered table-hover" style="margin-bottom:20px;">
		<thead>
			<th>No</th>
			<th>Tanggal</th>
			<th>Butir Sikap</th>
			<th>Predikat</th>
			<th>Catatan Perilaku</th>
			<th class="text-center">Tindakan</th>
		</thead>
		<tbody>
		<?php
		$loggeduser = $this->ion_auth->user()->row();
		if($all_sikap){
			$i=1;
			foreach($all_sikap as $sikap){
				$get_sikap = Datasikap::find_by_id($sikap->butir_sikap);
				if($sikap->opsi_sikap == 1){
					$opsi_sikap = 'Positif';
				} else {
					$opsi_sikap = 'Negatif';
				}
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo date('d/m/Y',strtotime($sikap->tanggal_sikap)); ?></td>
				<td><?php echo $get_sikap->butir_sikap; ?></td>
				<td><?php echo $opsi_sikap; ?></td>
				<td><?php echo $sikap->uraian_sikap; ?></td>
				<td>
					<div class="text-center">
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
							<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu pull-right text-left" role="menu">
								<li><a href="<?php echo site_url('admin/asesmen/edit_sikap/'.$sikap->id); ?>" class="toggle-modal"><i class="fa fa-pencil"></i>Edit</a></li>
								<?php 
								if($loggeduser->data_guru_id){
								} else {
									echo '<li><a href="'.site_url('admin/asesmen/delete_sikap/'.$sikap->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>';
								} ?>
							</ul>
						</div>
					</div>
				</td>
			</tr>
			<?php
			$i++;
			}
		} else { ?>
			<tr>
				<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
<script>
$('.datepicker').datepicker({
	autoclose: true,
	format: "dd-mm-yyyy"
});
$('.add').click(function(){
	$('#form').fadeIn();
	$('.cancel').fadeIn();
	$('.simpan').fadeIn();
	$('.add').fadeOut();
})
$('.cancel').click(function(){
	$('#form').fadeOut();
	$('.cancel').fadeOut();
	$('.simpan').fadeOut();
	$('.add').fadeIn();
})
$('a.toggle-modal').bind('click',function(e) {
	e.preventDefault();
	var url = $(this).attr('href');
	if (url.indexOf('#') == 0) {
		$('#modal_content').modal('open');
	} else {
		$.get(url, function(data) {
			$('#modal_content').modal();
			$('#modal_content').html(data);
			}).success(function(data) {
				if(data == 'activate' || data== 'deactivate'){
				$('#modal_content').modal('hide');
				var url      = window.location.href;     // Returns full URL
				window.location.replace(url);
			}
		});
	}
});
$('a.confirm').bind('click',function(e) {
	var ini = $(this).parents('tr');
	e.preventDefault();
	var url = $(this).attr('href');
	swal({
		title: "Anda Yakin?",
		text: "Tindakan ini tidak bisa dikembalikan!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Hapus!",
		showLoaderOnConfirm: true,
		preConfirm: function() {
			return new Promise(function(resolve) {
				$.get(url).done(function(data) {
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						ini.remove();
					});
				})
			})
		}
	});
});
</script>