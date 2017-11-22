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

	/**
	 * 获取表字段
	 * @date   2017-11-22T15:14:10+0800
	 * @return array
	 */
	function getColnm(){
		preg_match_all('/\n\s+`\w+`/m', $sql, $result, PREG_PATTERN_ORDER);
		$result = $result[0];
		foreach ($result as &$value) {
		    $value = preg_replace('/\n\s+/m','',$value);
		}
		return $result;
	}

}
