<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Backend_Controller {
	protected $activemenu = 'settings';
	public function __construct(){
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}

	public function index(){
		$data['settings'] = Setting::first();
		$data['sekolah'] = Datasekolah::first();
		$this->template->title('Administrator Panel')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Settings')
        ->build($this->admin_folder.'/settings', $data);
		//->build($this->admin_folder.'/demo');
	}

	

/*-----------------------------------------------------------------------------------------------------------------------
	function to upload user photos
-------------------------------------------------------------------------------------------------------------------------*/
	public function upload_image($fieldname) {
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = MEDIAFOLDER;
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
			$data = array('success' => true, 'upload_data' => $upload_details, 'msg' => "Upload success!");
		}
		return $data;
	}
	public function backup(){
		$this->load->dbutil();
		$data['tables'] = $this->db->list_tables();
		$this->template->title('Administrator Panel : Backup / Restore Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Backup / Restore Data')
        ->build($this->admin_folder.'/tools/backup',$data);
	}
}
