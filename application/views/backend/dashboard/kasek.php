<?php
$sekolah = Datasekolah::first();
$keahlian = Keahlian::find_all_by_sekolah_id($sekolah->id);
?>
<h4 class="page-header">Profil Singkat Sekolah</h4>
<div class="row">
	<div class="col-lg-6 col-xs-6">
		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>Nama Sekolah</th>
				<th width="10px;">:</th>
				<td><?php echo $sekolah->nama; ?></td>
			</tr>
			<tr>
				<th>NPSN</th>
				<th width="10px;">:</th>
				<td><?php echo $sekolah->npsn; ?></td>
			</tr>
			<tr>
				<th>Kompetensi Keahlian</th>
				<th width="10px;">:</th>
				<td>
					<ol style="margin-left:-25px;">
				<?php 
				if($keahlian){
					foreach($keahlian as $ahli){
						$jurusan = Datakurikulum::find_by_kurikulum_id($ahli->kurikulum_id);
						if($jurusan){
							echo '<li>'.$jurusan->nama_kurikulum.'</li>';
						}
					}
				} ?>
					</ol>
				</td>
			</tr>
		</table>
	</div>
</div>