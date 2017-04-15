<?php
// function to check if the system has been installed
function check_installer(){
	$CI = & get_instance();
	$CI->load->database();
	$CI->load->dbutil();
		if ($CI->db->database == "") {
			redirect('install');
		} else {
			$datakurikulums = Datakurikulum::first();
			$data_mapels = Datamapel::first();
			$kds_1	= Kd::first();
			$kds_2	= Kd::find_by_id(1001);
			$kds_3	= Kd::find_by_id(2001);
			$kds_4	= Kd::find_by_id(3001);
			$kds_5	= Kd::find_by_id(4001);
			$kds_6	= Kd::find_by_id(5001);
			$kds_7	= Kd::find_by_id(6001);
			$kds_8	= Kd::find_by_id(7001);
			$kds_9	= Kd::find_by_id(8001);
			$kds_10	= Kd::find_by_id(9001);
			$kds_11	= Kd::find_by_id(10001);
			$kds_12	= Kd::find_by_id(11001);
			$kds_13	= Kd::find_by_id(12001);
			$kds_14	= Kd::find_by_id(13001);
			$kds_15	= Kd::find_by_id(14001);
			$kds_16	= Kd::find_by_id(15001);
			$kds_17	= Kd::find_by_id(16001);
			$kds_18	= Kd::find_by_id(17001);
			$kds_19	= Kd::find_by_id(18001);
			$kds_20	= Kd::find_by_id(19001);
			$matpel_komps = MatpelKomp::first();
			if (!$CI->dbutil->database_exists($CI->db->database)){
				redirect('install/index.php?e=db');

			}else if (is_dir('install')) {
				//redirect('install/index.php?e=folder');
				$rename = rename('install','install_renamed');
			} elseif(!$datakurikulums){
				$CI->session->set_userdata('title', 'Referensi Kurikulum');
				$CI->session->set_userdata('table', 'datakurikulums');
				redirect('step_2/index.php');
			} elseif(!$data_mapels){
				$CI->session->set_userdata('title', 'Referensi Mata Pelajaran');
				$CI->session->set_userdata('table', 'data_mapels');
				redirect('step_2/index.php');
			} elseif(!$kds_1){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 1');
				$CI->session->set_userdata('table', 'kds_1');
				redirect('step_2/index.php');
			} elseif(!$kds_2){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 2');
				$CI->session->set_userdata('table', 'kds_2');
				redirect('step_2/index.php');
			} elseif(!$kds_3){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 3');
				$CI->session->set_userdata('table', 'kds_3');
				redirect('step_2/index.php');
			} elseif(!$kds_4){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 4');
				$CI->session->set_userdata('table', 'kds_4');
				redirect('step_2/index.php');
			} elseif(!$kds_5){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 5');
				$CI->session->set_userdata('table', 'kds_5');
				redirect('step_2/index.php');
			} elseif(!$kds_6){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 6');
				$CI->session->set_userdata('table', 'kds_6');
				redirect('step_2/index.php');
			} elseif(!$kds_7){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 7');
				$CI->session->set_userdata('table', 'kds_7');
				redirect('step_2/index.php');
			} elseif(!$kds_8){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 8');
				$CI->session->set_userdata('table', 'kds_8');
				redirect('step_2/index.php');
			} elseif(!$kds_9){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 9');
				$CI->session->set_userdata('table', 'kds_9');
				redirect('step_2/index.php');
			} elseif(!$kds_10){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 10');
				$CI->session->set_userdata('table', 'kds_10');
				redirect('step_2/index.php');
			} elseif(!$kds_11){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 11');
				$CI->session->set_userdata('table', 'kds_11');
				redirect('step_2/index.php');
			} elseif(!$kds_12){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 12');
				$CI->session->set_userdata('table', 'kds_12');
				redirect('step_2/index.php');
			} elseif(!$kds_13){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 13');
				$CI->session->set_userdata('table', 'kds_13');
				redirect('step_2/index.php');
			} elseif(!$kds_14){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 14');
				$CI->session->set_userdata('table', 'kds_14');
				redirect('step_2/index.php');
			} elseif(!$kds_15){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 15');
				$CI->session->set_userdata('table', 'kds_15');
				redirect('step_2/index.php');
			} elseif(!$kds_16){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 16');
				$CI->session->set_userdata('table', 'kds_16');
				redirect('step_2/index.php');
			} elseif(!$kds_17){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 17');
				$CI->session->set_userdata('table', 'kds_17');
				redirect('step_2/index.php');
			} elseif(!$kds_18){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 18');
				$CI->session->set_userdata('table', 'kds_18');
				redirect('step_2/index.php');
			} elseif(!$kds_19){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 19');
				$CI->session->set_userdata('table', 'kds_19');
				redirect('step_2/index.php');
			} elseif(!$kds_20){
				$CI->session->set_userdata('title', 'Referensi Kompetensi Dasar 20');
				$CI->session->set_userdata('table', 'kds_20');
				redirect('step_2/index.php');
			} elseif(!$matpel_komps){
				$CI->session->set_userdata('title', 'Referensi Mata Pelajaran Kompetensi');
				$CI->session->set_userdata('table', 'matpel_komps');
				redirect('step_2/index.php');
			
			}
		}
}
function date_format_select($selected = ''){
	$formats = array('d/m/Y' => date('d/m/Y'),
					 'm/d/Y' => date('m/d/Y'),
					 'Y/m/d' => date('Y/m/d'),
					 'F j, Y' => date('F j, Y'),
					 'm.d.y' => date('m.d.Y'),
					 'd-m-Y' => date('d-m-Y'),
					 'D M j Y' => date('D M j Y'),
			
	);
	$select = form_dropdown('date_format', $formats, $selected,  'class="form-control" name="date_format"');
	return $select;
}
function success_msg($msg){
	$display = '<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Success! </b> ' .$msg. '
                </div>';
	return $display;
}

