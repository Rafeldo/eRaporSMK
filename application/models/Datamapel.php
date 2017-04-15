<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataMapel extends ActiveRecord\Model{
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data referensi mata pelajaran','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data referensi mata pelajaran','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data referensi mata pelajaran','ID:'.$this->id,$loggeduser->username);
		$kurikulum = Kurikulum::find('all',array(
            				'conditions' => array(
								'id_mapel' => $this->id_mapel
							)
					)
        );
        if($kurikulum){
			foreach($kurikulum as $k){
				$k->delete();
			}
		}
	}
}