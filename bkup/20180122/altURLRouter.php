<?php
	require_once "./include/required.php";

	class appRouter {
		public $fullRequest = "";
		public $landing = "";
		public $parameters = "";
		public $route = "";
	}
	
	session_start();
	
	$GLOBALS['ROUTER'] = new appRouter();
	$GLOBALS['PAGE'] = new appPage();

	if (isset($_GET["fullRequest"]) && !empty($_GET["fullRequest"])) $GLOBALS['ROUTER']->fullRequest = $_GET["fullRequest"];
	
	if (strlen($GLOBALS['ROUTER']->fullRequest) > 0)
	if (substr($GLOBALS['ROUTER']->fullRequest,0,1) == "/") 
		$GLOBALS['ROUTER']->fullRequest = substr($GLOBALS['ROUTER']->fullRequest,1);
	
	if (strlen($GLOBALS['ROUTER']->fullRequest) > 0) {
		$reqParts = explode("/", $GLOBALS['ROUTER']->fullRequest);
		if (count($reqParts) > 0) {
			$reqParams = [];
			$GLOBALS['ROUTER']->landing = $reqParts[0];
			$startI = 1;
			for ($i = $startI; $i < count($reqParts); $i++) {
				if (strlen($reqParts[$i]) > 0) {
					$reqParams[] = $reqParts[$i];
				}
			}
			$GLOBALS['ROUTER']->paramaters = $reqParams;
		}
	}
	
	if (strlen($GLOBALS['ROUTER']->landing) == 0) {
		$GLOBALS['ROUTER']->route = "./landing/charts/landing.php";
	}
	else {
		if (file_exists("./landing/".$GLOBALS['ROUTER']->landing."/")) {
			$GLOBALS['ROUTER']->route = "./landing/".$GLOBALS['ROUTER']->landing."/landing.php";
		}
		else if (file_exists("./landing/".$GLOBALS['ROUTER']->landing.".php")) {
			$GLOBALS['ROUTER']->route = "./landing/".$GLOBALS['ROUTER']->landing.".php";
		}
	}
	
	if (strlen($GLOBALS['ROUTER']->route) == 0) {
		include "./appNotFound.php";
	}
	else {
		$GLOBALS['PAGE']->parameters = $GLOBALS['ROUTER']->parameters;
		$GLOBALS['PAGE']->landing = $GLOBALS['ROUTER']->landing;
		
		include($GLOBALS['ROUTER']->route);
	}
?>