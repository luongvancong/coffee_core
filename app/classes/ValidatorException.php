<?php

class ValidatorException extends Exception{

	public function __construct($message) {
		$arrayBug = debug_backtrace();
		$arrayConfig = array(
			'file'    => $arrayBug[1]['file'],
			'line'    => $arrayBug[1]['line'],
			'message' => $arrayBug[0]['args'],
			'args' => $arrayBug[1]['args']
		);
		$this->template($arrayConfig);
	}

	private function template($message) {
		echo '<pre>';
		echo 'File: ' . $message['file'] . '<br/>';
		echo 'Line: ' . $message['line'] . '<br/>';
		echo 'Error: '  . $message['message'][0] . '<br/>';
		echo 'Args : ';
		print_r($message['args']);
	}
}