function error_msg($msg){
	$display = '<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Error! </b> ' .$msg. '
                </div>';
	return $display;
}
function delete_btn($link = '', $text = 'Hapus'){
	ob_start(); ?>
	<a class="btn btn-danger btn-sm btn_delete" rel="popover" data-placement="left" data-content="<a class='btn btn-danger btn-delete' href='<?php echo site_url($link);  ?>'>
	Ya, Saya Yakin</a> <button class='btn btn-close'>Batal</button>" data-original-title="<b>Apakah Anda Yakin?</b>" ><i class="fa fa-trash-o"></i> <?php echo $text; ?></a>              
	<?php $display = ob_get_clean ();
	return $display;
}
function delete_btn_lg($link = '', $text = 'Hapus'){
	ob_start(); ?>
	<a class="btn btn-danger btn-lg btn_delete" rel="popover" data-placement="left" data-content="<a class='btn btn-danger btn-delete' href='<?php echo site_url($link);  ?>'>
	Ya, Saya Yakin</a> <button class='btn btn-close'>Batal</button>" data-original-title="<b>Apakah Anda Yakin?</b>" ><i class="fa fa-power-off"></i><?php echo $text; ?><i class="fa fa-power-off"></i></a>              
	<?php $display = ob_get_clean ();
	return $display;
}
function activate_btn($link = '', $text = 'Activate'){
	$display = ' <a href="'.site_url($link).'" class="btn btn-info btn-sm toggle-modal"><i class="fa fa-tick"></i> '.$text.'</a> ';			
	return $display;
}

function deactivate_btn($link = '', $text = 'Deactivate'){
	$display = ' <a href="'.site_url($link).'" class="btn btn-warning btn-sm toggle-modal"><i class="fa fa-times"></i> '.$text.'</a> ';		
	return $display;
}

