<?php

class Str {

   /**
    * Determine if a input string contains a input sub-string.
    * @param  string          $haystack   Input string
    * @param  string|array    $needle     Input sub-string
    * @return bool
    */
   public static function contains($haystack, $needle) {
      foreach ((array) $needle as $n)
      {
         if (strpos($haystack, $n) !== false) return true;
      }

      return false;
   }

   /**
    * Determine if a string starts with a given needle.
    *
    * @param  string          $haystack
    * @param  string|array    $needles
    * @return bool
    */
   public static function startsWith($haystack, $needles) {
      foreach ((array) $needles as $needle) {
         if (strpos($haystack, $needle) === 0) return true;
      }

      return false;
   }

   /**
    * Determine if a given string ends with a given needle.
    *
    * @param string        $haystack
    * @param string|array  $needles
    * @return bool
    */
   public static function endsWith($haystack, $needles) {
      foreach ((array) $needles as $needle) {
         if ($needle == substr($haystack, strlen($haystack) - strlen($needle))) return true;
      }

      return false;
   }

   /**
    * Cut string
    * @param  string    $str     Input string
    * @param  int       $limit   Limit words
    * @param  string    $end     End string
    * @return string
    */
   public static function cut_string($str, $limit, $end = '...') {
      $strlen = mb_strlen($str, "UTF-8");
      if ($strlen <= $limit) return $str;

      // Cắt chiều dài chuỗi $str tới đoạn cần lấy
      $substr = mb_substr($str, 0, $limit, "UTF-8");
      if (mb_substr($str, $limit, 1, "UTF-8") == " ") return $substr . $end;

      // Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
      $strPoint= mb_strrpos($substr, " ", "UTF-8");

      // Return string
      if ($strPoint < $limit - 20) return $substr . $end;
      else return mb_substr($substr, 0, $strPoint, "UTF-8") . $end;
   }

   /**
    * Cut string with the number of characters
    * @param  string    $str     Input string
    * @param  int       $limit   Limit characters
    * @param  string    $end     End string
    * @return string
    */
   public static function limits($str, $limit, $end = '...') {
      if (mb_strlen($str) <= $limit) return $str;

      return mb_substr($str, 0, $limit, 'UTF-8').$end;
   }

   /**
    * Limit the number of words in a string.
    *
    * @param  string  $str
    * @param  int     $words
    * @param  string  $end
    * @return string
    */
   public static function words($str, $words = 100, $end = '...') {
      preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $str, $matches);

      if ( ! isset($matches[0])) return $str;

      if (strlen($str) == strlen($matches[0])) return $str;

      return rtrim($matches[0]).$end;
   }

   /**
    * Generate a random string
    * @param  integer $length
    * @return string
    */
   public static function random($length = 16) {
      $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
   }

   /**
    * Convert input string to uppercase
    * @param  string $value
    * @return string
    */
   public static function upper($value) {
      return mb_strtoupper($value);
   }

   /**
    * Convert input string to lowercase
    * @param  string $value
    * @return string
    */
   public static function lower($value) {
      return mb_strtolower($value);
   }

   /**
    * Get length of input string
    * @param  string $value
    * @return integer
    */
   public static function length($value) {
      return mb_strlen($value);
   }

   /**
    * Convert string to ascii
    * @param  string $value
    * @return string
    */
   public static function removeAccent($value) {
      $vi_characters = array(
         // Chữ thường
         "à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
         "è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
         "ì","í","ị","ỉ","ĩ",
         "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
         "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
         "ỳ","ý","ỵ","ỷ","ỹ",
         "đ","Đ","'",
         // Chữ hoa
         "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
         "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
         "Ì","Í","Ị","Ỉ","Ĩ",
         "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
         "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
         "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
         "Đ","Đ","'"
      );

      $en_characters = array(
         // Chữ thường
         "a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
         "e","e","e","e","e","e","e","e","e","e","e",
         "i","i","i","i","i",
         "o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
         "u","u","u","u","u","u","u","u","u","u","u",
         "y","y","y","y","y",
         "d","D","",
         //Chữ hoa
         "A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
         "E","E","E","E","E","E","E","E","E","E","E",
         "I","I","I","I","I",
         "O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
         "U","U","U","U","U","U","U","U","U","U","U",
         "Y","Y","Y","Y","Y",
         "D","D","",
      );
      return str_replace($vi_characters, $en_characters, $value);
   }

   /**
    * Convert string to slug style
    * | Rename from [removeTitle] function
    * @param  string $title
    * @param  string $separator
    * @return string
    */
   public static function slug($title, $separator = "-") {
      $title = self::removeAccent($title);

      // Remove all characters that are not the separator, letters, numbers, or whitespace.
      $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', self::lower($title));

      // Convert all dashes/undescores into separator
      $flip = $separator == '-' ? '_' : '-';

      $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

      // Replace all separator characters and whitespace by a single separator
      $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

      return trim($title, $separator);
   }
}