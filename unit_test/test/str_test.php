<?php

require_once('../libs/autorun.php');
require_once('../../app/classes/str.php');

class StrTest extends UnitTestCase {

   /**
    * Chuỗi test
    * @var string
    */
   protected $mystring = "Hôm nay là cuối tuần, thời tiết rất thích hợp cho việc đi dã ngoại";

   /**
    * Test Str::removeAccent
    */
   public function testStrRemoveAccent() {
      $mystring = $this->mystring;
      $str_no_accent = Str::removeAccent($mystring);

      // Nên là 1 chuỗi
      $this->assertIsA($str_no_accent, 'string');
      // So sánh với chuỗi k dấu
      $this->assertEqual($str_no_accent, 'Hom nay la cuoi tuan, thoi tiet rat thich hop cho viec di da ngoai');
      // "đi" vẫn còn dấu > false
      $this->assertNotEqual($str_no_accent, 'Hom nay la cuoi tuan, thoi tiet rat thich hop cho viec đi da ngoai');
   }

   /**
    * Test Str::length
    */
   public function testStrLength() {
      $mystring = $this->mystring;
      // Nên return ra 1 số integer
      $this->assertIsA(Str::length($mystring), 'integer');
      // Kết quả phải đúng bằng giá trị hàm native strlen
      $this->assertEqual(Str::length($mystring), strlen($mystring));
      // 1 kết quả false
      $this->assertNotEqual(Str::length($mystring), 66);
   }

   /**
    * Test Str::contains
    */
   public function testStrContains() {
      $sub = "rất thích hợp cho";
      $sub_false = "một con vịt";
      // Nên return ra 1 giá trị boolean
      $this->assertIsA(Str::contains($this->mystring, $sub), 'bool');
      // Nên return ra true
      $this->assertTrue(Str::contains($this->mystring, $sub));
      $this->assertTrue(Str::contains($this->mystring, array($sub)));
      // Nên return ra false
      $this->assertFalse(Str::contains($this->mystring, $sub_false));
      $this->assertFalse(Str::contains($this->mystring, array($sub_false)));
      // Nên return ra true
      $this->assertTrue(Str::contains($this->mystring, array($sub, $sub_false)));
   }

   /**
    * Test Str::startsWith
    */
   public function testStartsWith() {
      $str = "Hôm nay";
      $this->assertIsA(Str::startsWith($this->mystring, $str), 'bool');
      // Nên true
      $this->assertTrue(Str::startsWith($this->mystring, $str));
      $this->assertTrue(Str::startsWith($this->mystring, array($str)));
      // Nên false
      $this->assertFalse(Str::startsWith($this->mystring, 'vịt con'));
      $this->assertFalse(Str::startsWith($this->mystring, array('vịt con')));
      // Nên true
      $this->assertTrue(Str::startsWith($this->mystring, array('vịt con', $str)));
   }

   /**
    * Test Str::endsWith
    */
   public function testEndsWith() {
      $str = "dã ngoại";
      $this->assertIsA(Str::endsWith($this->mystring, $str), 'bool');
      // Nên true
      $this->assertTrue(Str::endsWith($this->mystring, $str));
      $this->assertTrue(Str::endsWith($this->mystring, array($str)));
      // Nên false
      $this->assertFalse(Str::endsWith($this->mystring, 'vịt con'));
      $this->assertFalse(Str::endsWith($this->mystring, array('vịt con')));
      // Nên true
      $this->assertTrue(Str::endsWith($this->mystring, array('vịt con', $str)));
   }

   /**
    * Test Str::cut_string
    */
   public function testCutString() {
      $this->assertIsA(Str::cut_string($this->mystring, 4), 'string');
      $this->assertEqual(Str::cut_string($this->mystring, 4), 'Hôm...'); // K có dấu cách
      $this->assertNotEqual(Str::cut_string($this->mystring, 4), 'Hôm ...');
      $this->assertNotEqual(Str::cut_string($this->mystring, 4), 'Hôm nay...');
   }

   /**
    * Test Str::limits
    */
   public function testLimits() {
      $mystring = $this->mystring;
      $this->assertIsA(Str::limits($mystring, 4), 'string');
      $this->assertEqual(Str::limits($mystring, 4), 'Hôm ...'); // tính cả dấu cách
      $this->assertNotEqual(Str::limits($mystring, 4), 'Hom ...');
      $this->assertNotEqual(Str::limits($mystring, 4), 'Hom nay...');
   }

   /**
    * Test Str::words
    * @return [type] [description]
    */
   public function testWords() {
      $this->assertIsA(Str::words($this->mystring, 4), 'string');
      $this->assertEqual(Str::words($this->mystring, 4), 'Hôm nay là cuối...');
      $this->assertNotEqual(Str::words($this->mystring, 4), 'Hôm nay là cuối ...');
      $this->assertNotEqual(Str::words($this->mystring, 4), 'Hôm nay là...');
   }

   /**
    * Test Str::slug
    */
   public function testSlug() {
      $this->assertIsA(Str::slug($this->mystring), 'string');
      $this->assertEqual(Str::slug($this->mystring), 'hom-nay-la-cuoi-tuan-thoi-tiet-rat-thich-hop-cho-viec-di-da-ngoai');
      $this->assertEqual(Str::slug($this->mystring, '_'), 'hom_nay_la_cuoi_tuan_thoi_tiet_rat_thich_hop_cho_viec_di_da_ngoai');
   }
}
?>