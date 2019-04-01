<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['privilegio-admin']) || isset($_POST['uniSelect']) || isset($_POST['carreraSelect'])){

		if(isset($_POST['uniSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['uniSelect']=$_POST['uniSelect'];		
		}

		if(isset($_POST['carreraSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraSelect']=$_POST['carreraSelect'];		
		}
		
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }