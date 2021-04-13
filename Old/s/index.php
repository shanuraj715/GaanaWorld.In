<?php
include '../config.php';
class LinkShort{

	private $connection;
	private $string;

	function __construct(){

	}

	function getString(){
		$url = explode( '/', THIS_PAGE);
		if(end($url) != ''){
			$string = end($url);
		}
		else{
			$length = count($url);
			$string = $url[$length - 2];
		}

		if($string == ''){
			header('Location: ' . SITE_URL);
		}
		else{
			$this -> string = $string;
			$link_query = new DbQuery;
			$link_query -> string = $this -> string;

			if($ref_page = $link_query -> getLinkData()){
				$ref_page_full_url = SITE_URL . $ref_page;
				header('Location: ' . $ref_page_full_url);
				exit();
			}
			else{
				echo "<h1>Invalid Link</h1>";
			}
		}

	}


}

class DbQuery{

	private $connection;
	public $string;

	function __construct(){
		include '../db.php';
		$this -> connection = $conn;
	}

	function getLinkData(){
		$string = $this -> string;
		$sql = "SELECT * FROM link_short WHERE shorted = '$string'";
		$query = mysqli_query($this -> connection, $sql);
		if($query){
			$row = mysqli_num_rows($query);
			if($row == 1){
				$result = mysqli_fetch_assoc($query);
				$ref_page = $result['ref_page'];
				return $ref_page;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

}



$short = new LinkShort;
$short -> getString();

?>