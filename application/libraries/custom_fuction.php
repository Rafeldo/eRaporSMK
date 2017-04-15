<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Custom_fuction{	
	function __construct(){
	   
	}
    public function my_form_notif($title,$name,$readonly = false){
		if($readonly){
			$read = 'readonly="true"';
		} else {
			$read = '';
		}
		$html = '<div class="form-group">
        								<label class="col-sm-4 control-label">'.$title.'</label>
        								<div class="col-sm-7">
        									<input type="text" id="'.$name.'" name="'.$name.'" class="form-control input-sm" '.$read.' />
        								</div>
        							</div>';
		return $html;
	}
    public function my_form($form,$title,$name,$placeholder,$value,$left,$right,$readonly = false,$selected = false){
		if($readonly){
			$read = 'readonly="true"';
		} else {
			$read = '';
		}
        $formulir = '';
        switch($form){
            case 'hidden':
                //$formulir='Teknik Kendaraan Ringan'.$name.' place '.$placeholder;
				$formulir= '<input type="hidden" id="'.$name.'" name="'.$name.'" class="form-control input-sm" value="'.$value.'" placeholder="'.$placeholder.'" '.$read.' />';
                break;
            case 'text':
                //$formulir='Teknik Kendaraan Ringan'.$name.' place '.$placeholder;
				$formulir= '<div class="row">	
							<div class="form-group">
								<label class="col-sm-'.$left.' control-label">'.$title.'</label>
								<div class="col-sm-'.$right.'">
									<input type="text" id="'.$name.'" name="'.$name.'" class="form-control input-sm" value="'.$value.'" placeholder="'.$placeholder.'" '.$read.' />
								</div>
							</div>
						</div>';
                break;
            case 'textarea':
                $formulir= '<div class="row">	
							<div class="form-group">
								<label class="col-sm-'.$left.' control-label">'.$title.'</label>
								<div class="col-sm-'.$right.'">
									<textarea id="'.$name.'" name="'.$name.'" class="form-control input-sm" placeholder="'.$placeholder.'">'.$value.'</textarea>
								</div>
							</div>
						</div>';
                break;
            case 'select':
                $formulir='<div class="row">	
							<div class="form-group">
								<label class="col-sm-'.$left.' control-label">'.$title.'</label>
								<div class="col-sm-'.$right.'">
									<select id="'.$name.'" name="'.$name.'" class="form-control input-sm">
										<option value="" '.$selected.'>'.$placeholder.'</option>
										'.$this->select_option($value).'
									</select>
								</div>
							</div>
						</div>';
                break;
            case 'upload':
                $formulir='Busana Butik';
                break;
            case 'button':
                $formulir='<button type="submit" class="btn btn-primary">'.$title.'</button>';
                break;
			case 'date':
				$formulir = '<div class="row">	
							<div class="form-group">
								<label class="col-sm-'.$left.' control-label">'.$title.'</label>
								<div class="col-sm-'.$right.'">
									<div class="input-group"><input type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" class="form-control input-sm" '.$read.' /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div>
								</div>
							</div>
						</div>';
				break;
			case 'select2':
                $formulir='<div class="row">	
							<div class="form-group">
								<label class="col-sm-3 control-label">'.$title.'</label>
								<div class="col-sm-8"><div id="'.$name.'"><a class="btn btn-default btn-flat" href="javascript:void(0)" id="getdata-button">'.$placeholder.'</a></div></div>
							</div>
						</div>';
                break;
            default:
                $formulir='';
                break;
        }
        return $formulir;
    }
    
    
    public function get_prestasi_status($kode){
        $status = '';
        switch($kode){
            case '1':
                $status='Perorangan';
                break;
            case '0.5':
                $status='Sampai 5 (lima) Orang';
                break;
            case '0.3':
                $status='Sampai 10 (sepuluh) Orang';
                break;
            case '0.3':
                $status='Ketua Regu lebih dari 10 (sepuluh) Orang';
                break;
            case '0.2':
                $status='Anggota Regu lebih dari 10 (sepuluh) Orang';
                break;
            default:
                $status='Tidak Ada Penghargaan';
                break;
        }
    }
    
    private function select_option($value){
		$html = '';
		foreach($value as $key => $val){
			//$html .= $this->print_r2($val);
			$html .= '<option value="'.$key.'">'.$val.'</option>'."\n\t\t\t\t\t\t\t\t\t\t";
		}
        return $html;
    }
	private function print_r2($kode){
        return '<pre>'.print_r($kode).'</pre>';
    }
	public function get_prestasi_tingkat($kode){
        
    }
    
    public function get_jurusan_all(){
        $jurusan = array('1','2','3','4','5');
        return $jurusan;
    }
    
    public function get_no_pendaftaran($id){
        $no_pendaftaran = str_pad($id, 4, "0", STR_PAD_LEFT);//*10000;
        return $no_pendaftaran;
    }
	public function GeneratePassword($length = 6) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function GenerateEmail($length = 6) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function GenerateID($length = 10) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function GenerateNISN($length = 12) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function TanggalIndo($date){
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	    $tahun = substr($date, 0, 4);
    	$bulan = substr($date, 5, 2);
	    $tgl   = substr($date, 8, 2);
    	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun; 
    	return($result);
	}
	public function HariIndo($date){
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	    $tahun = substr($date, 0, 4);
    	$bulan = substr($date, 5, 2);
	    $tgl   = substr($date, 8, 2);
    	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun; 
    	return($result);
	}
	public function BulanIndo($date){
	    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$result = $BulanIndo[(int)$bulan-1] . " ". $tahun;        
		return($result);
	}
	public function validateDate($date, $format = 'Y-m-d'){
	    $d = DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
	}
	public function validateYear($date, $format = 'Y'){
	    $d = DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
	}
	public function status_label($status){
		if($status == '1') : 
			$label = '<span class="btn btn-sm btn-success"> Aktif </span>';
		elseif ($status == '0') : 
			$label = '<span class="btn btn-sm btn-danger"> Non Aktif </span>';
		endif;
		return $label;
	}
	public function delete_btn($link = '', $text = 'Hapus'){
		ob_start(); ?>
		<a class="btn btn-danger btn-sm btn_delete" rel="popover" data-placement="left" data-content="<a class='btn btn-danger btn-delete' href='<?php echo site_url($link);  ?>'>
		Ya, Saya Yakin</a> <button class='btn btn-close'>Batal</button>" data-original-title="<b>Apakah Anda Yakin?</b>" ><i class="fa fa-trash-o"></i> <?php echo $text; ?></a>              
		<?php $display = ob_get_clean ();
		return $display;
	}
	public function delete_btn_lg($link = '', $text = 'Hapus'){
		ob_start(); ?>
		<a class="btn btn-danger btn-lg btn_delete" rel="popover" data-placement="left" data-content="<a class='btn btn-danger btn-delete' href='<?php echo site_url($link);  ?>'>
		Ya, Saya Yakin</a> <button class='btn btn-close'>Batal</button>" data-original-title="<b>Apakah Anda Yakin?</b>" ><i class="fa fa-power-off"></i><?php echo $text; ?><i class="fa fa-power-off"></i></a>              
		<?php $display = ob_get_clean ();
		return $display;
	}
	public function activate_btn($link = '', $text = 'Activate'){
		$display = '<a href="'.site_url($link).'" class="btn btn-info btn-sm toggle-modal"><i class="fa fa-tick"></i> '.$text.'</a>';			
		return $display;
	}
	
	public function deactivate_btn($link = '', $text = 'Deactivate'){
		$display = '<a href="'.site_url($link).'" class="btn btn-warning btn-sm toggle-modal"><i class="fa fa-times"></i> '.$text.'</a>';		
		return $display;
	}
	
	public function edit_btn($link = '', $text = 'Edit'){
		$display = '<a href="'.site_url($link).'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> '.$text.'</a>';
		return $display;
	}
	public function view_btn($link = '', $text = 'Detil'){
		$display = '<a href="'.site_url($link).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-eye"></i> '.$text.'</a>';
		return $display;
	}
	public function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}
		//test($_GET);
		return $start;
	}

	public function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}

	public function get_sort_dir() {
		$sort_dir = "ASC";
		$sdir = strip_tags($_GET['sSortDir_0']);
		if (isset($sdir)) {
			if ($sdir != "asc" ) {
				$sort_dir = "DESC";
			}
		}

		return $sort_dir;
	}
	public function expired($date1,$date2) {
	    if ($date1>$date2) { 
    	    $tmp=$date1; 
        	$date1=$date2; 
	        $date2=$tmp; 
    	    unset($tmp); 
        	$sign=-1; 
	    } else $sign = 1;
    	if ($date1==$date2) return 0;
	    $days = 0;
    	$working_days = array(1,2,3,4,5); // Monday-->Friday
		$working_hours = array(9, 17.5); // from 9:00 to 17:30 (8.5 hours)
		$current_date = $date1;
		$beg_h = floor($working_hours[0]); 
		$beg_m = ($working_hours[0]*60)%60;
		$end_h = floor($working_hours[1]); 
		$end_m = ($working_hours[1]*60)%60;
	    //In case date1 is on same day of date2
    	if (mktime(0,0,0,date('n', $date1), date('j', $date1), date('Y', $date1))==mktime(0,0,0,date('n', $date2), date('j', $date2), date('Y', $date2))){
        //If its not working day, then return 0
        if (!in_array(date('w', $date1), $working_days)) return 0;
        $date0 = mktime($beg_h, $beg_m, 0, date('n', $date1), date('j', $date1), date('Y', $date1));
        $date3 = mktime($end_h, $end_m, 0, date('n', $date1), date('j', $date1), date('Y', $date1));

        if ($date1<$date0) {
            if ($date2<$date0) return 0;
            $date1 = $date0;
            if ($date2>$date3) $date2=$date3;
            	return $date2-$date1;
        	}
    	    if ($date1>$date3) return 0;
	        if ($date2>$date3) $date2=$date3;
    	    return $date2-$date1;
	    }
	    //setup the very next first working time stamp
    	if (!in_array(date('w',$current_date) , $working_days)) {
	        // the current day is not a working day
    	    // the current time stamp is set at the beginning of the working day
	        $current_date = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
    	    // search for the next working day
	        while ( !in_array(date('w',$current_date) , $working_days) ) {
            	$current_date += 24*3600; // next day
        	}
	    } else {
    	    // check if the current timestamp is inside working hours
	        $date0 = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
    	    // it's before working hours, let's update it
	        if ($current_date<$date0) $current_date = $date0;
	        $date3 = mktime( $end_h, $end_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
    	    if ($date3<$current_date) {
	            // outch ! it's after working hours, let's find the next working day
            	$current_date += 24*3600; // the day after
        	    // and set timestamp as the beginning of the working day
    	        $current_date = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
	            while ( !in_array(date('w',$current_date) , $working_days) ) {
            	    $current_date += 24*3600; // next day
        	    }
    	    }
	    }
	    // so, $current_date is now the first working timestamp available...
	    // calculate the number of seconds from current timestamp to the end of the working day
    	$date0 = mktime( $end_h, $end_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
	    $seconds = $date0-$current_date;
	    // calculate the number of days from the current day to the end day
	    $date3 = mktime( $beg_h, $beg_m, 0, date('n',$date2), date('j',$date2), date('Y',$date2) );
    	while ( $current_date < $date3 ) {
	        $current_date += 24*3600; // next day
        	if (in_array(date('w',$current_date) , $working_days) ) $days++; // it's a working day
    	}
	    if ($days>0) $days--; //because we've already count the first day (in $seconds)
    	// check if end's timestamp is inside working hours
	    $date0 = mktime( $beg_h, $beg_m, 0, date('n',$date2), date('j',$date2), date('Y',$date2) );
    	if ($date2<$date0) {
	        // it's before, so nothing more !
    	} else {
	        // is it after ?
        	$date3 = mktime( $end_h, $end_m, 0, date('n',$date2), date('j',$date2), date('Y',$date2) );
    	    if ($date2>$date3) $date2=$date3;
	        // calculate the number of seconds from current timestamp to the final timestamp
        	$tmp = $date2-$date0;
    	    $seconds += $tmp;
	     }
    	// calculate the working days in seconds
	    $seconds += 3600*($working_hours[1]-$working_hours[0])*$days;
    	return $this->seconds2human($sign * $seconds);
	}
	public function seconds2human($ss) {
    	$s = $ss%60;
	    $m = floor(($ss%3600)/60);
	    $h = floor(($ss)/3600);
    	return "$h jam, $m menit, $s detik";
	}
	public function TanggalIndonesia($date){
    $hari=substr($date, 11, 1);
    $tgl =substr($date, 8, 2);
    $bln =substr($date, 5, 2);
    $thn =substr($date, 0, 4);
    switch($hari){      
        case 0 : {
                    $hari='Minggu';
                }break;
        case 1 : {
                    $hari='Senin';
                }break;
        case 2 : {
                    $hari='Selasa';
                }break;
        case 3 : {
                    $hari='Rabu';
                }break;
        case 4 : {
                    $hari='Kamis';
                }break;
        case 5 : {
                    $hari="Jum'at";
                }break;
        case 6 : {
                    $hari='Sabtu';
                }break;
        default: {
                    $hari='UnKnown';
                }break;
    }
     
switch($bln){       
        case 1 : {
                    $bln='Januari';
                }break;
        case 2 : {
                    $bln='Februari';
                }break;
        case 3 : {
                    $bln='Maret';
                }break;
        case 4 : {
                    $bln='April';
                }break;
        case 5 : {
                    $bln='Mei';
                }break;
        case 6 : {
                    $bln="Juni";
                }break;
        case 7 : {
                    $bln='Juli';
                }break;
        case 8 : {
                    $bln='Agustus';
                }break;
        case 9 : {
                    $bln='September';
                }break;
        case 10 : {
                    $bln='Oktober';
                }break;     
        case 11 : {
                    $bln='November';
                }break;
        case 12 : {
                    $bln='Desember';
                }break;
        default: {
                    $bln='UnKnown';
                }break;
    	}
		return "<span style='width:244px;'>".$hari.", ".$tgl." ".$bln." ".$thn."</span>";
	}
	public function TanggalIndonesia2($date){
    $hari=substr($date, 11, 1);
    $tgl =substr($date, 8, 2);
    $bln =substr($date, 5, 2);
    $thn =substr($date, 0, 4);
    switch($hari){      
        case 0 : {
                    $hari='Minggu';
                }break;
        case 1 : {
                    $hari='Senin';
                }break;
        case 2 : {
                    $hari='Selasa';
                }break;
        case 3 : {
                    $hari='Rabu';
                }break;
        case 4 : {
                    $hari='Kamis';
                }break;
        case 5 : {
                    $hari="Jum'at";
                }break;
        case 6 : {
                    $hari='Sabtu';
                }break;
        default: {
                    $hari='UnKnown';
                }break;
    }
     
switch($bln){       
        case 1 : {
                    $bln='Januari';
                }break;
        case 2 : {
                    $bln='Februari';
                }break;
        case 3 : {
                    $bln='Maret';
                }break;
        case 4 : {
                    $bln='April';
                }break;
        case 5 : {
                    $bln='Mei';
                }break;
        case 6 : {
                    $bln="Juni";
                }break;
        case 7 : {
                    $bln='Juli';
                }break;
        case 8 : {
                    $bln='Agustus';
                }break;
        case 9 : {
                    $bln='September';
                }break;
        case 10 : {
                    $bln='Oktober';
                }break;     
        case 11 : {
                    $bln='November';
                }break;
        case 12 : {
                    $bln='Desember';
                }break;
        default: {
                    $bln='UnKnown';
                }break;
    	}
		return "Hari ".$hari.", Tanggal ".$tgl." bulan ".$bln." tahun ".$thn;
	}
	public function jadwal_ujian($date){
    $hari=substr($date, 11, 1);
    $tgl =substr($date, 8, 2);
    $bln =substr($date, 5, 2);
    $thn =substr($date, 0, 4);
    switch($hari){      
        case 0 : {
                    $hari='Minggu';
                }break;
        case 1 : {
                    $hari='Senin';
                }break;
        case 2 : {
                    $hari='Selasa';
                }break;
        case 3 : {
                    $hari='Rabu';
                }break;
        case 4 : {
                    $hari='Kamis';
                }break;
        case 5 : {
                    $hari="Jum'at";
                }break;
        case 6 : {
                    $hari='Sabtu';
                }break;
        default: {
                    $hari='UnKnown';
                }break;
    }
     
	switch($bln){       
        case 1 : {
                    $bln='Januari';
                }break;
        case 2 : {
                    $bln='Februari';
                }break;
        case 3 : {
                    $bln='Maret';
                }break;
        case 4 : {
                    $bln='April';
                }break;
        case 5 : {
                    $bln='Mei';
                }break;
        case 6 : {
                    $bln="Juni";
                }break;
        case 7 : {
                    $bln='Juli';
                }break;
        case 8 : {
                    $bln='Agustus';
                }break;
        case 9 : {
                    $bln='September';
                }break;
        case 10 : {
                    $bln='Oktober';
                }break;     
        case 11 : {
                    $bln='November';
                }break;
        case 12 : {
                    $bln='Desember';
                }break;
        default: {
                    $bln='UnKnown';
                }break;
    	}
		return $hari.", ".$tgl."-".$bln."-".$thn;
	}
	public function limit_words($id,$string, $word_limit){
		$string = $this->add_responsive_class($string);
        $words = explode(" ",$string);
        if(count($words)>$word_limit){
           return implode(" ",array_splice($words,0,$word_limit)).' <a href="'.site_url('main/berita/'.$id).'">Selengkapnya &raquo;</a>';
        }else{
           return $string;
        }
    }
	public function add_responsive_class($content){
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
}