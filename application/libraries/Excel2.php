<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/PHPepeExcel/lib/PHPExcel.php"; 
 
class Excel2 extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}