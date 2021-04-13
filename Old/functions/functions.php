<?php

function catIdToName( $cat_id ){
    global $conn;
    $str = "SELECT category_name from categories WHERE category_id = $cat_id";
    $query = mysqli_query($conn, $str);
    if($query){
        $result = mysqli_fetch_assoc($query);
        return $result['category_name'];
    }
    else{
        return "Unknown category";
    }

}

function getSingerTags($singer_id){
    global $conn;
    $sql = "SELECT tags FROM singers WHERE singer_id = $singer_id";
    $query = mysqli_query($conn, $sql);
    if($query){
        $rows = mysqli_num_rows($query);
        $result = mysqli_fetch_assoc($query);
        $tags = $result['tags'];
        return $tags;
    }
}

function singerIdToName( $singer_id ){
    global $conn;
    $str = "SELECT singer_name from singers WHERE singer_id = $singer_id";
    $query = mysqli_query($conn, $str);
    if($query){
        $result = mysqli_fetch_assoc($query);
        return $result['singer_name'];
    }
    else{
        return "Unknown Singer";
    }
}

function singerNameToId( $singer_name ){
    global $conn;
    $singer_name = mysqli_real_escape_string($conn, $singer_name);
    $str = "SELECT singer_id from singers WHERE singer_name = '$singer_name'";
    $query = mysqli_query($conn, $str);
    if($query){
        $result = mysqli_fetch_assoc($query);
        if(is_numeric( $result['singer_id'] )){
            return $result['singer_id'];
        }
        else{
            return 'Unknown Id';
        }
    }
    else{
        return "Unknown Id";
    }
}

function albumIdToName( $album_id ){
    global $conn;
    $str = "SELECT album_name from albums WHERE album_id = $album_id";
    $query = mysqli_query($conn, $str);
    if($query){
        $result = mysqli_fetch_assoc($query);
        if($result['album_name'] == ''){
            return "Unknown Album";
        }
        else{
            return $result['album_name'];
        }


    }
    else{
        return "Unknown Album";
    }
}

function userIdToName( $user_id ){
	global $conn;
	$sql = "SELECT * FROM accounts WHERE user_id = $user_id";
	$query = mysqli_query($conn, $sql);
	if($query){
		$data = mysqli_fetch_assoc($query);
		return $data['name'];
	}
	else{
		return 'Unknown';
	}
}

function songIdToName( $song_id ){
    global $conn;
    $str = "SELECT title from songs WHERE song_id = $song_id";
    $query = mysqli_query($conn, $str);
    if($query){
        $result = mysqli_fetch_assoc($query);
        if($result['title'] == ''){
            return "Unknown Song";
        }
        else{
            return $result['title'];
        }


    }
    else{
        return "Unknown Song";
    }
}


function songImage( $image, $image_month_dir ){
    
    function getRandomImage(){
        $image_name = rand(1, 30);
        $image_name = $image_name . '.png';

        $image_addr = './images/song_images/' . $image_name;

        if(file_exists($image_addr)){
            return SITE_URL . 'images/song_images/' . $image_name;
        }
        else{
            return SITE_URL . 'images/song_images/default.png';
        }
    }
    if($image == ''){
        return getRandomImage();
        
    }
    else{
        $image_addr = './uploads/' . $image_month_dir . '/images/' . $image;
        if(file_exists($image_addr)){
            return SITE_URL . 'uploads/' . $image_month_dir . '/images/' . $image;
        }
        else{
            return getRandomImage();
        }
        return SITE_URL . 'uploads/' . $image_month_dir . '/images/' . $image;
    }
}

function incrementTotalDownloads( $song_id , $currentDownloads ){
    global $conn;
    
    $tot_down = $currentDownloads + 1;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT * FROM ip_for_total_downloads WHERE song_id = $song_id AND userip = '$user_ip' ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if($query){
        $rows = mysqli_num_rows($query);
        if($rows == 0 or $rows != 0){
            $result = mysqli_fetch_assoc($query);
            $last_date = $result['date_ts'];

            $now_time = time();
            if($now_time - $last_date > TD_INC_TIME){
                /* update song table for total downloads and insert a new record in the database */
                $sql = "UPDATE songs SET total_downloads = $tot_down WHERE song_id = $song_id";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $ip_to_loc = ipToLocation();
                    if($ip_to_loc['status'] == 'success' and !crawler()){
                        $continent = $ip_to_loc['continent'];
                        $country = $ip_to_loc['country'];
                        $region = $ip_to_loc['region'];
                        $city = $ip_to_loc['city'];
                        $lat_long = $ip_to_loc['lat'] . ', ' . $ip_to_loc['lon'];
                        $isp = $ip_to_loc['isp'];
                        $proxy = $ip_to_loc['proxy'];
                        if($proxy){
                            $proxy = 'true';
                        }
                        else{
                            $proxy = 'false';
                        }
                        
                        $sql = "INSERT INTO ip_for_total_downloads(userip, song_id, date_ts, continent, country, region, city, lat_long, isp, proxy) VALUES('$user_ip', $song_id, '$now_time', '$continent', '$country', '$region', '$city', '$lat_long', '$isp', '$proxy')";
                        try{
                            $query = mysqli_query($conn, $sql);
                            if(!$query){
                                error_log( mysqli_error($conn) );
                            }
                        }
                        catch( Exception $e){
                            echo "Unable to update the total downloads";
                        }
                    }
                    elseif( !crawler() ){
                        $sql = "INSERT INTO ip_for_total_downloads(userip, song_id, date_ts)";
                        $sql .= " VALUES('$user_ip', $song_id, '$now_time')";
                        try{
                            $query = mysqli_query($conn, $sql);
                        }
                        catch( Exception $e){
                            echo "Unable to update the total downloads";
                        }
                    } 
                }
            }
        }
        else{

        }
    }
    else{

    }

}

