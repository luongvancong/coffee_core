<?php
/**
 * Input class
 *
 * Copyright (c) 2013 VNP Ltd,.
 *
 * Class lấy dữ liệu từ 1 request
 *
 * @copyright  Copyright (c) 2013 VNP Ltd,.
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 * @version    1.0.0
 * @author ManhTran manhtt@vatgia.com
 */

class Input {

   /**
    * Method hien tai cua request
    * @var string
    */
   protected $method;

   /**
    * Lay du lieu tu 1 data source
    * @param  array     $array      Data source
    * @param  string    $key        Input field
    * @param  any       $default    Default value if not exitst input field
    * @param  bool      $clean_xss  Clean XSS
    * @return any
    */
   private function fetch_data(&$array, $key = '', $default = null, $clean_xss = false) {
      // Nhan gia tri mac dinh neu khong ton tai key trong array
      if (! isset($array[$key])) {
         return $default;
      }

      if ($clean_xss === false) {
         return $this->cleanXSS($array[$key]);
      }

      return $array[$key];
   }

   /**
    * Clean xss
    * @param  string|number $data
    * @return string|number
    */
   private function cleanXSS($data) {
      // Fix &entity;
      $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
      $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
      $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
      $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

      // Remove any attribute starting with "on" or xmlns
      $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

      // Remove javascript: and vbscript: protocols
      $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
      $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
      $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

      // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
      $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
      $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
      $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

      // Remove namespaced elements (we do not need them)
      $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

      do {
         // Remove really unwanted tags
         $old_data = $data;
         $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
      }
      while ($old_data !== $data);

      // we are done...
      return $data;
   }

   /**
    * Lay method hien tai cua 1 request
    * @return string       GET/POST
    */
   private function getMethod() {
      $this->method = isset($_SERVER['REQUEST_METHOD'])
         ? strtoupper($_SERVER['REQUEST_METHOD'])
         : 'GET';

      return $this->method;
   }

   /**
    * Lay gia tri data source theo request
    * @return array     $_GET/$_POST
    */
   private function getMethodSource() {
      $src = "_" . $this->getMethod();
      return $$src;
   }

   /**
    * Lay gia tri tu 1 data source ($_GET/$_POST)
    *
    * @param  string    $field      Input field
    * @param  any       $default    Default value if not exist input field
    * @return any
    */
   public static function get($field, $default = null, $clean_xss = false) {
      return $this->fetch_data($this->getMethodSource(), $key, $default, $clean_xss);
   }

   /**
    * Lay gia tri tu $_COOKIE
    * @param  string  $field     Input field
    * @param  boolean $clean_xss Clean XSS
    * @return any
    */
   public static function cookie($field, $clean_xss = false) {
      return $this->fetch_data($_COOKIE, $field, null, $clean_xss);
   }

   /**
    * Lay gia tri tu $_SERVER
    * @param  string  $field     Input field
    * @param  boolean $clean_xss Clean XSS
    * @return any
    */
   public static function server($field, $clean_xss = false) {
      return $this->fetch_data($_SERVER, $field, null, $clean_xss);
   }

   /**
    * Lay tat ca gia tri cua cac input field
    * Tuy theo method cua request se lay gia tri tuong ung
    *
    * @param  string|array  $except    Input field khong muon lay gia tri
    * @param  boolean $clean_xss       Clean XSS
    * @return array
    */
   public static function all($clean_xss = false) {
      // Response data
      $data = array();

      // Data source
      $source = $this->getMethodSource();

      if (! empty($source)) {

         foreach (array_keys($source) as $key) {
            $data[$key] = $this->fetch_data($source, $key, null, $clean_xss);
         }
      }

      return $data;
   }

   /**
    * Lay gia tri cac field xac dinh.
    * Co the truyen nhieu field khac nhau nhu cac tham so cua ham.
    * @return array
    */
   public static function only() {
      $arg_list = func_get_args();
      $all = self::all();

      // response data
      $response = array();

      foreach ($arg_list as $arg) {

         if (isset($all[$arg])) {
            $response[$arg] = $all[$arg];
         }
      }

      return $response;
   }

   /**
    * Loai bo gia tri cac field xac dinh, sau do lay cac field con lai
    * Co the truyen nhieu field khac nhau nhu cac tham so cua ham.
    * @return array
    */
   public static function except() {
      $arg_list = func_get_args();
      $all = self::all();

      foreach ($arg_list as $arg) {

         if (isset($all[$arg])) {
            unset($all[$arg]);
         }
      }

      return $all;
   }

   /**
    * Ktra 1 input field co ton tai trong request hien tai k
    * @param  string  $field Input field
    * @return boolean
    */
   public static function has($field) {
      $source = $this->getMethodSource();
      return isset($source[$field]);
   }
}