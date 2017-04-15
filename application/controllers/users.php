<?php

class Users extends Frontend_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function profile(){
		$user = $this->ion_auth->user()->row();
		//validate form input
		$this->form_validation->set_rules('firstname', 'first name', 'required|xss_clean');
		$this->form_validation->set_rules('lastname', 'last name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
		$this->form_validation->set_rules('company', 'company', 'xss_clean');
		$this->form_validation->set_rules('password', 'password', 'min_length[8]|trim|xss_clean');
		$this->form_validation->set_rules('password_confirm', 'confirm password', 'matches[password]|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="field-validation-error">', '</div>');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('firstname'),
					'last_name'  => $this->input->post('lastname'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);
				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
				//Save the photo if any
				if(!empty($_FILES['profilephoto']['name'])){
					$upload_response = $this->upload_photo('profilephoto');
					if($upload_response['success']){
						if(is_file(PROFILEPHOTOS.$user->photo))
						{
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
				redirect('users/profile');
			}
		}
		$data['menu'] = 'profile';
		$data['user'] = $user;
		$this->template->title('Edit Profile')
        ->set_layout($this->front_tpl)
        ->set('page_title', 'Edit Profile')
        ->build($this->user_folder.'/user/profile', $data);
	}
	public function exams(){
		$user = $this->ion_auth->user()->row();
		$data['menu'] = 'myexams';
		$data['userexams']  = Userexam::find_all_by_user_id($user->id, array('order' => 'id desc'));
		$this->template->title('My Exams')
        ->set_layout($this->front_tpl)
        ->set('page_title', 'My Exams')
        ->build($this->user_folder.'/user/exams', $data);
	}
	public function subscriptions(){
		$user = $this->ion_auth->user()->row();
		$data['subscriptions'] = Subscription::all(array('user_id'=>$user->id));
		$data['menu'] = 'subscriptions';
		$this->template->title('My subscriptions')
        ->set_layout($this->front_tpl)
        ->set('page_title', 'subscriptions')
        ->build($this->user_folder.'/user/subscriptions', $data);
	}
	public function change_password(){
		$user = $this->ion_auth->user()->row();
		//validate form input
		$this->form_validation->set_rules('old', 'old password', 'required');
		$this->form_validation->set_rules('new', 'new password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'confirm password', 'required');
		$this->form_validation->set_error_delimiters('<div class="field-validation-error">', '</div>');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$identity = $this->session->userdata('identity');
				$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('success', 'Password successfully changed');
					redirect('usesr/change_password');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					redirect('users/change_password');
				}
			}
		}
		$data['menu'] = 'changepassword';
		$data['user'] = $user;
		$this->template->title('Change Password')
        ->set_layout($this->front_tpl)
        ->set('page_title', 'Edit Profile')
        ->build($this->user_folder.'/user/change_password', $data);
	}

/*-----------------------------------------------------------------------------------------------------------------------
	function to upload user photos
-------------------------------------------------------------------------------------------------------------------------*/
	public function upload_photo($fieldname) {
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = PROFILEPHOTOS;
		// set the filter image types
		$config['allowed_types'] = 'png|gif|jpeg|jpg';
		$config['max_width'] = '500'; 
		$this->load->helper('string');
		$config['file_name']	 = random_string('alnum', 32);
		//load the upload library
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
	
		//if not successful, set the error message
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('success' => false, 'msg' => $this->upload->display_errors());
		}
		else
		{ 
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