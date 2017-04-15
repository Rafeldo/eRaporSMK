<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Backend_Controller {
	protected $activemenu = 'profil';
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->template->set('activemenu', $this->activemenu);
	}

	public function index(){
		$join = 'LEFT JOIN users_groups a ON(users.id = a.user_id)';
		$sel = 'users.*, a.group_id AS id_group';
		$data['users'] = User::all(array('joins' => $join,'select'=>$sel,'conditions' => "a.group_id = 2"));
		$this->template->title('Administrator Panel : Atur Operator')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Data Operator')
        ->build($this->admin_folder.'/users/list', $data);
	}
	public function user(){
		$user = $this->ion_auth->user()->row();
		//validate form input
		$this->form_validation->set_rules('username', 'Nama', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Handphone', 'xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if (isset($_POST) && !empty($_POST)){
			if ($this->form_validation->run() === TRUE){
				$data = array(
					'username' => $this->input->post('username'),
					'phone'      => $this->input->post('phone'),
					'email'      => $this->input->post('email')
				);
					//update the password if it was posted
				if ($this->input->post('password')){
					$data['password'] = $this->input->post('password');
				}
				//Save the photo if any
				if(!empty($_FILES['profilephoto']['name'])){
					$upload_response = $this->upload_photo('profilephoto');
					if($upload_response['success']){
						if(is_file(PROFILEPHOTOS.$user->photo))						{
							unlink(PROFILEPHOTOS.$user->photo);
							unlink(PROFILEPHOTOSTHUMBS.$user->photo);
						}
						$data['photo']  = $upload_response['upload_data']['file_name'];
					}
					else{
						$this->session->set_flashdata('error', $upload_response['msg']);
					}
				}
				$this->ion_auth->update($user->id, $data);
				$this->session->set_flashdata('success', "Profile Updated");
			} else {
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}
			redirect('admin/profil/user');
		}
		$data['menu'] = 'profile';
		$data['user'] = $user;
		$this->template->title('Edit Profile')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Edit Profile')
		->set('action', site_url('admin/profil/user'))
        ->build($this->admin_folder.'/profil/user', $data);
	}
	public function sekolah(){
		$data['settings'] = Setting::first();
		$data['sekolah'] = Datasekolah::first();
		$this->template->title('Administrator Panel')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Profil Sekolah')
        ->build($this->admin_folder.'/profil/sekolah', $data);
	}
	public function update_sekolah(){
		if($_POST){
			//echo '<pre>';
			//print_r($_POST['kompetensi_keahlian']);
			//die();
			$loggeduser = $this->ion_auth->user()->row();
			$config['upload_path'] = MEDIAFOLDER;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '0';
			$settings 	= Setting::first();
			$sekolah 	= Datasekolah::first();
			$data_sekolah = array(
							'nama'				=> $_POST['nama_sekolah'],
							'npsn'				=> $_POST['npsn_sekolah'],
							'alamat' 			=> $_POST['alamat_sekolah'],
							'desa_kelurahan'	=> $_POST['desa_kelurahan_sekolah'],
							'kecamatan' 		=> $_POST['kecamatan_sekolah'],
							'kabupaten' 		=> $_POST['kabupaten_sekolah'],
							'provinsi' 			=> $_POST['provinsi_sekolah'],
							'kode_pos' 			=> $_POST['kodepos_sekolah'],
							'lintang' 			=> $_POST['lintang_sekolah'],
							'bujur' 			=> $_POST['bujur_sekolah'],
							'no_telp' 			=> $_POST['telp_sekolah'],
							'no_fax' 			=> $_POST['fax_sekolah'],
							'email' 			=> $_POST['email_sekolah'],
							'website' 			=> $_POST['website_sekolah'],
							'user_id' 			=> $loggeduser->id
							);
			$data_keahlian = $_POST['kompetensi_keahlian'];
			$keahlian = Keahlian::all();
			if($keahlian){
				foreach($keahlian as $ahli){
					$ahli->delete();
				}
			}
			foreach($data_keahlian as $datakeahlian){
				$attributes = array('sekolah_id' => $_POST['sekolah_id'], 'kurikulum_id' => $datakeahlian);
				$keahlian_new = Keahlian::create($attributes);
			}
			$setting = array(
				//'periode'			=> $_POST['periode'],
				'kepsek' 			=> $_POST['kepsek'],
				'nip_kepsek' 		=> $_POST['nip_kepsek'],
				//'sambutan_kepsek'	=> $_POST['sambutan_kepsek'],
			);
				$strings = $setting['periode'];
				$strings = explode('|',$strings);
				$tapel = $strings[0];
				$semester = str_replace(' ','',$strings[1]);
				if($semester == 'SemesterGanjil'){
					$smt = 1;
				} else {
					$smt = 2;
				}	
				$ajarans = Ajaran::find_by_tahun_and_smt($tapel,$smt);
				if(!$ajarans){
					$data_ajarans = array(
						'tahun'				=> $tapel,
						'smt' 				=> $smt
					);
					Ajaran::create($data_ajarans);
				}
				if(!empty($_FILES['profilephoto']['name'])){
					$upload_response = $this->upload_photo('profilephoto');
					if($upload_response['success']){
						if(is_file(PROFILEPHOTOS.$sekolah->logo_sekolah)){
							unlink(PROFILEPHOTOS.$sekolah->logo_sekolah);
							unlink(PROFILEPHOTOSTHUMBS.$sekolah->logo_sekolah);
						}
						$data_sekolah['logo_sekolah']  = $upload_response['upload_data']['file_name'];
					}
					else{
						$this->session->set_flashdata('error', $upload_response['msg']);
					}
				}
				$settings->update_attributes($setting);
				$sekolah->update_attributes($data_sekolah);
				$this->session->set_flashdata('success', 'Profil Sekolah berhasil di update');
				redirect('admin/profil/sekolah');
		}
		else{
			redirect('admin/profil/sekolah');
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
}