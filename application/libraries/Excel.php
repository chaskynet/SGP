<?
require_once APPPATH."/third_party/PHPExcel/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}