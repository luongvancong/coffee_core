<?php

class PermissionException extends Exception {
   public function __construct($message = null, $code = 403) {
      parent::__construct($message? : 'Action not allowed', $code);
   }
}

/**
 * Class này nhận vào 1 thể hiện của class Validator
 * và lấy message báo lỗi đầu tiên.
 */
class ValidationException extends Exception {
   protected $message;
   public function __construct($validator) {
      $this->message = $validator->message();
      parent::__construct($this->message, 400);
   }

   public function getMessages() {
      return $this->message;
   }
}

class NotFoundException extends Exception {
   public function __construct($message = null, $code = 404) {
      parent::__construct($message ? : 'Resource not found', $code);
   }
}