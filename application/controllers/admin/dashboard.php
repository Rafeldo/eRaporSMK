<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Backend_Controller {
	protected $activemenu = 'dashboard';
	public function __construct() {
		parent::__construct(); 
		$this->template->set('activemenu', $this->activemenu);
	}
	public function index(){
		$keahlian = Keahlian::first();
		if(!$keahlian){
			redirect('admin/profil/sekolah');
		}
		$loggeduser 				= $this->ion_auth->user()->row();
		$data['detil_user']			= $this->ion_auth->user()->row();
		$data['user'] 				= $this->ion_auth->user()->row();
		$data['ajaran'] 			= get_ta();
		$data['siswa'] 				= Datasiswa::count();
		$data['guru'] 				= Dataguru::count();
		$data['mata_pelajaran']		= Kurikulum::count();
		$data['rombongan_belajar']	= Datarombel::count();
		$data['rencana_penilaian']	= Rencana::count();
		$data['nilai']				= Nilai::count();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Beranda')
		->build($this->admin_folder.'/dashboard', $data);
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
