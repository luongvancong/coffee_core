<?php
require_once('../simpletest/autorun.php');

function __autoload($classname) {
	include '../' . $classname . '.php';
}

class TestClassValidator extends UnitTestCase {
	function test_email() {

		$email = 'cong.itsoft@gmail.com';

		$data = array(
			'email' => $email
		);

		$rules = array(
			'email' => 'email|required|string'
		);

		$message = array(
			'email' => 'Email khong hop le'
		);

		$this->assertTrue(Validator::email($email));
		$this->assertEqual(Validator::make($data, $rules, $message)->passes(), true);
		$this->assertEqual(Validator::make($data, $rules, $message)->fails(), false);
	}

	function testString() {
		$value = 'luong van cong';

		$data = array(
			'value' => $value
		);

		$rules = array(
			'value' => 'string'
		);

		$message = array(
			'value' => 'Phai la kieu string'
		);

		$this->assertTrue(Validator::string($value));
	}

	function testInteger() {
		$value = '123';

		$data = array(
			'value' => $value
		);

		$rules = array(
			'value' => 'integer'
		);

		$this->assertTrue(Validator::integer($value));
		$this->assertTrue(Validator::make($data, $rules)->passes());
		$this->assertEqual(Validator::make($data, $rules)->fails(), false);
	}

	function testBool() {
		$value = true;

		$data = array('value' => $value);

		$rules = array('value' => 'bool');

		$this->assertEqual(Validator::make($data, $rules)->passes(), true);
		$this->assertTrue(Validator::bool($value));
	}

	function testFloat() {
		$value = 124.5;

		$data = array('value' => $value);

		$rules = array('value' => 'float');

		$this->assertEqual(Validator::float($value), true, '');
		$this->assertEqual(Validator::make($data, $rules)->passes(), true, '');
	}


	function testRequired() {
		$value = '123';

		$data = array('value' => $value);

		$rules = array('value' => 'required');

		$this->assertEqual(Validator::required($value), true, 'required');
		$this->assertTrue(Validator::make($data, $rules)->passes());
	}

	function testIp() {
		$value = '123.3.4.5';

		$data  = array('value' => $value);

		$rules = array('value' => 'ip|required');

		$message = array('value' => 'deo phai ip');

		var_dump(Validator::make($data, $rules, $message)->getErrors());

		$this->assertTrue(Validator::ip($value));
		$this->assertTrue(Validator::make($data, $rules)->passes());
	}
}