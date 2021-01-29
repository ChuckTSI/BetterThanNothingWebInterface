<?php

if(getcwd() != $_CONFIG["path"]){
	echo 'Your install lives in: '.getcwd();
	echo '<br>Your config says: '.$_CONFIG["path"];
	die('<br>The path in your configuration is incorrect. Please edit the $_CONFIG["path"] config.inc.php');
}