<?php 
	require_once "../php/conexion.php";
	$conexion=conexion();

	$sql="SELECT id,nombre,apellido,email,telefono 
						from t_persona";
				$result=mysqli_query($conexion,$sql);

 ?>
<br><br>
<div class="row">
	<div class="col-sm-8"></div>
	<div class="col-sm-4">
		<label>Buscador</label>
		<select id="buscadorvivo" class="form-control input-sm">
			<option value="0">Seleciona uno</option>
			<?php
				while($ver=mysqli_fetch_row($result)): 
			 ?>
				<option value="<?php echo $ver[0] ?>">
					<?php echo $ver[1]." ".$ver[2] ?>
				</option>

			<?php endwhile; ?>

		</select>
	</div>
</div>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#buscadorvivo').select2();

			$('#buscadorvivo').change(function(){
				$.ajax({
					type:"post",
					data:'valor=' + $('#buscadorvivo').val(),
					url:'php/crearsession.php',
					success:function(r){
						$('#tabla').load('componentes/tabla.php');
					}
				});
			});
		});
	</script>

<!----------------------------------------------------------TABLA.PHP------------------------------------------------>


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


<!---------------------------------------------funciones.js----------------------------------------------------->


<script type="text/javascript">
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
</script>