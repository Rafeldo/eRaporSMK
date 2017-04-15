<div class="col-sm-12" id="form">
	<div class="form-group">
		<label for="mitra_prakrein" class="col-sm-2 control-label">Jenis Prestasi</label>
		<div class="input-group col-sm-6">
			<input type="text" name="jenis_prestasi" id="jenis_prestasi" class="form-control" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lokasi_prakerin" class="col-sm-2 control-label">Keterangan Prestasi</label>
		<div class="input-group col-sm-6">
			<input type="text" name="keterangan_prestasi" id="keterangan_prestasi" class="form-control" required />			
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
		$prestasi = Prestasi::find_all_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa_id);
		?>
			<table class="table table-bordered table-hover" style="margin-bottom:20px;">
				<thead>
					<th width="2%" style="vertical-align:middle;" class="text-center">No</th>
					<th width="30%" style="vertical-align:middle;">Jenis Prestasi</th>
					<th width="53%" style="vertical-align:middle;">Keterangan Prestasi</th>
					<th width="15%" style="vertical-align:middle;" class="text-center">Aksi</th>
				</thead>
				<tbody>
					<?php
					if($prestasi){
						$i=1;
						foreach($prestasi as $pres){
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td><?php echo $pres->jenis_prestasi; ?></td>
						<td><?php echo $pres->keterangan_prestasi; ?></td>
						<td><div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
								 <li><a href="<?php echo site_url('admin/laporan/edit_prestasi/'.$pres->id); ?>" class="toggle-modal"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="<?php echo site_url('admin/laporan/delete_prestasi/'.$pres->id); ?>" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div></td>
					</tr>
					<?php
						$i++;
						}
					
					} else { ?>
					<tr>
						<td colspan="4" class="text-center">Belum ada data untuk ditampilkan</td>
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