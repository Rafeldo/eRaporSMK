<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rombel extends Backend_Controller {
	protected $activemenu = 'referensi';
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}

	public function index(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$pilih_rombel = '<a href="'.site_url('admin/rombel/tambah_rombel').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data Rombongan Belajar</a>';
		$this->template->title('Administrator Panel : Data Rombongan Belajar')
        ->set_layout($this->admin_tpl)
        ->set('pilih_rombel', $pilih_rombel)
        ->set('page_title', 'Referensi Rombongan Belajar')
        ->build($this->admin_folder.'/rombel/list');
	}
	public function wali($id){
		if(isset($_POST['id'])){
			$guru_id = $_POST['id'];
			$find = Datarombel::find_by_guru_id($guru_id);
			if($find){
				$status['type'] = 'error';
				$status['text'] = 'Wali kelas terpilih terdeteksi telah menjabat wali kelas di rombel lain';
				$status['title'] = 'Gagal!';
			} else {
				$updatedata = array('guru_id'=>$guru_id);
				$this->db->where('id', $id);
				$this->db->update('data_rombels', $updatedata); 
				$status['type'] = 'success';
				$status['text'] = 'Wali kelas berhasil di perbaharui';
				$status['title'] = 'Data Tersimpan!';
			}
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Permintaan tidak bisa di proses. Silahkan ulangi lagi.';
			$status['title'] = 'Error';
		}
		echo json_encode($status);
	}
	public function tambah_rombel(){
		$this->form_validation->set_rules('data_sekolah_id', 'Sekolah ID', 'required|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama Rombel', 'required|xss_clean');
		$this->form_validation->set_rules('kurikulum_id', 'Kurikulum', 'xss_clean');
		$this->form_validation->set_rules('guru_id', 'Wali Kelas', 'required|xss_clean');
		$this->form_validation->set_rules('tingkat', 'Tingkat Pendidikan', 'required|xss_clean');
		$this->form_validation->set_rules('petugas', 'Petugas', 'required|xss_clean');
		if ($this->form_validation->run() == true){			
			$data = array(
				'data_sekolah_id'	=> $this->input->post('data_sekolah_id'),
				'nama'				=> $this->input->post('nama'),
				'kurikulum_id' 		=> $this->input->post('kurikulum_id'),
				'guru_id'    		=> $this->input->post('guru_id'),
				'tingkat'      		=> $this->input->post('tingkat'),
				'petugas'  			=> $this->input->post('petugas'),
			);
			$find = Datarombel::find_by_guru_id($data['guru_id']);
			if($find){
				$this->session->set_flashdata('error', 'Wali kelas terpilih terdeteksi telah menjabat wali kelas di rombel lain');
				redirect("admin/rombel/tambah");
			} else {
				$insert_data = Datarombel::create($data);
				if($insert_data){
					//check to see if we are creating the user
					//redirect them back to the admin page
					$this->session->set_flashdata('success', 'Data Rombongan Belajaran Berhasil ditambah');
					redirect("admin/rombel");
				} else {
					$message = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
					$this->session->set_flashdata('message', $message);
					redirect("admin/rombel/tambah");
				}
			}
		} else {
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$loggeduser = $this->ion_auth->user()->row();
			$this->data['guru_id'] = '';
			$this->data['tingkat'] = '';
			$this->data['kurikulum_id'] = '';
			$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'class' => "form-control required",
				'value' => $this->form_validation->set_value('nama'),
			);
			$this->data['gurus'] 	= Dataguru::find('all', array('order' => 'nama asc'));
			$this->data['keahlian'] = Keahlian::all();
			$this->template->title('Administrator Panel : Tambah Rombel')
	        ->set_layout($this->admin_tpl)
	        ->set('page_title', 'Data Rombel')
	        ->set('form_action', 'admin/rombel/tambah')
	        ->build($this->admin_folder.'/rombel/_rombel', $this->data);
			//->build($this->admin_folder.'/demo');
		}
	}
	public function edit($id){
		$rombel = Datarombel::find($id);
		//validate form input
		$this->form_validation->set_rules('nama', 'Nama Rombongan Belajar', 'required|xss_clean');
		$this->form_validation->set_rules('kurikulum_id', 'Kurikulum', 'xss_clean');
		$this->form_validation->set_rules('guru_id', 'Wali Kelas', 'xss_clean');
		$this->form_validation->set_rules('tingkat', 'Tingkat Pendidikan', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('data_sekolah_id', 'Sekolah ID', 'required|xss_clean');
		$this->form_validation->set_rules('petugas', 'Operator', 'required|xss_clean');
		if (isset($_POST) && !empty($_POST)){
			// do we have a valid request?
			if ($id != $this->input->post('id')){
				show_error('Aksi ini tidak memenuhi pemeriksaan keamanan kami');
			}
			if ($this->form_validation->run() === TRUE){
				$data = array(
					'nama' 				=> $this->input->post('nama'),
					'kurikulum_id'		=> $this->input->post('kurikulum_id'),
					'guru_id'    		=> $this->input->post('guru_id'),
					'tingkat'      		=> $this->input->post('tingkat'),
					'data_sekolah_id'   => $this->input->post('data_sekolah_id'),
					'petugas'      		=> $this->input->post('petugas')
				);
				$find = Datarombel::find_by_guru_id($data['guru_id']);
				if($find){
					$this->session->set_flashdata('error', "Wali kelas terpilih terdeteksi telah menjabat wali kelas di rombel lain");
				} else {
					$rombel->update_attributes($data);
					$this->session->set_flashdata('success', "Rombongan Belajar berhasil di edit");
				}
				redirect('admin/rombel');
			}
		}
		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		//pass the user to the view
		$loggeduser = $this->ion_auth->user()->row();
		$this->data['gurus'] 	= Dataguru::find('all', array('conditions'=>array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$this->data['rombel'] = $rombel;
		$this->data['guru_id'] = $rombel->guru_id;
		$this->data['tingkat'] = $rombel->tingkat;
		$this->data['kurikulum_id'] = $rombel->kurikulum_id;
		$this->data['keahlian'] = Keahlian::all();
		$this->data['nama'] = array(
			'name'  => 'nama',
			'id'    => 'nama',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('nama', $rombel->nama),
		);
		if($this->ion_auth->in_group('admin')){
			$layout = $this->admin_tpl;
		} elseif($this->ion_auth->in_group('guru')){
			$layout = $this->guru_tpl;
		}
		$this->template->title('Administrator Panel : Edit Rombongan Belajar')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Edit Rombongan Belajar')
		->build($this->admin_folder.'/rombel/_rombel', $this->data);
		//->build($this->admin_folder.'/demo');

	}

	public function view($id){
		$rombel = Datarombel::find($id);
		$this->template->title('Administrator Panel : Detil Guru')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Detil Guru')
	        ->set('rombel', $rombel)
			->set('modal_footer', '')			
	        ->build($this->admin_folder.'/rombel/view');
	}
	public function multidelete(){
		$ids = $_POST['id'];
		$super_admin = array(1,2);
		if($this->ion_auth->in_group($super_admin)){
			$data = Datarombel::find($ids);
			if(is_array($data)){
				foreach($data as $d){
					$d->delete();
				}
			} else {
			$data->delete();
			}
			$status['type'] = 'success';
			$status['text'] = 'Data Rombel berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data Rombel tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
	public function delete($id){
		$super_admin = array(1,2);
		if($this->ion_auth->in_group($super_admin)){
			$data = Datarombel::find($id);
			$data->delete();
			$status['type'] = 'success';
			$status['text'] = 'Data Siswa berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data Siswa tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
	public function _get_csrf_nonce(){
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function deactivate($id = NULL){
		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE) {
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->template->title('Administrator Panel : Deactivate user')
	        ->set_layout('modal_tpl')
	        ->set_partial('styles', 'backend/partials/css')
	        ->set_partial('header', 'backend/partials/header')
	        ->set_partial('sidebar', 'backend/partials/sidebar')
	        ->set_partial('footer', 'backend/partials/footer')
	        ->set('page_title',  'Deactivate User' )
			->set('modal_footer', '')
	        ->build('auth/deactivate_user', $this->data);
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes') {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}
				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
					$this->session->set_flashdata('success', $this->ion_auth->messages());
				}
			}
			//redirect them back to the auth page
			redirect('admin/guru');
		}
	}

	//activate the user
	function activate($id)
	{

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('success', $this->ion_auth->messages());
			redirect("admin/guru");
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("admin/guru");
		}
	}
/*-----------------------------------------------------------------------------------------------------------------------
	function to upload user photos
-------------------------------------------------------------------------------------------------------------------------*/
	public function upload_photo($fieldname) {
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = PROFILEPHOTOS;
		// set the filter image types
		$config['allowed_types'] = 'png|gif|jpeg|jpg';
		//$config['max_width'] = '500'; 
		$this->load->helper('string');
		$config['file_name']	 = random_string('alnum', 32);
		//load the upload library
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
	
		//if not successful, set the error message
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('success' => false, 'msg' => $this->upload->display_errors());
		} else { 
			$upload_details = $this->upload->data(); //uploading
			$config1 = array(
			      'source_image' => $upload_details['full_path'], //get original image
			      'new_image' => PROFILEPHOTOSTHUMBS, //save as new image //need to create thumbs first
			      'maintain_ratio' => true,
			      'width' => 250,
			      'height' => 250
			    );
		    $this->load->library('image_lib', $config1); //load library
		    $this->image_lib->resize(); //generating thumb
			$data = array('success' => true, 'upload_data' => $upload_details, 'msg' => "Upload success!");
		}
		return $data;
	}
	public function proses_kenaikan(){
		$id_rombel = $_POST['id_rombel'];
		$rombel = Datarombel::find($id_rombel);
		$id_siswa = $_POST['id_siswa'];
		$siswa = Datasiswa::find($id_siswa);
		if(is_array($siswa)){
			foreach($siswa as $s){
				$s->data_rombel_id = $id_rombel;
				$s->save();
			}
		} else {
			$siswa->data_rombel_id = $id_rombel;
			$siswa->save();
		}
		if($rombel->tingkat == 13){
			$users = User::find_by_data_siswa_id($id_siswa);
			if(is_array($users)){
				foreach($users as $user){
					$user->active = 0;
					$user->save();
				}
			} else {
				$users->active = 0;
				$users->save();
			}
		}
		$output = array(
					'title' 	=> 'Sukses',
					'text'		=> 'Proses kenaikan kelas berhasil',
					'type'		=> 'success',
					'status'	=> 1
						);
		echo json_encode($output);
	}
	public function proses_lanjutkan(){
		$id_rombel = $_POST['id_rombel'];
		$id_siswa = $_POST['id_siswa'];
		$ajaran = get_ta();
		$get_next_smt = Ajaran::find_by_tahun_and_smt($ajaran->tahun,2);
		if($get_next_smt){
			foreach($id_siswa as $s){
				$attributes = array('ajaran_id' => $get_next_smt->id, 'rombel_id' => $id_rombel, 'siswa_id' => $s);
				$anggota = Anggotarombel::create($attributes);
			}
		} else {
			$data_ajarans = array(
				'tahun'				=> $ajaran->tahun,
				'smt' 				=> 2,
				'created_at' 		=> date('Y-m-d H:i:s'),
				'updated_at' 		=> date('Y-m-d H:i:s')
			);
			$new_ajaran = Ajaran::create($data_ajarans);
			foreach($id_siswa as $s){
				$attributes = array('ajaran_id' => $new_ajaran->id, 'rombel_id' => $id_rombel, 'siswa_id' => $s);
				$anggota = Anggotarombel::create($attributes);
			}
		}
		$output = array(
			'title' 	=> 'Sukses',
			'text'		=> 'Proses lanjutkan semester berhasil',
			'type'		=> 'success',
			'status'	=> 1
		);
		echo json_encode($output);
	}
	public function kenaikan($id_rombel){
		$loggeduser = $this->ion_auth->user()->row();
		$find_rombel = Datarombel::find($id_rombel);
		//$anggota = Datasiswa::find('all', array('conditions' => array('data_rombel_id =?', $id_rombel)));
		$anggota 	= Anggotarombel::find('all', array('conditions' => array('rombel_id =?', $id_rombel)));
		$data_rombel = Datarombel::all(array('conditions' => array('tingkat = ? AND kurikulum_id = ?', ($find_rombel->tingkat+1), $find_rombel->kurikulum_id)));
		$this->template->title('Administrator Panel : Proses Kenaikan Kelas')
        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Proses Kenaikan Kelas')
			->set('data_rombel', $data_rombel)
	        ->set('anggota', $anggota)
			->set('modal_footer', '<div class="text-center"><a href="javascript:void(0)" class="btn btn-success btn-sm proses_kenaikan"><i class="fa fa-plus-circle"></i> Simpan</a></div>')
	        ->build($this->admin_folder.'/rombel/kenaikan');
	}
	public function lanjutkan($id_rombel){
		$ajaran = get_ta();
		$get_next_smt = Ajaran::find_by_tahun_and_smt($ajaran->tahun,2);
		if($get_next_smt){
			$anggota_next_smt 	= Anggotarombel::find('all', array('conditions' => array('ajaran_id = ? AND rombel_id = ?', $get_next_smt->id, $id_rombel)));
			if($anggota_next_smt){
				foreach($anggota_next_smt as $ans){
					$id_next_smt[] = $ans->siswa_id;
				}
			}
		}
		$id_next_smt = isset($id_next_smt) ? $id_next_smt : 0;
		$anggota 	= Anggotarombel::find('all', array('conditions' => array('ajaran_id = ? AND rombel_id = ? AND siswa_id NOT IN (?)', $ajaran->id, $id_rombel, $id_next_smt)));
		$this->template->title('Administrator Panel : Proses Kenaikan Kelas')
        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Proses Kenaikan Kelas')
	        ->set('anggota', $anggota)
			->set('rombel_id', $id_rombel)
			->set('modal_footer', '<div class="text-center"><a href="javascript:void(0)" class="btn btn-success btn-sm proses_kenaikan"><i class="fa fa-plus-circle"></i> Simpan</a></div>')
	        ->build($this->admin_folder.'/rombel/lanjutkan');
	}
    public function list_rombel($kompetensi = NULL, $tingkat = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$search = "";
		$start = 0;
		$rows = 25;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		if($kompetensi && !$tingkat){
			$query = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND kurikulum_id = $kompetensi AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND kurikulum_id = $kompetensi AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')"));
		} elseif($kompetensi && $tingkat){
			$query = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND tingkat = $tingkat AND kurikulum_id = $kompetensi AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND tingkat = $tingkat AND kurikulum_id = $kompetensi AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')"));
		} else {
			$query = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Datarombel::find('all', array('include'=>array('datasiswa'), 'conditions' => "id IS NOT NULL AND (nama LIKE '%$search%' OR kurikulum_id LIKE '%$search%' OR tingkat LIKE '%$search%' OR id LIKE '%$search%')"));
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
			$class = 'btn-danger';
			$text = 'Salin Pembelajaran';
			$link = 'salin_pembelajaran';
			$kurikulum = Kurikulum::find_by_ajaran_id_and_rombel_id($ajaran->id, $temp->id);
			if($kurikulum){
				$class = 'btn-success';
				$text = 'Pembelajaran';
				$link = 'pembelajaran';
			}
			$walikelas = (get_wali_kelas($temp->id) != '-') ? get_wali_kelas($temp->id).'<a href="'.site_url('admin/guru/select/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal pull-right"><i class="fa fa-search-plus"></i> Ganti Wali Kelas</a>': '<a href="'.site_url('admin/guru/select/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-search-plus"></i> Pilih Wali Kelas</a>';
			$record = array();
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $temp->nama;
			$record[] = $walikelas;
			$record[] = '<div class="text-center">'.$temp->tingkat.'</div>';
			if($temp->kurikulum_id){
				if($ajaran->smt == 2){
					$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/'.$link.'/'.$temp->id).'" class="btn '.$class.' btn-sm toggle-modal"><i class="fa fa-search-plus"></i> '.$text.'</a></div>';
				} else {
					$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/'.$link.'/'.$temp->id).'" class="btn '.$class.' btn-sm toggle-modal"><i class="fa fa-search-plus"></i> '.$text.'</a></div>';
				}
			} else {
				$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/jurusan/'.$temp->id).'" class="btn btn-primary btn-sm confirm_input"><i class="fa fa-search-plus"></i> Jurusan</a></div>';
			}
			$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/anggota/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-search-plus"></i> Anggota Rombel</a></div>';
			if($ajaran->smt == 2){
				$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/kenaikan/'.$temp->id).'" class="btn btn-info btn-sm toggle-modal"><i class="fa fa-level-up"></i> Proses Kenaikan</a></div>';
			} else {
				$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/lanjutkan/'.$temp->id).'" class="btn btn-info btn-sm toggle-modal"><i class="fa fa-level-up"></i> Lanjutkan Semester</a></div>';
			}			
			$record[] = '<div class="text-center"><a href="'.site_url('admin/rombel/edit/'.$temp->id).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a></div>';
			//$record[] = $nama_jurusan;
			//$record[] = '<div class="text-center">'.$jumlahsiswa.'</div>';
			/*$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="'.site_url('admin/rombel/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
								<li><a href="'.site_url('admin/rombel/edit/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								<li><a href="'.site_url('admin/rombel/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
								<li><a href="'.site_url('admin/rombel/kenaikan/'.$temp->id).'" class="toggle-modal"><i class="fa fa-level-up"></i>Proses Kenaikan</a></li>
                            </ul>
                        </div></div>';*/
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function jurusan($id){
		if(isset($_POST['nama'])){
			$nama = $_POST['nama'];
			$updatedata = array('kurikulum_id'=>$nama);
			$this->db->where('id', $id);
			$this->db->update('data_rombels', $updatedata); 
			echo 'sukses';
		} else {
			$keahlian = Keahlian::all();
			if($keahlian){
				foreach($keahlian as $ahli){
					$data_kurikulum = Datakurikulum::find_by_kurikulum_id($ahli->kurikulum_id);
					$output[$data_kurikulum->kurikulum_id] 	= $data_kurikulum->nama_kurikulum;
				}
			} else {
				$output[''] = 'Kompetensi Keahlian tidak ditemukan.';
			}
		echo json_encode($output);
		}
	}	
	public function pembelajaran($id){
		$ajaran = get_ta();
		$rombel = Datarombel::find($id);
		$kurikulum = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
		if($kurikulum){
			if (strpos($kurikulum->nama_kurikulum, 'SMK 2013') !== false) {
				$file = 'pembelajaran_2013';
			} else {
				$file = 'pembelajaran_ktsp';
			}
			$this->template->title('')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Referensi Pembelajaran Rombongan Belajar '.$rombel->nama)
			->set('data_rombel', $rombel)
			->set('ajaran_id', $ajaran->id)
			->set('modal_footer', '<a href="javascript:void(0)" class="btn btn-success btn-sm simpan_pembelajaran"><i class="fa fa-plus-circle"></i> Simpan</a>')			
			->build($this->admin_folder.'/rombel/'.$file);
		} else {
			redirect('admin/dashboard');
		}
	}
	public function salin_pembelajaran($id){
		$ajaran = get_ta();
		$get_prev_smt = Ajaran::find_by_tahun_and_smt($ajaran->tahun,1);
		$get_prev_smt_id = isset($get_prev_smt->id) ? $get_prev_smt->id : 0;
		$rombel = Datarombel::find($id);
		$kurikulum = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
		if($kurikulum){
			if (strpos($kurikulum->nama_kurikulum, 'SMK 2013') !== false) {
				$file = 'pembelajaran_2013';
			} else {
				$file = 'pembelajaran_ktsp';
			}
			$this->template->title('')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Referensi Pembelajaran Rombongan Belajar '.$rombel->nama)
			->set('data_rombel', $rombel)
			->set('ajaran_id', $get_prev_smt_id)
			->set('modal_footer', '<a href="javascript:void(0)" class="btn btn-success btn-sm simpan_pembelajaran"><i class="fa fa-plus-circle"></i> Simpan</a>')			
			->build($this->admin_folder.'/rombel/'.$file);
		} else {
			redirect('admin/dashboard');
		}
	}
	public function anggota($id_rombel){
		$ajaran = get_ta();
		$free		= Datasiswa::find('all', array('conditions' => array('data_rombel_id =?', 0)));	
		$anggota 	= Anggotarombel::find('all', array('conditions' => array('ajaran_id = ? AND rombel_id = ?', $ajaran->id, $id_rombel)));
		$this->template->title('Administrator Panel : Pilih Anggota Rombel')
        ->set_layout($this->modal_tpl)
		->set('page_title', 'Pilih Anggota Rombel')
		->set('anggota', $anggota)
		->set('free', $free)
		->set('id_rombel', $id_rombel)
		//->set('modal_footer', '<div class="text-center"><a href="javascript:void(0)" class="btn btn-success btn-sm simpan_anggota"><i class="fa fa-plus-circle"></i> Simpan</a></div>')
		->build($this->admin_folder.'/rombel/anggota');
	}
	public function simpan_guru_mapel(){
	}
	public function simpan_anggota(){
		$rombel_id 	= $_POST['rombel_id'];
		$siswa_id	= $_POST['siswa_id'];
		$ajaran = get_ta();
		$data_siswa = Datasiswa::find_by_id($siswa_id);
		$find = Anggotarombel::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id, $rombel_id, $siswa_id);
		if($find){
			$data_siswa->update_attributes(array('data_rombel_id' => $rombel_id));
			$status['type'] = 'warning';
			$status['text'] = 'Berhasil mengupdate anggota rombel';
			$status['title'] = 'Data Tersimpan!';
		} else {
			$data_siswa->update_attributes(array('data_rombel_id' => $rombel_id));
			$new_data				= new Anggotarombel();
			$new_data->ajaran_id	= $ajaran->id;
			$new_data->rombel_id	= $rombel_id;
			$new_data->siswa_id		= $siswa_id;
			$new_data->save();
			$status['type'] = 'success';
			$status['text'] = 'Berhasil menambah anggota rombel';
			$status['title'] = 'Data Tersimpan!';
		}
		echo json_encode($status);
	}
	public function hapus_anggota(){
		$rombel_id 	= $_POST['rombel_id'];
		$siswa_id	= $_POST['siswa_id'];
		$ajaran = get_ta();
		$data_siswa = Datasiswa::find_by_id($siswa_id);
		$find = Anggotarombel::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id, $rombel_id, $siswa_id);
		if($find){
			$data_siswa->update_attributes(array('data_rombel_id' => 0));
			$find->delete();
			$status['type'] = 'error';
			$status['text'] = 'Berhasil menghapus anggota rombel';
			$status['title'] = 'Data Tersimpan!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data anggota rombel tidak ditemukan';
			$status['title'] = 'Data Tersimpan!';
		}
		echo json_encode($status);
	}
	public function simpan_pembelajaran(){
		$ajaran = get_ta();
		$query = $_POST['query'];
		$rombel_id = $_POST['rombel_id'];
		$mapel_id = $_POST['mapel_id'];
		$data_mapel = Datamapel::find_by_id_mapel($mapel_id);
		$guru_id = isset($_POST['guru_id']) ? $_POST['guru_id'] : '0';//$_POST['guru_id'];
		$id_mulok = isset($_POST['id_mulok']) ? $_POST['id_mulok'] : '0';//$_POST['guru_id'];
		$nama_mapel_alias = isset($_POST['nama_mapel_alias']) ? $_POST['nama_mapel_alias'] : '';//$_POST['guru_id'];
		$kurikulum_costum = isset($_POST['kurikulum_costum']) ? $_POST['kurikulum_costum'] : '';//$_POST['guru_id'];
		$keahlian_id = isset($_POST['keahlian_id']) ? $_POST['keahlian_id'] : '';//$_POST['guru_id'];
		$data_kurikulum = array(
			'ajaran_id'			=> $ajaran->id,
			'rombel_id'			=> $rombel_id,
			'id_mapel'			=> $mapel_id,
			'nama_mapel_alias' 	=> $nama_mapel_alias,
			'guru_id'			=> $guru_id,
			'keahlian_id'		=> $keahlian_id
		);
		$data_kurikulum_update = array(
			'id_mapel' => $mapel_id,
			'guru_id' => $guru_id,
			'nama_mapel_alias' => $nama_mapel_alias,
			'keahlian_id' => $keahlian_id
		);
		$data_kurikulum_alias = array(
			'ajaran_id'	=> $ajaran->id,
			'rombel_id'	=> $rombel_id,
			'id_mapel'	=> $mapel_id,
			'guru_id'	=> $guru_id,
			'nama_kur'	=> $query
		);
		$data_kurikulum_alias_update = array(
			'id_mapel'	=> $mapel_id,
			'guru_id'	=> $guru_id,
		);
		if($query == 'kurikulum'){
			$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran->id,$rombel_id,$mapel_id);
			if($find){
				if($find->guru_id == 0){
					$find->delete();
				} else {
					$find->update_attributes($data_kurikulum_update);
				}
				$status['type'] = 'warning';
				$status['text'] = 'Berhasil mengupdate pembelajaran';
				$status['title'] = 'Data Tersimpan!';
			} else {
				if($guru_id !=0){
					$new_data				= new Kurikulum();
					$new_data->ajaran_id	= $ajaran->id;
					$new_data->rombel_id	= $rombel_id;
					$new_data->id_mapel		= $mapel_id;
					$new_data->guru_id		= $guru_id;
					$new_data->keahlian_id	= $keahlian_id;
					$new_data->save();
					$status['type'] = 'success';
					$status['text'] = 'Berhasil menambah pembelajaran';
					$status['title'] = 'Data Tersimpan!';
				} else {
					$nama_mapel = isset($data_mapel->nama_mapel) ? $data_mapel->nama_mapel : $mapel_id;
					$status['type'] = 'info';
					$status['text'] = 'Guru tidak dipilih untuk mata pelajaran '.$nama_mapel;
					$status['title'] = 'Data dilewati!';
				}
			}
		} else {
			$find = Kurikulumalias::find_by_id($mapel_id);
			if($find && $guru_id == 0){
				$find->delete();
				$status['type'] = 'error';
				$status['text'] = 'Pembelajaran '.$mapel_id.' dihapus';
				$status['title'] = 'Data Terhapus!';
			} elseif($find && $guru_id !=0){
				$find->update_attributes($data_kurikulum_alias_update);
				$status['type'] = 'warning';
				$status['text'] = 'Berhasil mengupdate pembelajaran';
				$status['title'] = 'Data Tersimpan!';
			} else {
				if($guru_id != 0) {
					$new_data = Kurikulumalias::create($data_kurikulum_alias);
					$data_kurikulum = array(
						'ajaran_id'			=> $ajaran->id,
						'rombel_id'			=> $rombel_id,
						'id_mapel'			=> $new_data->id,
						'nama_mapel_alias' 	=> $mapel_id,
						'guru_id'			=> $guru_id,
						'keahlian_id'		=> $keahlian_id
					);
					$new_data_kurikulum	= Kurikulum::create($data_kurikulum);
					$status['type'] = 'success';
					$status['text'] = 'Berhasil menambah pembelajaran '.$mapel_id;
					$status['title'] = 'Data Tersimpan!';
				} else {
					$status['type'] = 'info';
					$status['text'] = 'Guru tidak dipilih untuk mata pelajaran '.$mapel_id;
					$status['title'] = 'Data dilewati!';
				}
			}
		}
		echo json_encode($status);
	}
	public function guru(){
		$data_guru = Dataguru::find('all', array('order' => 'nama asc'));
		foreach($data_guru as $guru){
			$status = array();
			$status['id'] = $guru->id;
			$status['text'] = $guru->nama;
			$output[] = $status;
		}
		echo json_encode($output);
	}
}