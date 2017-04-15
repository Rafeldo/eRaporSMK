<?php
$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
$rombel = Datarombel::find($rombel_id);
if(isset($query) && $query == 'wali'){
?>
<div class="row">
<div class="col-md-12">
<div class="box box-info">
    <div class="box-body">
<?php } ?>
<div style="clear:both;"></div>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="60%">Nama Siswa</th>
				<th width="10%" class="text-center">Lihat Nilai</th>
				<th width="10%" class="text-center">Lihat Deskripsi</th>
				<th width="10%" class="text-center">Cetak Rapor (PDF)</th>
				<!--th width="10%" class="text-center">Cetak Rapor (WORD)</th-->
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
					<a href="<?php echo site_url('admin/laporan/review_nilai/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-dropbox tooltip-left" title="Lihat nilai <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i></a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/laporan/review_desc/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-google tooltip-left" title="Lihat deskripsi <?php echo $siswa->nama; ?>">
						<i class="fa fa-search"></i>
					</a>
				</td>
				<td class="text-center">
					<a href="<?php echo site_url('admin/cetak/rapor_pdf/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" target="_blank" class="btn btn-social-icon btn-twitter tooltip-left" title="Cetak rapor <?php echo $siswa->nama; ?>">
					<i class="fa fa-fw fa-file-pdf-o"></i></a>
				</td>
				<!--td class="text-center">
					<a href="<?php echo site_url('admin/cetak/rapor_word/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$rombel_id.'/'.$siswa->id); ?>" class="btn btn-social-icon btn-flickr tooltip-left" title="Cetak rapor <?php echo $siswa->nama; ?>">
					<i class="fa fa-fw  fa-file-word-o"></i></a>
				</td-->
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
<?php if(isset($query) && $query == 'waka'){?>
</div>
</div>
</div>
</div>
<?php } ?>
<script>
$('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 2}
  })
</script>