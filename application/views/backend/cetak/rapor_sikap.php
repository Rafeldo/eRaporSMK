<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$atribute = ' class="table table-bordered"';
		$atribute_2 = ' class="table table-bordered"';
	} else {
		$atribute = ' border="0" width="100%"';
		$atribute_2 = ' width="100%" border="1" style="margin-left:20px;"';
	}
}
$s = Datasiswa::find($siswa_id);
$sekolah = Datasekolah::first();
$setting = Setting::first();
$rombel = Datarombel::find($rombel_id);
$ajaran = Ajaran::find($ajaran_id);
?>
<table<?php echo $atribute; ?>>
  <tr>
    <td style="width: 20%;padding-top:5px; padding-bottom:5px;">Nama Sekolah</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 35%"><?php echo $sekolah->nama; ?></td>
	<td style="width: 20%;">Kelas</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 25%"><?php echo $rombel->nama; ?></td>
  </tr>
  <tr>
    <td style="width: 20%;padding-top:5px; padding-bottom:5px;">Alamat</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 35%"><?php echo $sekolah->alamat; ?></td>
	<td style="width: 20%;">Semester</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 25%"><?php echo ($ajaran->smt == 1) ? '1 (Satu)' : '2 (Dua)'; ?></td>
  </tr>
  <tr>
    <td style="width: 20%;padding-top:5px; padding-bottom:5px;">Nama Siswa</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 35%"><?php echo $s->nama; ?></td>
	<td style="width: 20%;">Tahun Pelajaran</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 25%"><?php echo $ajaran->tahun; ?></td>
  </tr>
  <tr>
    <td style="width: 20%;padding-top:5px; padding-bottom:5px;">Nomor Induk/NISN</td>
    <td style="width: 1%;" class="text-center">:</td>
    <td style="width: 35%"><?php echo $s->no_induk.' / '.$s->nisn; ?></td>
	<td style="width: 20%;">&nbsp;</td>
    <td style="width: 1%;" class="text-center">&nbsp;</td>
    <td style="width: 25%">&nbsp;</td>
  </tr>
</table><br>
<h4>CAPAIAN HASIL BELAJAR</h4>
<div class="strong">A.&nbsp;&nbsp;Sikap</div>
<?php
$deskripsi_sikap = Deskripsisikap::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$s->id);
if($deskripsi_sikap){
	$data_deskripsi = $deskripsi_sikap->uraian_deskripsi;
} else {
	$data_deskripsi = '';
}
?>
<table <?php echo $atribute_2; ?>>
  <tr>
    <td style="padding:10px 10px 40px 10px;">Deskripsi:<br /><br /><?php echo $data_deskripsi; ?>
	</td>
  </tr>
</table>