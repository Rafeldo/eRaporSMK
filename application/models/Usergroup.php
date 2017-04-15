<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserGroup extends ActiveRecord\Model{
	
	static $table_name = 'users_groups';
	
	static $belongs_to = array(
        array('user'),
		array('dataguru'),
        array('group')
    );
}