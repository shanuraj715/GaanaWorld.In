<?php
include '../../config.php';
include '../../db.php';

if(isset($_GET['username']) and !empty($_GET['username'])){
	$username = mysqli_real_escape_string($conn, $_GET['username']);
	// echo $username;
	$sql = "SELECT * FROM accounts WHERE username = '$username' OR email_id = '$username'";
	$query = mysqli_query($conn, $sql);
	if($query){
		$rows = mysqli_num_rows($query);
		if($rows == 1){
			$result = mysqli_fetch_assoc($query);
			if( checkEmailId( $result['email_id']) ){
				if( $otp = sendOTP( $result['email_id'] ) ){
					updateOTPRow( $otp, $result['user_id'] );
				}
			}
		}
		else{
			echo 'username or email id not found';
		}
	}
}

function sendOTP( $to ){

	$subject = 'Reset Account Password | ' . SITE_TITLE;

	$site_image_logo = SITE_URL . 'images/site_title_image.png';

	$otp = rand(112233, 999999);

	$message = '<html><body style="padding-left:40px;">';
	$message .= '<h2>Reset Your Account Password</h2>';
	$message .= '<div style="text-align:center; width: 80px; height: 80px;><img src="' . $site_image_logo . '" style="width: 100%; height:100%; /></div>';
	$message .= '<p style="color: #58B19F; padding-left: 15px;">We have received a request to reset your ' . SITE_TITLE . ' password.</p>';
	$message .= '<p style="color: #2C3A47;">OTP to reset your account password is </p>';
	$message .= '<span style="background:#006266; color: white; padding: 5px 15px;">' . $otp . '</span>';
	$message .= '<p style="">Your OTP is valid for 30 Minutes. <span style="color:#ff7979;">If this is not  you, please ignore this email.</span></p>';
	$message .= '</body></html>';


	$header = "MIME-Version: 1.0" . "\r\n";
	$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	$header .= 'From: <reset-password@gaanaworld.in>' . "\r\n";

	if( mail( $to, $subject, $message, $header) ){
		return $otp;
	}
	else{
		return false;
	}
}

function updateOTPRow( $otp, $userid ){
	$time = time();
	echo $otp . $userid;
	$sql = "UPDATE accounts SET otp = $otp, otp_time = '$time' WHERE user_id = $userid";
	$query = mysqli_query($conn, $sql);
	if($query){
		echo mysqli_error($conn);
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

function checkEmailId( $email ){
	$wrong_email_list = ['', 'user@gmail.com'];

	if(in_array( $email, $wrong_email_list )){
		return false;
	}
	else{
		return true;
	}
}

?>