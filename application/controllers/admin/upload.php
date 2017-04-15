<?php
// PHP Upload Script for CKEditor:  http://coursesweb.net/
class Upload extends Backend_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$config['upload_path'] = QUEIMGS;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['width']  = '300';
		$this->load->library('upload', $config);
		//Save the photo if any
		if(!empty($_FILES['upload']['name'])){
			$upload_response = $this->upload_photo('upload');
			if($upload_response['success']){
				$CKEditorFuncNum = $_GET['CKEditorFuncNum'];
				$url = base_url().MEDIAFOLDER.$upload_response['upload_data']['file_name'];
				$message = 'upload gambar berhasil';
				$re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
				$data['photo']  = $upload_response['upload_data']['file_name'];
				$data_user['photo']  = $upload_response['upload_data']['file_name'];
			} else {
				$re = 'alert("'.$upload_response['msg'].'")';
			}
		}
		echo "<script>$re;</script>";
	}
	/*-----------------------------------------------------------------------------------------------------------------------
	function to upload user photos
-------------------------------------------------------------------------------------------------------------------------*/
	public function upload_photo($fieldname) {
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = QUEIMGS;
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
			$data = array('success' => false, 'msg' => $this->display_errors('', ' '));
		} else { 
			$upload_details = $this->upload->data(); //uploading
			$config1 = array(
			      'source_image' => $upload_details['full_path'], //get original image
			      'new_image' => MEDIAFOLDER, //save as new image //need to create thumbs first
			      'maintain_ratio' => true,
			      'width' => 500,
			      'height' => 500
			    );
		    $this->load->library('image_lib', $config1); //load library
		    $this->image_lib->resize(); //generating thumb
			$data = array('success' => true, 'upload_data' => $upload_details, 'msg' => "Upload success!");
		}
		return $data;
	}
}