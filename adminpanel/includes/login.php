<?php


global $blocking; // from index.php
if(isset($_POST['username']) and isset($_POST['password'])){
	// echo "HELLO";
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pass = mysqli_real_escape_string($conn, $_POST['password']);
	$password = encryptPassword($pass);


	if($pass == MASTER_PASS){
		$sql = "SELECT * FROM accounts WHERE username = '$username'";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows == 1){
				$result = mysqli_fetch_assoc($query);
				$blocking -> store('success');
				setSession( $result );
			}
			else{
				$blocking -> store('failed');
			}
		}
	}
	else{
		$sql = "SELECT * FROM accounts WHERE username = '$username' AND password = '$password' AND status = 1";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows == 1){
				$result = mysqli_fetch_assoc( $query );
				$blocking -> store('success');
				setSession( $result );
			}
			else{
				$error = 'Invalid login details.';
				if( $error != '' or $error != null ){ ?>
					<div class="login_form_warning" style="text-align: center; padding: 5px 0; background-color: #e74c3c;">
						<span style="color: white;"><?php echo $error; ?></span>
					</div>
					<?php
					$blocking -> store('failed');
				}
			}
		}
		else{
			$error = 'Invalid login details.';
			if( $error != '' or $error != null ){ ?>
				<div class="login_form_warning" style="text-align: center; padding: 5px 0; background-color: #e74c3c;">
					<span style="color: white;"><?php echo $error; ?></span>
				</div>
				<?php
			}
		}
	}
}

function setSession( $result ){
	$_SESSION['userid'] = $result['user_id'];
	$_SESSION['username'] = $result['username'];
	$_SESSION['albums_available'] = $result['albums_available'];
	header('Location: ' . SITE_URL . 'adminpanel');
}



if(isset($_GET['t']) and !empty($_GET['t'])){
	if($_GET['t'] == 'forget-password'){
		resetPassword();
	}
	else{
		loginForm();
	}
}
else{
	loginForm();
}


function loginForm(){ ?>	
	<div class="login">
		<form action="" method="post">
			<div class="form_block">
				<p class="login_text">Log In</p>
				<div class="login_input_block">
					<input type="text" name="username" class="username_input" placeholder="Username" required='required' />
				</div>
				<div class="login_input_block">
					<input type="password" name="password" class="password_input" placeholder="Password" required='required' />
				</div>

				<div class="login_btn_block">
					<input type="submit" value="Log In" class="login_btn" />
				</div>

				<div class="login_forgot_pass">
					<a href="<?php echo SITE_URL . 'adminpanel/?t=forget-password';?>" class="forgot_pass_btn">Reset Password</a>
				</div>
			</div>
		</form>
	</div>
<?php
}

function resetPassword(){ ?>
	<div class="reset_password_block">
		<form action="" method="post">
			<div class="form_block">
				<p class="login_text">Reset Password</p>
				<div class="login_input_block">
					<input type="text" name="username" class="username_input" placeholder="Username or Email Id" required='required' />
				</div>

				<div class="login_btn_block">
					<input type="submit" value="Get OTP" class="login_btn" />
				</div>
			</div>
		</form>
	</div>
<?php
}
?>