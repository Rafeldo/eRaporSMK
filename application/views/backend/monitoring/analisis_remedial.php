<?php
$html = '';
		$settings 	= Setting::first();
		$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		$get_all_kd = Kd::find_all_by_id_mapel_and_kelas_and_aspek($id_mapel, $kelas, $aspek);
		if(!$get_all_kd){
			$get_all_kd = Kd::find_all_by_id_mapel_and_kelas_and_aspek($id_mapel, $kelas, 'PK');
		}
		$count_get_all_kd = count($get_all_kd);
		$kkm = get_kkm($ajaran_id, $rombel_id, $id_mapel);
		$html .= '<div class="table-responsive no-padding">';
		$html .= '<table class="table table-bordered table-hover">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th rowspan="3" style="vertical-align: middle;">Nama Siswa</th>';
		$html .= '<th class="text-center" colspan="'.( $count_get_all_kd * 2 ).'">Kompetensi Dasar</th>';
		$html .= '<th rowspan="3" style="vertical-align: middle;" class="text-center">Rerata Akhir</th>';
		$html .= '<th rowspan="3" style="vertical-align: middle;" class="text-center">Rerata Remedial</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$get_all_kd_finish = count($get_all_kd);
		foreach($get_all_kd as $all_kd){
			//$kd = Kd::find_by_id($allpengetahuan->kd_id);
			$id_kd = $all_kd->id_kompetensi;
			$id_kds[] = $all_kd->id;
			$html .= '<th colspan="2"><a href="javacript:void(0)" class="tooltip-left" title="'.$all_kd->kompetensi_dasar.'">&nbsp;&nbsp;&nbsp;'.$id_kd.'&nbsp;&nbsp;&nbsp;</a></th>';
		}
		$html .= '</tr>';
		$html .= '<tr>';
		foreach($get_all_kd as $all_kd){
			$html .= '<th class="text-center bg-gray disabled color-palette">A</th>';
			$html .= '<th class="text-center">R</th>';
		}
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no=0;
		$rencana = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id,$id_mapel,$rombel_id,$kompetensi_id);
		if($rencana){
			foreach($rencana as $ren){
				$id_rencana[] = $ren->id;
			}
			$all_rencana_penilaian = Rencanapenilaian::find('all', array('order'=>'kd_id ASC', 'conditions' => array("rencana_id IN(?)",$id_rencana)));
			if($all_rencana_penilaian){
				foreach($all_rencana_penilaian as $arp){
					$rencana_penilaian_id[] = $arp->id;
				}
			}
		}
		foreach($data_siswa as $siswa){
			$remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, $kompetensi_id, $rombel_id, $id_mapel, $siswa->id);
			$html .= '<tr>';
			$html .= '<td>';
			$html .= $siswa->nama;
			$html .= '</td>';
			if($remedial){
				$set_rencana_id = implode("','",$id_rencana);
				$all_nilai_asli = Nilai::find_by_sql("select b.kd_id, a.id,a.data_siswa_id, a.rencana_penilaian_id, avg(a.nilai) as rata_rata from `nilais` a INNER JOIN rencana_penilaians b ON b.id = a.rencana_penilaian_id AND b.rencana_id IN('$set_rencana_id') WHERE a.data_siswa_id = $siswa->id GROUP BY b.kd_id");
				$all_nilai = unserialize($remedial->nilai);
				$set_nilai = 0;
				foreach($all_nilai as $key=>$nilai){
					$nilai_asli = isset($all_nilai_asli[$key]) ? $all_nilai_asli[$key] : 0;
					$set_nilai += $nilai;
					if($kkm > number_format($nilai_asli->rata_rata,0)){
						$bg_nilai_asli = ' text-red';
					} else {
						$bg_nilai_asli = '';
					}
					$html .= '<td class="text-center bg-gray disabled color-palette'.$bg_nilai_asli.'">';
					$html .= number_format($nilai_asli->rata_rata,0);
					$html .= '</td>';
					$html .= '<td class="text-center">';
					$html .= number_format($nilai,0);
					$html .= '</td>';
					$no++;
				}
				$count_all_nilai = count($all_nilai);
				if($count_all_nilai < $count_get_all_kd){
					$get_all_kd_finish = $count_all_nilai;
					$kurang = ($count_get_all_kd - $count_all_nilai);
					for ($x = 1; $x <= $kurang; $x++) {
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
					}
				}
				$html .= '<td class="text-center"><strong>';
				$html .= $remedial->rerata_akhir;
				$html .= '</strong></td>';
				$html .= '<td class="text-center"><strong>';
				$html .= $remedial->rerata_remedial;
				$html .= '</strong></td>';
			} else {
				$html .= '<td class="text-center" colspan="'.( $count_get_all_kd * 2 ).'">';
						$html .= 'Nilai tidak ditemukan';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '<input type="hidden" id="get_all_kd" value="'.$get_all_kd_finish.'" />';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css');
		$html .= '<script src="'.base_url().'assets/js/tooltip-viewport.js"></script>';
		$html .= '<script src="'.base_url().'assets/js/remedial.js"></script>';
		echo $html;
?>