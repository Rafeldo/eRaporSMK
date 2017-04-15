<?php $siswa = Datasiswa::find($siswa_id); ?>
<div style="clear:both;"></div>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="35%" class="text-center">Lihat Nilai</th>
				<th width="35%" class="text-center">Lihat Deskripsi</th>
				<th width="35%" class="text-center">Cetak Rapor</th>
			</tr>
		</thead>
		<tbody>
				<tr>
				<td class="text-center">
					<a href="<?php echo site_url('admin/laporan/review_nilai/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-dropbox tooltip-left" title="Lihat nilai <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i></a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/laporan/review_desc/'.nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-google tooltip-left" title="Lihat deskripsi <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i>
					</a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/cetak/rapor/'.nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-facebook tooltip-left" title="Cetak rapor <?php echo $siswa->nama; ?>">
					<i class="fa fa-print"></i></a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
$('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 2}
  })
</script>