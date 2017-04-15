<?php
$s = Datasiswa::find($siswa_id);
$sekolah = Datasekolah::first();
$setting = Setting::first();
$rombel = Datarombel::find($rombel_id);
$ajaran = Ajaran::find($ajaran_id);
$catatan = Catatanwali::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa_id);
$uraian_deskripsi = isset($catatan->uraian_deskripsi) ? $catatan->uraian_deskripsi : '';
?>
<br>
<div class="strong">H.&nbsp;&nbsp;Catatan Wali Kelas</div>
<table width="100%" border="1" style="margin-left:20px;">
  <tr>
    <td style="padding:10px 10px 60px 10px;"><?php echo $uraian_deskripsi; ?></td>
  </tr>
</table>
<br>
<div class="strong">I.&nbsp;&nbsp;Tanggapan Orang tua/Wali</div>
<table width="100%" border="1" style="margin-left:20px;">
  <tr>
    <td style="padding:10px 10px 60px 10px;">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<?php if($ajaran->smt == 2){ ?>
<div class="strong">Keputusan :</div>
<p>Berdasarkan hasil yang dicapai pada semester 1 dan 2, peserta didik ditetapkan</p>
<p>Naik ke kelas ................. (...........................)<br>
<p>Tinggal di kelas ................. (...........................)</p>
<?php } ?>
<table width="100%">
  <tr>
    <td style="width:30%">
		<p>Mengetahui;<br>Orang Tua/Wali</p><br>
<br>
<br>
<br>
<br>
<br>
		<p>...................................................................</p>
	</td>
	<td style="width:40%"></td>
    <td style="width:30%"><p><?php echo $sekolah->kabupaten; ?>, .................................,20....<br>Wali Kelas</p><br>
<br>
<br>
<br>
<br>
<br>
<p>
<?php
$wali_kelas = Dataguru::find($rombel->guru_id);
echo '<u>'.$wali_kelas->nama.'</u>';
?>
<br>
NIP. <?php echo $wali_kelas->nip; ?></p>
</td>
  </tr>
</table>
<table width="100%" style="margin-top:20px;">
  <tr>
    <td style="width:50%">&nbsp;</td>
    <td style="width:50%; padding:0px;"><p>Mengetahui,<br>Kepala Sekolah</p>
	<br>
<br>
<br>
<br>
<br>
<br>
<p><u><?php echo $setting->kepsek; ?></u><br>
NIP. <?php echo $setting->nip_kepsek; ?>
</p>
</td>
  </tr>
</table>