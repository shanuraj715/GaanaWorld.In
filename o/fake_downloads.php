<?php
include '../db.php';

$from = 2;
$to = 8;
$operator = 'plus';
if(isset($_GET['from']) and is_numeric($_GET['from'])){
	if(isset($_GET['to']) and is_numeric($_GET['to'])){
		if(isset($_GET['op']) and !empty($_GET['op'])){
			$from = $_GET['from'];
			$to = $_GET['to'];
			$operator = $_GET['op'];
		}
	}
}

$sql = "SELECT * FROM songs";
$query = mysqli_query($conn, $sql);

$iteration = 0;


if($query){
	while ($result = mysqli_fetch_assoc($query)) {

		$iteration++;

		$song_id = $result['song_id'];
		$downloads = $result['total_downloads'];
		if($operator == 'plus'){
			$new_total_downloads = $downloads + rand($from, $to);
		}
		else{
			$new_total_downloads = $downloads - rand($from, $to);
		}

		

		$sql2 = "UPDATE songs SET total_downloads = $new_total_downloads WHERE song_id = $song_id";
		$qry = mysqli_query($conn, $sql2);

	}
}

echo "Done :) => Total $iteration rows updated";

?>