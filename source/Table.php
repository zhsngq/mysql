<?php
/**
 *
 */
require_once 'load.php';
use Illuminate\Database\Capsule\Manager as DB;

class Table extends Base {

	public $res = null;

	function __construct($dbname) {
		parent::__construct($dbname);
		$res = DB::select('show tables;');
		$res = json_decode(json_encode($res), true);
		$this->res = [];
		foreach ($res as $value) {
			foreach ($value as $v) {
				$this->res[$v] = $this->getCreatSql($v);
			}
		}
	}

	function getCreatSql($tname){
		$res = DB::select("SHOW CREATE TABLE `$tname`;");
		$res = json_decode(json_encode($res), true);
		$res = $res[0]['Create Table'];
		return $res;
	}

}
