<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ekskul extends ActiveRecord\Model{
	static $has_many = array(array('nilaiekskuls'));
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data ekstrakurikuler','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data ekstrakurikuler','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data ekstrakurikuler','ID:'.$this->id,$loggeduser->username);
        $nilai_ekskuls = NilaiEkskul::find('all',array(
            'conditions' => array(
            'ekskul_id' => $this->id)
        ));
		//not deleted
		if($nilai_ekskuls){
	        foreach($nilai_ekskuls as $n){
				$id[] = $n->id;
			}
			Nilaiekskul::table()->delete(array('id' => $id));
		}
    }
}