<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Administración <small>Materias - UACJ</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/carrerauacjControlador.php";
	$insCarrera= new carreraUacjControlador();

	$url=explode("/", $_GET['views']);
	
	if(isset($_SESSION['carreraSelect']))	{
		$codigoCarrera=$_SESSION['carreraSelect'];
	}else{
		$codigoCarrera="";
	}

	$tipoConsulta="Unico";
	//Se obtiene un array con los datos de la carrera seleccionada
	if(isset($codigoCarrera)){
		$datosCarrera=$insCarrera->datos_carrera_uacj_controlador($tipoConsulta,$codigoCarrera);
		if($datosCarrera->rowCount()==1){
			$camposCarrera=$datosCarrera->fetch();
		}
	}

	$tipoConsulta="Lista";
	//Se obtiene un array con los nombres de todas las carreras (para la lista desplegable)
	$listaC=$insCarrera->datos_carrera_uacj_controlador($tipoConsulta,"");
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}
?>

<div class="container-fluid">
	<div class="panel-body">
		<div class="pull-right">
			<!--listado de carreras ---------------------------------------------------------->
			<select class="selectpicker" id="carreraSelect" name="carreraSelect" data-live-search="true">
				<option value="0">Seleciona una carrera</option>			
				<?php foreach($listaCarrera as $rows){ ?> 
					<option value="<?php echo $lc->encryption($rows['CarreraCodigo']);?>" <?php if($codigoCarrera==$lc->encryption($rows['CarreraCodigo'])){echo ' selected';} ?>>
						<?php echo $rows['CarreraNombre'];?>
					</option>	
				<?php } ?>	
			</select>
		</div>
			
		<p class="lead"></p>
		<br>
		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
					<a href="<?php echo SERVERURL; ?>materiasuacj/" class="btn btn-info">
						<i class="zmdi zmdi-plus"></i> &nbsp; AGREGAR MATERIA
					</a>
				</li>
				<li>
					<a href="<?php echo SERVERURL; ?>materiasuacjlist/" class="btn btn-success">
						<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MATERIAS
					</a>
				</li>
		</ul>
	</div>
</div>

<div id="tabla">         
  <?php 
    require_once "./controladores/materiaControlador.php";
    $insMateria= new materiaControlador();
  ?>

  <!-- Panel listado de materias -->

  <div class="container-fluid">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp;LISTA DE MATERIAS</h3>
      </div>
      <div class="panel-body">
      <?php
      
        if(isset($url[1])){
          $pagina=$url[1];
        }else{
          $pagina=1;
        }
        
        echo $insMateria->paginador_materia_controlador($pagina,3,1,$codigoCarrera);
        ?>	
      </div>
    </div>
  </div>
</div>
	

<!--Ventana emergente para renombrar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/materiauacjAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="ren-materia-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Renombrar materia</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="MateriaCodigoUpdate" name="MateriaCodigoUpdate" hidden="">
					<input type="text" id="MateriaPrivilegioUpdate" name="MateriaPrivilegioUpdate" hidden="">
					<input type="text" id="MateriaNombreUpdate" name="MateriaNombreUpdate" class="form-control input">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
		$('#carreraSelect').select2();
  });

	$('#carreraSelect').change(function(){
      $.ajax({
        type:"post",
        data:"carreraSelect=" + $('#carreraSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/materiauacjAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });  
</script>