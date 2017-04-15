<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends Backend_Controller {
	protected $activemenu = 'laporan';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}
	public function index(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Laporan')
		->build($this->admin_folder.'/perbaikan');
	}
	public function catatan_wali_kelas(){
		$ajaran = get_ta();
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_siswa_id){
			$siswa = Datasiswa::find_by_id($loggeduser->data_siswa_id);
			$data['ajaran']	= $ajaran->tahun.' Semester '.$ajaran->smt;
			$data['data'] = Catatanwali::find_by_ajaran_id_and_siswa_id($ajaran->id, $siswa->id);
			$this->template->title('Administrator Panel')
			->set_layout($this->admin_tpl)
			->set('page_title', 'Catatan Wali Kelas')
			->build($this->admin_folder.'/laporan/catatan_siswa',$data);
		} else {
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$file = 'add_catatan_wali';
			} else {
				$file = 'list_deskripsi_antar_mapel';
			}
			$this->template->title('Administrator Panel')
			->set_layout($this->admin_tpl)
			->set('page_title', 'Catatan Wali Kelas')
			//->set('pilih_rombel', '<a href="'.site_url('admin/laporan/add_deskripsi_antar_mapel').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>')
			->set('form_action', 'admin/laporan/simpan_deskripsi_antar_mapel')
			->build($this->admin_folder.'/laporan/'.$file);
		}
	}
	public function add_deskripsi_antar_mapel(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_deskripsi_antar_mapel')
		->set('page_title', 'Tambah Data Catatan Wali Kelas')
		->build($this->admin_folder.'/laporan/add_deskripsi_antar_mapel',$data);
	}
	public function deskripsi_sikap(){
		$admin_group = array(3);
		hak_akses($admin_group);
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_deskripsi_sikap')
		->set('page_title', 'Deskripsi Sikap')
		->build($this->admin_folder.'/laporan/deskripsi_sikap');
	}
	public function simpan_deskripsi_sikap(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$siswa_id = $_POST['siswa_id'];
		$uraian_deskripsi = $_POST['uraian_deskripsi'];
		foreach($siswa_id as $k=>$siswa){
			$find = Deskripsisikap::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa);
			if($find){
				$find->update_attributes(
					array(
						'uraian_deskripsi' => $uraian_deskripsi[$k]
					)
				);
				$this->session->set_flashdata('success', 'Berhasil memperbaharui data deskripsi sikap');
			} else {
				if($uraian_deskripsi[$k]){
					$new_data = new Deskripsisikap();
					$new_data->ajaran_id = $ajaran_id;
					$new_data->rombel_id = $rombel_id;
					$new_data->siswa_id = $siswa;
					$new_data->uraian_deskripsi = $uraian_deskripsi[$k];
					$new_data->save();
				}
				$this->session->set_flashdata('success', 'Berhasil menambah data deskripsi sikap');
			}
		}
		redirect('admin/laporan/deskripsi_sikap');
		test($_POST);
	}
	public function absensi(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$file = 'add_absensi';
		} else {
			$file = 'list_absensi';
		}
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_absensi')
		->set('page_title', 'Data Absensi Siswa')
		->build($this->admin_folder.'/laporan/'.$file,$data);
	}
	public function ekstrakurikuler(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$file = 'ekstrakurikuler';
		} else {
			$file = 'list_ekstrakurikuler';
		}
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_ekstrakurikuler')
		->set('page_title', 'Ekstrakurikuler')
		->build($this->admin_folder.'/laporan/'.$file,$data);
	}
	public function prakerin(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$file = 'prakerin';
		} else {
			$file = 'list_prakerin';
		}
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_prakerin')
		->set('page_title', 'Praktik Kerja Lapangan')
		->build($this->admin_folder.'/laporan/'.$file,$data);
	}
	public function prestasi(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$file = 'prestasi';
		} else {
			$file = 'list_prestasi';
		}
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/laporan/simpan_prestasi')
		->set('page_title', 'Prestasi Siswa')
		->build($this->admin_folder.'/laporan/'.$file,$data);
	}
	public function rapor(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
			$rombel_id = isset($rombel->id) ? $rombel->id : 0;
			$kurikulum_id = isset($rombel->kurikulum_id) ? $rombel->kurikulum_id : 0;
			$ajaran = get_ta();
			$data['query'] = 'wali';
			$data['rombel_id'] = $rombel_id;
			$data['ajaran_id'] = $ajaran->id;
			$kompetensi = Datakurikulum::find_by_kurikulum_id($kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$data['nama_kompetensi'] = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$data['nama_kompetensi'] = 'ktsp';
			} else {
				$data['nama_kompetensi'] = 0;
			}
			$folder = '/cetak/';
		} else {
			$data['query'] = 'waka';
			$data['ajarans'] = Ajaran::all();
			$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
			$folder = '/laporan/';
		}
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Cetak Rapor')
		->build($this->admin_folder.$folder.'rapor',$data);
		//->build($this->admin_folder.'/cetak/'.$file,$data);
	}
	public function legger(){
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
			$rombel_id = isset($rombel->id) ? $rombel->id : 0;
			$kurikulum_id = isset($rombel->kurikulum_id) ? $rombel->kurikulum_id : 0;
			$ajaran = get_ta();
			$data['query'] = 'wali';
			$data['rombel_id'] = $rombel_id;
			$data['ajaran_id'] = $ajaran->id;
			$kompetensi = Datakurikulum::find_by_kurikulum_id($kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$data['nama_kompetensi'] = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$data['nama_kompetensi'] = 'ktsp';
			} else {
				$data['nama_kompetensi'] = 0;
			}
			$folder = '/cetak/';
		} else {
			$data['query'] = 'waka';
			$data['ajarans'] = Ajaran::all();
			$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
			$folder = '/laporan/';
		}
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Cetak Legger')
		->build($this->admin_folder.$folder.'legger',$data);
	}
	public function list_catatan_wali_kelas(){
		$loggeduser = $this->ion_auth->user()->row();
		$cari_rombel = '';
		if($loggeduser->data_guru_id != 0){
			$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
		}
		$wali_kelas = '';
		if($cari_rombel){
			$wali_kelas = "AND rombel_id = $cari_rombel->id";
		}
		$ajaran = get_ta();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$query = Catatanwali::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%' OR uraian_deskripsi LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Catatanwali::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%' OR uraian_deskripsi LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$kompetensi = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$kur = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$kur = 'ktsp';
			} else {
				$kur = 0;
			}
			$siswa = Datasiswa::find($temp->siswa_id);
			$record = array();
            $tombol_aktif = '';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $siswa->nama;
            $record[] = limit_words($temp->id,$temp->uraian_deskripsi,10);
            $record[] = '<div class="text-center"><a href="'.site_url('admin/laporan/review_rapor/'.$kur.'/'.$ajaran->id.'/'.$temp->rombel_id.'/'.$temp->siswa_id).'" class="btn btn-info btn-sm">Pratintau Rapor</a></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function list_absensi(){
		$loggeduser = $this->ion_auth->user()->row();
		$cari_rombel = '';
		if($loggeduser->data_guru_id != 0){
			$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
		}
		$wali_kelas = '';
		if($cari_rombel){
			$wali_kelas = "AND rombel_id = $cari_rombel->id";
		}
		$ajaran = get_ta();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$query = Absen::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Absen::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$kompetensi = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$kur = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$kur = 'ktsp';
			} else {
				$kur = 0;
			}
			$siswa = Datasiswa::find($temp->siswa_id);
			$record = array();
            $tombol_aktif = '';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $siswa->nama;
            $record[] = $temp->sakit;
            $record[] = $temp->izin;
            $record[] = $temp->alpa;
            $record[] = '<div class="text-center"><a href="'.site_url('admin/laporan/review_rapor/'.$kur.'/'.$ajaran->id.'/'.$temp->rombel_id.'/'.$temp->siswa_id).'" class="btn btn-info btn-sm">Pratintau Rapor</a></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function list_ekstrakurikuler(){
		$loggeduser = $this->ion_auth->user()->row();
		$cari_rombel = '';
		if($loggeduser->data_guru_id != 0){
			$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
		}
		$wali_kelas = '';
		if($cari_rombel){
			$wali_kelas = "AND rombel_id = $cari_rombel->id";
		}
		$ajaran = get_ta();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$query = Nilaiekskul::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Nilaiekskul::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$kompetensi = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$kur = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$kur = 'ktsp';
			} else {
				$kur = 0;
			}
			$siswa = Datasiswa::find($temp->siswa_id);
			$record = array();
            $tombol_aktif = '';
			$record[] = $rombel->nama;
			$record[] = $siswa->nama;
            $record[] = get_nama_ekskul($temp->ajaran_id,$temp->ekskul_id);
            $record[] = get_nilai_ekskul($temp->nilai);
            $record[] = $temp->deskripsi_ekskul;
            $record[] = '<div class="text-center"><a href="'.site_url('admin/laporan/review_rapor/'.$kur.'/'.$ajaran->id.'/'.$temp->rombel_id.'/'.$temp->siswa_id).'" class="btn btn-info btn-sm">Pratintau Rapor</a></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function list_prakerin(){
		$loggeduser = $this->ion_auth->user()->row();
		$cari_rombel = '';
		if($loggeduser->data_guru_id != 0){
			$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
		}
		$wali_kelas = '';
		if($cari_rombel){
			$wali_kelas = "AND rombel_id = $cari_rombel->id";
		}
		$ajaran = get_ta();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$query = Prakerin::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Prakerin::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$kompetensi = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$kur = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$kur = 'ktsp';
			} else {
				$kur = 0;
			}
			$siswa = Datasiswa::find($temp->siswa_id);
			$record = array();
            $tombol_aktif = '';
			$record[] = $rombel->nama;
			$record[] = $siswa->nama;
            $record[] = $temp->mitra_prakerin;
            $record[] = $temp->lokasi_prakerin;
            $record[] = $temp->lama_prakerin;
            $record[] = $temp->keterangan_prakerin;
            $record[] = '<div class="text-center"><a href="'.site_url('admin/laporan/review_rapor/'.$kur.'/'.$ajaran->id.'/'.$temp->rombel_id.'/'.$temp->siswa_id).'" class="btn btn-info btn-sm">Pratintau Rapor</a></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function list_prestasi(){
		$loggeduser = $this->ion_auth->user()->row();
		$cari_rombel = '';
		if($loggeduser->data_guru_id != 0){
			$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
		}
		$wali_kelas = '';
		if($cari_rombel){
			$wali_kelas = "AND rombel_id = $cari_rombel->id";
		}
		$ajaran = get_ta();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$query = Prakerin::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Prakerin::find('all', array('conditions' => "ajaran_id = $ajaran->id $wali_kelas AND (rombel_id LIKE '%$search%' OR siswa_id LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$kompetensi = Datakurikulum::find_by_kurikulum_id($rombel->kurikulum_id);
			$nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
			if (strpos($nama_kompetensi, 'SMK 2013') !== false) {
				$kur = 2013;
			} elseif (strpos($nama_kompetensi, 'SMK KTSP') !== false) {
				$kur = 'ktsp';
			} else {
				$kur = 0;
			}
			$siswa = Datasiswa::find($temp->siswa_id);
			$record = array();
            $tombol_aktif = '';
			$record[] = $rombel->nama;
			$record[] = $siswa->nama;
            $record[] = $temp->jenis_prestasi;
            $record[] = $temp->keterangan_prestasi;
            $record[] = '<div class="text-center"><a href="'.site_url('admin/laporan/review_rapor/'.$kur.'/'.$ajaran->id.'/'.$temp->rombel_id.'/'.$temp->siswa_id).'" class="btn btn-info btn-sm">Pratintau Rapor</a></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function view_deskripsi_antar_mapel($id){
		$deskripsi = Deskripsimapel::find($id);
		$siswa = Datasiswa::find_by_id($deskripsi->siswa_id);
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Deskripsi Antar Mata Pelajaran '.$siswa->nama)
		->set('data', $deskripsi->uraian_deskripsi)
		->build($this->admin_folder.'/laporan/view_deskripsi_antar_mapel');
	}
	public function review_rapor($kur,$ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$data['kurikulum'] = $kur;
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Pratinjau Rapor')
		->build($this->admin_folder.'/laporan/review_rapor',$data);
	}
	public function review_desc($kur, $ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$data['kurikulum'] = $kur;
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Pratinjau Deskripsi')
		->build($this->admin_folder.'/laporan/review_desc',$data);
	}
	public function review_nilai($kur,$ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$data['kurikulum'] = $kur;
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Pratinjau Nilai')
		->build($this->admin_folder.'/laporan/rapor_nilai',$data);
	}
	public function simpan_deskripsi_antar_mapel(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$siswa_id = $_POST['siswa_id'];
		foreach($siswa_id as $key=>$siswa){
			$deskripsi_antar_mapel = Catatanwali::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa);
			if($deskripsi_antar_mapel){
				$deskripsi_antar_mapel->update_attributes(
					array(
						'uraian_deskripsi' => $_POST['uraian_deskripsi'][$key]
					)
				);
				$this->session->set_flashdata('success', 'Berhasil memperbaharui deskripsi antar mata pelajaran');
			} else {
				$new_deskripsi					= new Catatanwali();
				$new_deskripsi->ajaran_id		= $ajaran_id;
				$new_deskripsi->rombel_id		= $rombel_id;
				$new_deskripsi->siswa_id		= $siswa;
				$new_deskripsi->uraian_deskripsi		= $_POST['uraian_deskripsi'][$key];
				$new_deskripsi->save();
				$this->session->set_flashdata('success', 'Berhasil menambah deskripsi antar mata pelajaran');
			}
		}
		redirect('admin/laporan/catatan_wali_kelas');
	}
	public function simpan_absensi(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$siswa_id = $_POST['siswa_id'];
		foreach($siswa_id as $key=>$siswa){
			$absen = Absen::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran_id,$rombel_id,$siswa);
			if($absen){
				$absen->update_attributes(
					array(
						'sakit' => $_POST['sakit'][$key],
						'izin' 	=> $_POST['izin'][$key],
						'alpa'	=> $_POST['alpa'][$key],
					)
				);
			} else {
				$new_absen				= new Absen();
				$new_absen->ajaran_id	= $ajaran_id;
				$new_absen->rombel_id	= $rombel_id;
				$new_absen->siswa_id	= $siswa;
				$new_absen->sakit		= $_POST['sakit'][$key];
				$new_absen->izin		= $_POST['izin'][$key];
				$new_absen->alpa		= $_POST['alpa'][$key];
				$new_absen->save();
			}
		}
		$this->session->set_flashdata('success', 'Berhasil menambah data absensi');
		redirect('admin/laporan/absensi');
	}
	public function simpan_ekstrakurikuler(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$ekskul_id = $_POST['ekskul_id'];
		$siswa_id = $_POST['siswa_id'];
		foreach($siswa_id as $key=>$siswa){
			$nilai_ekskul = Nilaiekskul::find_by_ajaran_id_and_ekskul_id_and_rombel_id_and_siswa_id($ajaran_id,$ekskul_id,$rombel_id,$siswa);
			if($nilai_ekskul){
				$nilai_ekskul->update_attributes(
					array(
						'nilai' => $_POST['nilai'][$key],
						'deskripsi_ekskul' 	=> $_POST['deskripsi_ekskul'][$key],
					)
				);
			} else {
				$new_ekskul					= new Nilaiekskul();
				$new_ekskul->ajaran_id		= $ajaran_id;
				$new_ekskul->rombel_id		= $rombel_id;
				$new_ekskul->ekskul_id		= $ekskul_id;
				$new_ekskul->siswa_id		= $siswa;
				$new_ekskul->nilai				= $_POST['nilai'][$key];
				$new_ekskul->deskripsi_ekskul	= $_POST['deskripsi_ekskul'][$key];
				$new_ekskul->save();
			}
		}
		$this->session->set_flashdata('success', 'Berhasil menambah nilai ekstrakurikuler');
		redirect('admin/laporan/ekstrakurikuler');
	}
	public function simpan_prakerin(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$siswa_id = $_POST['siswa_id'];
		$mitra_prakerin = $_POST['mitra_prakerin'];
		$lokasi_prakerin = $_POST['lokasi_prakerin'];
		$lama_prakerin = $_POST['lama_prakerin'];
		$keterangan_prakerin = $_POST['keterangan_prakerin'];
		$new_prakerin						= new Prakerin();
		$new_prakerin->ajaran_id			= $ajaran_id;
		$new_prakerin->rombel_id			= $rombel_id;
		$new_prakerin->siswa_id				= $siswa_id;
		$new_prakerin->mitra_prakerin		= $mitra_prakerin;
		$new_prakerin->lokasi_prakerin		= $lokasi_prakerin;
		$new_prakerin->lama_prakerin		= $lama_prakerin;
		$new_prakerin->keterangan_prakerin	= $keterangan_prakerin;
		$new_prakerin->save();
		$this->session->set_flashdata('success', 'Berhasil menambah data prakerin');
		redirect('admin/laporan/prakerin');
	}
	public function edit_prakerin($id){
		if($_POST){
			$prakerin = Prakerin::find($id);
			$prakerin->update_attributes(
				array(
					'mitra_prakerin' => $_POST['mitra_prakerin'], 
					'lokasi_prakerin' => $_POST['lokasi_prakerin'], 
					'lama_prakerin' => $_POST['lama_prakerin'],
					'keterangan_prakerin' => $_POST['keterangan_prakerin']
				)
			);
			$ajaran_id = $_POST['ajaran_id'];
			$rombel_id = $_POST['rombel_id'];
			$siswa_id = $_POST['siswa_id'];
			$this->form_prakerin($ajaran_id,$rombel_id,$siswa_id);
		} else {
			$prakerin = Prakerin::find($id);
			$this->template->title('Administrator Panel : Edit Sikap')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Edit Sikap')
			->set('prakerin', $prakerin)
			->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
			->build($this->admin_folder.'/laporan/edit_prakerin');
		}
	}
	function form_prakerin($ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$this->load->view('backend/laporan/add_prakerin', $data);
	}
	public function simpan_prestasi(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$siswa_id = $_POST['siswa_id'];
		$jenis_prestasi = $_POST['jenis_prestasi'];
		$keterangan_prestasi = $_POST['keterangan_prestasi'];
		$new_prestasi						= new Prestasi();
		$new_prestasi->ajaran_id			= $ajaran_id;
		$new_prestasi->rombel_id			= $rombel_id;
		$new_prestasi->siswa_id				= $siswa_id;
		$new_prestasi->jenis_prestasi		= $jenis_prestasi;
		$new_prestasi->keterangan_prestasi	= $keterangan_prestasi;
		$new_prestasi->save();
		$this->session->set_flashdata('success', 'Berhasil menambah data prestasi siswa');
		redirect('admin/laporan/prestasi');
	}
	public function edit_prestasi($id){
		$prestasi = Prestasi::find($id);
		if($_POST){
			$prestasi->update_attributes(
				array(
					'jenis_prestasi' 		=> $_POST['jenis_prestasi'], 
					'keterangan_prestasi' 	=> $_POST['keterangan_prestasi']
				)
			);
			$ajaran_id = $_POST['ajaran_id'];
			$rombel_id = $_POST['rombel_id'];
			$siswa_id = $_POST['siswa_id'];
			$this->form_prestasi($ajaran_id,$rombel_id,$siswa_id);
		} else {
			$this->template->title('Administrator Panel : Edit Prestasi')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Edit Prestasi')
			->set('prestasi', $prestasi)
			->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
			->build($this->admin_folder.'/laporan/edit_prestasi');
		}
	}
	function form_prestasi($ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$this->load->view('backend/laporan/add_prestasi', $data);
	}
	public function edit_deskripsi_antar_mapel($id){
		$deskripsi = Deskripsimapel::find($id);
		if($_POST){
			$deskripsi->update_attributes(
				array(
					'uraian_deskripsi' 	=> $_POST['uraian_deskripsi']
				)
			);
		} else {
			$this->template->title('Administrator Panel : Edit Prestasi')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Edit Prestasi')
			->set('deskripsi', $deskripsi)
			->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
			->build($this->admin_folder.'/laporan/edit_deskripsi_antar_mapel');
		}
	}
}