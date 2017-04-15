<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataGuru extends ActiveRecord\Model{
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
		set_log('Tambah data guru','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data guru','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data guru','ID:'.$this->id,$loggeduser->username);
        $kurikulum = Kurikulum::find('all',array(
            'conditions' => array(
                'guru_id' => $this->id)
        ));
		if($kurikulum){
			foreach($kurikulum as $k){
				$k->delete();
			}
		}
		$rombel = Datarombel::find('all',array(
            'conditions' => array(
                'guru_id' => $this->id)
        ));
		if($rombel){
			foreach($rombel as $r){
				$r->guru_id = 0;
				$r->save();
			}
		}
		$user = User::find('all',array(
            'conditions' => array(
                'data_guru_id' => $this->id)
        ));
		if($user){
			foreach($user as $u){
				$u->delete();
			}
		}
    }
}