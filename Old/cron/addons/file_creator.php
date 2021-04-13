<?php
/**
 * 
 */
class CreateLogFile{
	
	function __construct(){

	}

	function create_file(){
		$file_name = $this -> getFileName();
		$file = fopen( $file_name, "w");
		return $file_name;
	}

	function getFileName(){
		$file_name = date('d-m-y');
		return 'cron_log_' . $file_name . '.txt';
	}
}
?>