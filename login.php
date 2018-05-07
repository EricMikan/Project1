<?php
	require_once "include/required.php";
	require_once "./code/db.php";

	$RENDER = new appRender();
	
	$errMsg = "";
	$fAttempt = 0;
	
	$rPage = "/charts";
	if (isset($_GET["rd"]) && !empty($_GET["rd"])) $rPage = $_GET["rd"];
	else if (isset($_POST["rd"]) && !empty($_POST["rd"])) $rPage = $_POST["rd"];
	
	$isLoggedIn = false;
	
	if (isset($_SESSION["validated"]) && !empty($_SESSION["validated"])) {
		if ($_SESSION["validated"] == true) {
			$isLoggedIn = true;
		}
	}
	
	if ($isLoggedIn) {
		header("Location: ".$rPage);
		exit();
	}
	else if (isset($_POST["login"])) {
		$fAttempt = $_POST["attempt"];
		$fEmail = $_POST["email"];
		$fPwd = $_POST["pwd"];
		
		if (strlen($fEmail) == 0 || strlen($fPwd) == 0) {
			$errMsg = "Please enter a valid Email ID and Password";
		}
		else {
			if ($GLOBALS['SECURITY']->validateLogin($fEmail, $fPwd)) {
				$_SESSION["validated"] = true;
				
				//$_SESSION["email"] = $fEmail;
				
				//michael.grodi@gmail.com
				
				if ($fEmail == "test@test.com") $fEmail = "michael.grodi@gmail.com";
				
				$logQ = mysqli_query($conn, "SELECT * FROM users where email='".$fEmail."'");
				
				if (mysqli_num_rows($logQ) == 0) {
					$errMsg = "Please enter valid Email ID/Password";
				}
				else {
					$GLOBALS['SECURITY']->username = $fEmail;
					$GLOBALS['SECURITY']->initSession();
					
					header("Location: ".$rPage);
					exit();
				}
			}
			else {
				if ($fAttempt >= 5) {
					$errMsg = "Too many login attempts.";
				}
				else {
					$errMsg = "Invalid Email ID or Password.<br/>Please try again.";
				}
			}
		}
	}
	
	$fAttempt++;
	
	$RENDER->renderHeader(false);
?>
	<style type="text/css">
		body {
			background: url('images/login_bg.jpg') #000000;
			background-repeat: no-repeat;
			background-position: center center;
		}
		
		.login-row {
			width:300px;
			text-align:center;
			height: auto;
		}
		
		.login {
			padding:20px;
			margin-top:20px;
		}
		
		.login-header {
			text-align: center; 
			color: #337ab7; 
			padding: 0 0 0.5em 0;
			font-size: 2em;
		}
		
		.login-header-2 {
			text-align: center; 
			font-size: 2em;
			line-height: 3em;
		}
		
		.login-body {
			border: 3px solid #337ab7;
			background: #f5f5f5;
		}
		
		.login-form {
			padding: 1em;
		}
		
		.alert {
			margin-left: 1em;
			margin-right: 1em;
		}
	</style>
<?php
	$RENDER->startBody();
?>
	<form method="post" action="login.php">
		<input type="hidden" name="rd" value="<?=$rPage?>" />
		<input type="hidden" name="attempt" value="<?=$fAttempt?>" />
		<div class="center-center login">
			<div class="login-header">ATG DASHBOARD</div>
			<div class="login-row login-body">
				<div style="border-bottom: 2px solid #0e74bc; text-align: center;"><img style="padding:8px;margin: 0 auto 0 auto;" class="img-responsive" alt="ATG-DASHBOARD logo" src="images/logoatg.png" /></div>
				<div class="login-header-2">Log In</div>
				<?php
					if (strlen($errMsg) > 0) echo "<div class=\"alert alert-danger\">".$errMsg."</div>";
				?>
				<div class="login-form">
					<div class="form-group">
						<input type="text" name="email" class="form-control" placeholder="Email Address" required autofocus />
					</div>
					<div class="form-group">
						<input type="password" name="pwd" class="form-control" placeholder="Password" required autofocus />
					</div>
					<div class="form-group" style="padding-top: 1em;">
						<input style="background-color: #f37923; */" type="submit" name="login" class="btn btn-primary btn-block" value="Log in" />
					</div>
				</div>
			</div>
		</div>
	</form>

<?php
	$RENDER->renderFooter();
?>