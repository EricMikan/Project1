<?php

class appPage {
	public $fullRequest = "";
	public $landing = "";
	public $paramaters = [];
	public $title = "NBT";
	public $debug = "";
	public $isSecure = false;
	
	public $renderQueue = [];
	
	function __construct() {
		
	}
	
	function secure() {
		if (!$_SESSION["validated"]) {
			$lPage = "/login.php";
			$lRedir = "/charts";
			if (isset($GLOBALS['ROUTER']->fullRequest) && !empty($GLOBALS['ROUTER']->fullRequest)) $lRedir = $GLOBALS['ROUTER']->fullRequest;
			if (strlen($GLOBALS['CONFIG']->appSettings["appLoginPage"]) > 0) $lPage = $GLOBALS['CONFIG']->appSettings["appLoginPage"];
			header("Location: ".$lPage."?x=".$_SESSION["validated"]."&rd=".urlencode($lRedir));
			exit();
		}
	}
	
	function renderHeader($startBody = true) {
		include "./include/header.php";
		if ($startBody) $this->startBody();
	}
	
	function startBody() {
		echo "\r\n</head>\r\n<body>";
	}
	
	function renderFooter() {
		include "./include/footer.php";
	}
}

?>