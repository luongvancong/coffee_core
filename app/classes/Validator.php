<?php
/**
 * Class kiểm tra tính đúng đắn của dữ liệu
 * @author Cong Luong cong.itsoft@gmail.com
 * @copyright 2013 - Cong Luong
 */
class Validator {

	/**
	 * Mang cac kieu du lieu can kiem tra
	 * @var array
	 */
	private $rules = array(
		'string', 'email','bool',
		 'double','integer','float',
		 'url','ip',
		 'required'
	);

	private $errors;

	/**
	 * The hien lop Validator
	 * @var [type]
	 */
	private static $instance;


	/**
	 * Lay ra 1 the hien cua lop
	 * @return [type] [description]
	 */
	public static function getInstance() {
		if(!isset(Validator::$instance)) {
			Validator::$instance = new Validator();
		}

		return Validator::$instance;
	}

	/**
	 * Tao rules
	 * @param  Mang cac rules  $rules [description]
	 * @return true hoac false        [description]
	 */
	public static function make(array $data, array $rules, array $message = array()) {
		if(!is_array($rules)) {
			throw new ValidatorException("Rules phải là 1 mảng");
		}

		$instance = self::getInstance();

		/**
		 * Lap mang du lieu de kiem tra
		 */
		foreach($data as $key => $value) {

			if(isset($rules[$key])) {
				//Luat cho bien nay
				$ruleForKey = $rules[$key];

				//Mang cac luat
				$arrayRule = $instance->breakRule($ruleForKey);
				//Lap mang Rule
				foreach($arrayRule as $rule) {
					if(!in_array($rule, $instance->rules)) {
						throw new ValidatorException($instance->templateErrorRule($key, $rule));
					}
					//Kiem tra du lieu
					$messageError = isset($message[$key]) ? $message[$key] : '';
					$instance->validate($key, $value, $rule, $messageError);
				}
			}

		}

		return $instance;
	}

	/**
	 * Kiem tra cac luat
	 * @param  [type] $name  [description]
	 * @param  [type] $value [description]
	 * @param  [type] $rule  [description]
	 * @return [type]        [description]
	 */
	private function validate($name, $value, $rule, $message) {
		if(!call_user_func_array(array($this, $rule), array($value))) {
			$this->addErros($name, $rule, $message);
		}
	}


	/**
	 * Lay ra loi
	 * @return [type] [description]
	 */
	public function getErrors() {
		return $this->errors;
	}


	/**
	 * Neu kiem tra thanh cong
	 * @return [type] [description]
	 */
	public function passes() {
		if(is_null($this->errors)) {
			return true;
		}

		return false;
	}


	/**
	 * Kiem tra that bai
	 * @return [type] [description]
	 */
	public function fails() {
		return ! $this->passes();
	}


	/**
	 * Mau loi, hien ra man hinh
	 * @param  [type] $key   [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	private function templateErrorRule($key, $value) {
		return 'Giá trị của biến <strong>' . $key . '</strong> với kiểu dữ liệu là <strong>' . $value . '</strong> không hợp lệ';
	}


	/**
	 * Be chuoi lay ra cac rule
	 * @param  [type] $rule [description]
	 * @return [type]       [description]
	 */
	private function breakRule($rule) {
		$rule = trim($rule, '|');
		$rule = explode('|', $rule);
		return $rule;
	}


	/**
	 * Chuan hoa 1 rule
	 * @param  [string] $rule [description]
	 * @return [string]       [description]
	 */
	private function trimRule($rule) {
		$rule = trim($rule, '|');
		return $rule;
	}


	/**
	 * Luu loi
	 * @param [type] $key   [description]
	 * @param [type] $value [description]
	 */
	private function addErros($key, $value, $message = '') {
		if($message === '') {
			$this->errors[] = $key . ' phải là ' . $value;
		}else{
			$this->errors[] = $message;
		}
	}

	/**
	 * Validate 1 email
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	public static function email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}


	/**
	 * Kiem tra kieu string
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function string($value) {
		return is_string($value);
	}


	/**
	 * Kiem tra gia tri rong
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function required($value) {
		return !empty($value);
	}


	/**
	 * Kiem tra co phai la url
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public static function url($url) {
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	/**
	 * Kiem tra co phai la kieu interger
	 */
	public static function integer($number) {
		return filter_var($number, FILTER_VALIDATE_INT);
		// return is_integer($number);
	}

	/**
	 * Kiem tra kieu float
	 * @param  [type] $number [description]
	 * @return [type]         [description]
	 */
	public static function float($number) {
		return filter_var($number, FILTER_VALIDATE_FLOAT);
	}


	/**
	 * Kiem tra kieu bool
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function bool($value) {
		return filter_var($value, FILTER_VALIDATE_BOOLEAN);
	}


	/**
	 * Kiem tra co phai ip
	 * @param  [type] $ip [description]
	 * @return [type]     [description]
	 */
	public static function ip($ip) {
		return filter_var($ip, FILTER_VALIDATE_IP);
	}
}
