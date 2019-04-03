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
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">System <small>TimeLine</small></h1>
	</div>
	<section id="cd-timeline" class="cd-container">
        <div class="cd-timeline-block">
            <div class="cd-timeline-img">
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/Male2Avatar.png" alt="user-picture">
            </div>
            <div class="cd-timeline-content">
                <h4 class="text-center text-titles">1 - Name (Admin)</h4>
                <p class="text-center">
                    <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                    <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
                </p>
                <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
            </div>
        </div>  
        <div class="cd-timeline-block">
            <div class="cd-timeline-img">
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/Male2Avatar.png" alt="user-picture">
            </div>
            <div class="cd-timeline-content">
                <h4 class="text-center text-titles">2 - Name (Teacher)</h4>
                <p class="text-center">
                    <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                    <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
                </p>
                <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
            </div>
        </div>
        <div class="cd-timeline-block">
            <div class="cd-timeline-img">
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/Male2Avatar.png" alt="user-picture">
            </div>
            <div class="cd-timeline-content">
                <h4 class="text-center text-titles">3 - Name (Student)</h4>
                <p class="text-center">
                    <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                    <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
                </p>
                <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
            </div>
        </div>
        <div class="cd-timeline-block">
            <div class="cd-timeline-img">
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/Male2Avatar.png" alt="user-picture">
            </div>
            <div class="cd-timeline-content">
                <h4 class="text-center text-titles">4 - Name (Personal Ad.)</h4>
                <p class="text-center">
                    <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                    <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
                </p>
                <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
            </div>
        </div>   
    </section>
</div>