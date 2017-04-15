<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends Backend_Controller {
	protected $activemenu = 'config';
	public function __construct(){
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
	}
	public function index(){
	}
	public function generate_anggota_rombel(){
		$data_siswa = Datasiswa::find('all', array('conditions' => "data_rombel_id != 0"));
		$ajaran = get_ta();
		foreach($data_siswa as $siswa){
			$anggota = Anggotarombel::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id, $siswa->data_rombel_id, $siswa->id);
			if($anggota){
			} else {
				$new_data				= new Anggotarombel();
				$new_data->ajaran_id	= $ajaran->id;
				$new_data->rombel_id	= $siswa->data_rombel_id;
				$new_data->siswa_id		= $siswa->id;
				$new_data->save();
			}
		}
		redirect('admin/dashboard');
		//echo '<a href="'.site_url('admin/config/generate_anggota_rombel').'"><i class="fa fa-reload"></i> <span>Reload</span></a>';
	}
	public function backup(){
		$admin_group = array(1,2);
		hak_akses($admin_group);
		$this->template->title('Administrator Panel : Backup / Restore Data')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Backup / Restore Data')
        ->build($this->admin_folder.'/tools/backup');
		//->build($this->admin_folder.'/perbaikan');
	}
	public function general(){
		$admin_group = array(1,2);
		hak_akses($admin_group);
		$data['settings'] = Setting::first();
		$this->template->title('Administrator Panel : General Setting')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'General Setting')
        ->build($this->admin_folder.'/general', $data);
	}
	public function update(){
		if($_POST){
			$settings 	= Setting::first();
			$setting = array(
				/*'a_max'			=> $_POST['a_max'],
				'a_min' 		=> $_POST['a_min'],
				'b_max'			=> $_POST['b_max'],
				'b_min' 		=> $_POST['b_min'],
				'c_max'			=> $_POST['c_max'],
				'c_min' 		=> $_POST['c_min'],
				'd_max'			=> $_POST['d_max'],
				'd_min' 		=> $_POST['d_min'],*/
				'periode' 		=> $_POST['periode'],
				'sinkronisasi'	=> $_POST['sinkronisasi'],
				'rumus' 		=> $_POST['rumus'],
				'import' 		=> $_POST['import'],
				'desc' 			=> $_POST['desc'],
				'zona' 			=> $_POST['zona'],
			);
			$strings = $setting['periode'];
			$strings = explode('|',$strings);
			$tapel = $strings[0];
			$semester = str_replace(' ','',$strings[1]);
			if($semester == 'SemesterGanjil'){
				$smt = 1;
			} else {
				$smt = 2;
			}	
			$ajarans = Ajaran::find_by_tahun_and_smt($tapel,$smt);
			if(!$ajarans){
				$data_ajarans = array(
					'tahun'				=> $tapel,
					'smt' 				=> $smt
				);
				Ajaran::create($data_ajarans);
			}
			/*if($setting['a_min'] >= $setting['a_max']){
				$this->session->set_flashdata('error', 'Minimal Nilai A tidak boleh sama atau lebih besar dari Maksimal Nilai A');
			} elseif($setting['b_min'] >= $setting['b_max']){
				$this->session->set_flashdata('error', 'Minimal Nilai B tidak boleh sama atau lebih besar dari Maksimal Nilai B');
			} elseif($setting['c_min'] >= $setting['c_max']){
				$this->session->set_flashdata('error', 'Minimal Nilai C tidak boleh sama atau lebih besar dari Maksimal Nilai C');
			} elseif($setting['d_min'] > 0){
				$this->session->set_flashdata('error', 'Minimal Nilai D tidak boleh lebih besar dari 0');
			} else {
				$settings->update_attributes($setting);
			}*/
			$settings->update_attributes($setting);
			$this->session->set_flashdata('success', 'General Setting berhasil di update');
			redirect('admin/config/general');
		} else {
			redirect('admin/dashboard');
		}
	}
	public function users(){
		$join = 'LEFT JOIN users_groups a ON(users.id = a.user_id)';
		$sel = 'users.*, a.group_id AS id_group';
		$data['users'] = User::all(array('joins' => $join,'select'=>$sel,'group' => 'email'));//,'conditions' => "a.group_id != 1"));
		$this->template->title('Administrator Panel : Atur Operator')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Data Pengguna')
        ->build($this->admin_folder.'/users/list', $data);
	}
	public function list_users(){
		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}
		$loggeduser = $this->ion_auth->user()->row();
		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$join = "LEFT JOIN users_groups a ON(users.id = a.user_id)";
		$join .= "INNER JOIN groups b ON(a.group_id = b.id)";
		$sel = 'users.*, a.group_id AS id_group, b.description as nama_group';
		//$data['users'] = User::all(array('joins' => $join,'select'=>$sel,'group' => 'email'));
		$query = User::find('all', array('conditions' => "data_sekolah_id IS NOT NULL AND users.id != $loggeduser->id AND (username LIKE '%$search%' OR nisn LIKE '%$search%' OR nuptk LIKE '%$search%' OR email LIKE '%$search%' OR b.description LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC', 'joins' => $join,'select'=>$sel,'group' => 'email'));
		$filter = User::find('all', array('conditions' => "data_sekolah_id IS NOT NULL AND users.id != $loggeduser->id AND (username LIKE '%$search%' OR nisn LIKE '%$search%' OR nuptk LIKE '%$search%' OR email LIKE '%$search%' OR b.description LIKE '%$search%')",'order'=>'id ASC', 'joins' => $join,'select'=>$sel,'group' => 'email'));
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
	    foreach ($query as $temp) {
			$record = array();
			//if($loggeduser->id != $temp->id){
				$aktifkan = ($temp->active == 1)  ? '<a href="'.site_url('admin/config/deactivate/'.$temp->id).'" class="toggle-modal"><i class="fa fa-power-off"></i>Non Aktifkan</a>' : '<a href="'.site_url('admin/config/activate/'.$temp->id).'"><i class="fa fa-check-square-o"></i>Aktifkan</a>';
				$groups = $this->ion_auth->get_users_groups($temp->id)->result_array(); 
				$record[] = '<div class="text-center">'.($i + 1).'</div>';
				$record[] = $temp->username;
				$record[] = $temp->email;
				$record[] = $temp->phone;
				$record[] = implode(', ', array_map(function ($entry) {
						 	return $entry['description'];
						}, $groups));
				$record[] = status_label($temp->active);
				$record[] = '<div class="text-center"><div class="btn-group">
								<button type="button" class="btn btn-default btn-sm">Aksi</button>
								<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu pull-right text-left" role="menu">
									<li><a href="'.site_url('admin/config/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
									<li><a href="'.site_url('admin/users/edit/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
									<li>'.$aktifkan.'</li>
									<li><a href="'.site_url('admin/config/delete/'.$temp->id).'" class="confim"><i class="fa fa-trash-o"></i>Hapus</a></li>
								</ul>
							</div></div>';
			$i++;
			$output['aaData'][] = $record;
			//}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function view($id){
		$user = User::find($id);
		$this->template->title('Administrator Panel : view user')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'View User')
	        ->set('user', $user)
			->set('modal_footer','')
	        ->set('groups', $this->ion_auth->get_users_groups($id)->result())
	        ->build($this->admin_folder.'/users/view');
	}
	public function deactivate($id = NULL){
		$id = (int) $id;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');
		if ($this->form_validation->run() == FALSE){
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			$this->template->title('Administrator Panel : Non Aktifkan Pendaftar')
	        ->set_layout('modal_tpl')
			->set('modal_footer','')			
	        ->set('page_title',  'Deactivate User' )
	        ->build('auth/deactivate_user', $this->data);
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes'){
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')){
					show_error($this->lang->line('error_csrf'));
				}
				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
					$this->ion_auth->deactivate($id);
					$this->session->set_flashdata('success', $this->ion_auth->messages());
				}
			}
			//redirect them back to the auth page
			redirect('admin/config/users');
		}
	}

	//activate the user
	function activate($id){

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
			$activation = $this->ion_auth->activate($id);
		}
		if ($activation){
			//redirect them to the auth page
			$this->session->set_flashdata('success', $this->ion_auth->messages());
			redirect("admin/config/users");
		} else {
			//redirect them to the forgot password page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("admin/config/users");
		}
	}
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
