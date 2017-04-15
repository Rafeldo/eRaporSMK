<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;

    public function __construct($param = '"utf-8","A4","","",5,5,5,5,6,3'){
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}