function crawler(){
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_ip = explode('.', $user_ip);
    function validatePreviousInsertions(){
        global $conn;
        global $user_ip;
        $from_time = time() - 60;
        $till_time = time();
        $sql = "SELECT * FROM ip_for_total_downloads WHERE userip = '$user_ip' AND date_ts >= '$from_time' AND date_ts <= '$till_time' ORDER BY id DESC LIMIT 6";
        $query = mysqli_query($conn, $sql);
        if($query){
            $rows = mysqli_num_rows($query);
            if($rows == 6){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }
    /*
    This function is created to get info about the crawler. If the visiter is a crawler then this function will return true
    */
    $googlebot_ip_range = "66.249.x.x";
    $googlebot_ip_range = explode('.', $googlebot_ip_range);
    if($googlebot_ip_range[0] == $user_ip[0] and $googlebot_ip_range[1] == $user_ip[1]){
        return true;
    }
    else{
        if(validatePreviousInsertions()){
            return false;
        }
        else{
            return true;
        }
    }
}

function totalSongsOfAlbum($album_id){
    global $conn;

    $sql = "SELECT count(song_id) as total FROM songs WHERE album_id = $album_id";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        $total = $result['total'];
        return $total;
    }
    else{
        return '0';
    }
}

function page_title($title, $flag){
	if(strlen($title) > 40){
		$gen_title = '';
		$title_array = explode(' ', $title);
		$new_title = substr($title, 0, 40);
		$new_title_array = explode(' ', $new_title);
		foreach ($new_title_array as $key => $value) {
			if($title_array[$key] == $new_title_array[$key]){
				$gen_title .= $value . ' ';
			}
		}
		if($flag == true){
			$gen_title = $gen_title . '- ' . SITE_TITLE;
		}
	}
	else{
		$gen_title = $title;
		if($flag == true){
			$gen_title = $gen_title . ' - ' . SITE_TITLE;
		}
	}
	
	return $gen_title;
}

function urlSongTitle($name){
    $song_title = str_replace('( ', '(', $name);
    $song_title = str_replace(' )', ')', $song_title);
    $song_title = str_replace(' _ ', '-', $song_title);
    $song_title = str_replace(' - ', '-', $song_title);
    $song_title = str_replace(' ', '-', $song_title);
    $song_title = htmlentities( strtolower($song_title) );
    $song_title = substr($song_title, 0, 45);
    // echo $song_title;
    return $song_title;
}


function ipToLocation(){
    if(VISITOR_LOC == true){
        $endpoint = APIEndpoint(); // from config.php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $decoded = json_decode($output);

        /*
        status : success
        continent : Asia
        country : India
        regionName : Punjab
        city : Ludhiana
        lat : 30.9146
        lon : 75.8543
        isp : Jio
        proxy : false // boolean
        query : 157.0.0.0 // user ip
        */

        $array = [
            'status' => $decoded -> status,
            'continent' => $decoded -> continent,
            'country' => $decoded -> country,
            'region' => $decoded -> regionName,
            'city' => $decoded -> city,
            'lat' => $decoded -> lat,
            'lon' => $decoded -> lon,
            'isp' => $decoded -> isp,
            'proxy' => $decoded -> proxy,
            'query' => $decoded -> query
        ];
    }
    else{
        $user_ip = $_SERVER["REMOTE_ADDR"];
        $array = [
            'status' => 'success',
            'continent' => 'not-fetched',
            'country' => 'not-fetched',
            'region' => 'not-fetched',
            'city' => 'not-fetched',
            'lat' => 'not-fetched',
            'lon' => 'not-fetched',
            'isp' => 'not-fetched',
            'proxy' => 'not-fetched',
            'query' => $user_ip
        ];
    }
	
	return $array;
}

?>