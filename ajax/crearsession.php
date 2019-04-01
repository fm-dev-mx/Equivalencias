<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['uniSelect'])){
		session_start(['name'=>'SBP']);
		$_SESSION['uniSelect']=$_POST['uniSelect'];
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}