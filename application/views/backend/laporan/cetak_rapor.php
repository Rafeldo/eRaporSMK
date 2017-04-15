<?php
$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
$rombel = Datarombel::find($rombel_id);
?>
<div style="margin-bottom:20px;" class="text-center">
	<a class="btn btn-app tooltip-left" title="Cetak legger <?php echo $rombel->nama; ?>" href="<?php echo site_url('admin/cetak/legger/'.$ajaran_id.'/'.$rombel_id); ?>" target="_blank">
                <i class="fa fa-save"></i><?php echo strtoupper('CETAK LEGGER kelas '.$rombel->nama); ?>
              </a>
</div>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="55%">Nama Siswa</th>
				<th width="15%" class="text-center">Lihat Nilai</th>
				<th width="15%" class="text-center">Lihat Deskripsi</th>
				<th width="15%" class="text-center">Cetak Rapor</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($data_siswa){
				foreach($data_siswa as $siswa){
			?>
			<tr>
				<td><?php echo $siswa->nama; ?></td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/laporan/lihat_nilai/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-dropbox tooltip-left" title="Lihat nilai <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i></a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/laporan/lihat_deskripsi/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-google tooltip-left" title="Lihat deskripsi <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i>
					</a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/cetak/rapor/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-facebook tooltip-left" title="Cetak rapor <?php echo $siswa->nama; ?>">
					<i class="fa fa-print"></i></a>
				</td>
			</tr>
			<?php
				}
			} else {
			?>
			<tr>
				<td colspan="4" class="text-center">Tidak ada data siswa di rombongan belajar terpilih</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<script>
$('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 2}
  })
</script>