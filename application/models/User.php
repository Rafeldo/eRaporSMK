<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends ActiveRecord\Model{
	static $has_many = array(array('usergroups'),
	);

   // static $has_many = array(array('groups'));

	public function before_destroy(){
        $usergroup = UserGroup::find(array(
            'conditions' => array(
            'user_id' => $this->id)
        ));
        
        if($usergroup)
        $usergroup->delete();
    }
}