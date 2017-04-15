<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DataRombel extends ActiveRecord\Model{
	static $has_many = array(
							array('datasiswa'),
						);
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data rombongan belajar','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data rombongan belajar','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data rombongan belajar','ID:'.$this->id,$loggeduser->username);
		$siswa = Datasiswa::find('all',array(
            'conditions' => array(
                'data_rombel_id' => $this->id)
        ));
		if($siswa){
			foreach($siswa as $s){
				$s->data_rombel_id = 0;
				$s->save();
			}
		}
		$kurikulum = Kurikulum::find('all',array(
            'conditions' => array(
                'rombel_id' => $this->id)
        ));
		if($kurikulum){
			foreach($kurikulum as $k){
				$k->delete();
			}
		}
		$all_rencana = Rencana::find('all', array(
			'conditions' => array(
				'rombel_id' => $this->id)
		));
		if($all_rencana){
			foreach($all_rencana as $rencana){
				$rencana->delete();
			}
		}
		$nilai_ekskuls = NilaiEkskul::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($nilai_ekskuls){
	        foreach($nilai_ekskuls as $ne){
				$ne->delete();
			}
		}
		$nilai_akhir = Nilaiakhir::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($nilai_akhir){
	        foreach($nilai_akhir as $na){
				$na->delete();
			}
		}
		$all_nilai = Nilai::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_nilai){
	        foreach($all_nilai as $an){
				$an->delete();
			}
		}
		$all_prestasi = Prestasi::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_prestasi){
	        foreach($all_prestasi as $ap){
				$ap->delete();
			}
		}
		$all_prakerin = Prestasi::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_prakerin){
	        foreach($all_prakerin as $apk){
				$apk->delete();
			}
		}
		$all_desk = Catatanwali::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_desk){
	        foreach($all_desk as $desk){
				$desk->delete();
			}
		}
		$all_desks = Deskripsi::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_desks){
	        foreach($all_desks as $desks){
				$desks->delete();
			}
		}
		$all_portofolio = DataPortofolio::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_portofolio){
	        foreach($all_portofolio as $portofolio){
				$portofolio->delete();
			}
		}
		$all_anggota = AnggotaRombel::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_anggota){
	        foreach($all_anggota as $anggota){
				$anggota->delete();
			}
		}
		$all_absen = Absen::find('all',array(
            'conditions' => array(
            'rombel_id' => $this->id)
        ));
		if($all_absen){
	        foreach($all_absen as $absen){
				$absen->delete();
			}
		}
	}
}