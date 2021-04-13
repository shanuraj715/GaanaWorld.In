<?php

/**
 * 
 */
class CronManageMp3Files{
	public $log_file;
	public $conn;
	protected $file_name_array;
	
	function __construct(){
		$this -> file_name_array = [];
	}

	function mainCron(){
		$sql = "SELECT file_name from songs";
		$query = mysqli_query($this -> conn, $sql);
		while ($result = mysqli_fetch_assoc($query)) {
			array_push($this -> file_name_array, $result['file_name']);
		}
		$upload_dir = SITE_DIR . 'uploads/';
		$dir_files = scandir($upload_dir);

		foreach ($dir_files as $value) {
			if($value != '.' && $value != '..'){
				if(!in_array($value, $this -> file_name_array)){
					echo "Exist";
				}
			}
		}
	}
}

?>