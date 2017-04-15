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
			</div>
			<div class="box-footer">
				<?php 
				$this->load->view('backend/cetak/rapor_sikap');
				$this->load->view('backend/cetak/rapor_nilai'); 
				$this->load->view('backend/cetak/rapor_prakerin');
				$this->load->view('backend/cetak/rapor_ekskul');
				$this->load->view('backend/cetak/rapor_prestasi');
				$this->load->view('backend/cetak/rapor_absen');
				?>
			</div>
		</div>
	</div>
</div>