function edit_btn($link = '', $text = 'Edit'){
	$display = ' <a href="'.site_url($link).'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> '.$text.'</a> ';
	return $display;
}
function view_btn($link = '', $text = 'Detil'){
	$display = ' <a href="'.site_url($link).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-eye"></i> '.$text.'</a> ';
	return $display;
}
function format_date($date = ''){
	$CI = & get_instance();
	$settings = Setting::first();
	$formated_date = date($settings->date_format, strtotime($date));
	return $formated_date;
}
function opsi_sikap($opsi,$num = NULL){
	if($num){
		if($opsi == 1) : 
			$label = 'Positif';
		elseif ($opsi == 2) : 
			$label = 'Negatif';
		endif;
	} else {
		if($opsi == 1) : 
			$label = '<span class="label label-success"> Positif </span>';
		elseif ($opsi == 2) : 
			$label = '<span class="label label-danger"> Negatif </span>';
		endif;
	}
	return $label;
}
function butir_sikap($id){
	$data_sikap = Datasikap::find_by_id($id);
	$result = isset($data_sikap->butir_sikap) ? $data_sikap->butir_sikap : '';
	return $result;
}
function status_label($status){
	$label = '';
	if($status == '1') : 
		$label = '<span class="label label-success"> Aktif </span>';
	elseif ($status == '0') : 
		$label = '<span class="label label-danger"> Non aktif </span>';
	endif;
	return $label;
}
function format_amount($amount = 0){
	$CI =& get_instance();
	$settings = Setting::first();
	$currency = (isset($settings->currency)) ? $settings->currency : '';
	$formatted_amt = number_format($amount, 2);

	$formatted_amt = (isset($currency)) ? $currency.' '.$formatted_amt : $formatted_amt;
	return $formatted_amt;
}
function timeDiff($starttime, $endtime)
{
    $timespent = strtotime( $endtime)-strtotime($starttime);
    $days = floor($timespent / (60 * 60 * 24)); 
    $remainder = $timespent % (60 * 60 * 24);
    $hours = floor($remainder / (60 * 60));
    $remainder = $remainder % (60 * 60);
    $minutes = floor($remainder / 60);
    $seconds = $remainder % 60;
    $TimeInterval = '';
    if($hours < 0) $hours=0;
    if($hours != 0)
    {
        $TimeInterval = ($hours == 1) ? $hours.' jam' : $hours.' jam';
    }
    if($minutes < 0) $minutes=0;
    if($seconds < 0) $seconds=0;
    $TimeInterval = $minutes.' menit '. $seconds.' detik';
    
    return $TimeInterval;
}

