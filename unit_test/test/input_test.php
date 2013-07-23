<?php

require_once('../libs/autorun.php');
require_once('../libs/web_tester.php');
require_once('../../app/classes/input.php');

class InputTest extends UnitTestCase {
   public function testInputGet()
   {
      $this->get('http://www.example.com/contact.php');
      $this->assertResponse(200);
   }
}