<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_desc'){
		$border = '';
		$class = 'table table-bordered';
	} else {
		$border = 'border="1"';
		$class = 'table';
	}
}
$s = Datasiswa::find($siswa_id);
$sekolah = Datasekolah::first();
$setting = Setting::first();
$rombel = Datarombel::find($rombel_id);
$ajaran = Ajaran::find($ajaran_id);
$kelompok_a = preg_quote('A0', '~'); // don't forget to quote input string!
$kelompok_b = preg_quote('B0', '~'); // don't forget to quote input string!
$kelompok_c = preg_quote('C', '~'); // don't forget to quote input string!
$all_mapel = Kurikulum::find_all_by_ajaran_id_and_rombel_id($ajaran_id,$rombel_id);
foreach($all_mapel as $allmapel){
	$get_id_mapel[] = $allmapel->id_mapel;
}
if($all_mapel){
$mapel_a = preg_grep('~' . $kelompok_a . '~', $get_id_mapel);
$mapel_b = preg_grep('~' . $kelompok_b . '~', $get_id_mapel);
$mapel_c = preg_grep('~' . $kelompok_c . '~', $get_id_mapel);
$mapel_a = filter_agama_mapel($ajaran_id,$rombel_id,$get_id_mapel, $mapel_a, $s->agama);
$mapel_group = $mapel_a + $mapel_b + $mapel_c;
$mapel_tambahan = array_diff($get_id_mapel, $mapel_group);
if($mapel_tambahan){
	$mapel_b = $mapel_b + $mapel_tambahan;
}?>
<table <?php echo $border; ?> class="<?php echo $class; ?>">
	<thead>
  <tr>
    <th style="vertical-align:middle;width: 2px;" align="center" rowspan="2">No</th>
    <th style="vertical-align:middle;width: 400px;" rowspan="2">Mata Pelajaran</th>
    <th align="center" class="text-center">Pengetahuan</th>
	<th align="center" class="text-center">Keterampilan</th>
  </tr>
  <tr>
	<th align="center" class="text-center">Deskripsi</th>
	<th align="center" class="text-center">Deskripsi</th>
  </tr>
	</thead>
	<tbody>
<?php
if($kurikulum == 2013){
	$i=1;
	if($mapel_a){
	?>
		<tr>
			<td colspan="10">Kelompok A</td>
		</tr>
<?php
	foreach($mapel_a as $mapela){
		$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapela,$s->id);
		$deskripsi_pengetahuan = '';
		$deskripsi_keterampilan = '';
		if($deskripsi){
			$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
			$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
		}
	
	?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapela); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok A (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
	$i=1;
	if($mapel_b){
	?>
		<tr>
			<td colspan="10">Kelompok B</td>
		</tr>
<?php
	foreach($mapel_b as $mapelb){
		$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapelb,$s->id);
		$deskripsi_pengetahuan = '';
		$deskripsi_keterampilan = '';
		if($deskripsi){
			$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
			$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
		}
?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapelb); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok B (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
	$i=1;
	if($mapel_c){
	?>
		<tr>
			<td colspan="10">Kelompok C</td>
		</tr>
	<?php
	foreach($mapel_c as $mapelc){
		$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapelc,$s->id);
		$deskripsi_pengetahuan = '';
		$deskripsi_keterampilan = '';
		if($deskripsi){
			$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
			$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
		}
?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapelc); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok C (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php
} elseif($all_mapel){
	foreach($all_mapel as $allmapel){
		$get_id_mapel[] = $allmapel->id_mapel;
	}
	foreach($get_id_mapel as $abc){
		$get_id_2006[$abc] = substr($abc,0,2);
	}
	$normatif_1 = preg_quote(10, '~'); // don't forget to quote input string!
	$normatif_2 = preg_quote(20, '~'); // don't forget to quote input string!
	$normatif_3 = preg_quote(30, '~'); // don't forget to quote input string!
	$normatif_4 = preg_quote(50, '~'); // don't forget to quote input string!
	$normatif_5 = preg_quote(84, '~'); // don't forget to quote input string!
	$adaptif_1 = preg_quote(40, '~'); // don't forget to quote input string!
	$adaptif_2 = preg_quote(80, '~'); // don't forget to quote input string!
	$produktif = preg_quote('P', '~'); // don't forget to quote input string!
	$cari_mulok = preg_quote(85, '~'); // don't forget to quote input string!
	$mapel_normatif_1 = preg_grep('~' . $normatif_1 . '~', $get_id_2006);
	$mapel_normatif_2 = preg_grep('~' . $normatif_2 . '~', $get_id_2006);
	$mapel_normatif_3 = preg_grep('~' . $normatif_3 . '~', $get_id_2006);
	$mapel_normatif_4 = preg_grep('~' . $normatif_4 . '~', $get_id_2006);
	$mapel_normatif_5 = preg_grep('~' . $normatif_5 . '~', $get_id_2006);
	$mapel_adaptif_1 = preg_grep('~' . $adaptif_1 . '~', $get_id_2006);
	$mapel_adaptif_2 = preg_grep('~' . $adaptif_2 . '~', $get_id_2006);
	foreach($mapel_normatif_1 as $agama => $value){
		$mapel_agama[$agama] = get_nama_mapel($ajaran_id,$rombel_id,$agama);
	}
	if(isset($mapel_agama)){
		foreach($mapel_agama as $key=>$m_agama){
			if (strpos($m_agama,get_agama($s->agama)) !== false) {
				$mapel_normatif_1_alias[$key] = substr($key,0,2);
			}
		}
	}
	if(isset($mapel_normatif_1_alias)){
		$mapel_normatif_1 = $mapel_normatif_1_alias;
	}
	$mapel_normatif = $mapel_normatif_1 + $mapel_normatif_2 + $mapel_normatif_3 + $mapel_normatif_4 + $mapel_normatif_5;
	$mapel_adaptif = $mapel_adaptif_1 + $mapel_adaptif_2;
	$mapel_produktif1 = preg_grep('~' . $produktif . '~', $get_id_2006);
	$mapel_produktif = $mapel_produktif1;
	$all_mulok1 = preg_grep('~' . $cari_mulok . '~', $get_id_2006);
	$all_mulok = $all_mulok1;
	$mapel_group = $mapel_normatif + $mapel_adaptif + $mapel_produktif + $all_mulok;
	$mapel_tambahan = array_diff($get_id_2006, $mapel_group);
	if($mapel_tambahan){
		$mapel_adaptif = $mapel_adaptif + $mapel_tambahan;
	}
	$i=1;
	if($mapel_normatif){
	?>
		<tr>
			<td colspan="10">Normatif</td>
		</tr>
	<?php
		foreach($mapel_normatif as $normatif => $value){
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$normatif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
	?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$normatif); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php 
		$i++;
		}
	} else { ?>
		<tr>
			<td colspan="10" class="text-center">
				Mata Pelajaran Normatif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)
			</td>
		</tr>
	<?php } 
	$a=isset($i) ? $i : 1;
	if($mapel_adaptif){
	?>
		<tr>
			<td colspan="10">Adaptif</td>
		</tr>
	<?php
		foreach($mapel_adaptif as $adaptif => $value){
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$adaptif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
	?>
		<tr>
			<td align="center" valign="top"><?php echo $a; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$adaptif); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php 
			$a++;
		}
	} else { ?>
		<tr>
			<td colspan="10" class="text-center">Mata Pelajaran Adaptif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
	$b=isset($a) ? $a : 1;
	if($mapel_produktif){
	?>
		<tr>
			<td colspan="10">Produktif</td>
		</tr>
	<?php
		foreach($mapel_produktif as $produktif => $value){
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$produktif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
	?>
		<tr>
			<td align="center" valign="top"><?php echo $b; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$produktif); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
			
		<?php 
		$b++;
		}
	} else { ?>
		<tr>
			<td colspan="10" class="text-center">
				Mata Pelajaran Produktif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php 
	}
} ?>