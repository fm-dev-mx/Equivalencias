<!-----------INDEX---------------------------------------->

<?php 
  session_start();

  unset($_SESSION['consulta']);

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Tabla dinamica</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	<script src="librerias/jquery-3.2.1.min.js"></script>
  <script src="js/funciones.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
	<script src="librerias/alertifyjs/alertify.js"></script>
  <script src="librerias/select2/js/select2.js"></script>
</head>
<body>

	<div class="container">
        <div id="buscador"></div>
		<div id="tabla"></div>
	</div>

	<!-- Modal para registros nuevos -->


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nueva persona</h4>
      </div>
      <div class="modal-body">
        	<label>Nombre</label>
        	<input type="text" name="" id="nombre" class="form-control input-sm">
        	<label>Apellido</label>
        	<input type="text" name="" id="apellido" class="form-control input-sm">
        	<label>Email</label>
        	<input type="text" name="" id="email" class="form-control input-sm">
        	<label>telefono</label>
        	<input type="text" name="" id="telefono" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<!-- Modal para edicion de datos -->

<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
      </div>
      <div class="modal-body">
      		<input type="text" hidden="" id="idpersona" name="">
        	<label>Nombre</label>
        	<input type="text" name="" id="nombreu" class="form-control input-sm">
        	<label>Apellido</label>
        	<input type="text" name="" id="apellidou" class="form-control input-sm">
        	<label>Email</label>
        	<input type="text" name="" id="emailu" class="form-control input-sm">
        	<label>telefono</label>
        	<input type="text" name="" id="telefonou" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').load('componentes/tabla.php');
    $('#buscador').load('componentes/buscador.php');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(function(){
          nombre=$('#nombre').val();
          apellido=$('#apellido').val();
          email=$('#email').val();
          telefono=$('#telefono').val();
            agregardatos(nombre,apellido,email,telefono);
        });



        $('#actualizadatos').click(function(){
          actualizaDatos();
        });

    });
</script>



<!------------------------TABLA--------------------------------------------->


<?php 
	session_start();
	require_once "../php/conexion.php";
	$conexion=conexion();

 ?>
<div class="row">
	<div class="col-sm-12">
	<h2>Tabla dinamica facultad autodidacta</h2>
		<table class="table table-hover table-condensed table-bordered">
		<caption>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
				Agregar nuevo 
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</caption>
			<tr>
				<td>Nombre</td>
				<td>Apellido</td>
				<td>Email</td>
				<td>Telefono</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>

			<?php 

				if(isset($_SESSION['consulta'])){
					if($_SESSION['consulta'] > 0){
						$idp=$_SESSION['consulta'];
						$sql="SELECT id,nombre,apellido,email,telefono 
						from t_persona where id='$idp'";
					}else{
						$sql="SELECT id,nombre,apellido,email,telefono 
						from t_persona";
					}
				}else{
					$sql="SELECT id,nombre,apellido,email,telefono 
						from t_persona";
				}

				$result=mysqli_query($conexion,$sql);
				foreach($result as $rows){
				

					$datos=$rows['id']."||".
						   $rows['nombre']."||".
						   $rows['apellido']."||".
						   $rows['email']."||".
						   $rows['telefono'];
			 ?>

			<tr>
				<td><?php echo $rows['nombre'] ?></td>
				<td><?php echo $rows['apellido'] ?></td>
				<td><?php echo $rows['email'] ?></td>
				<td><?php echo $rows['telefono'] ?></td>
				<td>
					<button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion" onclick="agregaform('<?php echo $datos ?>')">
						
					</button>
				</td>
				<td>
					<button class="btn btn-danger glyphicon glyphicon-remove" 
					onclick="preguntarSiNo('<?php echo $rows['id'] ?>')">
						
					</button>
				</td>
			</tr>
			<?php 
		}
			 ?>
		</table>
	</div>
</div>



<!---------------------------------js------------------------------------------------>



function agregardatos(nombre,apellido,email,telefono){

cadena="nombre=" + nombre + 
        "&apellido=" + apellido +
        "&email=" + email +
        "&telefono=" + telefono;

$.ajax({
    type:"POST",
    url:"php/agregarDatos.php",
    data:cadena,
    success:function(r){
        if(r==1){
            $('#tabla').load('componentes/tabla.php');
             $('#buscador').load('componentes/buscador.php');
            alertify.success("agregado con exito :)");
        }else{
            alertify.error("Fallo el servidor :(");
        }
    }
});

}

function agregaform(datos){

d=datos.split('||');

$('#idpersona').val(d[0]);
$('#nombreu').val(d[1]);
$('#apellidou').val(d[2]);
$('#emailu').val(d[3]);
$('#telefonou').val(d[4]);

}

function actualizaDatos(){


id=$('#idpersona').val();
nombre=$('#nombreu').val();
apellido=$('#apellidou').val();
email=$('#emailu').val();
telefono=$('#telefonou').val();

cadena= "id=" + id +
        "&nombre=" + nombre + 
        "&apellido=" + apellido +
        "&email=" + email +
        "&telefono=" + telefono;

$.ajax({
    type:"POST",
    url:"php/actualizaDatos.php",
    data:cadena,
    success:function(r){
        
        if(r==1){
            $('#tabla').load('componentes/tabla.php');
            alertify.success("Actualizado con exito :)");
        }else{
            alertify.error("Fallo el servidor :(");
        }
    }
});

}

function preguntarSiNo(id){
alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este registro?', 
                function(){ eliminarDatos(id) }
            , function(){ alertify.error('Se cancelo')});
}

function eliminarDatos(id){

cadena="id=" + id;

    $.ajax({
        type:"POST",
        url:"php/eliminarDatos.php",
        data:cadena,
        success:function(r){
            if(r==1){
                $('#tabla').load('componentes/tabla.php');
                alertify.success("Eliminado con exito!");
            }else{
                alertify.error("Fallo el servidor :(");
            }
        }
    });
}

<!------------------------------- ACTUALIZAR DATOS ------------------------------------------------->


<?php 
	require_once "conexion.php";
	$conexion=conexion();
	$id=$_POST['id'];
	$n=$_POST['nombre'];
	$a=$_POST['apellido'];
	$e=$_POST['email'];
	$t=$_POST['telefono'];

	$sql="UPDATE t_persona set nombre='$n',
								apellido='$a',
								email='$e',
								telefono='$t'
				where id='$id'";
	echo $result=mysqli_query($conexion,$sql);

 ?>