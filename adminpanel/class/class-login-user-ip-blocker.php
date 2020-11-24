<?php

/**
 * To block users using their IP address. The class is used to block all invalid users from the login page. Blocked users will no longer to access the admin panel.

 */
class BlockUsers
{
	private $connection;
	private $user_ip;
	
	/*
	* in constructor, we are setting the variables. 
	*/
	function __construct()
	{
		global $conn;
		$this -> connection = $conn;
		$this -> user_ip = $_SERVER['REMOTE_ADDR'];
	}

	/*
	* init() returns either true or false value. if user ip is not blocked, it will return true else it will return false;
	*/
	function init(){
		$user_ip = $this -> user_ip;
		$sql = "SELECT * FROM `login_log` WHERE `ip` = '$user_ip' ORDER BY id DESC LIMIT 10";
		$query = mysqli_query( $this -> connection, $sql );
		$failed_logins = 0;
		if( $query ){
			if( mysqli_num_rows($query) != 0){
				while ( $result = mysqli_fetch_assoc( $query ) ) {
					if($result['status'] == 'failed'){
						$failed_logins++;
					}
				}
			}
		}
		if( $failed_logins >= 6 ){
			return false;
		}
		else{
			return true;
		}
	}

	/*
	* Store user login status. it accepts one parametr. parametr value can be 'success' or 'failed', depends on the login status.
	*/

	function store( $status ){
		$user_ip = $this -> user_ip;
		$_timestamp = time();
		$sql = "INSERT INTO login_log(`ip`, `_timestamp`, `status`) VALUES('$user_ip', '$_timestamp', '$status')";
		$query = mysqli_query( $this -> connection, $sql );
		if($query){

		}
		else{
			echo mysqli_error($this -> connection);
		}
	}

	/*
	* function to display the blocking message. No return value
	*/

	function display_data(){ ?>
		<div style="text-align: center; font-size: 19px; position: relative;">
			<img src="<?php echo SITE_URL;?>images/blocked.png">
			<div style="position: absolute; top: 0; left: 50%; transform: translate(-50%, 0); padding: 20px 0;">
				<p style="">Login limit exceeds. Your IP has been blocked by our servers due to invalid logins.</p>
				<p style="">You can Contact Us by email <strong>shanuraj715@gmail.com</strong> or by mobile <strong>+919877936035</strong>.</p>
				<!-- <p style="font-size: 23px; font-weight: bold; padding: 25px 0 0 0;">Why this happens</p> -->
				<p style="">The blocking system is used to protect the user login details. This system helps us to prevent Brute Force Attacks.</p>
				<p style="">To unblock your IP, Contact Us.</p>
			</div>
		</div>
		<?php
	}
}

?>