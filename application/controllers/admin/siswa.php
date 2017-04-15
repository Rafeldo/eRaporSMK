<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends Backend_Controller {
	protected $activemenu = 'referensi'; 
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->library('custom_fuction');
		$this->template->set('activemenu', $this->activemenu);
		//$this->load->model('data_model');
	}

	public function index(){
		$super_admin = array(1,2);
		$pilih_rombel = '';
		if($this->ion_auth->in_group($super_admin)){
			$pilih_rombel .= '<a href="'.site_url('admin/siswa/tambah_siswa').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data Siswa</a>';
		}
		$this->template->title('Administrator Panel : Data Siswa')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Referensi Data Siswa')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/siswa/list');
	}
	public function tambah_siswa(){
		//validate form input
		$tables = $this->config->item('tables','ion_auth');
		$this->form_validation->set_rules('rombel_id', 'Rombongan Belajar', 'required|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama', 'required|xss_clean');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|xss_clean');
		$this->form_validation->set_rules('nisn', 'NISN', 'xss_clean');
		$this->form_validation->set_rules('no_induk', 'no_induk', 'xss_clean');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|xss_clean');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|xss_clean');
		$this->form_validation->set_rules('agama', 'Agama', 'required|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat Jalan', 'xss_clean');
		$this->form_validation->set_rules('rt', 'RT', 'xss_clean');
		$this->form_validation->set_rules('rw', 'RW', 'xss_clean');
		$this->form_validation->set_rules('desa_kelurahan', 'Desa Kelurahan', 'xss_clean');
		$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'xss_clean');
		$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'numeric|xss_clean');
		$this->form_validation->set_rules('no_telp', 'Nomor Handphone', 'numeric|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|xss_clean');
		$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');

		if ($this->form_validation->run() == true){
			$nisn					= $this->input->post('nisn');
			$email					= strtolower($this->input->post('email'));
			if($nisn == ''){
				$nisn 				= $this->custom_fuction->GenerateNISN();
			}
			if($email == ''){
				$email = $this->custom_fuction->GenerateEmail().'@erapor-smk.net';
			}
			$data = array(
				'data_sekolah_id'		=> $this->input->post('data_sekolah_id'),
				'data_rombel_id'		=> $this->input->post('rombel_id'),
				'nama' 					=> $this->input->post('nama'),
				'no_induk' 				=> $this->input->post('no_induk'),
				'nisn'    				=> $nisn,
				'jenis_kelamin'  		=> $this->input->post('jenis_kelamin'),
				'tempat_lahir'      	=> $this->input->post('tempat_lahir'),
				'tanggal_lahir'      	=> date('Y-m-d', strtotime($this->input->post('tanggal_lahir'))),
				'agama'		    		=> $this->input->post('agama'),
				'status'		      	=> $this->input->post('status'),
				'anak_ke'		      	=> $this->input->post('anak_ke'),
				'alamat'		      	=> $this->input->post('alamat'),
				'rt'      				=> $this->input->post('rt'),
				'rw'      				=> $this->input->post('rw'),
				'desa_kelurahan'      	=> $this->input->post('desa_kelurahan'),
				'kecamatan'				=> $this->input->post('kecamatan'),
				'kode_pos'				=> $this->input->post('kode_pos'),
				'no_telp'				=> $this->input->post('no_telp'),
				'sekolah_asal' 			=> $this->input->post('sekolah_asal'),
				'diterima_kelas'		=> $this->input->post('diterima_kelas'),
				'diterima'     			=> date('Y-m-d', strtotime($this->input->post('diterima'))),
				'email'      			=> $email,
				'nama_ayah'      		=> $this->input->post('nama_ayah'),
				'kerja_ayah'      		=> $this->input->post('kerja_ayah'),
				'nama_ibu'      		=> $this->input->post('nama_ibu'),
				'kerja_ibu'      		=> $this->input->post('kerja_ibu'),
				'nama_wali'      		=> $this->input->post('nama_wali'),
				'alamat_wali'      		=> $this->input->post('alamat_wali'),
				'telp_wali'      		=> $this->input->post('telp_wali'),
				'kerja_wali'      		=> $this->input->post('kerja_wali'),
				'password'      		=> $this->input->post('password'),
				"active"				=> 1,
				'petugas'				=> strtolower($this->input->post('petugas'))
			);
			//Save the photo if any
			if(!empty($_FILES['siswaphoto']['name'])){
				$upload_response = $this->upload_photo('siswaphoto');
				if($upload_response['success']){
					$data['photo']  = $upload_response['upload_data']['file_name'];
					$data_user['photo']  = $upload_response['upload_data']['file_name'];
				} else {
					$this->session->set_flashdata('error', $upload_response['msg']);
				}
			}
			$additional_data = array(
				'data_sekolah_id'		=> $this->session->userdata('data_sekolah_id'),
				'id_petugas'			=> $this->session->userdata('user_id'),
				'nisn'    				=> $nisn,
				'nipd'    				=> $this->session->userdata('no_induk'),
				"active"				=> 1,
			);
			$password 				= $this->input->post('password');
			$username 				= $this->input->post('nama');
			$user_type				= $this->input->post('user_type');
			$find = Datasiswa::all(array('conditions' => array('nisn = ? AND nama = ?', $data['nisn'], $data['nama'])));
			if($find){
				$message = 'Data siswa dengan NISN '.$data['nisn'].' dan Nama '.$data['nama'].' sudah terdaftar';
				$this->session->set_flashdata('message', $message);
				redirect("admin/siswa/tambah", 'refresh');
			} else {
				$user_id = $this->ion_auth->register($username, $password, $email, $additional_data);
				if($user_id){
					$data['user_id'] = $user_id;
					$datasiswa = Datasiswa::create($data);
					$updatedata = array('data_siswa_id'=>$datasiswa->id);
					$this->db->where('id', $user_id);
					$this->db->update('users', $updatedata); 
					$this->ion_auth->add_to_group($user_type, $user_id);
					$this->session->set_flashdata('success', $this->ion_auth->messages());
					redirect("admin/siswa/tambah", 'refresh');
				} else{
					$message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
					$this->session->set_flashdata('message', $message);
					redirect("admin/siswa/tambah", 'refresh');
				}

			}
		} else {
			$loggeduser = $this->ion_auth->user()->row();
			$this->data['groups']=$this->ion_auth->groups()->result_array();
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['data_sekolah_id'] = $loggeduser->data_sekolah_id;
			$this->data['rombel'] = '';
			$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'class' => "form-control required",
				'value' => $this->form_validation->set_value('nama'),
			);
			$this->data['no_induk'] = array(
				'name'  => 'no_induk',
				'id'    => 'no_induk',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('no_induk'),
			);
			$this->data['nisn'] = array(
				'name'  => 'nisn',
				'id'    => 'nisn',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('nisn'),
			);
			$this->data['jenis_kelamin'] = 'L';
			$this->data['tempat_lahir'] = array(
				'name'  => 'tempat_lahir',
				'id'    => 'tempat_lahir',
				'type'  => 'text',
				'class' => "form-control required",
				'value' => $this->form_validation->set_value('tempat_lahir'),
			);
			$this->data['tanggal_lahir'] = array(
				'name'  => 'tanggal_lahir',
				'id'    => 'tanggal_lahir',
				'type'  => 'text',
				'class' => "form-control required datepicker",
				'data-date-format' => "dd-mm-yyyy",
				'value' => $this->form_validation->set_value('tanggal_lahir'),
			);
			$this->data['agama_id'] = 1;
			$this->data['status_id'] = 'Anak Kandung';
			$this->data['anak_ke'] = array(
				'name'  => 'anak_ke',
				'id'    => 'anak_ke',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('anak_ke'),
			);
			$this->data['alamat'] = array(
				'name'  => 'alamat',
				'id'    => 'alamat',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('alamat'),
			);
			$this->data['rt'] = array(
				'name'  => 'rt',
				'id'    => 'rt',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('rt'),
			);
			$this->data['rw'] = array(
				'name'  => 'rw',
				'id'    => 'rw',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('rw'),
			);
			$this->data['desa_kelurahan'] = array(
				'name'  => 'desa_kelurahan',
				'id'    => 'desa_kelurahan',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('desa_kelurahan'),
			);
			$this->data['kecamatan'] = array(
				'name'  => 'kecamatan',
				'id'    => 'kecamatan',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('kecamatan'),
			);
			$this->data['kode_pos'] = array(
				'name'  => 'kode_pos',
				'id'    => 'kode_pos',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('kode_pos'),
			);
			$this->data['no_telp'] = array(
				'name'  => 'no_telp',
				'id'    => 'no_telp',
				'type'  => 'text',
				'class' => "form-control required",
				'value' => $this->form_validation->set_value('no_telp'),
			);
			$this->data['sekolah_asal'] = array(
				'name'  => 'sekolah_asal',
				'id'    => 'sekolah_asal',
				'type'  => 'text',
				'class' => "form-control required",
				'value' => $this->form_validation->set_value('sekolah_asal'),
			);
			$this->data['diterima_kelas'] = array(
				'name'  => 'diterima_kelas',
				'id'    => 'diterima_kelas',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('diterima_kelas'),
			);
			$this->data['diterima'] = array(
				'name'  => 'diterima',
				'id'    => 'diterima',
				'type'  => 'text',
				'class' => "form-control datepicker",
				'data-date-format' => "dd-mm-yyyy",
				'value' => $this->form_validation->set_value('diterima'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'class' => "form-control email",
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['nama_ayah'] = array(
				'name'  => 'nama_ayah',
				'id'    => 'nama_ayah',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('nama_ayah'),
			);
			$this->data['kerja_ayah'] = array(
				'name'  => 'kerja_ayah',
				'id'    => 'kerja_ayah',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('kerja_ayah'),
			);		
			$this->data['nama_ibu'] = array(
				'name'  => 'nama_ibu',
				'id'    => 'nama_ibu',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('nama_ibu'),
			);		
			$this->data['kerja_ibu'] = array(
				'name'  => 'kerja_ibu',
				'id'    => 'kerja_ibu',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('kerja_ibu'),
			);	
			$this->data['nama_wali'] = array(
				'name'  => 'nama_wali',
				'id'    => 'nama_wali',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('nama_wali'),
			);
			$this->data['alamat_wali'] = array(
				'name'  => 'alamat_wali',
				'id'    => 'alamat_wali',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('alamat_wali'),
			);
			$this->data['telp_wali'] = array(
				'name'  => 'telp_wali',
				'id'    => 'telp_wali',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('telp_wali'),
			);
			$this->data['kerja_wali'] = array(
				'name'  => 'kerja_wali',
				'id'    => 'kerja_wali',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('kerja_wali'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'text',
				'class' => "form-control",
				'value' => $this->form_validation->set_value('password'),
			);
			$loggeduser = $this->ion_auth->user()->row();
			$this->data['rombels'] = Datarombel::find('all', array('conditions' => array('data_sekolah_id = ? AND guru_id != ?',$loggeduser->data_sekolah_id,0)));
			$this->template->title('Administrator Panel : Data Siswa')
	        ->set_layout($this->admin_tpl)
	        ->set('page_title', 'Tambah Data Siswa')
	        ->set('form_action', 'admin/siswa/tambah')
	        ->build($this->admin_folder.'/siswa/_siswa', $this->data);
		}
	}
	public function edit($id){
		$user = Datasiswa::find($id);
		$loggeduser = $this->ion_auth->user()->row();
		$this->form_validation->set_rules('nama', 'Nama', 'required|xss_clean');
		$this->form_validation->set_rules('no_induk', 'no_induk', 'xss_clean');
		$this->form_validation->set_rules('nisn', 'NISN', 'xss_clean');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|xss_clean');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|xss_clean');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|xss_clean');
		$this->form_validation->set_rules('agama', 'Agama', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'Status dalam keluarga', 'xss_clean');
		$this->form_validation->set_rules('anak_ke', 'Anak ke', 'xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat Jalan', 'xss_clean');
		$this->form_validation->set_rules('rt', 'RT', 'xss_clean');
		$this->form_validation->set_rules('rw', 'RW', 'xss_clean');
		$this->form_validation->set_rules('desa_kelurahan', 'Desa Kelurahan', 'xss_clean');
		$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'xss_clean');
		$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'numeric|xss_clean');
		$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'numeric|xss_clean');
		$this->form_validation->set_rules('sekolah_asal', 'Sekolah Asal', 'xss_clean');
		$this->form_validation->set_rules('diterima_kelas', 'Diterima dikelas', 'xss_clean');
		$this->form_validation->set_rules('diterima', 'Diterima pada tanggal', 'xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|xss_clean');
		$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'xss_clean');
		$this->form_validation->set_rules('kerja_ayah', 'Pekerjaan Ayah', 'xss_clean');
		$this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'xss_clean');
		$this->form_validation->set_rules('kerja_ibu', 'Pekerjaan Ibu', 'xss_clean');
		$this->form_validation->set_rules('nama_wali', 'Nama Wali', 'xss_clean');
		$this->form_validation->set_rules('alamat_wali', 'Alamat Wali', 'xss_clean');
		$this->form_validation->set_rules('telp_wali', 'Nomor Telepon Wali', 'xss_clean');
		$this->form_validation->set_rules('kerja_wali', 'Pekerjaan Ayah', 'xss_clean');
		if (isset($_POST) && !empty($_POST)){
			// do we have a valid request?
			if ($this->form_validation->run() === TRUE){
				$data = array(
					'data_rombel_id'		=> $this->input->post('rombel_id'),
					'nama' 					=> $this->input->post('nama'),
					'no_induk' 				=> $this->input->post('no_induk'),
					'nisn'    				=> $this->input->post('nisn'),
					'jenis_kelamin'  		=> $this->input->post('jenis_kelamin'),
					'tempat_lahir'      	=> $this->input->post('tempat_lahir'),
					'tanggal_lahir'      	=> date('Y-m-d', strtotime($this->input->post('tanggal_lahir'))),
					'agama'		    		=> $this->input->post('agama'),
					'status'		      	=> $this->input->post('status'),
					'anak_ke'		      	=> $this->input->post('anak_ke'),
					'alamat'		      	=> $this->input->post('alamat'),
					'rt'      				=> $this->input->post('rt'),
					'rw'      				=> $this->input->post('rw'),
					'desa_kelurahan'      	=> $this->input->post('desa_kelurahan'),
					'kecamatan'				=> $this->input->post('kecamatan'),
					'kode_pos'				=> $this->input->post('kode_pos'),
					'no_telp'				=> $this->input->post('no_telp'),
					'sekolah_asal' 			=> $this->input->post('sekolah_asal'),
					'diterima_kelas'		=> $this->input->post('diterima_kelas'),
					'diterima'     			=> date('Y-m-d', strtotime($this->input->post('diterima'))),
					'email'      			=> $this->input->post('email'),
					'nama_ayah'      		=> $this->input->post('nama_ayah'),
					'kerja_ayah'      		=> $this->input->post('kerja_ayah'),
					'nama_ibu'      		=> $this->input->post('nama_ibu'),
					'kerja_ibu'      		=> $this->input->post('kerja_ibu'),
					'nama_wali'      		=> $this->input->post('nama_wali'),
					'alamat_wali'      		=> $this->input->post('alamat_wali'),
					'telp_wali'      		=> $this->input->post('telp_wali'),
					'kerja_wali'      		=> $this->input->post('kerja_wali'),
					'password'      		=> $this->input->post('password')
				);
				$data_user = array(
					'username'				=> $this->input->post('nama'),
					'nisn'    				=> $this->input->post('nisn'),
					'nipd'	 				=> $this->input->post('nipd'),
					'email'      			=> $this->input->post('email')
				);
				if ($this->input->post('password')){
					//$data_user['password'] = $this->input->post('password');
				}
				//Save the photo if any
				if(!empty($_FILES['siswaphoto']['name'])){
					$upload_response = $this->upload_photo('siswaphoto');
					if($upload_response['success']){
						if(is_file(PROFILEPHOTOS.$user->photo))						{
							unlink(PROFILEPHOTOS.$user->photo);
							unlink(PROFILEPHOTOSTHUMBS.$user->photo);
						}
						$data['photo']  = $upload_response['upload_data']['file_name'];
						$data_user['photo']  = $upload_response['upload_data']['file_name'];
					}
					else{
						$this->session->set_flashdata('error', $upload_response['msg']);
					}
				}
				//$this->ion_auth->update($user->id, $data);
				$this->ion_auth->update($user->user_id, $data_user);
				$user->update_attributes($data);
				$this->session->set_flashdata('success', "Siswa berhasil di edit");
				redirect('admin/siswa/edit/'.$user->id, 'refresh');
			}
		}
		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['nama'] = array(
			'name'  => 'nama',
			'id'    => 'nama',
			'type'  => 'text',
			'class' => "form-control required",
			'value' => $this->form_validation->set_value('nama', $user->nama),
		);
		$this->data['jenis_kelamin'] = $user->jenis_kelamin;
		$this->data['nisn'] = array(
			'name'  => 'nisn',
			'id'    => 'nisn',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('nisn', $user->nisn),
		);
		$this->data['no_induk'] = array(
			'name'  => 'no_induk',
			'id'    => 'no_induk',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('no_induk', $user->no_induk),
		);
		$this->data['tempat_lahir'] = array(
			'name'  => 'tempat_lahir',
			'id'    => 'tempat_lahir',
			'type'  => 'text',
			'class' => "form-control required",
			'value' => $this->form_validation->set_value('tempat_lahir', $user->tempat_lahir),
		);
		$date = date_create($user->tanggal_lahir);
		$this->data['tanggal_lahir'] = array(
			'name'  => 'tanggal_lahir',
			'id'    => 'tanggal_lahir',
			'type'  => 'text',
			'class' => "form-control required datepicker",
			'data-date-format' => "dd-mm-yyyy",
			'value' => $this->form_validation->set_value('tanggal_lahir', date_format($date,'d-m-Y')),
		);
		$this->data['agama_id'] = $user->agama;
		$this->data['status_id'] = $user->status;
		$this->data['anak_ke'] = array(
			'name'  => 'anak_ke',
			'id'    => 'anak_ke',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('anak_ke', $user->anak_ke),
		);
		$this->data['alamat'] = array(
			'name'  => 'alamat',
			'id'    => 'alamat',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('alamat', $user->alamat),
		);
		$this->data['rt'] = array(
			'name'  => 'rt',
			'id'    => 'rt',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('rt', $user->rt),
		);
		$this->data['rw'] = array(
			'name'  => 'rw',
			'id'    => 'rw',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('rw', $user->rw),
		);
		$this->data['desa_kelurahan'] = array(
			'name'  => 'desa_kelurahan',
			'id'    => 'desa_kelurahan',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('desa_kelurahan', $user->desa_kelurahan),
		);		
		$this->data['kecamatan'] = array(
			'name'  => 'kecamatan',
			'id'    => 'kecamatan',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('kecamatan', $user->kecamatan),
		);		
		$this->data['kode_pos'] = array(
			'name'  => 'kode_pos',
			'id'    => 'kode_pos',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('kode_pos', $user->kode_pos),
		);		
		$this->data['no_telp'] = array(
			'name'  => 'no_telp',
			'id'    => 'no_telp',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('no_telp', $user->no_telp),
		);
		$this->data['sekolah_asal'] = array(
			'name'  => 'sekolah_asal',
			'id'    => 'sekolah_asal',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('sekolah_asal', $user->sekolah_asal),
		);
		$this->data['diterima_kelas'] = array(
			'name'  => 'diterima_kelas',
			'id'    => 'diterima_kelas',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('diterima_kelas', $user->diterima_kelas),
		);
		$diterima = date_create($user->diterima);
		$this->data['diterima'] = array(
			'name'  => 'diterima',
			'id'    => 'diterima',
			'type'  => 'text',
			'class' => "form-control datepicker",
			'data-date-format' => "dd-mm-yyyy",
			'value' => $this->form_validation->set_value('diterima', date_format($diterima,'d-m-Y')),
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('email', $user->email),
		);		
		$this->data['nama_ayah'] = array(
			'name'  => 'nama_ayah',
			'id'    => 'nama_ayah',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('nama_ayah', $user->nama_ayah),
		);		
		$this->data['kerja_ayah'] = array(
			'name'  => 'kerja_ayah',
			'id'    => 'kerja_ayah',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('kerja_ayah', $user->kerja_ayah),
		);		
		$this->data['nama_ibu'] = array(
			'name'  => 'nama_ibu',
			'id'    => 'nama_ibu',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('nama_ibu', $user->nama_ibu),
		);		
		$this->data['kerja_ibu'] = array(
			'name'  => 'kerja_ibu',
			'id'    => 'kerja_ibu',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('kerja_ibu', $user->kerja_ibu),
		);	
		$this->data['nama_wali'] = array(
			'name'  => 'nama_wali',
			'id'    => 'nama_wali',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('nama_wali', $user->nama_wali),
		);
		$this->data['alamat_wali'] = array(
			'name'  => 'alamat_wali',
			'id'    => 'alamat_wali',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('alamat_wali', $user->alamat_wali),
		);
		$this->data['telp_wali'] = array(
			'name'  => 'telp_wali',
			'id'    => 'telp_wali',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('telp_wali', $user->telp_wali),
		);
		$this->data['kerja_wali'] = array(
			'name'  => 'kerja_wali',
			'id'    => 'kerja_wali',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('kerja_wali', $user->kerja_wali),
		);
		$this->data['password'] = array(
			'name'  => 'password',
			'id'    => 'password',
			'type'  => 'text',
			'class' => "form-control",
			'value' => $this->form_validation->set_value('password', $user->password),
		);
		$this->data['data_sekolah_id'] = $user->data_sekolah_id;
		$this->data['rombel'] = $user->data_rombel_id;
		$this->data['rombels'] = Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$this->template->title('Administrator Panel : Edit Siswa')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Edit Siswa')
		->build($this->admin_folder.'/siswa/_siswa', $this->data);
		//->build($this->admin_folder.'/demo');
	}
	public function view($id){
		$siswa = Datasiswa::find($id, array('include'=>array('user')));
		$this->template->title('Administrator Panel : Detil Siswa')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'Detil Siswa')
        ->set('siswa', $siswa)
		->set('modal_footer', '')		
        ->build($this->admin_folder.'/siswa/view');
	}
	public function delete($id){
		$super_admin = array(1,2);
		if($this->ion_auth->in_group($super_admin)){
			$data = Datasiswa::find($id);
			if(is_file(PROFILEPHOTOS.$data->photo)){
				unlink(PROFILEPHOTOS.$data->photo);
				unlink(PROFILEPHOTOSTHUMBS.$data->photo);
			}
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
	public function multidelete(){
		$ids = $_POST['id'];
		$super_admin = array(1,2);
		if($this->ion_auth->in_group($super_admin)){
			foreach($ids as $id){
				$data = Datasiswa::find($id);
				if(is_file(PROFILEPHOTOS.$data->photo)){
					unlink(PROFILEPHOTOS.$data->photo);
					unlink(PROFILEPHOTOSTHUMBS.$data->photo);
				}
				$data->delete();
			}
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
		if ($this->form_validation->run() == FALSE){
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
	        ->build('auth/deactivate_siswa', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
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
			redirect('admin/siswa');
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
			redirect("admin/siswa");
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("admin/siswa");
		}
	}
    public function simpan(){
		$this->load->library('custom_fuction');
		$nama			= strtoupper(addslashes($this->input->post('nama_pd', TRUE)));
		$nisn	 		= $this->input->post('nisn', TRUE);
		$nik	 		= $this->input->post('nik', TRUE);
		$kelamin 		= $this->input->post('kelamin', TRUE);
		$idSekolah 		= $this->input->post('idSekolah', TRUE);
		$petugas		= $this->input->post('petugas', TRUE);
		$password_asli	= $this->custom_fuction->GeneratePassword();
		$password_acak	= sha1($password_asli);
		$SiswaID		= $this->input->post('pd_id', TRUE);
		if($nisn){
			$query_cek_pendaftaran = $this->siswa_model->get_siswa_by_nisn($nisn);
		} else {
		$query_cek_pendaftaran = $this->siswa_model->get_siswa_by_nisn_2();
		}
		if($query_cek_pendaftaran->num_rows()>0){
			$status['status'] = 0;
			$status['error'] = 'Siswa dengan NISN '.$nisn.' sudah ada di database!';
			$status['id']=$SiswaID;
		}else{
			$priveledge = 'operator';
			$statuss	= '1';
			$this->siswa_model->save_siswa($nama,$nisn,$nik,$password_asli,$password_acak,$kelamin,$idSekolah,$priveledge,$statuss,$petugas);
			$status['status'] = 1;
			$status['error'] = '';
			$status['nama']=$nama;
			$status['nisn']=$nisn;
			$status['kelamin']=$kelamin;
			$status['nik']=$nik;
			$status['id']=$SiswaID;
		}
        echo json_encode($status);
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
	public function rombel($id){
		$loggeduser = $this->ion_auth->user()->row();
		$rombels 	= Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$this->template->title('Administrator Panel : Detil Rombongan Belajar')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Nama Rombongan Belajar')
	        ->set('id_mapel', $id)
	        ->set('rombels', $rombels)
			->set('modal_s', 'modal_s')
			->set('modal_footer', '<a href="javascript:void(0)" class="btn btn-success btn-sm pilih_guru"><i class="fa fa-plus-circle"></i> Pilih</a>')			
	        ->build($this->admin_folder.'/siswa/rombel');
	}
	public function setrombel($id){
		if(isset($_POST['id'])){
			$rombel_id = $_POST['id'];
			$updatedata = array('data_rombel_id'=>$rombel_id);
			$this->db->where('id', $id);
			$this->db->update('data_siswas', $updatedata); 
			echo 'sukses';
		} else {
			echo 'gagal';
		}
	}
    public function list_siswa($kompetensi = NULL, $tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 10;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$siswa_guru_joint = '';
		$siswa_guru = '';
		$comma_separated = '0';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "ajaran_id = $ajaran->id AND guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			if($data_mapel){
				foreach($data_mapel as $datamapel){
					$id_rombel_mapel[] = $datamapel->rombel_id;
				}
			}
			if(isset($id_rombel_mapel)){
				$id_rombel = array_unique($id_rombel_mapel);
				$comma_separated = implode(",", $id_rombel);
			}
		$siswa_guru_joint = "AND a.id IN ($comma_separated)";
		$siswa_guru = "AND data_rombel_id IN ($comma_separated)";
		}
		if($kompetensi && !$tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(data_siswas.data_rombel_id = a.id AND a.kurikulum_id = $kompetensi $siswa_guru_joint)";
			$query = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'nama ASC', 'joins'=> $join));
			$filter = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'order'=>'nama ASC', 'joins'=> $join));
		} elseif($kompetensi && $tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(data_siswas.data_rombel_id = a.id AND a.kurikulum_id = $kompetensi AND a.tingkat = $tingkat $siswa_guru_joint)";
			$query = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'nama ASC', 'joins'=> $join));
			$filter = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'order'=>'nama ASC', 'joins'=> $join));
		} elseif($kompetensi && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(data_siswas.data_rombel_id = a.id AND a.kurikulum_id = $kompetensi AND a.tingkat = $tingkat AND a.id = $rombel $siswa_guru_joint)";
			$query = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'nama ASC', 'joins'=> $join));
			$filter = Datasiswa::find('all', array('conditions' => "data_siswas.id IS NOT NULL AND (data_siswas.nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'order'=>'nama ASC', 'joins'=> $join));
		} else {
			$query = Datasiswa::find('all', array('conditions' => "id IS NOT NULL $siswa_guru AND (nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'nama ASC'));
			$filter = Datasiswa::find('all', array('conditions' => "id IS NOT NULL $siswa_guru AND (nama LIKE '%$search%' OR nisn LIKE '%$search%' OR tempat_lahir LIKE '%$search%' OR data_rombel_id LIKE '%$search%')",'order'=>'nama ASC'));
		}

		//print_r($query);
		//$this->master_model->get_barang($start, $rows, $search);
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
		$admin_group = array(1,2);
		foreach ($query as $temp) {	
			if($temp->jenis_kelamin == 'L'){
				if($temp->photo)
					$foto = base_url().PROFILEPHOTOSTHUMBS.$temp->photo;
				else
					$foto= base_url().'assets/img/no_avatar.jpg';
			} else {
				if($temp->photo)
					$foto= base_url().PROFILEPHOTOSTHUMBS.$temp->photo;
				else
					$foto= base_url().'assets/img/no_avatar_f.jpg';
			}
			if($temp->nisn){
				$nisn = $temp->nisn;
			} else {
				$nisn = '-';
			}
			if($temp->data_rombel_id == 0){
				$rombel = 0;
			} else {
				$rombel = Datarombel::find($temp->data_rombel_id);
			}
			$admin_akses = '<div class="btn-group">';
			$admin_akses .= '<button type="button" class="btn btn-default btn-sm">Aksi</button>';
			$admin_akses .= '<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">';
			$admin_akses .= '<span class="caret"></span>';
			$admin_akses .= '<span class="sr-only">Toggle Dropdown</span>';
			$admin_akses .= '</button>';
			$admin_akses .= '<ul class="dropdown-menu pull-right text-left" role="menu">';
			$admin_akses .= '<li><a href="'.site_url('admin/siswa/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>';
			$admin_akses .= '<li><a href="'.site_url('admin/siswa/edit/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>';
			$admin_akses .= '<li><a href="'.site_url('admin/siswa/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>';
			$admin_akses .= '</ul>';
			$admin_akses .= '</div>';
			if($loggeduser->data_guru_id){
				$admin_akses = '<a href="'.site_url('admin/siswa/view/'.$temp->id).'" class="btn btn-success btn-sm toggle-modal"><i class="fa fa-eye"></i> Detil</a>';
			}
			$namarombel = ($rombel != '0') ? $rombel->nama.'/'.$rombel->tingkat: '<a href="'.site_url('admin/siswa/rombel/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-search-plus"></i> Pilih Rombongan Belajar</a>';
			$record = array();
            $tombol_aktif = '';
			if($this->ion_auth->in_group($admin_group)){
				$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			}
			$record[] = '<img src="'.$foto.'" width="50" style="float:left; margin-right:10px;" /> '.$temp->nama.'<br />
'.$nisn;
			$date = date_create($temp->tanggal_lahir);
			$record[] = '<div class="text-center">'.$temp->jenis_kelamin.'</div>';
			$record[] = $temp->tempat_lahir.', '.$this->custom_fuction->TanggalIndo(date_format($date,'Y-m-d'));
			$record[] = '<div class="text-center">'.get_agama($temp->agama).'</div>';
			$record[] = '<div class="text-center">'.$namarombel.'</div>';
			$record[] = '<div class="text-center">'.$admin_akses.'</div>';
			$output['aaData'][] = $record;
		}
		if($kompetensi && !$tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$id_rombel[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND kurikulum_id = ?', $id_rombel, $kompetensi)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id($kompetensi);
			}
		} elseif($kompetensi && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$id_rombel[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND tingkat = ? AND kurikulum_id = ?', $id_rombel, $tingkat, $kompetensi)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_tingkat_and_kurikulum_id($tingkat,$kompetensi);
			}
		}
		if(isset($get_all_rombel)){
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		} else {
			$result['value'] = '';
			$result['text'] = 'Tidak ditemukan rombel di tingkat kelas terpilih';
			$output['rombel'][] = $result;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
}