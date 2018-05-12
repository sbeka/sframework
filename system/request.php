<?php
	$request = xss($_REQUEST);
	if (isset($request["message"])) $message = $request["message"];

?>

