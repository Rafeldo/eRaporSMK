<div class="col-sm-12" id="form">
	<div class="form-group">
		<label for="mitra_prakrein" class="col-sm-2 control-label">Mitra DU/DI</label>
		<div class="input-group col-sm-6">
			<input type="text" name="mitra_prakerin" id="mitra_prakerin" class="form-control" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lokasi_prakerin" class="col-sm-2 control-label">Lokasi</label>
		<div class="input-group col-sm-6">
			<input type="text" name="lokasi_prakerin" id="lokasi_prakerin" class="form-control" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lama_prakerin" class="col-sm-2 control-label">Lamanya (bulan)</label>
		<div class="input-group col-sm-6">
			<input type="text" class="form-control" name="lama_prakerin" id="lama_prakerin" required />
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan_prakerin" class="col-sm-2 control-label">Keterangan</label>
		<div class="input-group col-sm-6">
			<input type="text" class="form-control" name="keterangan_prakerin" id="keterangan_prakerin" required />
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2"></div>
		<div class="col-sm-6">
		<button type="submit" class="btn btn-success">Simpan</button>
		</div>
	</div>
</div>
		<div style="clear:both"></div>
		<div class="table-responsive no-padding">
		<?php
		$prakerins = Prakerin::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa_id);
		?>
			<table class="table table-bordered table-hover" style="margin-bottom:20px;">
				<thead>
					<th width="2%" style="vertical-align:middle;" class="text-center">No</th>
					<th width="20%" style="vertical-align:middle;">Mitra DU/DI</th>
					<th width="20%" style="vertical-align:middle;">Lokasi</th>
					<th width="5%" class="text-center">Lamanya<br />(bulan)</th>
					<th width="43%" style="vertical-align:middle;">Keterangan</th>
					<th width="15%" style="vertical-align:middle;" class="text-center">Aksi</th>
				</thead>
				<tbody>
					<?php
					if($prakerins){
						$i=1;
						foreach($prakerins as $prakerin){
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td><?php echo $prakerin->mitra_prakerin; ?></td>
						<td><?php echo $prakerin->lokasi_prakerin; ?></td>
						<td class="text-center"><?php echo $prakerin->lama_prakerin; ?></td>
						<td><?php echo $prakerin->keterangan_prakerin; ?>
						<td><div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
								 <li><a href="<?php echo site_url('admin/laporan/edit_prakerin/'.$prakerin->id); ?>" class="toggle-modal"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="<?php echo site_url('admin/laporan/delete_prakerinp/'.$prakerin->id); ?>" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div></td>
					</tr>
					<?php
						$i++;
						}
					
					} else { ?>
					<tr>
						<td colspan="6" class="text-center">Belum ada data untuk ditampilkan</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
<script>
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
		$('input:text:visible:first').focus();
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
		//closeOnConfirm: false
		showLoaderOnConfirm: true,
		preConfirm: function() {
			return new Promise(function(resolve) {
				$.get(url)
				.done(function(data) {
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						$('#datatable').dataTable().fnReloadAjax();
					});
				})
			})
		}
	});
});
</script>