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



function isMobile() {
    $useragent=$_SERVER['HTTP_USER_AGENT'];

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        return true;
    }
    else{
        return false;
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


function songImage( $image, $image_month_dir, $category_id ){
    global $conn;
    


    if($image == ''){
        return getCategoryImage( $category_id );
        
    }
    else{

        $image_addr = SITE_DIR . '/uploads/' . $image_month_dir . '/images/' . $image;
        if(file_exists($image_addr)){
            return SITE_URL . 'uploads/' . $image_month_dir . '/images/' . $image;
        }
        else{
            return getCategoryImage( $category_id );
        }
    }
}

function getRandomImage(){
    $image_name = rand(1, 17);
    $image_name = $image_name . '.png';

    $image_addr = SITE_DIR . '/images/song_images/' . $image_name;

    if(file_exists($image_addr)){
        return SITE_URL . 'images/song_images/' . $image_name;
    }
    else{
        return SITE_URL . 'images/song_images/default.png';
    }
}

function getCategoryImage( $category_id ){
    $path = SITE_DIR .  'images/category_images/' . $category_id;
    if( file_exists( $path . '.jpg' ) ){
        return SITE_URL . 'images/category_images/' . $category_id . '.jpg';
    }
    elseif( file_exists( $path . '.png') ){
        return SITE_URL . 'images/category_images/' . $category_id . '.png';
    }
    else{
        return getRandomImage();
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
        if( $rows != 0){
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
            $now_time = time();
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
    $pageNumber = '';
    if( isset($_GET['page'])){
        $pageNumber = " - Page " . $_GET['page'];
    }
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
        $gen_title .= $pageNumber . ' ';
		if($flag == true){
			$gen_title = $gen_title . '- ' . SITE_TITLE;
		}
	}
	else{
		$gen_title = $title . $pageNumber;
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


function getFilePath( $fileName, $uploadtimestamp ){
    return SITE_URL . 'uploads/' . date('m_Y', $uploadtimestamp) . '/' . $fileName;
}




?>