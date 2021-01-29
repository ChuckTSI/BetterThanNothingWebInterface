<?php

if(getcwd() != $_CONFIG["path"]){
	$errors[] = '<h4 class="alert-heading"><strong>Incorrect Folder</strong></h4>Your install lives in: '.getcwd().'<br>Your config says: '.$_CONFIG["path"].'<br>Please edit the $_CONFIG["path"] config.inc.php';
}

if(!is_writeable($_CONFIG["data_path"])){
	$errors[] = '<h4 class="alert-heading"><strong>Cannot write to data folder</strong></h4>Please make the '.$_CONFIG["data_path"].' folder world writeable.';
}