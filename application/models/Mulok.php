<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mulok extends ActiveRecord\Model{
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data muatan lokal','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data muatan lokal','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data muatan lokal','ID:'.$this->id,$loggeduser->username);
		$nilai_mulok = Nilaimulok::find('all', array(
			'conditions' => array(
				'mapel_id' => $this->id)
		));
		if($nilai_mulok){
			foreach($nilai_mulok as $nilai){
				$nilai->delete();
			}
		}
	}
}
