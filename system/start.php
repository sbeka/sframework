<?php
	mb_internal_encoding("UTF-8");
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	session_start();
	
	$message = false;
	
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "expertsystem1");
	
	define("FORMAT_DATE", "Y.m.d H:i:s");
	define("HOME_PATH", $_SERVER['DOCUMENT_ROOT']);
	
	require_once HOME_PATH."/system/functions.php";
	require_once HOME_PATH."/system/request.php";

	//if (!isset($_SESSION['login']) && $_SERVER['SCRIPT_NAME'] != '/login.php') redirect('/login.php');
?>