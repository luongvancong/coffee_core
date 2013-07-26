<?php

/**
 * Class Statement
 * Tao cau lenh Insert, Update
 * @author Cong Luong cong.itsoft@gmail.com
 * @copyright Cong Luong
 * ------------------------------
 * Tao cau lenh Insert
 * ------------------------------
 * Vi du:
 * $person        = new Statement2;
 * $person->name  = 'cong';
 * $person->age   = 18;
 * $person->email = 'cong.itsoft@gmail.com';
 * $person->money = '153595468';
 * $person->setTable('person');
 * echo $person->getInsertSql();
 *
 * --------------------------------
 * Tao cau lenh Update
 * --------------------------------
 * Bat buoc phai truyen vao khoa chinh vi update theo gia tri cua khoa chinh
 * Vi du:
 * $person        = new Statement2;
 * $person->id    = 1
 * $person->name  = 'cong';
 * $person->age   = 18;
 * $person->email = 'cong.itsoft@gmail.com';
 * $person->money = '153595468';
 * $person->setPrimaryKey('id');
 * $person->setTable('person');
 * echo $person->getUpdateSql();
 */
class Statement {

	/**
	 * Khoa chinh
	 * @var [type]
	 */
	private $primaryKey;

	/**
	 * Ten bang
	 * @var [type]
	 */
	private $table;


	/**
	 * Mang chua du lieu
	 * @var array
	 */
	private $ar_data = array();

	public function __construct(array $data = array()) {
		if( !empty($data) ) {
			foreach($data as $name => $value)
			$this->ar_data['field'][$name] = $value;
		}
	}

	/**
	 * Set primarykey
	 * @param [type] $primaryKey [description]
	 */
	public function setPrimaryKey($primaryKey) {
		$this->primaryKey = $primaryKey;
	}

	/**
	 * Get primarykey
	 * @return [type] [description]
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * Set table name
	 * @param [type] $table_name [description]
	 */
	public function setTable($table_name) {
		$this->ar_data['table'] = $table_name;
	}

	/**
	 * Get table name
	 * @return [type] [description]
	 */
	public function getTable() {
		return $this->ar_data['table'];
	}


	/**
	 * Get array data
	 * @return [type] [description]
	 */
	public function getField() {
		return $this->ar_data['field'];
	}


	/**
	 * Get insert SQL
	 * @return string
	 */
	public function getInsertSql() {
		return $this->buildQueryInsert();
	}

	/**
	 * Get update SQL
	 * @return string
	 */
	public function getUpdateSql() {
		return $this->buildQueryUpdate();
	}


	/**
	 * Tao cau lenh insert
	 * @return [type] [description]
	 */
	private function buildQueryInsert() {
		$query     = $this->implodeQueryInsert();

		$str_field = $query['field'];

		$str_value = $query['value'];

		$sql       = "INSERT INTO {$this->getTable()}($str_field)";
		$sql       .= "VALUES($str_value)";

		return $sql;
	}

	/**
	 * Return cau lenh Update
	 * @return [type] [description]
	 */
	private function buildQueryUpdate() {
		if(!isset($this->primaryKey)) {
			throw new Exception("Câu lệnh Update bắt buộc phải có primaryKey");
		}

		if(empty($this->ar_data[$this->primaryKey])) {
			throw new Exception("Khóa chính chưa có giá trị!");
		}

		$ar_data = $this->ar_data;

		$ar_field = array_keys($ar_data['field']);

		$ar_value = array_values($ar_data['field']);

		$sql = "UPDATE {$this->getTable()} SET ";

		foreach ($ar_data['field'] as $field => $value) {
			if(is_string($value)) {
				$sql .= "$field = '{$value}',";
			}else{
				$sql .= "$field = $value,";
			}
		}

		$primaryKey = $this->getPrimaryKey();

		$primaryKeyValue = $ar_data['field'][$primaryKey];

		$sql = substr($sql, 0, -1) . " WHERE {$primaryKey} = {$primaryKeyValue}";

		return $sql;
	}

	/**
	 * Chuan cac thu de in ra cau Insert
	 * @return [type] [description]
	 */
	private function implodeQueryInsert() {
		$ar_data = $this->ar_data;

		$ar_field = array_keys($ar_data['field']);

		$ar_value = array_values($ar_data['field']);

		foreach ($ar_value as $key => $value) {
			if(is_string($value)) {
				$ar_value[$key] = "'{$value}'";
			}
		}

		$str_field = implode(',', $ar_field);

		$str_value = implode(',', $ar_value);

		$array_return['field'] = $str_field;
		$array_return['value'] = $str_value;

		return $array_return;
	}


	/**
	 * Handle set property
	 * @param [type] $name  [description]
	 * @param [type] $value [description]
	 */
	public function __set($name, $value) {
		$this->ar_data['field'][$name] = $value;
	}
}