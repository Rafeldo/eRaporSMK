<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keahlian extends ActiveRecord\Model{
	public function before_destroy(){
		$rombel = Datarombel::find('all',array(
            'conditions' => array(
                'kurikulum_id' => $this->id)
        ));
		if($rombel){
			foreach($rombel as $r){
				$r->delete();
			}
		}
	}
}