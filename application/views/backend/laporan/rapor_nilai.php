<?php
$siswa = Datasiswa::find($siswa_id);
$ajaran = Ajaran::find($ajaran_id);
?>
<style>
.strong {font-weight:bold;}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
			<h3><?php echo $page_title; ?> Untuk Siswa <strong><?php echo $siswa->nama; ?></strong> Tahun Pelajaran <?php echo $ajaran->tahun; ?> Semester <?php echo $ajaran->smt; ?></h3>
			</div><!--box-body-->
			<div class="box-footer">
				<?php 
				$this->load->view('backend/cetak/rapor_nilai_no_desc'); 
				?>
			</div><!--box-footer mana-->
		</div><!--box-->
	</div><!--col-->
</div><!--row-->