<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends ActiveRecord\Model{
	static $has_many = array(
		array('usergroups'),
        array('users', 'through' => 'usergroups')
    );
}