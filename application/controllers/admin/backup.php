<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends Backend_Controller {
	protected $activemenu = 'settings';
	public function __construct(){
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}

	public function index(){
		$admin_group = array(1,2);
		hak_akses($admin_group);
		$this->template->title('Administrator Panel : Backup / Restore Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Backup / Restore Data')
        ->build($this->admin_folder.'/tools/backup');
		//->build($this->admin_folder.'/perbaikan');
	}
}