function limit_text($string = '', $limit = 80) {
	if (strlen($string) >= $limit)
	return substr($string, 0, $limit-1)." ..."; // This is a test...
	else
	return $string;
}
function bentuk($no){
if($no = 1) $nama = 'SMA';
elseif($no = 2) $nama = 'SMLB';
elseif($no = 3) $nama = 'SMK';
elseif($no = 4) $nama = 'MA';
elseif($no = 5) $nama = 'MAK';
elseif($no = 6) $nama = 'Paket C';
elseif($no = 7) $nama = 'SLB';
elseif($no = 8) $nama = 'Satap SD SMP SMA';
else $nama = 'Unknow';
return $nama;
}
function clean_html($string){
	$patterns = array();
	$patterns[0] = '/<html>/';
	$patterns[1] = '/<head>/';
	$patterns[2] = '/<title>/';
	$patterns[3] = '/<\/title>/';
	$patterns[4] = '/<\/head>/';
	$patterns[5] = '/<body>/';
	$patterns[6] = '/<\/body>/';
	$patterns[7] = '/<\/html>/';
	$replacements = array();
	$replacements[0] = '';
	$replacements[1] = '';
	$replacements[2] = '';
	$replacements[3] = '';
	$replacements[4] = '';
	$replacements[5] = '';
	$replacements[6] = '';
	$replacements[7] = '';
	$string = preg_replace('/\s\s+/', ' ', $string);
	return preg_replace($patterns, $replacements, $string);
}
function get_ta(){
	$CI =& get_instance();
	$settings = Setting::first();
	$strings = $settings->periode;
	$strings = explode('|',$strings);
	$tapel = $strings[0];
	$semester = str_replace(' ','',$strings[1]);
	if($semester == 'SemesterGanjil'){
		$smt = 1;
	} else {
		$smt = 2;
	}	
	$ajarans = Ajaran::find_by_tahun_and_smt($tapel,$smt);
	return $ajarans;
}
function get_kurikulum($kurikulum_id,$query='nama'){
	$CI =& get_instance();
	$kompetensi = Datakurikulum::find_by_kurikulum_id($kurikulum_id);
	$nama_kompetensi = $kompetensi->nama_kurikulum;
	if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
		$get_nama_kompetensi['nama'] = str_replace('SMK 2013','',$nama_kompetensi.' (2013)');
		$get_nama_kompetensi['id'] = str_replace('SMK 2013','','2013');
	}
	if (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
		$get_nama_kompetensi['nama'] = str_replace('SMK KTSP','',$nama_kompetensi.' (KTSP)');
		$get_nama_kompetensi['id'] = str_replace('SMK KTSP','','KTSP');
	}
	return $get_nama_kompetensi[$query];
}
function get_bentuk_penilaian($a){
	$metode = Metode::find_by_id($a);
	$result = isset($metode->nama_metode) ? $metode->nama_metode : '-';
	return $result;
}
function get_agama($a){
	if(is_numeric($a)){
		$agamas = array(1=>'Islam',2=>'Kristen',3=>'Katholik',4=>'Hindu',5=>'Buddha',6=>'Konghucu',98=>'Tidak diisi',99=>'Lainnya');
		$agama = $agamas[$a];
	} else {
		$agama = str_replace('Budha','Buddha',$a);
	}
	return $agama;
}
function filter_agama_siswa($nama_mapel,$rombel_id){
	$agamas = array(1=>'Islam',2=>'Kristen',3=>'Katolik',4=>'Hindu',5=>'Buddha',6=>'Konghucu',98=>'Tidak diisi',99=>'Lainnya');
	foreach($agamas as $key=>$value){
		if (strpos($nama_mapel, $value) !== false) {
			$data_siswa = Datasiswa::find('all',array('conditions' => array("data_rombel_id = ? AND agama = ? OR data_rombel_id = ? AND agama = ?",$rombel_id, $value, $rombel_id, $key)));
			break;
		} else {
			$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		}
	}
	return $data_siswa;
}
function filter_agama_mapel($ajaran_id,$rombel_id,$get_id_mapel, $all_mapel,$agama_siswa){
	$kelompok_agama = preg_quote('A01', '~'); // don't forget to quote input string!
	$normatif_1 = preg_quote(10001, '~'); // don't forget to quote input string!
	$get_mapel_agama = preg_grep('~' . $kelompok_agama . '~', $get_id_mapel);
	$get_mapel_agama_alias = preg_grep('~' . $normatif_1 . '~', $get_id_mapel);
	foreach($get_mapel_agama as $agama){
		$mapel_agama[$agama] = get_nama_mapel($ajaran_id,$rombel_id,$agama);
	}
	foreach($get_mapel_agama_alias as $agama_alias){
		$mapel_agama_alias[$agama_alias] = get_nama_mapel($ajaran_id,$rombel_id,$agama_alias);
	}
	if(isset($mapel_agama)){
		foreach($mapel_agama as $key=>$m_agama){
			if (strpos($m_agama,get_agama($agama_siswa)) == false) {
				$mapel_agama_jadi[] = $key;
			}
		}
	}
	if(isset($mapel_agama_alias)){
		foreach($mapel_agama_alias as $key=>$m_agama_alias){
			if (strpos($m_agama_alias,get_agama($agama_siswa)) == false) {
				$mapel_agama_alias_jadi[] = $key;
			}
		}
	}
	if(isset($mapel_agama_jadi)){
		$all_mapel = array_diff($all_mapel, $mapel_agama_jadi);
	}
	if(isset($mapel_agama_alias_jadi)){
		$all_mapel = array_diff($all_mapel, $mapel_agama_alias_jadi);
	}
	return $all_mapel;
}
function konversi_huruf($kkm_value, $n,$show='predikat'){
$predikat	= 0;
$sikap		= 0;
$sikap_full	= 0;
$b = predikat($kkm_value,'b') + 1;
$c = predikat($kkm_value,'c') + 1;
$d = predikat($kkm_value,'d') - 1;
	if($n == 0){
		$predikat 	= '-';
		$sikap		= '-';
		$sikap_full	= '-';
	} elseif($n >= $b){//$settings->a_min){ //86
		$predikat 	= 'A';
		$sikap		= 'SB';
		$sikap_full	= 'Sangat Baik';
	} elseif($n >= $c){ //71
		$predikat 	= 'B';
		$sikap		= 'B';
		$sikap_full	= 'Baik';
	} elseif($n >= $d){ //56
		$predikat 	= 'C';
		$sikap		= 'C';
		$sikap_full	= 'Cukup';
	} elseif($n < $d){ //56
		$predikat 	= 'D';
		$sikap		= 'K';
		$sikap_full	= 'Kurang';
	}
	if($show == 'predikat'){
		$html = $predikat;
	} elseif($show == 'sikap'){
		$html = $sikap;
	} elseif($show == 'sikap_full'){
		$html = $sikap_full;
	} else {
		$html = 'Unknow';
	}
	return $html;
}
function deskripsi_huruf($n,$id){
if($id != 0){
$desk = Deskripsi::find($id);
$desk_a = str_replace('<br>','',$desk->uraian_a);
$desk_b = str_replace('<br>','',$desk->uraian_b);
$desk_c = str_replace('<br>','',$desk->uraian_c);
$desk_d = str_replace('<br>','',$desk->uraian_d);
} else {
$desk_a = '-';
$desk_b = '-';
$desk_c = '-';
$desk_d = '-';
}
	if($n >= 86){
		$html	= $desk_a;
	} elseif($n >= 71){
		$html	= $desk_b;
	} elseif($n >= 56){
		$html	= $desk_c;
	} elseif($n < 55){
		$html	= $desk_d;
	}
	return $html;
}
function konversi_huruf_sikap($n,$show='predikat'){
$predikat	= 0;
$sikap		= 0;
$sikap_full	= 0;
	if($n >= 3.67){
		$predikat 	= 'A';
		$sikap		= 'SB';
		$sikap_full	= 'Sangat Baik';
	} elseif($n >= 3.34){
		$predikat 	= 'A-';
		$sikap		= 'SB';
		$sikap_full	= 'Sangat Baik';
	} elseif($n >= 3.01){
		$predikat 	= 'B+';
		$sikap		= 'B';
		$sikap_full	= 'Baik';
	} elseif($n >= 2.67){
		$predikat 	= 'B';
		$sikap		= 'B';
		$sikap_full	= 'Baik';
	} elseif($n >= 2.34){
		$predikat 	= 'B-';
		$sikap		= 'B';
		$sikap_full	= 'Baik';
	} elseif($n >= 2.01){
		$predikat 	= 'C+';
		$sikap		= 'C';
		$sikap_full	= 'Cukup';
	} elseif($n >= 1.67){
		$predikat 	= 'C';
		$sikap		= 'C';
		$sikap_full	= 'Cukup';
	} elseif($n >= 1.34){
		$predikat 	= 'C-';
		$sikap		= 'C';
		$sikap_full	= 'Cukup';
	} elseif($n >= 1.01){
		$predikat 	= 'D+';
		$sikap		= 'K';
		$sikap_full	= 'Kurang';
	} elseif($n >= 0){
		$predikat 	= 'D';
		$sikap		= 'K';
		$sikap_full	= 'Kurang';
	} else {
		$predikat 	= '-';
		$sikap		= '-';
		$sikap_full	= '-';
	}
	if($show == 'predikat'){
		$html = $predikat;
	} elseif($show == 'sikap'){
		$html = $sikap;
	} elseif($show == 'sikap_full'){
		$html = $sikap_full;
	} else {
		$html = 'Unknow';
	}
	return $html;
}
function indonesian_date($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
		$BulanIndo = array("Januari", "Februari", "Maret",
						   "April", "Mei", "Juni",
						   "Juli", "Agustus", "September",
						   "Oktober", "November", "Desember");
	
		$tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
		$bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
		$tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
		
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
		return($result);
}
function indo_date($date = ''){
	$formated_date = date('Y-m-d', strtotime($date));
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	    $tahun = substr($formated_date, 0, 4);
    	$bulan = substr($formated_date, 5, 2);
	    $tgl   = substr($formated_date, 8, 2);
    	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun; 
    	return($result);
	//return $formated_date;
}
function bilanganKecil($a){
	$MAX_VALUE=100;
	for($i=0;$i<count($a) ;$i++){
		if($a[$i] <	$MAX_VALUE){
			$MAX_VALUE=$a[$i];
		}
	}
	return $MAX_VALUE;
}
function bilanganBesar($a){
	$MAX_VALUE=0;
	for($i=0;$i<count($a) ;$i++){
		if($a[$i] > $MAX_VALUE){
			$MAX_VALUE=$a[$i];
		}
	}
	return $MAX_VALUE;
}
function get_nama_mapel($ajaran_id, $rombel_id, $id_mapel){
	$get_nama_mapel = Datamapel::find_by_id_mapel($id_mapel);
	if(isset($get_nama_mapel->nama_mapel)){
		$nama_mapel = $get_nama_mapel->nama_mapel;
	} else {
		$nama_mapel = get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel);
	}
	return $nama_mapel;
}
function get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel){
	$get_nama_mapel = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran_id, $rombel_id, $id_mapel);
	$nama_mapel = isset($get_nama_mapel->nama_mapel_alias) ? ($get_nama_mapel->nama_mapel_alias) ? $get_nama_mapel->nama_mapel_alias : '' : '';
	return $nama_mapel;
}
function get_guru_mapel($ajaran_id, $rombel_id, $id_mapel, $query = 'nama'){
	$get_mapel = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran_id, $rombel_id, $id_mapel);
	$nama_guru_mapel['id'] = isset($get_mapel->guru_id) ? $get_mapel->guru_id : 0;
	$nama_guru_mapel['nama'] = isset($get_mapel->guru_id) ? get_nama_guru($get_mapel->guru_id) : 0;
	return $nama_guru_mapel[$query];
}
function get_nama_rombel($id_rombel){
	$rombel = Datarombel::find_by_id($id_rombel);
	$nama_rombel = isset($rombel->nama) ? $rombel->nama : '-';
	return $nama_rombel;
}
function get_wali_kelas($id_rombel){
	$rombel = Datarombel::find_by_id($id_rombel);
	$guru_id = isset($rombel->guru_id) ? $rombel->guru_id : 0;
	$nama_guru = get_nama_guru($guru_id);
	return $nama_guru;
}
function get_jumlah_siswa($id_rombel){
	$jumlah_siswa = Datasiswa::find_all_by_data_rombel_id($id_rombel);
	return count($jumlah_siswa);
}
function get_nama_guru($id_guru){
	$guru = Dataguru::find_by_id($id_guru);
	$nama_guru = isset($guru->nama) ? $guru->nama : '-';
	return $nama_guru;
}
function get_nama_ekskul($ajaran_id,$id){
	$ekskul = Ekskul::find_by_ajaran_id_and_id($ajaran_id,$id);
	$nama_ekskul = isset($ekskul->nama_ekskul) ? $ekskul->nama_ekskul : '-';
	return $nama_ekskul;
}
function get_nilai_ekskul($id){
	if($id == 1){
		$nilai_ekskul = 'Sangat Baik';
	} elseif($id == 2){
		$nilai_ekskul = 'Baik';
	} elseif($id == 3){
		$nilai_ekskul = 'Cukup';
	} elseif($id == 4){
		$nilai_ekskul = 'Kurang';
	} else {
		$nilai_ekskul = '-';
	}
	return $nilai_ekskul;
}
function get_kkm($ajaran_id, $rombel_id, $id){
	$get_kkm = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran_id, $rombel_id, $id);
	$kkm = isset($get_kkm->kkm) && $get_kkm->kkm ? $get_kkm->kkm : '-';
	return $kkm;
}
function get_jumlah_penilaian($ajaran_id, $rombel_id, $id_mapel, $query = 1){
	$all_rencana = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => array("ajaran_id = ? AND rombel_id = ? AND id_mapel = ? AND kompetensi_id = ?",$ajaran_id, $rombel_id, $id_mapel, $query)));
	if($all_rencana){
		foreach($all_rencana as $rencana){
			//test($rencana);
			if($rencana->rencanapenilaian){
				$rencana_penilaian = $rencana->rencanapenilaian;
			} else {
				$rencana_penilaian = array();
			}
		}
	} else {
		$rencana_penilaian = array();
	}
	$jumlah = count($rencana_penilaian);
	return status_penilaian($jumlah);
}
function status_penilaian($status){
	if($status > 0) {
		$label = '<span class="label label-success"> '.ucwords($status).' </span>';
	} else {
		$label = '<span class="label label-danger">'.ucwords($status).' </span>';
	}
	return $label;
}

