<?php
/**
 * 
 */
class Cronjob{
	protected $directory;
	protected $log_file;
	
	function __construct(){
		$this -> directory = __DIR__;
		$this -> directory = str_replace('\\', '/', $this -> directory);
		

		/* log file class and objects */
		include './addons/file_creator.php';
		$log_file = new CreateLogFile;
		$this -> log_file = $log_file -> create_file();
	}

	function startCron(){
		include '../config.php';
		include '../db.php';

		if(DEL_MP3_FILE){
			include $this -> directory . '/cron_job_files/manage_uploaded_song_files.php';
			$cron_song = new CronManageMp3Files(); // object initialization
			$cron_song -> log_file = $this -> log_file; // setting log file name to log every activity

			$cron_song -> conn = $conn;
			$cron_song -> mainCron();
		}




























		if(DEL_IMG_FILE){
			include $this -> directory . '/cron_job_files/manage_uploaded_image.php';
			$cron_image = new CronManageImageFiles; // object initialization
			
		}

		if(DB_DEL_SONG_ROW){
			include $this -> directory . '/cron_job_files/db_song_rows.php';
			$cron_song_db = new CronManageSongDb; // object initialization
			
		}
	}


}

$cron = new Cronjob;
$cron -> startCron();

?>