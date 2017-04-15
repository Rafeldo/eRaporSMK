<?php
class Machine{
    private $privateVar = 'Default private';
    protected $protectedVar = 'Default protected';
    public $publicVar = 'Default public';

    public function __construct(){
        $this->privateVar = 'parent instance';
    }
	public function GetVolumeLabel($drive) {
		/*if (preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
			$volname = $m[1];
		} else {
			$volname = '';
		}
	return $volname;*/
	return false;
	}
}
?>