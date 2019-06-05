<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Administración <small>Materias</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/carrerauacjControlador.php";
	$insCarrera= new carreraUacjControlador();
	require_once "./controladores/alumnoControlador.php";
	$insAlumno= new alumnoControlador();
	require_once "./controladores/materiaControlador.php";
	$insMateria= new materiaControlador();

	$url=explode("/", $_GET['views']);
	
	if(isset($_SESSION['carreraUacjSelect']))	{
		$codigoCarrera=$_SESSION['carreraUacjSelect'];
	}else{
		$codigoCarrera="";
	}

	//Se obtiene un array con los datos del alumno seleccionado
	if($url[1]!=""){
		$datosAlumno=$insAlumno->datos_alumno_controlador("Unico",$url[1]);
		if($datosAlumno->rowCount()==1){
			$camposAlumno=$datosAlumno->fetch();
		}
	}

	//Se obtiene un array con los nombres de todas las carreras (para la lista desplegable)
	$listaC=$insCarrera->datos_carrera_uacj_controlador("Lista","");
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}

	//Se obtiene un array con los nombres de todas las carreras (para la lista desplegable)
	$listaM=$insMateria->datos_materia_controlador("Lista","",$camposAlumno['AlumnoCarrera']);
	if($listaM->rowCount()>=1){
		$listaMateria=$listaM->fetchAll();
	}
?>

<div class="container-fluid">
	<div class="panel-body">
		<div class="pull-right">
			<!--listado de carreras ---------------------------------------------------------->
			<select class="selectpicker" id="carreraUacjSelect" name="carreraUacjSelect" data-live-search="true">
				<option value="0">Seleciona una carrera</option>			
				<?php foreach($listaCarrera as $rows){ ?> 
					<option value="<?php echo $rows['CarreraCodigo'];?>" <?php if($codigoCarrera==$rows['CarreraCodigo']){echo ' selected';} ?>>
						<?php echo $rows['CarreraNombre'];?>
					</option>	
				<?php } ?>	
			</select>
		</div>	
	<br>		
	<br>		
	<br>		
</div>

<style>
	.container {
		box-sizing: border-box;;
		margin: auto;
		max-width: 1200px;
		padding: 20px 20px;
		width: 100%;
	}
</style>

<!-- Panel listado de materias -->
<div class="container">

	<select multiple="multiple" name="multiSelectMaterias[]">
		<?php foreach($listaMateria as $rows){ ?> 

			
			<option value="<?php echo $rows['MateriaCodigo'].' class=\'selected-wrapper\'';?>">
				<?php echo $rows['MateriaNombre'];?>
			</option>	
		<?php } ?>	
	</select>
</div>		
	

<script type="text/javascript">
  $(document).ready(function(){
    $('#carreraUacjSelect').select2();

	$('select').multi({
		search_placeholder: 'Busca las materias cursadas por el alumno',
	});

  });

	$('#carreraUacjSelect').change(function(){
      $.ajax({
        type:"post",
        data:"carreraUacjSelect=" + $('#carreraUacjSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/materiauacjAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });  
</script>                