<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Asesmen extends Backend_Controller {
	protected $activemenu = 'penilaian';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
		//$admin_group = array(1,2,3,5,6);
		//hak_akses($admin_group);
	}
	public function index(){
		redirect('admin/asesmen/sikap');
	}
	public function sikap(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$pilih_rombel = '<a href="'.site_url('admin/asesmen/add_sikap').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('pilih_rombel', $pilih_rombel)
		->set('page_title', 'Tambah Data Penilaian Sikap')
		->set('form_action', 'admin/asesmen/simpan_sikap')
		->build($this->admin_folder.'/asesmen/list_sikap',$data);
	}
	public function add_sikap(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Jurnal Sikap')
		->set('form_action', 'admin/asesmen/simpan_sikap')
		->build($this->admin_folder.'/asesmen/sikap',$data);
	}
	public function pengetahuan(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Pengetahuan')
		->set('form_action', 'admin/asesmen/simpan_nilai')
		->set('query', 'rencana_penilaian')
		->set('kompetensi_id', 1)
		->build($this->admin_folder.'/asesmen/form_asesmen',$data);
	}
	public function keterampilan(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Keterampilan')
		->set('form_action', 'admin/asesmen/simpan_nilai')
		->set('query', 'rencana_penilaian')
		->set('kompetensi_id', 2)
		->build($this->admin_folder.'/asesmen/form_asesmen',$data);
	}
	public function remedial(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Remedial')
		->set('form_action', 'admin/asesmen/simpan_remedial')
		->set('query', 'remedial')
		->set('kompetensi_id', 1)
		->build($this->admin_folder.'/asesmen/form_remedial',$data);
	}
	public function simpan_remedial(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$kompetensi_id = $_POST['kompetensi_id'];
		$id_mapel = $_POST['id_mapel'];
		$data_siswa = $_POST['siswa_id'];
		$rerata = $_POST['rerata'];
		$rerata_akhir = $_POST['rerata_akhir'];
		$rerata_remedial = $_POST['rerata_remedial'];
		foreach($data_siswa as $k=>$siswa){
			$remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, $kompetensi_id, $rombel_id, $id_mapel, $siswa);
			if($remedial){
				$data_update = array(
									'nilai' => serialize($rerata[$siswa]),
									'rerata_akhir' => $rerata_akhir[$k],
									'rerata_remedial' => $rerata_remedial[$k]
									);
				$remedial->update_attributes($data_update);
				$this->session->set_flashdata('success', 'Berhasil memperbaharui data nilai remedial.');
			} else {
				foreach($rerata as $rata){
					array_walk($rata, 'check_great_than_one_fn');
				}
				$new_remedial					= new Remedial();
				$new_remedial->ajaran_id		= $ajaran_id;
				$new_remedial->kompetensi_id	= $kompetensi_id;
				$new_remedial->rombel_id		= $rombel_id;
				$new_remedial->mapel_id			= $id_mapel;
				$new_remedial->data_siswa_id	= $siswa;
				$new_remedial->nilai			= serialize($rerata[$siswa]);
				$new_remedial->rerata_akhir		= $rerata_akhir[$k];
				$new_remedial->rerata_remedial	= $rerata_remedial[$k];
				$new_remedial->save();
				$this->session->set_flashdata('success', 'Tambah data nilai remedial berhasil.');
			}
		}
		redirect('admin/asesmen/remedial');
	}
	public function get_remedial(){
		$html = '';
		$settings 	= Setting::first();
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id	= $_POST['rombel_id'];
		$id_mapel = $_POST['id_mapel'];
		$kelas = $_POST['kelas'];
		$aspek = $_POST['aspek'];
		$kompetensi_id = ($aspek == 'P') ? 1 : 2;
		$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		$get_all_kd = Kd::find_all_by_id_mapel_and_kelas_and_aspek($id_mapel, $kelas, $aspek);
		if(!$get_all_kd){
			$get_all_kd = Kd::find_all_by_id_mapel_and_kelas_and_aspek($id_mapel, $kelas, 'PK');
		}
		$count_get_all_kd = count($get_all_kd);
		$kkm = get_kkm($ajaran_id, $rombel_id, $id_mapel);
		$html .= '<input type="hidden" name="kompetensi_id" value="'.$kompetensi_id.'" />';
		$html .= '<input type="hidden" id="get_kkm" value="'.$kkm.'" />';
		$html .= '<div class="table-responsive no-padding">';
		$html .= '<div class="row"><div class="col-md-6">';
		$html .= '<table class="table table-bordered">';
		$html .= '<tr>';
		$html .= '<td colspan="2" class="text-center">';
		$html .= '<strong>Keterangan</strong>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td width="30%">';
		$html .= 'KKM';
		$html .= '</td>';
		$html .= '<td>';
		$html .= $kkm;
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '<input type="text" class="bg-red form-control input-sm" />';
		$html .= '</td>';
		$html .= '<td>';
		$html .= 'Tidak tuntas (input aktif)';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '<input type="text" class="bg-green form-control input-sm" />';
		$html .= '</td>';
		$html .= '<td>';
		$html .= 'Tuntas (input non aktif)';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div></div>';
		$html .= '<table class="table table-bordered table-hover">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th rowspan="2" style="vertical-align: middle;">Nama Siswa</th>';
		$html .= '<th class="text-center" colspan="'.count($get_all_kd).'">Kompetensi Dasar</th>';
		$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Akhir</th>';
		$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Remedial</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$get_all_kd_finish = count($get_all_kd);
		foreach($get_all_kd as $all_kd){
			//$kd = Kd::find_by_id($allpengetahuan->kd_id);
			$id_kd = $all_kd->id_kompetensi;
			$id_kds[] = $all_kd->id;
			$html .= '<th><a href="javacript:void(0)" class="tooltip-left" title="'.$all_kd->kompetensi_dasar.'">&nbsp;&nbsp;&nbsp;'.$id_kd.'&nbsp;&nbsp;&nbsp;</a></th>';
		}
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no=0;
		$rencana = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id,$id_mapel,$rombel_id,$kompetensi_id);
		if($rencana){
			foreach($rencana as $ren){
				$id_rencana[] = $ren->id;
			}
			$all_rencana_penilaian = Rencanapenilaian::find('all', array('order'=>'kd_id ASC', 'conditions' => array("rencana_id IN(?)",$id_rencana)));
			if($all_rencana_penilaian){
				foreach($all_rencana_penilaian as $arp){
					$rencana_penilaian_id[] = $arp->id;
				}
			}
		}
		foreach($data_siswa as $siswa){
			$remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, $kompetensi_id, $rombel_id, $id_mapel, $siswa->id);
			$html .= '<input type="hidden" name="siswa_id[]" value="'.$siswa->id.'" />';
			$html .= '<tr>';
			$html .= '<td>';
			$html .= $siswa->nama;
			$html .= '</td>';
			if($remedial){
				$all_nilai = unserialize($remedial->nilai);
				$set_nilai = 0;
				foreach($all_nilai as $key=>$nilai){
					$set_nilai += $nilai;
					if($kkm > number_format($nilai)){
						$aktif = '';
						$bg = 'bg-red';
					} else {
						$aktif = 'readonly';
						$bg = 'bg-green';
					}
					$html .= '<td class="text-center">';
					//$html .= '<input type="hidden" name="rencana_penilaian_id[]" value="'.$nilai->rencana_penilaian_id.'" />';
					$html .= '<input type="text" name="rerata['.$siswa->id.'][]" size="10" class="'.$bg.' form-control input-sm" value="'.number_format($nilai,0).'" '.$aktif.' />';
					$html .= '</td>';
					$no++;
				}
				$count_all_nilai = count($all_nilai);
				if($count_all_nilai < $count_get_all_kd){
					$get_all_kd_finish = $count_all_nilai;
					$kurang = ($count_get_all_kd - $count_all_nilai);
					for ($x = 1; $x <= $kurang; $x++) {
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
					}
				}
				if($kkm > $remedial->rerata_akhir){
					$bg_rerata_akhir = 'text-red';
				} else {
					$bg_rerata_akhir = 'text-green';
				}
				if($kkm > $remedial->rerata_remedial){
					$bg_rerata_remedial = 'text-red';
				} else {
					$bg_rerata_remedial = 'text-green';
				}
				$html .= '<td id="rerata_akhir" class="text-center '.$bg_rerata_akhir.'"><strong>';
				$html .= '<input type="hidden" id="rerata_akhir_input" name="rerata_akhir[]" value="'.$remedial->rerata_akhir.'" />';
				$html .= $remedial->rerata_akhir;
				$html .= '</strong></td>';
				$html .= '<td id="rerata_remedial" class="text-center '.$bg_rerata_remedial.'"><strong>';
				$html .= '<input type="hidden" id="rerata_remedial_input" name="rerata_remedial[]" value="'.$remedial->rerata_remedial.'" />';
				$html .= $remedial->rerata_remedial;
				$html .= '</strong></td>';
			} else {
				if(isset($id_rencana)){
					$set_rencana_id = implode("','",$id_rencana);
					$all_nilai = Nilai::find_by_sql("select b.kd_id, a.id,a.data_siswa_id, a.rencana_penilaian_id, avg(a.nilai) as rata_rata from `nilais` a INNER JOIN rencana_penilaians b ON b.id = a.rencana_penilaian_id AND b.rencana_id IN('$set_rencana_id') WHERE a.data_siswa_id = $siswa->id GROUP BY b.kd_id");
					$no = 1;
					$count_all_nilai = count($all_nilai);
					if($all_nilai){
						$set_nilai = 0;
						foreach($all_nilai as $key=>$nilai){
							$set_nilai += $nilai->rata_rata;
							if($kkm > number_format($nilai->rata_rata)){
								$aktif = '';
								$bg = 'bg-red';
							} else {
								$aktif = 'readonly';
								$bg = 'bg-green';
							}
							$html .= '<td class="text-center">';
							$html .= '<input type="hidden" name="rencana_penilaian_id[]" value="'.$nilai->rencana_penilaian_id.'" />';
							$html .= '<input type="text" name="rerata['.$siswa->id.'][]" size="10" class="'.$bg.' form-control input-sm" value="'.number_format($nilai->rata_rata,0).'" '.$aktif.' />';
							$html .= '</td>';
							$no++;
						}
						if($count_all_nilai < $count_get_all_kd){
							$get_all_kd_finish = $count_all_nilai;
							$kurang = ($count_get_all_kd - $count_all_nilai);
							for ($x = 1; $x <= $kurang; $x++) {
								$html .= '<td class="text-center">';
								$html .= '-';
								$html .= '</td>';
							}
						}
						$rerata_akhir = number_format($set_nilai / count($all_nilai),0);
						if($kkm > $rerata_akhir){
							$bg = 'text-red';
						} else {
							$bg = 'text-green';
						}
						$html .= '<td id="rerata_akhir" class="text-center '.$bg.'"><strong>';
						$html .= '<input type="hidden" id="rerata_akhir_input" name="rerata_akhir[]" value="'.$rerata_akhir.'" />';
						$html .= $rerata_akhir;
						$html .= '</strong></td>';
						$html .= '<td id="rerata_remedial" class="text-center '.$bg.'"><strong>';
						$html .= '<input type="hidden" id="rerata_remedial_input" name="rerata_remedial[]" value="'.$rerata_akhir.'" />';
						$html .= $rerata_akhir;
						$html .= '</strong></td>';
					} else {
						$html .= '<td class="text-center" colspan="'.count($get_all_kd).'">';
						$html .= 'Nilai tidak ditemukan';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
					}
					$no++;
				} else {
					$html .= '<td class="text-center" colspan="'.count($get_all_kd).'">';
					$html .= 'Perencanaan penilaian belum dilakukan!';
					$html .= '</td>';
					$html .= '<td class="text-center">';
					$html .= '-';
					$html .= '</td>';
					$html .= '<td class="text-center">';
					$html .= '-';
					$html .= '</td>';
				}
			}
			$html .= '</tr>';
		}
		$html .= '<input type="hidden" id="get_all_kd" value="'.$get_all_kd_finish.'" />';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css');
		$html .= '<script src="'.base_url().'assets/js/tooltip-viewport.js"></script>';
		$html .= '<script src="'.base_url().'assets/js/remedial.js"></script>';
		echo $html;
	}
	public function add_pengetahuan(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Pengetahuan')
		->set('form_action', 'admin/asesmen/simpan_nilai')
		->set('query', 'rencana_penilaian')
		->set('kompetensi_id', 1)
		->build($this->admin_folder.'/asesmen/form_asesmen',$data);
	}
	public function add_keterampilan(){
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Keterampilan')
		->set('form_action', 'admin/asesmen/simpan_nilai')
		->set('query', 'rencana_penilaian')
		->set('kompetensi_id', 2)
		->build($this->admin_folder.'/asesmen/form_asesmen',$data);
	}
	public function portofolio(){
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Portofolio')
		->set('form_action', 'admin/asesmen/simpan_portofolio')
		->build($this->admin_folder.'/asesmen/portofolio',$data);
	}
	public function simpan_portofolio(){
		redirect('admin/asesmen/portofolio');
	}
	public function mulok(){
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Penilaian Muatan Lokal')
		->set('form_action', 'admin/asesmen/simpan_mulok')
		->build($this->admin_folder.'/asesmen/mulok',$data);
	}
	public function deskripsi_mapel(){
		$ajaran = get_ta();
		$loggeduser = $this->ion_auth->user()->row();
		$siswa = Datasiswa::find_by_id($loggeduser->data_siswa_id);
		if($loggeduser->data_siswa_id){
			$data['ajaran']	= $ajaran->tahun.' Semester '.$ajaran->smt;
			$data['deskripsi'] = Deskripsi::find_all_by_ajaran_id_and_siswa_id($ajaran->id, $siswa->id);
			$this->template->title('Administrator Panel')
			->set_layout($this->admin_tpl)
			->set('page_title', 'Deskripsi per Mata Pelajaran')
			->build($this->admin_folder.'/asesmen/catatan_siswa',$data);
		} else {
			$data['ajarans'] = Ajaran::all();
			$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
			$this->template->title('Administrator Panel')
			->set_layout($this->admin_tpl)
			->set('page_title', 'Deskripsi per Mata Pelajaran')
			->set('form_action', 'admin/asesmen/simpan_deskripsi_mapel')
			->build($this->admin_folder.'/asesmen/deskripsi_mapel',$data);
		}
	}
	public function simpan_deskripsi_mapel(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$mapel_id = $_POST['id_mapel'];
		$siswa_id = $_POST['siswa_id'];
		$deskripsi_mulok = isset($_POST['deskripsi_mulok']) ? $_POST['deskripsi_mulok'] : '';
		foreach($siswa_id as $key=>$siswa){
			$deskripsi_pengetahuan = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapel_id,$siswa);
			if($deskripsi_pengetahuan){
				if($deskripsi_mulok){
					$data_update = array('deskripsi_mulok' => $_POST['deskripsi_mulok'][$key]);	
				} else {
					$data_update = array(
									'deskripsi_pengetahuan' => $_POST['deskripsi_pengetahuan'][$key],
									'deskripsi_keterampilan' => $_POST['deskripsi_keterampilan'][$key],
									);
				}
				$deskripsi_pengetahuan->update_attributes($data_update);
				$this->session->set_flashdata('error', 'Terdeteksi data existing. Data di update!');
			} else {
				$new_deskripsi_pengetahuan					= new Deskripsi();
				$new_deskripsi_pengetahuan->ajaran_id		= $ajaran_id;
				$new_deskripsi_pengetahuan->rombel_id		= $rombel_id;
				$new_deskripsi_pengetahuan->mapel_id		= $mapel_id;
				$new_deskripsi_pengetahuan->siswa_id		= $siswa;
				if($deskripsi_mulok){
					$new_deskripsi_pengetahuan->deskripsi_mulok		= $_POST['deskripsi_mulok'][$key];
				} else {
					$new_deskripsi_pengetahuan->deskripsi_pengetahuan		= $_POST['deskripsi_pengetahuan'][$key];
					$new_deskripsi_pengetahuan->deskripsi_keterampilan		= $_POST['deskripsi_keterampilan'][$key];
				}
				$new_deskripsi_pengetahuan->save();
				$this->session->set_flashdata('success', 'Berhasil menambah deskripsi per mata pelajaran');
			}
		}
		redirect('admin/asesmen/deskripsi_mapel');
	}
	public function get_siswa(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$all_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		$all_mapel = Kurikulum::find_all_by_rombel_id($rombel_id);
		$all_mulok = Mulok::find_all_by_ajaran_id_and_rombel_id($ajaran_id,$rombel_id);
		if($all_mapel){
			foreach($all_mapel as $mapel){
				$data_mapel = Datamapel::find_by_id_mapel($mapel->id_mapel);
				$record= array();
				$record['value'] 	= $mapel->id_mapel;
				$record['text'] 	= $data_mapel->nama_mapel.' ('.$data_mapel->id_mapel.')';
				$output['mapel'][] = $record;
			}
		} else {
			$record['value'] 	= '0';
			$record['text'] 	= 'Tidak ditemukan mata pelajaran di kelas terpilih';
			$output['mapel'][] = $record;
		}
		if($all_siswa){
			foreach($all_siswa as $siswa){
				$record= array();
				$record['value'] 	= $siswa->id;
				$record['text'] 	= $siswa->nama;
				$output['result'][] = $record;
			}
		} else {
			$record['value'] 	= '0';
			$record['text'] 	= 'Tidak ditemukan siswa di rombel terpilih';
			$output['result'][] = $record;
		}
		if($all_mulok){
			foreach($all_mulok as $mulok){
				$record= array();
				$record['value'] 	= $mulok->id;
				$record['text'] 	= $mulok->nama_mulok;
				$output['mulok'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan mata pelajaran mulok di rombel terpilih';
			$output['mulok'][] = $record;
		}
		echo json_encode($output);
	}
	public function get_prakerin(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['rombel_id'] = $_POST['rombel_id'];
		$data['siswa_id'] = $_POST['siswa_id'];
		$this->template->title('Administrator Panel')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Entry Absensi')
		->build($this->admin_folder.'/laporan/add_prakerin',$data);
	}
	public function get_prestasi(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['rombel_id'] = $_POST['rombel_id'];
		$data['siswa_id'] = $_POST['siswa_id'];
		$this->template->title('Administrator Panel')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Entry Absensi')
		->build($this->admin_folder.'/laporan/add_prestasi',$data);
	}
	function form_sikap($ajaran_id,$rombel_id,$mapel_id,$siswa_id){
		$ajaran = get_ta();
		$data['all_sikap'] = Sikap::find_all_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapel_id,$siswa_id);
		$data['data_sikap'] = Datasikap::find_all_by_ajaran_id($ajaran->id);
		$data['mapel_id'] = $mapel_id;
		$this->template->title('')
		->set_layout($this->blank_tpl)
		->set('page_title', '')
		->build($this->admin_folder.'/asesmen/form_sikap',$data);
	}
	public function get_sikap(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$mapel_id = $_POST['id_mapel'];
		$siswa_id = $_POST['siswa_id'];
		$this->form_sikap($ajaran_id,$rombel_id,$mapel_id,$siswa_id);
	}
	public function edit_sikap($id){
		if($_POST){
			$sikap = Sikap::find_by_id($id);
			$sikap->update_attributes(
				array(
					'butir_sikap' => $_POST['butir_sikap'], 
					'opsi_sikap' => $_POST['opsi_sikap'], 
					'uraian_sikap' => $_POST['uraian_sikap']
				)
			);
			$ajaran_id = $_POST['ajaran_id'];
			$rombel_id = $_POST['rombel_id'];
			$siswa_id = $_POST['siswa_id'];
			$this->form_sikap($ajaran_id,$rombel_id,$siswa_id);
		} else {
			$sikap = Sikap::find_by_id($id);
			$data_sikap = Datasikap::all();
			$this->template->title('Administrator Panel : Edit Sikap')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Edit Sikap')
			->set('sikap', $sikap)
			->set('data_sikap', $data_sikap)
			->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
			->build($this->admin_folder.'/asesmen/edit_sikap');
		}
	}
	public function simpan_mulok(){
	//echo '<pre>';
	//print_r($_POST);
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$mapel_id = $_POST['id_mapel'];
		$nama_penilaian = $_POST['nama_penilaian'];
		$bentuk_penilaian = $_POST['bentuk_penilaian'];
		$bobot_penilaian = $_POST['bobot_penilaian'];
		$kompetensi_id = $_POST['kompetensi_id'];
		$siswa_id	= $_POST['siswa_id'];
		foreach($siswa_id as $key=>$siswa){
			$i=1;
			foreach($nama_penilaian as $k=>$namapenilaian){
				$nilai_mulok = Nilaimulok::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_kompetensi_id_and_bentuk_penilaian($ajaran_id, $rombel_id, $mapel_id, $siswa, $kompetensi_id, $bentuk_penilaian[$k]);
				if($nilai_mulok){
					$nilai_mulok->update_attributes(
						array(
							'nama_penilaian' => $namapenilaian,
							'bobot_penilaian' => $bobot_penilaian[$k], 
							'nilai' => $_POST['kd_'.$i][$key]
						)
					);
				} else {
					if($namapenilaian){
						$new_nilai_mulok = new Nilaimulok();
						$new_nilai_mulok->ajaran_id = $ajaran_id;
						$new_nilai_mulok->rombel_id = $rombel_id;
						$new_nilai_mulok->mapel_id = $mapel_id;
						$new_nilai_mulok->kompetensi_id = $kompetensi_id;
						$new_nilai_mulok->data_siswa_id = $siswa;
						$new_nilai_mulok->nama_penilaian = $namapenilaian;
						$new_nilai_mulok->bentuk_penilaian = $bentuk_penilaian[$k];
						$new_nilai_mulok->bobot_penilaian = $bobot_penilaian[$k];
						$new_nilai_mulok->nilai = $_POST['kd_'.$i][$key];
						$new_nilai_mulok->save();
					}
				}
				//echo $siswa.'=>'.$namapenilaian.'=>'.$bentuk_penilaian[$k].'=>'.$bobot_penilaian[$k].'=>'.$_POST['kd_'.$i][$key].'<br />';
				$i++;
			}
		}
		$this->session->set_flashdata('success', 'Berhasil menambah nilai muatan lokal');
		redirect('admin/asesmen/mulok');
	}
	public function simpan_sikap(){
		$ajaran_id		= $_POST['ajaran_id'];
		$rombel_id		= $_POST['rombel_id'];
		$mapel_id		= $_POST['mapel_id'];
		$siswa_id		= $_POST['siswa_id'];
		$tanggal_sikap	= $_POST['tanggal_sikap'];
		//$tanggal_sikap	= str_replace('/','-',$tanggal_sikap);
		$tanggal_sikap	= date('Y-m-d', strtotime($tanggal_sikap));
		$butir_sikap	= $_POST['butir_sikap'];
		$opsi_sikap		= $_POST['opsi_sikap'];
		$uraian_sikap	= $_POST['uraian_sikap'];
		$sikap = Sikap::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id_and_butir_sikap($ajaran_id,$rombel_id, $mapel_id, $siswa_id,$butir_sikap);
		if($sikap){
			/*$sikap->ajaran_id		= $ajaran_id;
			$sikap->rombel_id		= $rombel_id;
			$sikap->siswa_id		= $siswa_id;
			$sikap->tanggal_sikap	= $tanggal_sikap;
			$sikap->butir_sikap		= $butir_sikap;
			$sikap->uraian_sikap	= $uraian_sikap;
			$sikap->save();*/
			$this->session->set_flashdata('error', 'Terdeteksi data existing');
		} else {
			$attributes = array(
								'ajaran_id'	=> $ajaran_id,
								'rombel_id'	=> $rombel_id,
								'mapel_id'	=> $mapel_id,
								'siswa_id'	=> $siswa_id,
								'tanggal_sikap' => $tanggal_sikap,
								'butir_sikap'	=> $butir_sikap,
								'opsi_sikap'		=> $opsi_sikap,
								'uraian_sikap' => $uraian_sikap,
							);
			$sikap = Sikap::create($attributes);
			$this->session->set_flashdata('success', 'Berhasil menambah data sikap');
		}
		redirect('admin/asesmen/sikap');
	}
	public function get_deskripsi_mapel(){
		$ajaran_id	= $_POST['ajaran_id'];
    	$rombel_id	= $_POST['rombel_id'];
    	$id_mapel	= $_POST['id_mapel'];
		$rombel = Datarombel::find_by_id($rombel_id);
		$all_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		$mapel = Datamapel::find($id_mapel);
		$html = '';
		if($all_siswa){
			$html .= '<div class="table-responsive no-padding">';
			$html .= '<table class="table table-bordered table-hover">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th width="20%">Nama Siswa</th>';
			$html .= '<th width="40%">Deskripsi Pengetahuan</th>';
			$html .= '<th width="40%">Deskripsi Keterampilan</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$result_kd_pengetahuan_tertinggi = 'Belum dilakukan penilaian';
			$result_kd_pengetahuan_terendah = 'Belum dilakukan penilaian';
			$result_kd_keterampilan_tertinggi = 'Belum dilakukan penilaian';
			$result_kd_keterampilan_terendah = 'Belum dilakukan penilaian';
			foreach($all_siswa as $key=>$siswa){
				$nilai_pengetahuan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id);
				if($nilai_pengetahuan){
					foreach($nilai_pengetahuan as $nilaipengetahuan){
						$rencana_pengetahuan_id[$key] = $nilaipengetahuan->rencana_penilaian_id;
						$get_nilai_pengetahuan[] = $nilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_tertinggi = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id, bilanganBesar($get_nilai_pengetahuan));
					if($nilai_pengetahuan_tertinggi){
						$rencana_penilaian_pengetahuan_tertinggi = Rencanapenilaian::find($nilai_pengetahuan_tertinggi->rencana_penilaian_id);
						$get_kd_pengetahuan_tertinggi = Kd::find($rencana_penilaian_pengetahuan_tertinggi->kd_id);
						$result_kd_pengetahuan_tertinggi = 'Sangat menonjol pada kompetensi '.strtolower($get_kd_pengetahuan_tertinggi->kompetensi_dasar);
					}
					//space tinggi rendah
					$nilai_pengetahuan_terendah = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 1, $rombel_id, $id_mapel, $siswa->id, bilanganKecil($get_nilai_pengetahuan));
					if($nilai_pengetahuan_terendah){
						$rencana_penilaian_pengetahuan_terendah = Rencanapenilaian::find($nilai_pengetahuan_terendah->rencana_penilaian_id);
						$get_kd_pengetahuan_terendah = Kd::find($rencana_penilaian_pengetahuan_terendah->kd_id);
						$result_kd_pengetahuan_terendah = ' dan perlu meningkatkan kompetensi '.strtolower($get_kd_pengetahuan_terendah->kompetensi_dasar);
					}
				}
				$nilai_keterampilan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id);
				if($nilai_keterampilan){
					foreach($nilai_keterampilan as $nilaiketerampilan){
						$rencana_keterampilan_id[$key] = $nilaiketerampilan->rencana_penilaian_id;
						$get_nilai_keterampilan[] = $nilaiketerampilan->nilai;
					}
					$nilai_keterampilan_tertinggi = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id, bilanganBesar($get_nilai_keterampilan));
					if($nilai_keterampilan_tertinggi){
						$rencana_penilaian_keterampilan_tertinggi = Rencanapenilaian::find_by_id($nilai_keterampilan_tertinggi->rencana_penilaian_id);
						if($rencana_penilaian_keterampilan_tertinggi){
							$get_kd_keterampilan_tertinggi = Kd::find($rencana_penilaian_keterampilan_tertinggi->kd_id);
							$result_kd_keterampilan_tertinggi = 'Sangat menonjol pada kompetensi '.strtolower($get_kd_keterampilan_tertinggi->kompetensi_dasar);
						}
					}
					//space tinggi rendah
					$nilai_keterampilan_terendah = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_nilai($ajaran_id, 2, $rombel_id, $id_mapel, $siswa->id, bilanganKecil($get_nilai_keterampilan));
					if($nilai_keterampilan_terendah){
						$rencana_penilaian_keterampilan_terendah = Rencanapenilaian::find_by_id($nilai_keterampilan_terendah->rencana_penilaian_id);
						if($rencana_penilaian_keterampilan_terendah){
							$get_kd_keterampilan_terendah = Kd::find_by_id($rencana_penilaian_keterampilan_terendah->kd_id);
							$result_kd_keterampilan_terendah = ' dan perlu meningkatkan kompetensi '.strtolower($get_kd_keterampilan_terendah->kompetensi_dasar);
						}
					}
				}
				$html .= '<input type="hidden" name="siswa_id[]" value="'.$siswa->id.'" />';
				$html .= '<tr>';
				$html .= '<td>';
				$html .= $siswa->nama;
				$html .= '</td>';
				$html .= '<td>';
				$html .= '<textarea name="deskripsi_pengetahuan[]" class="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">';
				//$html .= bilanganKecil($get_nilai_pengetahuan).'<br />';
				//$html .= bilanganBesar($get_nilai_pengetahuan).'<br />';
				$html .= $result_kd_pengetahuan_tertinggi.'<br />'.$result_kd_pengetahuan_terendah;
				$html .= '</textarea>';
				$html .= '</td>';
				$html .= '<td>';
				$html .= '<textarea name="deskripsi_keterampilan[]" class="editor" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">';
				$html .= $result_kd_keterampilan_tertinggi.'<br />'.$result_kd_keterampilan_terendah;
				$html .= '</textarea>';
				$html .= '</td>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
		} else {
			$html .= '<h4>Belum ada siswa di kelas terpilih</h4>';
		}
		$html .= '<script>';
		$html .= '$(".editor").wysihtml5({';
		$html .= '"font-styles": false,';
		$html .= '"emphasis": true,';
		$html .= '"lists": false,';
		$html .= '"html": false,';
		$html .= '"link": false,';
		$html .= '"image": false,';
		$html .= '"color": false';
		$html .= '});';
		$html .= '</script>';
		echo $html;
	}
	public function get_rerata(){
		$siswa_id = $_POST['siswa_id'];
		$jumlah_kd = $_POST['jumlah_kd'];
		$bobot = $_POST['bobot_kd'];
		$all_bobot = $_POST['all_bobot'];
		$kompetensi_id = $_POST['kompetensi_id'];
		/*$rencana_id = $_POST['rencana'];
		$get_all_bobot = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $rencana->id", 'group' => 'nama_penilaian',));
		foreach($get_all_bobot as $getbobot){
			$html .= '<input type="hidden" name="all_bobot[]" value="'.$getbobot->bobot_penilaian.'" />';
		}*/
		//if($kompetensi_id == 1){
			$total_bobot = 0;
			foreach($all_bobot as $allbobot){
				$total_bobot += $allbobot;
			}
			$total_bobot = ($total_bobot > 0) ? $total_bobot : 1;
			$bobot = ($bobot > 0) ? $bobot : 1;
			$output['jumlah_form'] = count($siswa_id);
			foreach($siswa_id as $k=>$siswa){
				$hitung=0;
				for ($i = 1; $i <= $jumlah_kd; $i++) {
					$hitung += $_POST['kd_'.$i][$k];
				}
				$hasil = $hitung/$jumlah_kd;
				$rerata_nilai = $hasil*$bobot;//($hasil*$bobot)/$total_bobot;
				$rerata_jadi = number_format($rerata_nilai/$total_bobot,2);
				$record['value'] 	= number_format($hitung/$jumlah_kd,0);
				//=F6*(C4/(C4+G4+J4+M4))
				$record['rerata_text'] 	= 'x '.$bobot.' / '.$total_bobot.' =';
				$record['rerata_jadi'] 	= $rerata_jadi;
				$output['rerata'][] = $record;
			}
			$settings 	= Setting::first();
			$html = '';
			if($settings->rumus == 1){
				$html .= '<p><strong>Rumus nilai akhir per penilaian: <br />Rerata * Bobot Penilaian / Total bobot penilaian per mapel</strong></p>';
				$html .= '<p>Keterangan: <br />Bobot : '.$bobot.'<br />Total Bobot : '.$total_bobot.'</p>';
			}
			$output['rumus'] = $html;
		/*} else {
			$output['jumlah_form'] = count($siswa_id);
			foreach($siswa_id as $k=>$siswa){
				$hitung=0;
				for ($i = 1; $i <= $jumlah_kd; $i++) {
					if($_POST['kd_'.$i][$k]){
						$hitung += $_POST['kd_'.$i][$k];//
					} else {
						$hitung = 0;
					}
				}
				$hitung_nilai = $hitung / $jumlah_kd;
				$record['value'] 	= number_format($hitung_nilai,0);
				//=F6*(C4/(C4+G4+J4+M4))
				$record['rerata_text'] 	= '';
				$record['rerata_jadi'] 	= $hitung_nilai;
				$output['rerata'][] = $record;
			}
			$output['rumus'] = '';
		}*/
		echo json_encode($output);
	}
	public function simpan_nilai(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$id_mapel = $_POST['id_mapel'];
		$penilaian_penugasan = $_POST['rencana_id'];
		$post = explode("#", $penilaian_penugasan);
		$rencana_id = $post[0];
		$bentuk_penilaian = $post[1];
		$rencana_penilaian_id = $post[2];
		$get_rencana = Rencana::find_by_id($rencana_id);
		$jumlah_kd = $_POST['jumlah_kd'];
		$siswa_id = $_POST['siswa_id'];
		$redirect = '';
		if($get_rencana->kompetensi_id == 1){
			$redirect = 'pengetahuan';
		} else {
			$redirect = 'keterampilan';
		}
		foreach($siswa_id as $k=>$siswa){
			for ($i = 1; $i <= $jumlah_kd; $i++) {
				if($_POST['kd_'.$i][$k] > 100){
					$this->session->set_flashdata('error', 'Tambah data nilai '.$redirect.' gagal. Nilai harus tidak lebih besar dari 100');
					redirect('admin/asesmen/'.$redirect);
				}
			}
		}
		foreach($siswa_id as $k=>$siswa){
			$nilai_akhir = Nilaiakhir::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id_and_rencana_penilaian_id($ajaran_id, $get_rencana->kompetensi_id, $rombel_id, $id_mapel, $siswa,$rencana_penilaian_id);
			if($nilai_akhir){
				$nilai_akhir->update_attributes(
					array(
						'rerata_nilai'	=> $_POST['rerata'][$k],
						'nilai'	 		=> $_POST['rerata_jadi'][$k],
						)
					);
			} else {
				$new_nilai_akhir							= new Nilaiakhir();
				$new_nilai_akhir->ajaran_id					= $ajaran_id;
				$new_nilai_akhir->kompetensi_id				= $get_rencana->kompetensi_id;
				$new_nilai_akhir->rombel_id					= $rombel_id;
				$new_nilai_akhir->mapel_id					= $id_mapel;
				$new_nilai_akhir->rencana_penilaian_id		= $rencana_penilaian_id;
				$new_nilai_akhir->siswa_id					= $siswa;
				$new_nilai_akhir->rerata_nilai				= $_POST['rerata'][$k];
				$new_nilai_akhir->nilai						= $_POST['rerata_jadi'][$k];
				$new_nilai_akhir->save();
			}
			for ($i = 1; $i <= $jumlah_kd; $i++) {
				$nilai = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, $get_rencana->kompetensi_id, $rombel_id, $id_mapel, $siswa, $_POST['rencana_penilaian_id_'.$i][$k]);
				if($nilai){
					$nilai->update_attributes(
						array(
							'ajaran_id' => $ajaran_id, 
							'ajaran_id' => $ajaran_id, 
							'kompetensi_id' => $get_rencana->kompetensi_id, 
							'rombel_id' => $rombel_id, 
							'mapel_id' => $id_mapel, 
							'data_siswa_id' => $siswa,
							'rencana_penilaian_id' => $_POST['rencana_penilaian_id_'.$i][$k],
							'nilai'	=> $_POST['kd_'.$i][$k],
							'rerata'	=> $_POST['rerata'][$k],
							'rerata_jadi'	=> $_POST['rerata_jadi'][$k]
							)
						);
				} else {
					$new_nilai							= new Nilai();
					$new_nilai->ajaran_id				= $ajaran_id;
					$new_nilai->kompetensi_id			= $get_rencana->kompetensi_id;
					$new_nilai->rombel_id				= $rombel_id;
					$new_nilai->mapel_id				= $id_mapel;
					$new_nilai->data_siswa_id			= $siswa;
					$new_nilai->rencana_penilaian_id	= $_POST['rencana_penilaian_id_'.$i][$k];
					$new_nilai->nilai					= $_POST['kd_'.$i][$k];
					$new_nilai->rerata					= $_POST['rerata'][$k];
					$new_nilai->rerata_jadi				= $_POST['rerata_jadi'][$k];
					$new_nilai->save();
				}
			}	
		}
		$this->session->set_flashdata('success', 'Berhasil menambah data nilai '.$redirect);
		redirect('admin/asesmen/'.$redirect);
	}
	public function simpan_nilai_keterampilan(){
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
		$id_mapel = $_POST['id_mapel'];
		$penilaian_penugasan = $_POST['penilaian_penugasan'];
		$post = explode("#", $penilaian_penugasan);
		$rencana_id = $post[0];
		$bentuk_penilaian = $post[1];
		$get_rencana = Rencana::find_by_id($rencana_id);
		$jumlah_kd = $_POST['jumlah_kd'];
		$siswa_id = $_POST['siswa_id'];
		foreach($siswa_id as $k=>$siswa){
			for ($i = 1; $i <= $jumlah_kd; $i++) {
				$nilai = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, $get_rencana->kompetensi_id, $rombel_id, $id_mapel, $siswa, $_POST['rencana_penilaian_id_'.$i][$k]);
				if($nilai){
					$nilai->update_attributes(
						array(
							'ajaran_id' => $ajaran_id, 
							'ajaran_id' => $ajaran_id, 
							'kompetensi_id' => $get_rencana->kompetensi_id, 
							'rombel_id' => $rombel_id, 
							'mapel_id' => $id_mapel, 
							'data_siswa_id' => $siswa,
							'rencana_penilaian_id' => $_POST['rencana_penilaian_id_'.$i][$k],
							'nilai'	=> $_POST['kd_'.$i][$k]
							)
						);
				} else {
					$new_nilai							= new Nilai();
					$new_nilai->ajaran_id				= $ajaran_id;
					$new_nilai->kompetensi_id			= $get_rencana->kompetensi_id;
					$new_nilai->rombel_id				= $rombel_id;
					$new_nilai->mapel_id				= $id_mapel;
					$new_nilai->data_siswa_id			= $siswa;
					$new_nilai->rencana_penilaian_id	= $_POST['rencana_penilaian_id_'.$i][$k];
					$new_nilai->nilai					= $_POST['kd_'.$i][$k];
					$new_nilai->save();
				}
			}	
		}
		redirect('admin/asesmen/keterampilan');
	}
	public function delete_file($id,$file){
		$portofolio = Dataportofolio::find($id);
		$portofolio->delete();
		$filename = './uploads/'.$file;
		if (file_exists($filename)) {
			unlink($filename);
		}
	}
	public function get_nilai(){
		$query = $_POST['query'];
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['id_mapel'] = $_POST['id_mapel'];
		$data['rombel_id'] = $_POST['rombel_id'];
		$data['kompetensi_id'] = isset($_POST['kompetensi_id']) ? $_POST['kompetensi_id'] : '';
		if($query == 'nilai'){
			$query = 'portofolio';
		}
		$this->template->title('')
		->set_layout($this->blank_tpl)
		->set('page_title', '')
		->build($this->admin_folder.'/asesmen/form_'.$query,$data);
	}
	public function get_kd_penilaian(){
		$html = '';
		$settings 	= Setting::first();
		$ajaran_id = $_POST['ajaran_id'];
		$post	= $_POST['rencana_id'];
		$post = explode("#", $post);
		$rencana_id = $post[0];
		$nama_penilaian = $post[1];
		$bobot_kd = $post[3];
		$bobot_kd = ($bobot_kd > 0) ? $bobot_kd : 1;
		$rombel_id	= $_POST['rombel_id'];
		$id_mapel = $_POST['id_mapel'];
		$kompetensi_id = $_POST['kompetensi_id'];
		$rencana = Rencana::find_by_id($rencana_id);
		$html .= '<input type="hidden" name="bobot_kd" value="'.$bobot_kd.'" />';
		$all_rencana = Rencana::find_all_by_ajaran_id_and_rombel_id_and_id_mapel_and_kompetensi_id($ajaran_id,$rombel_id,$id_mapel,$kompetensi_id);
		foreach($all_rencana as $ren){
				$id_rencana[] = $ren->id;
		} 
		$get_all_bobot_new = Rencanapenilaian::find('all', array('group' => 'nama_penilaian','order'=>'id ASC', 'conditions' => array("rencana_id IN(?)",$id_rencana)));
		$data_mapel = Datamapel::find_by_id_mapel($id_mapel);
		if($data_mapel){
			$nama_mapel = $data_mapel->nama_mapel;
		} else {
			$nama_mapel = '';
		}
		$get_all_bobot = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $rencana->id", 'group' => 'nama_penilaian',));
		$all_pengetahuan = Rencanapenilaian::find_all_by_rencana_id_and_nama_penilaian($rencana_id,$nama_penilaian);
		$data_siswa = filter_agama_siswa($nama_mapel,$rencana->rombel_id);
		foreach($get_all_bobot_new as $getbobot){
			$set_bobot = ($getbobot->bobot_penilaian > 0) ? $getbobot->bobot_penilaian : 1;
			$html .= '<input type="hidden" name="all_bobot[]" value="'.$set_bobot.'" />';
			$html .= '<input type="hidden" name="rencana_penilaian_id[]" value="'.$getbobot->id.'" />';
		}
		if($all_pengetahuan){
			$jumlah_kd = count($all_pengetahuan);
			$html .= '<input type="hidden" name="jumlah_kd" value="'.$jumlah_kd.'" />';
			$html .= '<input type="hidden" name="rencana" value="'.$rencana_id.'" />';
			$html .= '<div class="table-responsive no-padding">';
			$html .= '<table class="table table-bordered table-hover">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th rowspan="2" style="vertical-align: middle;">Nama Siswa</th>';
			$html .= '<th class="text-center" colspan="'.$jumlah_kd.'">Kompetensi Dasar</th>';
			//if($rencana->kompetensi_id == 1){
				$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Nilai</th>';
			//}
			if($settings->rumus == 1){
				$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rumus</th>';
				$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Nilai Akhir<br />Per Penilaian</th>';
			}
			$html .= '</tr>';
			$html .= '<tr>';
			foreach($all_pengetahuan as $allpengetahuan){
				$kd = Kd::find_by_id($allpengetahuan->kd_id);
				//$html .= '<input type="text" name="bobot_kd" value="'.$allpengetahuan->bobot_penilaian.'" />';
				$id_kd = $kd->id_kompetensi;
				$html .= '<th><a href="javacript:void(0)" class="tooltip-left" title="'.$kd->kompetensi_dasar.'">'.$id_kd.'</a></th>';
			}
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no=0;
			foreach($data_siswa as $siswa){
				$html .= '<input type="hidden" name="siswa_id[]" value="'.$siswa->id.'" />';
				$html .= '<tr>';
				$html .= '<td>';
				$html .= $siswa->nama;
				$html .= '</td>';
				$i=1;
				foreach($all_pengetahuan as $allpengetahuan){
					$nilai = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, $rencana->kompetensi_id, $rencana->rombel_id, $rencana->id_mapel, $siswa->id, $allpengetahuan->id);
					$nilai_value = isset($nilai) ? $nilai->nilai : '';
					$rerata = isset($nilai) ? $nilai->rerata : '';
					$rerata_jadi = isset($nilai) ? $nilai->rerata_jadi : '';
					$html .= '<input type="hidden" name="rencana_penilaian_id_'.$i.'[]" value="'.$allpengetahuan->id.'" />';
					$html .= '<td><input type="text" name="kd_'.$i.'[]" size="10" class="form-control" value="'.$nilai_value.'" autocomplete="off" maxlength="3" required /></td>';
					$i++;
				}
				//if($rencana->kompetensi_id == 1){
					$html .= '<td><input type="text" name="rerata[]" id="rerata_'.$no.'" size="10" class="form-control" value="'.$rerata.'" readonly /></td>';
				//} else {
					//$html .= '<input type="hidden" name="rerata[]" id="rerata_'.$no.'" size="10" class="form-control" value="'.$rerata.'" />';
				//}
				if($settings->rumus == 1){
					$html .= '<td class="text-center"><strong><span id="rerata_text_'.$no.'"></span></strong></td>';
					$html .= '<td><input type="text" name="rerata_jadi[]" id="rerata_jadi_'.$no.'" size="10" class="form-control" value="'.$rerata_jadi.'" readonly /></td>';
				} else {
					$html .= '<input type="hidden" name="rerata_jadi[]" id="rerata_jadi_'.$no.'" size="10" class="form-control" value="'.$rerata_jadi.'" readonly />';
				}
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
		} else {
			$html .= '<h4>Tidak ada KD terpilih di Perencanaan Penilaian</h4>';
		}
		$html .= link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css');
		$html .= '<script src="'.base_url().'assets/js/tooltip-viewport.js"></script>';
		//echo $jumlah_kd;
		echo $html;
	}
	public function get_analisis_penilaian(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['rombel_id'] = $_POST['rombel_id'];
		$data['mapel_id'] = $_POST['id_mapel'];
		$post	= $_POST['penilaian'];
		$post = explode("#", $post);
		$data['rencana_id'] = $post[0];
		if(!isset($post[1])){
			exit;
		}
		$data['nama_penilaian'] = $post[1];
		$data['kompetensi_id'] = $post[2];
		$this->template->title('Administrator Panel')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Analisis Hasil Penilaian')
		->build($this->admin_folder.'/monitoring/analisis_penilaian',$data);
	}
	public function get_analisis_kompetensi(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$post	= $_POST['penilaian'];
		$post = explode("#", $post);
		if(!isset($post[1])){
			exit;
		}
		$rencana_id = $post[0];
		$nama_penilaian = $post[1];
		$rencana_penilaian = Rencanapenilaian::find_all_by_rencana_id_and_nama_penilaian($rencana_id,$nama_penilaian);
		if($rencana_penilaian){
			ksort($rencana_penilaian);
			foreach($rencana_penilaian as $rp){
				$record= array();
				$record['value'] 	= $rp->kd_id.'#'.$rp->id;
				$record['text'] 	= $rp->kd;
				$output['result'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan KD di rencana penilaian terpilih';
			$output['result'][] = $record;
		}
		echo json_encode($output);
	}
	public function get_analisis_individu($id = NULL){
		$html = '';
		if($id){
			$ajaran = get_ta();
			$siswa = Datasiswa::find_by_id($id);
			$mapel = Datamapel::find_by_id_mapel($_POST['id_mapel']);
			$data_rombel = Datarombel::find_by_id($siswa->data_rombel_id);
			$nilai_pengetahuan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran->id, 1, $siswa->data_rombel_id, $mapel->id_mapel, $siswa->id);
			$nilai_keterampilan = Nilai::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran->id, 2, $siswa->data_rombel_id, $mapel->id_mapel, $siswa->id);
			$html .= '<table class="table table-bordered table-hover">';
			$html .= '<tr>';
			$html .= '<th width="10%" class="text-center">ID KD</th>';
			$html .= '<th width="80%">Kompetensi Dasar Pengetahuan</th>';
			$html .= '<th width="10%" class="text-center">Rerata Nilai</th>';
			$html .= '</tr>';
			foreach($nilai_pengetahuan as $np){
				$rencana_penilaian_pengetahuan = Rencanapenilaian::find_by_id($np->rencana_penilaian_id);
				$get_pengetahun[$rencana_penilaian_pengetahuan->kd][] = $np->nilai;
			}
			ksort($get_pengetahun);
			foreach($get_pengetahun as $key=>$gp){
				$get_kompetensi = Kd::find_by_id_kompetensi_and_id_mapel_and_kelas($key,$mapel->id_mapel,$data_rombel->tingkat);
				$jumlah_kd = array_sum($gp);
				$rerata_nilai = number_format(($jumlah_kd / count($gp)),0);
				$html .= '<tr>';
				$html .= '<td class="text-center">'.$key.'</td>';
				$html .= '<td>'.$get_kompetensi->kompetensi_dasar.'</td>';
				$html .= '<td class="text-center">'.$rerata_nilai.'</td>';
				$html .= '</tr>';
			}
			$html .= '</table>';
			$html .= '<table class="table table-bordered table-hover" style="margin-top:10px;">';
			$html .= '<tr>';
			$html .= '<th width="10%" class="text-center">ID KD</th>';
			$html .= '<th width="80%">Kompetensi Dasar Keterampilan</th>';
			$html .= '<th width="10%" class="text-center">Rerata Nilai</th>';
			$html .= '</tr>';
			foreach($nilai_keterampilan as $nk){
				$rencana_penilaian_keterampilan = Rencanapenilaian::find_by_id($nk->rencana_penilaian_id);
				$get_keterampilan[$rencana_penilaian_keterampilan->kd][] = $nk->nilai;
			}
			ksort($get_keterampilan);
			foreach($get_keterampilan as $key=>$gk){
				$get_kompetensi = Kd::find_by_id_kompetensi_and_id_mapel_and_kelas($key,$mapel->id_mapel,$data_rombel->tingkat);
				$jumlah_kd = array_sum($gk);
				$rerata_nilai = number_format(($jumlah_kd / count($gk)),0);
				$html .= '<tr>';
				$html .= '<td class="text-center">'.$key.'</td>';
				$html .= '<td>'.$get_kompetensi->kompetensi_dasar.'</td>';
				$html .= '<td class="text-center">'.$rerata_nilai.'</td>';
				$html .= '</tr>';
			}
			$html .= '</table>';
			echo $html;
		} else {
			$ajaran = get_ta();
			$data['ajaran_id'] = isset($_POST['ajaran_id']) ? $_POST['ajaran_id'] : $ajaran->id;
			$data['id_mapel'] = $_POST['id_mapel'];
			$data['rombel_id'] = $_POST['rombel_id'];
			$data['siswa_id'] = $_POST['siswa_id'];
			$this->template->title('Administrator Panel')
			->set_layout($this->blank_tpl)
			->set('page_title', '')
			->build($this->admin_folder.'/monitoring/analisis_individu',$data);
			/*$siswa = Datasiswa::find_by_id($siswa_id);
			$mapel = Datamapel::find_by_id_mapel($id_mapel);
			$data_rombel = Datarombel::find_by_id($siswa->data_rombel_id);
			$all_kd = Kd::find_all_by_id_mapel_and_kelas($id_mapel,$data_rombel->tingkat);
			foreach($all_kd as $kd){
				$get_kd[$kd->id] = $kd->id_kompetensi;
				$get_kd_alternatif[str_replace(' ','_',$kd->kompetensi_dasar)] = $kd->id_kompetensi;
			}
			if(!isset($get_kd)){
				echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
				Pilih Mata Pelajaran terlebih dahulu sebelum memilih nama siswa!
              </div>';
			exit;
			}
			$input_pengetahuan = preg_quote('KD-03', '~'); // don't forget to quote input string!
			$input_alt_pengetahuan = preg_quote('3.', '~'); // don't forget to quote input string!
			$input_keterampilan = preg_quote('KD-04', '~'); // don't forget to quote input string!
			$input_alt_keterampilan = preg_quote('4.', '~'); // don't forget to quote input string!
			$input_all = preg_quote('', '~'); // don't forget to quote input string!
			$result_pengetahuan = preg_grep('~' . $input_pengetahuan . '~', $get_kd);
			if(!$result_pengetahuan){
				$result_pengetahuan = preg_grep('~' . $input_alt_pengetahuan . '~', $get_kd_alternatif);
			}
			$rencana_pengetahuan = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id, $mapel->id_mapel, $rombel_id, 1);
			if($rencana_pengetahuan){
				foreach($rencana_pengetahuan as $rp){
					$get_kd_rencana = Rencanapenilaian::find_all_by_rencana_id($rp->id);
					foreach($get_kd_rencana as $a=>$gkr){
						$get_kd_id_atas[] = $gkr->rencana_id;
					}
					$rencana_id_satuan = implode(',',$get_kd_id_atas);
					$get_rencana_penilaian_pengetahuan = Rencanapenilaian::find('all', array('conditions' => "rencana_id IN ($rencana_id_satuan)",'group' => 'nama_penilaian','order'=>'id ASC'));
				}
				foreach($get_kd_rencana as $a=>$gkr){
					$get_kd_id[$gkr->id] = $gkr->kd_id;
				}
			}
			$html .= '<table class="table table-bordered table-hover">';
			$html .= '<tr>';
			$html .= '<th width="10%" class="text-center">ID KD</th>';
			$html .= '<th>Kompetensi Dasar Pengetahuan</th>';
			$nilai_value = '';
			if(isset($get_rencana_penilaian_pengetahuan)){
				foreach($get_rencana_penilaian_pengetahuan as $grpp){
					$html .= '<th class="text-center">'.$grpp->nama_penilaian.'</th>';
				}
				foreach($result_pengetahuan as $key=>$rp){
					$get_kompetensi = Kd::find_by_id($key);
					$html .= '<tr>';
					$html .= '<td class="text-center">'.$rp.'</td>';
					$html .= '<td>'.$get_kompetensi->kompetensi_dasar.'</td>';
						//if(in_array($key,$get_kd_id)){
						foreach($get_rencana_penilaian_pengetahuan as $grpp){
							$rencana_satuan = Rencanapenilaian::find_by_kd_id_and_nama_penilaian($get_kompetensi->id,$grpp->nama_penilaian);
							if($rencana_satuan){
								$nilai = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id( $ajaran_id, 1, $rombel_id, $id_mapel, $siswa_id, $rencana_satuan->id);
								if($nilai){
									$nilai_value = $nilai->nilai;
									$html .= '<td class="text-center table-success">'.$nilai_value.'</td>';
								}  else {
									$html .= '<td class="text-center table-warning"></td>';
								}
							} else {
								$html .= '<td class="text-center table-danger"></td>';
							}
						}
					$html .= '</tr>';
				}
			} else {
				$html .= '<th>Belum ada penilaian</th>';
			}
			$html .= '</tr>';
			$html .= '</table>';

			$result_keterampilan = preg_grep('~' . $input_keterampilan . '~', $get_kd);
			if(!$result_keterampilan){
				$result_keterampilan = preg_grep('~' . $input_alt_keterampilan . '~', $get_kd_alternatif);
			}
			$rencana_keterampilan = Rencana::find_all_by_ajaran_id_and_id_mapel_and_rombel_id_and_kompetensi_id($ajaran_id, $mapel->id_mapel, $rombel_id, 2);
			if($rencana_keterampilan){
				foreach($rencana_keterampilan as $rp){
					$get_kd_rencana = Rencanapenilaian::find_all_by_rencana_id($rp->id);
					foreach($get_kd_rencana as $a=>$gkr){
						$get_kd_id_bawah[] = $gkr->rencana_id;
					}
					$rencana_id_satuan = implode(',',$get_kd_id_bawah);
					$get_rencana_penilaian_keterampilan = Rencanapenilaian::find('all', array('conditions' => "rencana_id IN ($rencana_id_satuan)",'group' => 'nama_penilaian','order'=>'id ASC'));
				}
				foreach($get_kd_rencana as $a=>$gkr){
					$get_kd_id[$gkr->id] = $gkr->kd_id;
				}
			}
			//foreach($get_rencana_penilaian_keterampilan as $grpp){
				//$cari_nama_penilaian[] = $grpp->nama_penilaian;
			//}
			$html .= '<table class="table table-bordered table-hover table-inverse" style="margin-top:10px;">';
			$html .= '<tr>';
			$html .= '<th width="10%" class="text-center">ID KD</th>';
			$html .= '<th>Kompetensi Dasar Keterampilan</th>';
			if(isset($get_rencana_penilaian_keterampilan)){
				foreach($get_rencana_penilaian_keterampilan as $grpp){
					$html .= '<th class="text-center">'.$grpp->nama_penilaian.'</th>';
				}
				foreach($result_keterampilan as $key=>$rp){
					$get_kompetensi = Kd::find_by_id($key);
					$html .= '<tr>';
					$html .= '<td class="text-center">'.$rp.'</td>';
					$html .= '<td>'.$get_kompetensi->kompetensi_dasar.'</td>';
					//if(in_array($key,$get_kd_id)){
						foreach($get_rencana_penilaian_keterampilan as $grpp){
							$rencana_satuan = Rencanapenilaian::find_by_kd_id_and_nama_penilaian($get_kompetensi->id,$grpp->nama_penilaian);
							if($rencana_satuan){
								$nilai = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id( $ajaran_id, 2, $rombel_id, $id_mapel, $siswa_id, $rencana_satuan->id);
								if($nilai){
									$nilai_value = $nilai->nilai;
									$html .= '<td class="text-center table-success">'.$nilai_value.'</td>';
								}  else {
									$html .= '<td class="text-center table-warning"></td>';
								}
							} else {
								$html .= '<td class="text-center table-danger"></td>';
							}
						}
					//} else {
						//foreach($get_rencana_penilaian_keterampilan as $grpp){
							//$html .= '<td class="text-center table-danger"></td>';
						//}
					//}
					$html .= '</tr>';
				}
			} else {
				$html .= '<th>Belum ada penilaian</th>';
			}
			$html .= '</tr>';
			$html .= '</table>';*/	
		}
		//echo $html;
	}
	public function get_ekstrakurikuler(){
		//$admin_group = array(1,2,3,5,6);
		//hak_akses($admin_group);
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['ekskul_id'] = $_POST['ekskul_id'];
		$data['rombel_id'] = $_POST['rombel_id'];
		$this->template->title('Administrator Panel')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Entry Absensi')
		->build($this->admin_folder.'/laporan/add_ekstrakurikuler',$data);
	}
	public function list_sikap($kompetensi = NULL, $tingkat = NULL, $rombel = NULL){
		$this->load->library('custom_fuction');
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 10;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$guru_murni = '';
		$wali_kelas = 0;
		$get_rombel = 0;
		$get_mapel = 0;
		$query_join = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$guru_murni = "AND c.guru_id = $loggeduser->data_guru_id";
		} else {
		}
		if($kompetensi && !$tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(sikaps.rombel_id = a.id AND a.kurikulum_id = $kompetensi $query_join)";
		} elseif($kompetensi && $tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(sikaps.rombel_id = a.id AND a.kurikulum_id = $kompetensi AND a.tingkat = $tingkat $query_join)";
		} elseif($kompetensi && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(sikaps.rombel_id = a.id AND a.kurikulum_id = $kompetensi AND a.tingkat = $tingkat AND a.id = $rombel $query_join)";
		} else {
			$join = "INNER JOIN data_rombels a ON(sikaps.rombel_id = a.id)";
		}
		$join .= "INNER JOIN data_siswas b ON(sikaps.siswa_id = b.id)";
		$join .= "INNER JOIN kurikulums c ON(sikaps.mapel_id = c.id_mapel $guru_murni)";
		$sel = 'sikaps.*, a.nama AS nama_rombel, a.tingkat AS tingkat_rombel, b.nama AS nama_siswa';
		$query = Sikap::find('all', array('conditions' => "siswa_id IS NOT NULL AND (b.nama LIKE '%$search%' OR b.nisn LIKE '%$search%' OR b.tempat_lahir LIKE '%$search%' OR a.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC', 'joins'=> $join,'select'=>$sel, 'group' => 'mapel_id'));
		$filter = Sikap::find('all', array('conditions' => "siswa_id IS NOT NULL AND (b.nama LIKE '%$search%' OR b.nisn LIKE '%$search%' OR b.tempat_lahir LIKE '%$search%' OR a.nama LIKE '%$search%')",'order'=>'rombel_id ASC', 'joins'=> $join));
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
		//$super_admin = array(1,2);
		//$barang = $query->result();
	    foreach ($query as $temp) {	
			$record = array();
            $tombol_aktif = '';
			$record[] = $temp->nama_siswa;
			$record[] = $temp->nama_rombel.'/'.$temp->tingkat_rombel;
			$record[] = get_nama_mapel($temp->ajaran_id,$temp->rombel_id,$temp->mapel_id);
			$record[] = butir_sikap($temp->butir_sikap);
			$record[] = '<div class="text-center">'.opsi_sikap($temp->opsi_sikap).'</div>';
			$record[] = $temp->uraian_sikap;
			$output['aaData'][] = $record;
		}
		if($kompetensi && !$tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$id_rombel[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND kurikulum_id = ?', $id_rombel, $kompetensi)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id($kompetensi);
			}
		} elseif($kompetensi && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$id_rombel[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND tingkat = ? AND kurikulum_id = ?', $id_rombel, $tingkat, $kompetensi)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_tingkat_and_kurikulum_id($tingkat,$kompetensi);
			}
		}
		if(isset($get_all_rombel)){
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		} else {
			$result['value'] = '';
			$result['text'] = 'Tidak ditemukan rombel di tingkat kelas terpilih';
			$output['rombel'][] = $result;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
    public function list_pengetahuan($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$get_guru_login = Dataguru::find_by_id($loggeduser->data_guru_id);
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 25;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$siswa_guru_joint = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$id_rombel[] = $datamapel->rombel_id;
				$id_mapel[] = $datamapel->id_mapel;
			}
			if(isset($id_rombel)){
				$id_rombel = implode(",", $id_rombel);
			} else {
				$id_rombel = 0;
			}
			if(isset($id_mapel)){
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			} else {
				$id_mapel = 0;
			}
		$siswa_guru_joint = "AND a.id IN ($id_rombel) AND rombel_id IN ($id_rombel) AND id_mapel IN ($id_mapel)";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		}elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat AND a.id = $rombel $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 1 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		}
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
			$mapel = Datamapel::find($temp->id_mapel);
			$get_kurikulum = Kurikulum::find_by_rombel_id_and_id_mapel($temp->rombel_id,$temp->id_mapel);
			if ($get_kurikulum) {
				$get_nama_guru = Dataguru::find($get_kurikulum->guru_id);
			}
			$nama_guru = isset($get_nama_guru->nama) ? $get_nama_guru->nama : '-';
			$nama_guru_login = isset($get_guru_login->nama) ? $get_guru_login->nama : '';
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			foreach($rencana_penilaian_group as $rpg){
				$rpg_id[] = $rpg->id;
			}
			if(isset($rpg_id)){
				$rpg_id_result = implode(',',$rpg_id);
			} else {
				$rpg_id_result = 0;
			}
			$nilai = Nilai::find('all', array('conditions' => "rencana_penilaian_id IN ($rpg_id_result)", 'limit'=>1));
			if(!in_array('waka',$nama_group)){ //murni guru
				if($nilai){
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				} else {
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
					$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				}
			} else { // guru plus waka
				$admin_akses = '<li><a href="'.site_url('admin/perencanaan/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i> Detil</a></li>';
				if($nama_guru_login == $nama_guru){
					if($nilai){
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					} else {
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/edit/1'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					}
				}
			}
			$jumlah_rencana_penilaian = count($temp->rencanapenilaian);
			$record = array();
            $tombol_aktif = '';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $mapel->nama_mapel.' ('.$mapel->id_mapel.') ';
            $record[] = $nama_guru;
            $record[] = '<div class="text-center">'.count($rencana_penilaian_group).'</div>';
            $record[] = '<div class="text-center">'.$jumlah_rencana_penilaian.'</div>';
			//$record[] = '<div class="text-center">'.$admin_akses.'</div>';
            //$record[] = '<a class="tooltip-left" title="'.$get_kd->kompetensi_dasar.'">'.$temp->kd.'</a>';
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
								 <!--li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li-->
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$rombel_id[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND kurikulum_id = ? AND tingkat = ?', $jurusan, $rombel_id, $tingkat)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan,$tingkat);
			}
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function list_keterampilan($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$get_guru_login = Dataguru::find_by_id($loggeduser->data_guru_id);
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 25;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$siswa_guru_joint = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$id_rombel[] = $datamapel->rombel_id;
				$id_mapel[] = $datamapel->id_mapel;
			}
			if(isset($id_rombel)){
				$id_rombel = implode(",", $id_rombel);
			} else {
				$id_rombel = 0;
			}
			if(isset($id_mapel)){
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			} else {
				$id_mapel = 0;
			}
		$siswa_guru_joint = "AND a.id IN ($id_rombel) AND rombel_id IN ($id_rombel) AND id_mapel IN ($id_mapel)";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		}elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat AND a.id = $rombel $siswa_guru_joint)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id)";
			$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "ajaran_id = $ajaran->id AND kompetensi_id = 2 $siswa_guru_joint AND (id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id_mapel ASC, id DESC', 'joins'=> $join));
		}
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
			$mapel = Datamapel::find($temp->id_mapel);
			$get_kurikulum = Kurikulum::find_by_rombel_id_and_id_mapel($temp->rombel_id,$temp->id_mapel);
			if ($get_kurikulum) {
				$get_nama_guru = Dataguru::find($get_kurikulum->guru_id);
			}
			$nama_guru = isset($get_nama_guru->nama) ? $get_nama_guru->nama : '-';
			$nama_guru_login = isset($get_guru_login->nama) ? $get_guru_login->nama : '';
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			foreach($rencana_penilaian_group as $rpg){
				$rpg_id[] = $rpg->id;
			}
			if(isset($rpg_id)){
				$rpg_id_result = implode(',',$rpg_id);
			} else {
				$rpg_id_result = 0;
			}
			$nilai = Nilai::find('all', array('conditions' => "rencana_penilaian_id IN ($rpg_id_result)", 'limit'=>1));
			if(!in_array('waka',$nama_group)){ //murni guru
				if($nilai){
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				} else {
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/edit/2/'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
					$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				}
			} else { // guru plus waka
				$admin_akses = '<li><a href="'.site_url('admin/perencanaan/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i> Detil</a></li>';
				if($nama_guru_login == $nama_guru){
					if($nilai){
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					} else {
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/edit/2'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					}
				}
			}
			$jumlah_rencana_penilaian = count($temp->rencanapenilaian);
			$record = array();
            $tombol_aktif = '';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $mapel->nama_mapel.' ('.$mapel->id_mapel.') ';
            $record[] = $nama_guru;
            $record[] = '<div class="text-center">'.count($rencana_penilaian_group).'</div>';
            $record[] = '<div class="text-center">'.$jumlah_rencana_penilaian.'</div>';
			//$record[] = '<div class="text-center">'.$admin_akses.'</div>';
            //$record[] = '<a class="tooltip-left" title="'.$get_kd->kompetensi_dasar.'">'.$temp->kd.'</a>';
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
								 <!--li><a href="'.site_url('admin/perencanaan/edit/2/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li-->
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$rombel_id[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND kurikulum_id = ? AND tingkat = ?', $jurusan, $rombel_id, $tingkat)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan,$tingkat);
			}
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
}