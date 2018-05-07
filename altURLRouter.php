<?php
	require_once "./include/required.php";
	
	$GLOBALS['SECURITY']->checkSecure();

	if (isset($_GET["fullRequest"]) && !empty($_GET["fullRequest"])) $GLOBALS['SPECS']->fullRequest = $_GET["fullRequest"];
	
	if (strlen($GLOBALS['SPECS']->fullRequest) > 0)
	if (substr($GLOBALS['SPECS']->fullRequest,0,1) == "/") 
		$GLOBALS['SPECS']->fullRequest = substr($GLOBALS['SPECS']->fullRequest,1);
	
	if (strlen($GLOBALS['SPECS']->fullRequest) > 0) {
		$reqParts = explode("/", $GLOBALS['SPECS']->fullRequest);
		if (count($reqParts) > 0) {
			$reqParams = [];
			$GLOBALS['SPECS']->landing = $reqParts[0];
			$startI = 1;
			for ($i = $startI; $i < count($reqParts); $i++) {
				if (strlen($reqParts[$i]) > 0) {
					$reqParams[] = $reqParts[$i];
				}
			}
			$GLOBALS['SPECS']->paramaters = $reqParams;
		}
	}
	
	if (strlen($GLOBALS['SPECS']->landing) == 0) {
		$GLOBALS['SPECS']->route = "./landing/charts/landing.php";
	}
	else {
		if (file_exists("./landing/".$GLOBALS['SPECS']->landing."/")) {
			$GLOBALS['SPECS']->route = "./landing/".$GLOBALS['SPECS']->landing."/landing.php";
		}
		else if (file_exists("./landing/".$GLOBALS['SPECS']->landing.".php")) {
			$GLOBALS['SPECS']->route = "./landing/".$GLOBALS['SPECS']->landing.".php";
		}
	}
	
	if (strlen($GLOBALS['SPECS']->route) == 0) {
		include "./appNotFound.php";
	}
	else {
		$GLOBALS['RENDER'] = new appRender();
		include($GLOBALS['SPECS']->route);
	}
?>