<?php

require_once('../libs/autorun.php');
require_once('../../app/classes/validator.php');

class ValidatorTest extends UnitTestCase {
   public function testValidator() {
      // Rules for all fields
      $rules = array(
         "name" => "required",
         "age" => "required|number"
      );

      // Data test true
      $data_true = array(
         "name" => "Alvin",
         "age" => 26
      );

      // Data test false
      $data_false = array(
         "name" => "",
         "age" => 26
      );

      $validator = new Validator($data_true, $rules);
      $this->assertTrue($validator->passes());
      $this->assertEqual($validator->messages(), "");

      $validator1 = new Validator($data_false, $rules);
      $this->assertTrue($validator1->fails());
      // Nên là 1 array
      $this->assertIsA($validator1->messages(), 'array');
      $this->assertTrue(array_key_exists('name', $validator1->messages()));
      // Tuong tu nhu testcase nhung can 1 phuong thuc ngan gon hon de ktra nhanh
      $this->assertTrue($validator1->has('name'));
      // Nen return 1 array
      $this->assertIsA($validator1->messages('name'), 'array');
      // Ly do fails
      $this->assertTrue(in_array("[name] is required", $validator1->messages('name')));
      // Lay thong bao loi dau tien <tuong tu nhu testcase tren>
      $this->assertEqual($validator1->message(), "[name] is required");
      // Lay cac field fail
      $this->assertIsA($validator1->failed(), 'array');
      // Nen chứa lý do name
      $this->assertTrue(in_array('name', $validator1->failed()));
   }
}