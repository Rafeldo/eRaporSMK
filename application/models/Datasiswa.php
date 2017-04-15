<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataSiswa extends ActiveRecord\Model{
	static $has_many = array(
							 array('user'),
							 array('usergroups'),
		);
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data siswa','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data siswa','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data siswa','ID:'.$this->id,$loggeduser->username);
		//deskripsis
		//deskripsi_mapels
		//absens
		//portofolios
		//nilai_ekskuls
		//nilai_muloks
		//prakerin
		//prestasis
		//sikaps
		//if($rencana_penilaian){
			//foreach($rencana_penilaian as $n){
				//$id[] = $n->id;
			//}
			//Rencanapenilaian::table()->delete(array('id' => $id));
		//}
		$user = User::find('all',array(
            'conditions' => array(
                'data_siswa_id' => $this->id)
        ));
		if($user){
			foreach($user as $u){
				$usergroup = UserGroup::find('all',array(
					'conditions' => array(
					'user_id' => $u->id)
				));
				if($usergroup){
					foreach($usergroup as $ug){
						$ug->delete();
					}
				}
			$u->delete();
			}
		}
		$nilai = Nilai::find('all',array(
            'conditions' => array(
                'data_siswa_id' => $this->id)
        ));
        
        if($nilai){
			foreach($nilai as $n){
				$n->delete();
			}
		}
    }	
}