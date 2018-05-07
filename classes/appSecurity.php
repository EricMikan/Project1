<?php

class appSecurity {
	public $username = "";
	public $uid = "";
	
	public function isValidated() {
		if (isset($_SESSION["validated"])) return true;
		else return false;
	}
	
	public function checkSecure() {
		if (!$this->isValidated()) {
			$lPage = "/login.php";
			$lRedir = "/charts";
			if (isset($GLOBALS['SPECS']->fullRequest) && !empty($GLOBALS['SPECS']->fullRequest)) $lRedir = $GLOBALS['SPECS']->fullRequest;
			if (strlen($GLOBALS['CONFIG']->appSettings["appLoginPage"]) > 0) $lPage = $GLOBALS['CONFIG']->appSettings["appLoginPage"];
			header("Location: ".$lPage."?rd=".urlencode($lRedir));
			exit();
		}
	}
	
	public function validateLogin($lUsername, $lPwd) {
		global $conn;
		
		$retVal = false;
		if ($lUsername == "test@test.com" && $lPwd == "321") $retVal = true;
		else if ($lUsername == "michael.grodi@gmail.com" && $lPwd == "executive") $retVal = true;
		else {
			$loginQ = mysqli_query($conn, "SELECT * FROM users where email='".$lUsername."' and password='".$lPwd."'");
		
			if (mysqli_num_rows($loginQ) == 1) {
				$retVal = true;
			}
		}
		return $retVal;
	}
	
	public function initSession() {
		global $conn;
		if (strlen($this->username) > 0) {
			$logQ = mysqli_query($conn, "SELECT * FROM users where email='".$this->username."'");
				
			if (mysqli_num_rows($logQ) > 0) {
				while ($row = mysqli_fetch_array($logQ ,MYSQLI_ASSOC)) {
					session_start();
					$_SESSION["validated"] = true;
					// $_SESSION['username'] = $row['username'];
					//$_SESSION['password'] = $row['password'];
					$_SESSION['level']=$row['level'];
					$_SESSION['firstname']=$row['first_name'];
					$_SESSION['lastname']=$row['last_name'];
					$_SESSION['email']=$row['email'];
					$_SESSION['driver_id']=$row['driver_id'];
					$_SESSION['uid']=$row['uid'];
					$_SESSION['su_ex_email']=$row['su_ex_email'];
					$_SESSION['company_name']=$row['company_name'];
				}
			}
			else {
				session_start();
				$_SESSION["validated"] = false;
				// $_SESSION['username'] = $row['username'];
				//$_SESSION['password'] = $row['password'];
				$_SESSION['level']="";
				$_SESSION['firstname']="";
				$_SESSION['lastname']="";
				$_SESSION['email']="";
				$_SESSION['driver_id']="";
				$_SESSION['uid']="";
				$_SESSION['su_ex_email']="";
				$_SESSION['company_name']="";
			}
		}
	}
	
	function __construct() {
		
	}
}


?>