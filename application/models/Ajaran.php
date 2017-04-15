<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaran extends ActiveRecord\Model{
	static $validates_presence_of = array(
     	array('tahun')
	);
}
