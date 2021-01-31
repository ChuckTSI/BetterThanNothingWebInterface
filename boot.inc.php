<?php

spl_autoload_register(function ($class) {
    include 'lib/' . $class . '.class.php';
});

if(getcwd() != $_CONFIG["path"]){
	$errors[] = '<h4 class="alert-heading"><strong>Incorrect Folder</strong></h4>Your install lives in: '.getcwd().'<br>Your config says: '.$_CONFIG["path"].'<br>Please edit the $_CONFIG["path"] config.inc.php';
}

if(!is_writeable($_CONFIG["data_path"])){
	$errors[] = '<h4 class="alert-heading"><strong>Cannot write to data folder</strong></h4>Please make the '.$_CONFIG["data_path"].' folder world writeable.';
}

if(is_dir($_CONFIG["path"].'/ramdisk')){
	$string = shell_exec("mountpoint '".$_CONFIG["path"]."/ramdisk"."'");
	if(strstr($string,'is not a mountpoint')){
		$errors[] = '<h4 class="alert-heading"><strong>Ramdisk is not a ramdisk</strong></h4>Please make the '.$_CONFIG["data_path"].' a ramdisk or delete the folder from your install path.';
	}
}