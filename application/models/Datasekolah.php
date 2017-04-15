<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataSekolah extends ActiveRecord\Model{
	static $has_many = array(
							 array('dataguru'),
							 array('datasiswa'),
							 array('datarombel'),
		);
}