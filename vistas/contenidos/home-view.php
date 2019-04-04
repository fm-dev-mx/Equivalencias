<?php 
    if($_SESSION['tipo_sbp']!="Administrador"){
        echo $lc->forzar_cierre_sesion_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Sistema de equivalencias <small>UACJ</small></h1>
	</div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
    <?php
        require "./controladores/administradorControlador.php";
        $IAdmin= new administradorControlador();
        $CAdmin=$IAdmin->datos_administrador_controlador("Conteo",0);
        require "./controladores/universidadControlador.php";
        $IUniv= new universidadControlador();
        $CUniv=$IUniv->datos_universidad_controlador("Conteo",0);
        require "./controladores/carreraControlador.php";
        $ICarrera= new carreraControlador();
        $CCarrera=$ICarrera->datos_carrera_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Administradores
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-account"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $CAdmin->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Universidades
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-balance"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $CUniv->rowCount(); ?></p>
			<small>Register</small>
		</div>
	</article>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Carreras
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-library"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $CCarrera->rowCount(); ?></p>
			<small>Register</small>
		</div>
	</article>
</div>
