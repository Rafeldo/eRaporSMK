<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends Backend_Controller {
	public function __construct(){
		parent::__construct();
	}
 
	public function index(){ 
		$data['data'] = Rencanapenilaian::all();
		$this->template->title('Materi Ujian Tersedia')
        ->set_layout($this->blank_tpl)
        ->set('page_title', 'Debug')
        ->build($this->admin_folder.'/debug', $data);
	}
	public function turunan($query){
		$tables = $this->db->list_tables();
		$this->template->title('')
		->set_layout($this->modal_tpl)
		->set('page_title', 'Data Turunan '.$query)
		->set('tables', $tables)
		->set('query', $query)
		//->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
		//->set('modal_s', 's')
		->build($this->admin_folder.'/turunan');
	}
}