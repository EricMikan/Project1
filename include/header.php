<?php
	$dispTitle = "";
	if (isset($this->title) && !empty($this->title)) $dispTitle = $this->title;
	else if (isset($GLOBALS['SPECS']->title) && !empty($GLOBALS['SPECS']->title)) $dispTitle = $GLOBALS['SPECS']->title;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NBT - <?=$dispTitle?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/default.css" />
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
