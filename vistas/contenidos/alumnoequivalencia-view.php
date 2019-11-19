<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
		<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Estudiante <small>Equivalencias</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	
	require_once "./controladores/universidadControlador.php";
	$insUniv= new universidadControlador();
	require_once "./controladores/carreraControlador.php";
	$insCarrera= new carreraControlador();
	require_once "./controladores/alumnoControlador.php";
	$insAlumno= new alumnoControlador();
	require_once "./controladores/materiaControlador.php";
	$insMateria= new materiaControlador();
	require_once "./controladores/alumnoMateriaControlador.php";
	$insAlumnoMateria= new alumnoMateriaControlador();

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
			$codigoAlumno=$camposAlumno['AlumnoCodigo'];
		}
	}

	//Se obtiene un array con las materias cursadas por el alumno
	if($url[1]!=""){
		$datosAlumnoMateria=$insAlumnoMateria->obtener_materias_controlador($url[1]);
		if($datosAlumnoMateria->rowCount()>=1){
			$materiasCursadas=$datosAlumnoMateria->fetchAll();		
		}
	}

	//Se obtiene un array con los nombres de todas las universidades (para datos del alumno)
	$listaUniv=$insUniv->datos_universidad_controlador("Lista","");
	if($listaUniv->rowCount()>=1){
		$listaUniversidad=$listaUniv->fetchAll();
	}

	//Se obtiene un array con los nombres de todas las carreras (para datos del alumno)
	$listaC=$insCarrera->datos_carrera_controlador("Lista","");
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}

	//Se obtiene un array con los nombres de todas las materias (para la lista desplegable)
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
					<option value="<?php echo $rows['CarreraCodigo'];?> <?php if($codigoCarrera==$rows['CarreraCodigo']){echo ' selected';} ?>">
						<?php echo $rows['CarreraNombre'];?>
					</option>	
				<?php } ?>	
			</select>
		</div>
	</div>
</div>

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
					
			echo $insAlumnoMateria->paginador_alumno_equivalencia_controlador($pagina,10,1,$codigoAlumno);
        ?>	
    	</div>
    </div>
</div>

		
<div style="text-indent:60px;">
	<legend>Datos del estudiante</legend>				
	<div style="text-indent:70px;">
		<p>
			<b>Nombre: </b> 
				<?php
					echo $camposAlumno['AlumnoNombre'].' '.$camposAlumno['AlumnoApellido'];
				?>
		</p>
		<p>
		<b>Universidad: </b> 
				<?php foreach($listaUniversidad as $rows){
					if($rows['UniversidadCodigo']==$camposAlumno['AlumnoUniversidad'])	
					echo $rows['UniversidadNombre'];					
				} ?>			
		</p>
		<p>
			<b>Carrera: </b> 
				<?php 
					foreach($listaCarrera as $rows){
					if($rows['CarreraCodigo']==$camposAlumno['AlumnoCarrera'])	
					echo $rows['CarreraNombre'];					
				} ?>			
				
		</p>
		<p>
			<b>Semestre: </b> 
				<?php
					echo $camposAlumno['AlumnoSemestre'].'to sem';
				?>
		</p>				    	
	</div>				
</div>		

<script type="text/javascript">
  $(document).ready(function(){
    $('#carreraUacjSelect').select2();
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