<?php 
	session_start();
	
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