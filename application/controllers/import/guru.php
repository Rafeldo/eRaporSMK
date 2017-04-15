<?php
class Guru extends Backend_Controller {
	function __construct()  {
         parent::__construct();
            $this->load->library('excel');
			$this->load->library('ion_auth');
			$this->load->model('ion_auth_model');
			$this->load->library('custom_fuction');
			$this->load->library('session');
    }
	public function index(){
		$loggeduser = $this->ion_auth->user()->row();
		$sekolah = Datasekolah::find($loggeduser->data_sekolah_id);
		$jumlah_guru = Dataguru::all();
		$jumlah_guru = count($jumlah_guru);
		$status=array();
		$importdata = $_REQUEST['data'];
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
		if($highestColumn == 'R') { // Import data guru
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
				$masukkan[] = array_merge($flat,$data_sekolah_id,$active,$photo,$password,$petugas);
			}
			$jumlah_data_import = count($masukkan);
			$sum=0;
			$data_sudah_ada = array();
			$gagal_insert_user = array();
		foreach($masukkan as $k=>$v){
		if($v['nuptk'] == ''){
			$a = Dataguru::all(array('conditions' => array('nama = ? AND tanggal_lahir = ?', $v['nama'], $v['tanggal_lahir'])));
		} else {
			$a = Dataguru::all(array('conditions' => array('nuptk = ? AND nama = ?', $v['nuptk'], $v['nama'])));
		}
			$sum+=count($a);
			if(!$a){
				$GenerateNUPTK = $this->custom_fuction->GenerateID();
				if($v['nuptk'] == ''){
					$v['nuptk'] = $GenerateNUPTK;
				} else {
					$v['nuptk'] = $v['nuptk'];
				}
				$username 	= $v['nama'];
				$password 	= $v['password'];
				$email		= ($v['email'] ? $v['email'] : $this->custom_fuction->GenerateEmail().'@cybereducation.co.id');
				$additional_data = array(
					"data_sekolah_id"=> $v['data_sekolah_id'],
					"nuptk"=> $v['nuptk'],
				);
				$group = array('3');
				$user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group);
				if($user_id){
					$id_guru = array('user_id'=>$user_id,'data_sekolah_id'=>$loggeduser->data_sekolah_id,'email'=>$email);
					$insert_guru = array_merge($id_guru,$v);
					$dataguru = Dataguru::create($insert_guru);
					$updatedata = array('data_guru_id'=>$dataguru->id);
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