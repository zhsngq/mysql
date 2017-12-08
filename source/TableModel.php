<?php

class TableModel {

	public $name = null;

	public $childen = [];

    public $diffmap = [];

	function __construct($sql) {
		preg_match_all('/(\S|\ )+/m', $sql, $result, PREG_PATTERN_ORDER);
		$result = $result[0];
		foreach ($result as $key => $value) {
            $value = trim($value);
			$res = $this->buildSring($value);
			if ($key === 0) {
				$this->name = $res;
				continue;
			}
            if (substr( $value, 0, 1 )=='`') {
                $this->childen[$res] = $this->substr($value);
                continue;
            }
            if (substr( $value, 0, 1 )!=')') {
                $this->childen[$value] = $value;
                continue;
            }
		}
	}

	/**
	 * 获取字段
	 * @date   2017-12-05T13:50:45+0800
	 */
	private function buildSring($string) {
		preg_match_all('/`\S+`/m', $string, $res, PREG_PATTERN_ORDER);
        if (empty($res[0])) {
            return trim($string);
        }
		$res = trim($res[0][0]);
        $res = preg_replace('/`/m', '', $res);
		return $res;
	}

    private function substr(&$string){
        $string = preg_replace('/(\ +`\S+`\ +|,\n)/m', '', $string);
        return $string;
    }

    /**
     * 获取不一致字段
     * @date   2017-12-05T15:47:57+0800
     */
    public function diff(TableModel $model){
        $this->diffmap = array_diff_key($this->childen,$model->childen);
        foreach ($this->childen as $key => $value) {
            if (!isset($model->childen[$key])) {
                $this->diffmap[$key] = "del $this->name:$key";
                continue;
            }
            if ($value != $model->childen[$key]) {
                $this->diffmap[$key] = "edit $this->name:$key->".$model->childen[$key];
            }
            unset($model->childen[$key]);
        }
        if (!empty($model->childen)) {
            foreach ($model->childen as $key => $value) {
                $this->diffmap[$key] = "add $this->name:$key";
            }
        }
    }

    private function bulidSql($key,$value){

    }

}
