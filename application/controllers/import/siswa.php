<?php
class Siswa extends Backend_Controller {
	function __construct()  {
         parent::__construct();
            $this->load->library('excel');
			$this->load->library('ion_auth');
			$this->load->model('ion_auth_model');
			$this->load->library('custom_fuction');
			$this->load->library('session');
    }
	public function index(){
		$ajaran = get_ta();
		$loggeduser = $this->ion_auth->user()->row();
		$sekolah = Datasekolah::find($loggeduser->data_sekolah_id);
		$status=array();
		$importdata = $_REQUEST['data'];
		$jumlah_siswa = Datasiswa::all();
		$jumlah_siswa = count($jumlah_siswa);
		if($sekolah->npsn == '12345678' && $jumlah_siswa >= 20){
			$status['type'] = 'error';
			$status['text'] = 'Maksimal import siswa adalah 20 siswa. Silahkan membeli lisensi resmi untuk pemakaian full fitur.';
			$status['title'] = 'Import Data Gagal!';
			echo json_encode($status);
			exit();
		}
		$date   = new DateTime;
		$fileName = $_FILES['import']['name'];
		$config['upload_path'] = './assets/files/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx';
		$config['overwrite'] = TRUE;
		$this->load->library('upload');
        $this->upload->initialize($config);
		if(!$this->upload->do_upload('import')){
			$status['type'] = 'error';
			$status['text'] = $this->upload->display_errors();
			$status['title'] = 'Import Data Gagal!';
			echo json_encode($status);
			exit();
		}
		$media = $this->upload->data('import');
		$inputFileName = './assets/files/'.$media['file_name'];
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		}
		$nrColumns = ord($highestColumn) - 64;
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$status['highestColumn'] = $highestColumn;
		$status['highestRow'] = $highestRow;
		$status['sheet'] = $sheet;
		$status['nrColumns'] = $nrColumns;
		if($highestColumn == 'AD') { // Import data siswa
			$row = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			foreach ($cellIterator as $k=>$cell) {
				$key[] = $cell->getValue();
			}
			for ($row = 2; $row <= $highestRow; ++ $row) {
				$val = array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[] = $cell->getValue();
				}
				$i=0;
				foreach($val as $k=>$v){
					$InsertData[] = array(
						"$key[$i]"=> $v
						);
					$i++;
				}
				$flat = call_user_func_array('array_merge', $InsertData);
				$data_sekolah_id = array("data_sekolah_id"=>$loggeduser->data_sekolah_id);
				$active = array("active"=> 1);
				$photo = array("photo"=>'');
				$password	= array("password"=>12345678);
				$petugas = array("petugas"=> $loggeduser->username);
				$data_rombel_id = array("data_rombel_id"=> $importdata);
				$masukkan[] = array_merge($data_sekolah_id,$flat,$data_rombel_id,$active,$photo,$password,$petugas);
			}
			$jumlah_data_import = count($masukkan);
			$sum=0;
			$data_sudah_ada = array();
			$gagal_insert_user = array();
		foreach($masukkan as $k=>$v){
			$a = Datasiswa::all(array('conditions' => array('nisn = ? AND nama = ?', $v['nisn'], $v['nama'])));
			$sum+=count($a);
			if(!$a){
				$GenerateNISN = $this->custom_fuction->GenerateNISN();
				if($v['nisn'] == ''){
					$v['nisn'] = $GenerateNISN;
				} else {
					$v['nisn'] = $v['nisn'];
				}
				$username 	= $v['nama'];
				$password 	= $v['password'];
				$email		= ($v['email'] ? $v['email'] : $this->custom_fuction->GenerateEmail().'@cybereducation.co.id');
				$additional_data = array(
					"data_sekolah_id"=> $v['data_sekolah_id'],
					"nisn"=> $v['nisn'],
				);
				$group = array('4');
				$user_id = $this->ion_auth->register($username, $password, $email, $additional_data,$group);
				if($user_id){
					$id_siswa = array('user_id'=>$user_id,'data_sekolah_id'=>$loggeduser->data_sekolah_id);
					$insert_siswa = $v;
					unset($insert_siswa['rombel']);
					unset($insert_siswa['tingkat']);
					$insert_siswa = array_merge($id_siswa,$insert_siswa);
					$datasiswa = Datasiswa::create($insert_siswa);
					$rombel = Datarombel::find_all_by_tingkat_and_nama($v['tingkat'],$v['rombel']);
					if($rombel){
						foreach($rombel as $r){
							$updaterombel = array('data_rombel_id'=>$r->id);
							$this->db->where('id', $datasiswa->id);
							$this->db->update('data_siswas', $updaterombel); 
							$attributes = array('ajaran_id' => $ajaran->id, 'rombel_id' => $r->id, 'siswa_id' => $datasiswa->id);
							$anggota = Anggotarombel::create($attributes);
						}
					} else {
						$datarombelbawah = Datarombel::create(array('data_sekolah_id'=>$loggeduser->data_sekolah_id,'petugas'=>$loggeduser->username,'tingkat'=>$v['tingkat'],'kurikulum_id'=>0,'nama'=>$v['rombel']));
						$updaterombel = array('data_rombel_id'=>$datarombelbawah->id);
						$this->db->where('id', $datasiswa->id);
						$this->db->update('data_siswas', $updaterombel); 
						$attributes = array('ajaran_id' => $ajaran->id, 'rombel_id' => $datarombelbawah->id, 'siswa_id' => $datasiswa->id);
						$anggota = Anggotarombel::create($attributes);
					}
					$updatedata = array('data_siswa_id'=>$datasiswa->id);
					$this->db->where('id', $user_id);
					$this->db->update('users', $updatedata);
				} else {
					$gagal_insert_user[] .= (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				}
			} else {
				$data_sudah_ada[] .= 'Data sudah ada';
			}
		}
		$jml_gagal_insert_user = count($gagal_insert_user);
		$jml_data_sudah_ada = count($data_sudah_ada);
		$kolom = ($highestRow - 1);
		$disimpan = ($kolom - $sum) - $jml_gagal_insert_user;
		$ditolak = ($kolom - $jml_data_sudah_ada);
		if (array_key_exists(0, $gagal_insert_user)) {
			$status_gagal_insert_user = $gagal_insert_user[0];
		} else {
			$status_gagal_insert_user = '';
		}
		$status['text']	= '<table width="100%" class="table">
				<tr>
					<td class="text-center">Jumlah Data</td>
					<td class="text-center">Status</td>
				</tr>
				<tr>
					<td>'.$disimpan.'</td>
					<td>Data sukses disimpan</td>
				<tr>
					<td>'.$jml_data_sudah_ada.'</td>
					<td>Data sudah ada</td>
				</tr>
				<tr>
					<td>'.$jml_gagal_insert_user.'</td>
					<td>Gagal<br />'.$status_gagal_insert_user.'</td>
				</tr>
				</table>';
		$status['type'] = 'success';
		$status['title'] = 'Import Data Sukses!';
	} else {
		$status['type'] = 'error';
		$status['text'] = 'Format Import tidak sesuai. Silahkan download template yang telah disediakan.';
		$status['title'] = 'Import Data Gagal!';
	}
	unlink($inputFileName);
	echo json_encode($status);
	}
}