<?php defined('BASEPATH') OR exit('No direct script access allowed');
class penerimaan extends Backend_Controller {
	protected $activemenu = 'penerimaan';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}
	public function index(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penerimaan')
		->build($this->admin_folder.'/penerimaan/');
	}
	public function bayarspp(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/penerimaan/konfrimasispp')
		->set('page_title', 'Penerimaan SPP')
		->build($this->admin_folder.'/penerimaan/_spp');

	}

	public function simpanspp(){

	}
		public function konfrimasispp(){
		//$data['data'] = Dataspp::find($id);
		$this->template->title('Administrator Panel')
		->set_layout($this->modal_tpl)
		->set('page_title', 'Konfrimasi  SPP')
		->set('form_action', 'admin/penerimaan/simpanspp')
		->build($this->admin_folder.'/penerimaan/_sppdetail');
	}
}