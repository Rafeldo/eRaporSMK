<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Backend_Controller {
	protected $activemenu = 'tools';
	public function __construct(){
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
		if($this->ion_auth->in_group('siswa')){
			redirect('siswa/dashboard');
		}
	}
	public function index(){
		$this->template->title('Administrator Panel : Manajemen Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Manajemen Data')
        ->build($this->admin_folder.'/tools/perbaikan');
	}
	public function rekap(){
		$loggeduser = $this->ion_auth->user()->row();
		//$siswa = Datasekolah::find($loggeduser->data_sekolah_id, array('include'=>array('datasiswa','category')));
		//$data['ujian'] = Exam::find_all_by_data_sekolah_id($loggeduser->data_sekolah_id);
		$data['rombels'] = Datarombel::find_all_by_data_sekolah_id($loggeduser->data_sekolah_id);
		$data['periode'] = Ajaran::all();
		$data_rombel = Datasekolah::find($loggeduser->data_sekolah_id, array('include'=>array('datarombel')));
		$pilih_rombel = '<div class="col-md-3"><select id="pilih_rombel" class="form-control">';
		$pilih_rombel .= '<option value="">==Filter Berdasar Rombel==</option>';
		foreach($data_rombel->datarombel as $rombel){
			$pilih_rombel .= '<option value="'.$rombel->id.'">'.$rombel->nama.'</option>';
		}
		$pilih_rombel .= '</select>';
		$pilih_rombel .= '</div>';
		$this->template->title('Administrator Panel : Manajemen Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Rekapitulasi Nilai')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/tools/rekap_view',$data);
	}
	public function ambil_ujian(){
		$id_tapel	= $_POST['tapel'];
		$id_rombel = $_POST['id_rombel'];
		$mapel = Category::find_all_by_data_rombel_id($id_rombel);
		$mapel_id = '';
		foreach($mapel as $m){
			$mapel_id[] = $m->id;
		}
		//$ujian 	= Exam::find('all', array('conditions' => array('category_id in (?)', $mapel_id)));
		$ujian = Exam::all(array('conditions' => array('ajaran_id = ? AND category_id IN (?)', $id_tapel, $mapel_id)));
		if($ujian){
			foreach($ujian as $u){
					$mapel = Category::find($u->category_id);
					$guru = Dataguru::find($mapel->guru_id);
					$rombel = Datarombel::find($mapel->data_rombel_id);
					//echo '<option value="'.$u->id.'" data-rombel="'.$rombel->id.'">'.$u->name.' || '.$mapel->nama.' || '.$rombel->nama.' || '.$guru->nama.'</option>';
					$record_ujian = array();
					$record_ujian['value'] = $u->id;
					$record_ujian['text'] = $u->name.' || '.$mapel->nama.' || '.$rombel->nama.' || '.$guru->nama;
					$record_ujian['data_rombel'] = $mapel->data_rombel_id;
					$record_ujian['id_tapel'] = $id_tapel;
					$output['ujian'][] = $record_ujian;
				}
		} else {
			$record_siswa['value'] = '0';
			$record_siswa['text'] = 'Tidak ditemukan data';
			$output['ujian'][] = $record_siswa;
		}
		echo json_encode($output);
	}
	public function ambil_rombel(){
		$id_tapel	= $_POST['tapel'];
		$rombel 	= Datarombel::all();
		if(isset($rombel)){
			foreach($rombel as $r){
				$record_rombel = array();
				$record_rombel['value'] = $r->id;
				$record_rombel['text'] = $r->nama;
				//$record_rombel['data_rombel'] = $mapel->data_rombel_id;
				$record_rombel['id_tapel'] = $id_tapel;
				$output['rombel'][] = $record_rombel;
			}
		} else {
			$record_rombel['value'] = '0';
			$record_rombel['text'] = 'Tidak ditemukan data';
			$output['rombel'][] = $record_rombel;
		}
		echo json_encode($output);
	}
	public function pantau(){
		$loggeduser = $this->ion_auth->user()->row();
		$data_rombel = Datasekolah::find($loggeduser->data_sekolah_id, array('include'=>array('datarombel')));
		$pilih_rombel = '<div class="col-md-3"><select id="pilih_rombel_pantau" class="form-control">';
		$pilih_rombel .= '<option value="">==Filter Berdasar Rombel==</option>';
		foreach($data_rombel->datarombel as $rombel){
			$pilih_rombel .= '<option value="'.$rombel->id.'">'.$rombel->nama.'</option>';
		}
		$pilih_rombel .= '</select>';
		$pilih_rombel .= '</div>';
		$this->template->title('Administrator Panel : Pantau Ujian')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Pantau Ujian')
        ->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/tools/pantau_view');
	}
	public function kehadiran(){
		$this->template->title('Administrator Panel : Manajemen Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Cetak Daftar Hadir')
        ->build($this->admin_folder.'/tools/perbaikan');
	}
	public function cetak(){
		$this->template->title('Administrator Panel : Manajemen Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Cetak Kartu Peserta')
        ->build($this->admin_folder.'/tools/perbaikan');
	}
	public function cetak_opsi(){
		$id		= $_POST['id_ujian'];
		$ujian 	= Exam::find($id);
		$nilai 	= Nilai::find_all_by_exam_id($ujian->id,array('conditions' => array("group"=>'data_siswa_id')));
		if($nilai){
			foreach($nilai as $n){
				$siswa_id[] = $n->data_siswa_id;
			}
			//$siswa_id = implode(',',$siswa_id);
			//echo $siswa_id;
			//Book::find('all', array('select' => 'id, title'));
			$cond =array('conditions'=>array('user_id IN(?)', $siswa_id));
			$siswa	= Datasiswa::all($cond);
			foreach($siswa as $s){
				$record_siswa = array();
				$record_siswa['value'] = $s->id;
				$record_siswa['text'] = $s->nama;
				$output['siswa'][] = $record_siswa;
			}
		} else {
			$record_siswa['value'] = '';
			$record_siswa['text'] = 'Belum ada siswa yang mengikuti ujian ini';
			$output['siswa'][] = $record_siswa;
		}
		$mapel 	= Category::find($ujian->category_id);
		$rombel	= Datarombel::find('all', array('conditions' => "id = $mapel->data_rombel_id"));
		foreach($rombel as $r){
			$record_rombel = array();
			$record_rombel[] = $r->id;
			$output['rombel'][] = $record_rombel;
		}
		echo json_encode($output);
	}
	public function get_siswa_by_mapel(){
		$id		= $_POST['id_mapel'];
		$ujian	= Exam::find('all', array('conditions' => "category_id = $id", 'select' => 'id'));
		if($ujian){
			foreach($ujian as $u){
				$id_ujian[] = $u->id;
			}
			$nilai = Nilai::find('all',array('conditions'=>array('exam_id IN(?)', $id_ujian),'group'=>'data_siswa_id'));
			if($nilai){
				foreach($nilai as $s){
					$siswa = Datasiswa::find($s->data_siswa_id);
					$record_siswa = array();
					$record_siswa['value'] = $siswa->id;
					$record_siswa['text'] = $siswa->nama;
					$output['siswa'][] = $record_siswa;
				}
			} else {
				$record_siswa['value'] = '';
				$record_siswa['text'] = 'Belum ada siswa yang mengikuti ujian di rombel '.$rombel->nama;
				$output['siswa'] = $record_siswa;
			}
		} else {
			$record_siswa['value'] = '';
			$record_siswa['text'] = 'Belum ada siswa di rombel '.$rombel->nama;
			$output['siswa'][] = $record_siswa;
		}
		echo json_encode($output);
	}
	public function pilih_mapel(){
		$id		= $_POST['id_rombel'];
		$id_tapel = $_POST['id_tapel'];
		$ajaran = Ajaran::find($id_tapel);
		$rombel = Datarombel::find($id);
		$mapel 	= Category::find_all_by_data_rombel_id($rombel->id);
		if($mapel){
			foreach($mapel as $m){
				$id_mapel[] = $m->id;
			}
			$cond1 =array('conditions'=>array('category_id IN(?) AND ajaran_id = ?', $id_mapel,$id_tapel));
			$ujian 	= Exam::all($cond1);
			if($ujian){
				foreach($ujian as $u){
					$id_mapels[] = $u->category_id;
				}
				$cond2 =array('conditions'=>array('id IN(?)', $id_mapels));
				$mapels	= Category::all($cond2);
				if($mapels){
					foreach($mapels as $m){
						$record_mapel = array();
						$record_mapel['value'] = $m->id;
						$record_mapel['text'] = $m->nama;
						$output['pilih_mapel'][] = $record_mapel;
					}
				} else {
					$record_ujian['value'] = '';
					$record_ujian['text'] = 'Belum ada ujian dirombel '.$rombel->nama.' pada Tahun '.$ajaran->tahun.' Semester '.$ajaran->smt;
					$output['pilih_mapel'] = array($record_ujian);
				}
			} else {
				$record_ujian['value'] = '';
				$record_ujian['text'] = 'Belum ada ujian dirombel '.$rombel->nama.' pada Tahun '.$ajaran->tahun.' Semester '.$ajaran->smt;
				$output['pilih_mapel'] = array($record_ujian);
			}
		} else {
			$record_ujian['value'] = '';
			$record_ujian['text'] = 'Belum ada mapel dirombel '.$rombel->nama;
			$output['pilih_mapel'] = array($record_ujian);
		}
		echo json_encode($output);
	}
    public function pantau_ujian($id = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$siswa = Datasekolah::find($loggeduser->data_sekolah_id, array('include'=>array('datasiswa')));
		foreach($siswa->datasiswa as $user){
			$user_id[] = $user->user_id;
		}
		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}
		$user_id = implode(',',$user_id);
		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		if($id){
			$user_id = '';
			$datasiswa = Datasiswa::find('all',array('conditions' =>'data_rombel_id = '.$id));
			foreach($datasiswa as $siswa){
				$user_id[] = $siswa->user_id;
			}
			$user_id = implode(',',$user_id);
			$query = Userexam::find('all', array('conditions' => "status = 'inprogress' AND user_id IN ($user_id) AND (user_id LIKE '%$search%' OR exam_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Userexam::find('all', array('conditions' => "status = 'inprogress' AND user_id IN ($user_id) AND (user_id LIKE '%$search%' OR exam_id LIKE '%$search%')"));
		} else {
			$query = Userexam::find('all', array('conditions' => "status = 'inprogress' AND user_id IN ($user_id) AND (user_id LIKE '%$search%' OR exam_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Userexam::find('all', array('conditions' => "status = 'inprogress' AND user_id IN ($user_id) AND (user_id LIKE '%$search%' OR exam_id LIKE '%$search%')"));
		}
		$iFilteredTotal = count($query);		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$siswa = Datasiswa::find_by_user_id($temp->user_id);
			$user = User::find($temp->user_id);
			if($siswa->jenis_kelamin == 'L'){
				if($siswa->photo)
					$foto = base_url().PROFILEPHOTOSTHUMBS.$siswa->photo;
				else
					$foto= base_url().'assets/img/no_avatar.jpg';
			} else {
				if($siswa->photo)
					$foto= base_url().PROFILEPHOTOSTHUMBS.$siswa->photo;
				else
					$foto= base_url().'assets/img/no_avatar_f.jpg';
			}
			$materi_ujian = Exam::find($temp->exam_id);
			$mapel = Category::find($materi_ujian->category_id);
			if($mapel->guru_id == 0){
				$guru = 0;
			} else {
				$guru = Dataguru::find($mapel->guru_id);
			}
			$gurumapel = ($guru != '0') ? $guru->nama: 'Guru Mapel Belum Dipilih';
			$rombel = Datarombel::find($mapel->data_rombel_id);
			if($user->login_status == 1){
				$tombol_reset = 'reset';
			} else {
				$tombol_reset = 'disabled';
			}
			$record = array();
			$record[] = $i+1;
			$record[] = '<img src="'.$foto.'" width="50" style="float:left; margin-right:10px;" /> '.$siswa->nama.'<br />
'.$siswa->nisn;
			$record[] = $mapel->nama;
			$record[] = $gurumapel;
			$record[] = $rombel->nama;
			$record[] = $materi_ujian->name;
			$record[] = $temp->waktu;
			//$record[] = '<div class="text-center">'.status_label($user->login_status).'</div>';
			//$record[] = '<div class="text-center"><a href="'.site_url('admin/tools/reset/'.$temp->user_id).'" class="'.$tombol_reset.' btn btn-warning">Reset Login</a></div>';
			$output['aaData'][] = $record;
		$i++;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function reset($id = null){
		if($id){
			$id = $id;
		} else {
			$ids = $_POST['id'];
			foreach($ids as $sdi){
				$id[] = $sdi;
			}
		}
		$user = User::find($id);
		if(is_array($user)){
			foreach($user as $u){
				$u->login_status = 0;
				$u->save();
			}
		} else {
			$user->login_status = 0;
			$user->save();
		}
	}
	public function reset_ujian($id = null){
		if($id){
			$this->db->where('id', $id);
		} else {
			$ids = $_POST['id'];
			$this->db->where_in('id', $ids);
		}
		$data = array(
               'status' => 'inprogress',
			   'ulang' => 1
            );
		$this->db->update('user_exams', $data); 
	}
	public function rekap_nilai($id = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$siswa = Datasekolah::find($loggeduser->data_sekolah_id, array('include'=>array('datasiswa')));
		foreach($siswa->datasiswa as $user){
			$user_id[] = $user->id;
		}
		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}
		$user_id = implode(',',$user_id);
		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		if($id){
			$get_mapel = Category::find_all_by_data_rombel_id($id);
			foreach($get_mapel as $ambil_mapel){
				$id_mapel_get[] = $ambil_mapel->id;
			}
			$get_ujian = Exam::find('all', array('conditions' => array("category_id IN (?)",$id_mapel_get)));
			foreach($get_ujian as $gu){
				$id_ujian_get[] = $gu->id;
			}
			if(isset($id_ujian_get)){
				$id_ujian_get = implode(',',$id_ujian_get);
			} else {
				$id_ujian_get = 0;
			}
			$query = Nilai::find('all', array('conditions' => "data_siswa_id IN ($user_id) AND exam_id IN ($id_ujian_get) AND (data_siswa_id LIKE '%$search%' OR exam_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start, 'order'=>'id DESC'));
			$filter = Nilai::find('all', array('conditions' => "data_siswa_id IN ($user_id) AND exam_id IN ($id_ujian_get) AND (data_siswa_id LIKE '%$search%' OR exam_id LIKE '%$search%')", 'order'=>'id DESC'));
		} else {
			$query = Nilai::find('all', array('conditions' => "data_siswa_id IN ($user_id) AND (data_siswa_id LIKE '%$search%' OR exam_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start, 'order'=>'id DESC'));
			$filter = Nilai::find('all', array('conditions' => "data_siswa_id IN ($user_id) AND (data_siswa_id LIKE '%$search%' OR exam_id LIKE '%$search%')", 'order'=>'id DESC'));
		}
		$iFilteredTotal = count($query);		
		$iTotal=count($filter);
	    
		$output = array(
			"rombel_id" => $id,
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$siswa = Datasiswa::find($temp->data_siswa_id);
			if($siswa->jenis_kelamin == 'L'){
				if($siswa->photo)
					$foto = base_url().PROFILEPHOTOSTHUMBS.$siswa->photo;
				else
					$foto= base_url().'assets/img/no_avatar.jpg';
			} else {
				if($siswa->photo)
					$foto= base_url().PROFILEPHOTOSTHUMBS.$siswa->photo;
				else
					$foto= base_url().'assets/img/no_avatar_f.jpg';
			}
			$materi_ujian = Exam::find($temp->exam_id);
			$mapel = Category::find($materi_ujian->category_id);
			if($mapel->guru_id == 0){
				$guru = 0;
			} else {
				$guru = Dataguru::find($mapel->guru_id);
			}
			$gurumapel = ($guru != '0') ? $guru->nama: 'Guru Mapel Belum Dipilih';
			$rombel = Datarombel::find($mapel->data_rombel_id);
			$jumlah_soal = Exam::find($temp->exam_id);
			$hasil = ($temp->benar/$jumlah_soal->pass_mark) * 1000;
			$status = ($temp->point >= $jumlah_soal->pass_mark) ? '<span class="btn btn-sm btn-success">Lulus</span>' : '<span class="btn btn-sm btn-danger">Gagal</span>';
			$record = array();
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = '<img src="'.$foto.'" width="50" style="float:left; margin-right:10px;" /> '.$siswa->nama.'<br />
'.$siswa->nisn;
			$record[] = $mapel->nama;
			$record[] = $gurumapel;
			$record[] = '<div class="text-center">'.$rombel->nama.'</div>';
			$record[] = $materi_ujian->name;
			$record[] = '<div class="text-center">'.$jumlah_soal->questions.'</div>';
			$record[] = '<div class="text-center">'.$temp->terjawab.'</div>';
			$record[] = '<div class="text-center">'.$temp->benar.'</div>';
			$record[] = '<div class="text-center">'.$temp->salah.'</div>';
			$record[] = '<div class="text-center">'.$temp->point.'</div>';
			$record[] = '<div class="text-center">'.$status.'</div>';
			$output['aaData'][] = $record;
		$i++;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}	
	public function excel_rombel($ujian,$rombel,$ajaran_id){
		$exam = Exam::find($ujian);
		$mapel = Category::find($exam->category_id);
		$guru = Dataguru::find($mapel->guru_id);
		$get_rombel = Datarombel::find($rombel);
		$siswa = Datasiswa::find_all_by_data_rombel_id($rombel);
		$materi_ujian = strtoupper($exam->name);
		$nama_rombel = strtoupper($get_rombel->nama);
		$mata_pelajaran = strtoupper($mapel->nama);
		$pembimbing = strtoupper($guru->nama);
		$ajaran = Ajaran::find($ajaran_id);
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("CV. Cyber Education")
				->setLastModifiedBy("TOOS App")
				->setTitle("Analisis Soal")
				->setSubject("REKAP NILAI ".$materi_ujian)
				->setDescription("REKAP NILAI ".$materi_ujian.", generated by TOOS App Using PHPExcel.")
				->setKeywords("office 2007 openxml php")
				->setCategory("REKAP NILAI");
		$objPHPExcel->setActiveSheetIndex(0);
		// Rename sheet
		$myCustomWidth = 10;
		$objPHPExcel->getActiveSheet()->setTitle("REKAP NILAI");
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('0000000000');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth($myCustomWidth);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
		$objPHPExcel->getActiveSheet()->mergeCells('C7:C8');
		$objPHPExcel->getActiveSheet()->mergeCells('D7:D8');
		$objPHPExcel->getActiveSheet()->mergeCells('E7:E8');
		$objPHPExcel->getActiveSheet()->mergeCells('F7:F8');
		$objPHPExcel->getActiveSheet()->mergeCells('G7:G8');
		$objPHPExcel->getActiveSheet()->mergeCells('H7:H8');
		$objPHPExcel->getActiveSheet()->mergeCells('I7:I8');
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'REKAP NILAI '.$materi_ujian);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'KELAS '.$nama_rombel);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'MATA PELAJARAN '.$mata_pelajaran);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'GURU PEMBIMBING '.$pembimbing);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'TAHUN PELAJARAN '.$ajaran->tahun);
		$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'SEMESTER '.$ajaran->smt);
		$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'NOMOR');
		$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'URUT');
		$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B8', 'NISN');
		$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		$objPHPExcel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'NAMA SISWA');
		$objPHPExcel->getActiveSheet()->setCellValue('D7', 'JUMLAH SOAL');
		$objPHPExcel->getActiveSheet()->setCellValue('E7', 'SOAL TERJAWAB');
		$objPHPExcel->getActiveSheet()->setCellValue('F7', 'JAWABAN BENAR');
		$objPHPExcel->getActiveSheet()->setCellValue('G7', 'JAWABAN SALAH');
		$objPHPExcel->getActiveSheet()->setCellValue('H7', 'NILAI ASLI');
		$objPHPExcel->getActiveSheet()->setCellValue('I7', 'NILAI REVISI');
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->getFont()->setBold(true);
		$rowIterator = 9;
		$col = 1;			
		foreach($siswa as $s){
			if(strlen($s->nisn) == 10){
				$nisn = $s->nisn;
			} else {
				$nisn = '';
			}
			//$user = User::find_by_data_siswa_id($s->id);
			//$nilai = Nilai::find_by_data_siswa_id_and_exam_id($s->id,$exam->id);
			$nilai = Nilai::find('last', array('conditions' => array('data_siswa_id = ? AND exam_id = ?', $s->id,$exam->id)));
			if($nilai){
				$jumlah_soal	= $exam->questions;
				$terjawab		= $nilai->terjawab;
				$benar			= $nilai->benar;
				$salah			= $nilai->salah;
				$point 			= $nilai->point;
				$point_2 		= $nilai->point_2;
			}else{
				$jumlah_soal	= $exam->questions;
				$terjawab		= 0;
				$benar			= 0;
				$salah			= 0;
				$point 			= 0;
				$point_2 		= 0;
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowIterator, $col);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowIterator, $nisn);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowIterator, $s->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowIterator, $jumlah_soal);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowIterator, $terjawab);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowIterator, $benar);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowIterator, $salah);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$rowIterator, $point);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowIterator, $point_2);
		$col++;
		$rowIterator++;
		}
		$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '00000000'),
							),
						),
					);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I'.($rowIterator - 1))->applyFromArray($styleArray);
		$filename="REKAP NILAI UJIAN ".$materi_ujian." KELAS ".$nama_rombel.".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');
	}
	public function cetak_rombel($ujian,$rombel,$ajaran_id){
		$setting = Setting::first();
		$exam = Exam::find($ujian);
		$mapel = Category::find($exam->category_id);
		$guru = Dataguru::find($mapel->guru_id);
		$get_rombel = Datarombel::find($rombel);
		$siswa = Datasiswa::find_all_by_data_rombel_id($rombel);
		$materi_ujian = strtoupper($exam->name);
		$nama_rombel = strtoupper($get_rombel->nama);
		$mata_pelajaran = strtoupper($mapel->nama);
		$pembimbing = strtoupper($guru->nama);
		$data['ajaran'] = Ajaran::find($ajaran_id);
		$data['exam'] = $exam;
		$data['ujian'] = $materi_ujian;
		$data['siswa'] = $siswa;
		$data['mapel']	= $mata_pelajaran;
		$data['guru_mapel']	= $pembimbing;
		$data['nip_guru']	= $guru->nip;
		$this->template->title("REKAP NILAI UJIAN ".$materi_ujian." KELAS ".$nama_rombel)
        ->set_layout($this->cetak_tpl)
        ->build($this->guru_folder.'/cetak/rekap',$data);
	}
	public function cetak_siswa($mapel,$siswa,$ajaran_id){
		$setting = Setting::first();
		$mapel = Category::find($mapel);
		$siswa = Datasiswa::find($siswa);
		$rombel = Datarombel::find($mapel->data_rombel_id);
		$guru = Dataguru::find($mapel->guru_id);
		//print_r($rombel);
		$mata_pelajaran = strtoupper($mapel->nama);
		$pembimbing = strtoupper($guru->nama);
		$ajaran = Ajaran::find($ajaran_id);
		$tapel = strtoupper('tahun pelajaran '.$ajaran->tahun);
		if($ajaran->smt == 1){
			$semester = 'Semester Ganjil';
		} else {
			$semester = 'Semester Genap';
		}
		$smt = strtoupper('periode '.$semester);
		$user = User::find($siswa->user_id);
		$ujian = Exam::find_all_by_ajaran_id_and_category_id($ajaran_id,$mapel->id);
		if($ujian){
			foreach($ujian as $u){
				$exam_id[] = $u->id;
			}
		}
		//$nilai = Nilai::find_all_by_data_siswa_id($user->id);
		$nilai = Nilai::find('all', array('conditions' => array('exam_id in (?) AND data_siswa_id = ?', $exam_id,$siswa->id)));
		$data['tapel'] = $tapel;
		$data['smt'] = $smt;
		$data['siswa'] = strtoupper($siswa->nama);
		$data['nilai'] = $nilai;
		$data['mapel']	= $mata_pelajaran;
		$data['guru_mapel']	= $pembimbing;
		$data['nip_guru']	= $guru->nip;
		$this->template->title("REKAP NILAI MATA PELAJARAN ".$mata_pelajaran." ".$siswa->nama)
       	->set_layout($this->cetak_tpl)
       	->build($this->guru_folder.'/cetak/rekap_siswa',$data);
	}
	public function excel_siswa($mapel,$siswa,$ajaran_id){
		$mapel = Category::find($mapel);
		$guru = Dataguru::find($mapel->guru_id);
		$siswa = Datasiswa::find($siswa);
		$mata_pelajaran = strtoupper($mapel->nama);
		$pembimbing = strtoupper($guru->nama);
		$ajaran = Ajaran::find($ajaran_id);
		$tapel = strtoupper('tahun pelajaran '.$ajaran->tahun);
		if($ajaran->smt == 1){
			$semester = 'Semester Ganjil';
		} else {
			$semester = 'Semester Genap';
		}
		$smt = strtoupper('periode '.$semester);
		$user = User::find($siswa->user_id);
		$ujian = Exam::find_all_by_ajaran_id_and_category_id($ajaran_id,$mapel->id);
		if($ujian){
			foreach($ujian as $u){
				$exam_id[] = $u->id;
			}
		}
		//$nilai = Nilai::find_all_by_data_siswa_id($user->id);
		$nilai = Nilai::find('all', array('conditions' => array('exam_id in (?) AND data_siswa_id = ?', $exam_id,$siswa->id)));
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("CV. Cyber Education")
				->setLastModifiedBy("TOOS App")
				->setTitle("Analisis Soal")
				->setSubject("REKAP NILAI MATA PELAJARAN ".$mata_pelajaran)
				->setDescription("REKAP NILAI MATA PELAJARAN ".$mata_pelajaran.", generated by TOOS App Using PHPExcel.")
				->setKeywords("office 2007 openxml php")
				->setCategory("REKAP NILAI");
		$objPHPExcel->setActiveSheetIndex(0);
		$myCustomWidth = 10;
		$objPHPExcel->getActiveSheet()->setTitle("REKAP NILAI");
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'REKAP NILAI MATA PELAJARAN '.$mata_pelajaran);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'NAMA SISWA '.$siswa->nama);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A3', $smt);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', $tapel);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'NO.');
		$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B7', 'MATERI UJIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'MATA PELAJARAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D7', 'JUMLAH SOAL');
		$objPHPExcel->getActiveSheet()->setCellValue('E7', 'SOAL TERJAWAB');
		$objPHPExcel->getActiveSheet()->setCellValue('F7', 'JAWABAN BENAR');
		$objPHPExcel->getActiveSheet()->setCellValue('G7', 'JAWABAN SALAH');
		$objPHPExcel->getActiveSheet()->setCellValue('H7', 'NILAI ASLI');
		$objPHPExcel->getActiveSheet()->setCellValue('I7', 'NILAI REVISI');
		$objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->getFont()->setBold(true);
		$rowIterator = 8;
		$col = 1;			
		foreach($nilai as $n){
				$ujian = Exam::find($n->exam_id);
				$mapel = Category::find($ujian->category_id);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowIterator, $col);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowIterator, $ujian->name);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowIterator, $mapel->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowIterator, $ujian->questions);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowIterator, $n->terjawab);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowIterator, $n->benar);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowIterator, $n->salah);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$rowIterator, $n->point);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowIterator, $n->point_2);
		$col++;
		$rowIterator++;
		}
		$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '00000000'),
							),
						),
					);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I'.($rowIterator - 1))->applyFromArray($styleArray);
		$filename="REKAP NILAI MATA PELAJARAN ".$mata_pelajaran." ".$siswa->nama.".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');
	}
}