function hak_akses($group){
	$CI = & get_instance();
    // You may need to load the model if it hasn't been pre-loaded
	//$this->load->library('someclass');
    $CI->load->library('ion_auth');
    // Call a function of the model
    if(!$CI->ion_auth->in_group($group)){
		return show_error('Akses ditolak');
	}
}
function sebaran($input, $a,$b){
	$range_data = range($a,$b);	
	$output = array_intersect($input , $range_data);
	return $output;
}
function sebaran_tooltip($input, $a,$b,$c){
	$CI = & get_instance();
	$range_data = range($a,$b);
	$output = array_intersect($input , $range_data);
	$data = array();
	$nama_siswa = '';
	foreach($output as $k=>$v){
		$siswa = Datasiswa::find_by_id($k);
		if($siswa){
			$nama_siswa = $siswa->nama;
		}
		$data[] = $nama_siswa;
	}
	if(count($output) == 0){
		$result = count($output);
	} else {
		$result = '<a class="tooltip-'.$c.'" href="javascript:void(0)" title="'.implode('<br />',$data).'" data-html="true">'.count($output).'</a>';
	}
	return $result;
}
function predikat($kkm, $a){
	//(100-65)/3 = 35/3 = 11,67 = 12 
	$rumus = (100-$kkm) / 3;
	$rumus = number_format($rumus,0);
	$result = array(
				'd'	=> $kkm - 1,
				'c'	=> $kkm + $rumus,
				'b'	=> $kkm + ($rumus * 2),
				'a'	=> $kkm + ($rumus * 3),
				);
	if($result[$a] > 100)
		$result[$a] = 100;
	return $result[$a];
}
function limit_words($id,$string, $word_limit){
	$string = add_responsive_class($string);
	$words = explode(" ",$string);
	if(count($words)>$word_limit){
		return implode(" ",array_splice($words,0,$word_limit)).' <a href="'.site_url('admin/laporan/view_deskripsi_antar_mapel/'.$id).'">Selengkapnya &raquo;</a>';
	} else {
		return $string;
	}
}
function add_responsive_class($content){
	$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
	$document = new DOMDocument();
	libxml_use_internal_errors(true);
	$document->loadHTML(utf8_decode($content));
	$imgs = $document->getElementsByTagName('img');
	foreach ($imgs as $img){
		$img->setAttribute('class','gambar');
	}
	$html = $document->saveHTML();
	$html = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$html);
	$html = str_replace('<html><body>','',$html);
	$html = str_replace('</body></html>','',$html);
	return $html;
}
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
function test($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}
function deskripsi_sikap($array){
	if(is_array($array)){
		$last  = array_slice($array, -1);
		$first = join(', ', array_slice($array, 0, -1));
		$both  = array_filter(array_merge(array($first), $last), 'strlen');
		$result = join(' dan ', $both);
		$result = strtolower($result);
	} else {
		$result = ''; 
	}
	return strtolower($result);
}
function set_log($table,$query,$user){
	$settings = Setting::first();
	if($settings->zona == 1){ // WIB
		date_default_timezone_set('Asia/Jakarta');
	}
	if($settings->zona == 2){ //WITA
		date_default_timezone_set('Asia/Makassar');
	}
	if($settings->zona == 3){ //WIT
		date_default_timezone_set('Asia/Jayapura');
	}
	$file = './log.txt';
	$message = $table.", ".$query. ", User: ".$user.", Waktu :".date('d-m-y H:i:s').PHP_EOL;
	file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
}
function array_filter_recursive($array, $callback = null, $remove_empty_arrays = false) {
	foreach ($array as $key => & $value) { // mind the reference
		if (is_array($value)) {
			$value = array_filter_recursive($value, $callback);
			if ($remove_empty_arrays && ! (bool) $value) {
				unset($array[$key]);
			}
		}
		else {
			if ( ! is_null($callback) && ! $callback($value)) {
				unset($array[$key]);
			}
			elseif ( ! (bool) $value) {
				unset($array[$key]);
			}
		}
	}
	unset($value); // kill the reference
	return $array;
}
function check_great_than_one_fn($val){
	$CI = & get_instance();
	if($val > 100){
  		$CI->session->set_flashdata('error', 'Tambah data nilai remedial gagal. Nilai harus tidak lebih besar dari 100');
		redirect('admin/asesmen/remedial');
	}
}