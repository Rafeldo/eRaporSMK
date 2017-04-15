<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Monitoring extends Backend_Controller {
	protected $activemenu = 'monitoring';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
	}
	public function index(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Monitoring')
		->build($this->admin_folder.'/perbaikan');
	}
	public function analisis(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Analisis Hasil Penilaian')
		->build($this->admin_folder.'/monitoring/analisis',$data);
	}
	public function kompetensi(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Analisis Pencapaian Kompetensi')
		->build($this->admin_folder.'/monitoring/kompetensi',$data);
	}
	public function remedial(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Analisis Pencapaian Remedial')
		->build($this->admin_folder.'/monitoring/remedial',$data);
	}
	public function get_analisis_kompetensi(){
		$data['data'] = $_POST;
		$this->template->title('Administrator Panel')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Cetak Legger')
		->build($this->admin_folder.'/monitoring/get_kompetensi',$data);
	}
	public function prestasi($id = NULL){
		$file = 'individu';
		$title = 'Monitoring Prestasi Individu Siswa';
		if($id){
			$data['mapel_id'] = $id;
			$file = 'detil_nilai';
		}
		$data['ajarans'] = Ajaran::all();
		$data['ajaran'] = get_ta();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['user'] = $this->ion_auth->user()->row();
		$admin_group = array('admin','tu','guru','kasek','bk');
		if($this->ion_auth->in_group($admin_group)){
			$file = 'all';
			$title = 'Monitoring Prestasi Individu Siswa';
		}
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', $title)
		->build($this->admin_folder.'/monitoring/'.$file, $data);
	}
	public function rapor(){
		$loggeduser = $this->ion_auth->user()->row();
		$admin_group = array(4);
		hak_akses($admin_group);
		$ajarans = Ajaran::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Cetak Rapor')
		->set('user', $loggeduser)
		->set('ajarans', $ajarans)
		->build($this->admin_folder.'/monitoring/rapor');
	}
}