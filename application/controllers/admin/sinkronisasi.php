<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sinkronisasi extends Backend_Controller {
	protected $activemenu = 'singkronisasi';
	public function __construct() {
		parent::__construct(); 
		$this->template->set('activemenu', $this->activemenu);
	}
	public function index(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Sinkronisasi Erapor dengan Dapodik')
		->build($this->admin_folder.'/perbaikan');
	}
	 function singkron(){
	 	$data['user_id'] = $this->session->userdata('email');
		$this->template->title('Administrator Panel')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'Sinkronisasi')
		->set('modal_footer','<div class="box-footer clearfix">
      <div class="form-group col-xs-12"><button id="fat-btn" class="btn btn-primary pull-right" data-loading-text="Loading..." 
   type="button"> Login
</button></div>
</div>')
        ->build($this->admin_folder.'/sinkron/sinkron', $data);
	}
	function guru(){
		$this->load->model('data_model');
		$data['guru']		= $this->data_model->get_all_guru();
	 	$data['user_id'] 	= $this->session->userdata('email');
	 	$query 				= $this->data_model->get_data_sekolah($this->session->userdata('email'));
		$data['sekolah'] = $query->row();
		$this->template->title('Administrator Panel')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'Cari Data Anda')
		->set('modal_footer','<div class="box-footer clearfix">
      <div class="form-group col-xs-12"><button id="fat-btn" class="btn btn-primary pull-right" data-loading-text="Loading..." 
   type="button"> Proses</button><button id="btn-integrasi-guru-ganti" class="btn btn-primary pull-right" style="display:none;" data-loading-text="Loading..." 
   type="button"> Proses</button></div>
</div>')
        ->build($this->admin_folder.'/singkron/ambil_data', $data);
	}
	function siswa(){
		$this->load->model('data_model');
		$data['guru']		= $this->data_model->get_all_guru();
	 	$data['user_id'] 	= $this->session->userdata('email');
	 	$query 				= $this->data_model->get_data_sekolah($this->session->userdata('email'));
		$data['sekolah'] = $query->row();
		$this->template->title('Administrator Panel')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'Cari Data Siswa')
		->set('modal_footer','<div class="box-footer clearfix">
      <div class="form-group col-xs-12"><button id="fat-btn" class="btn btn-primary pull-right" data-loading-text="Loading..." type="button"> Proses</button><button id="btn-integrasi-guru-ganti" class="btn btn-primary pull-right" style="display:none;" data-loading-text="Loading..." type="button"> Proses</button></div></div>')
        ->build($this->admin_folder.'/singkron/ambil_data_siswa', $data);
	}
	public function skin($id){
		$id = str_replace('_','-',$id);
		$this->load->library('user_agent');
		$newdata = array(
			'template'  => $id
				);
		$this->session->set_userdata($newdata);
		redirect($this->agent->referrer());
	}
}
