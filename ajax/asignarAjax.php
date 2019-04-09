<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";

	$busqueda = strip_tags($_REQUEST['busqueda'], ENT_QUOTES);
	
	$sWhere = "";
	if ( $_GET['busqueda'] != "" )
	{
		$sWhere.= " WHERE MateriaUacjNombre like '%$busqueda%' or MateriaUacjClave like '%$busqueda%'";			
	}
	
	$sWhere.=" order by MateriaUacjNombre asc";

	//Count the total number of row in your table*/
	$count_query = mainModel::ejecutar_consulta_simple("SELECT count(*) AS numrows FROM materiauacj $sWhere");
	$row= mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];

	//main query to fetch the data
	$sql="SELECT * FROM materiauacj $sWhere";
	$query = mysqli_query($con, $sql);
	
	//loop through fetched data
	if ($numrows>0){
		echo mysqli_error($con);
		?>
		<div class="table-responsive ">
			<table class="table table-hover" style="border-color: #337ab7;">
			<tr style="color: #fff; background-color: #337ab7; border-color: #337ab7;">
				<th>#</th>
				<th>CLAVE</th>
				<th>NOMBRE</th>
				<th>CREDITOS</th>
				<th>OBLIGATORIA</th>
			</tr>
			<?php
				$i=1;
				while ($row=mysqli_fetch_array($query)){						
			?>
				<tr>
					<td><?php echo utf8_encode($i); ?></td>
					<td><?php echo utf8_encode($row['MateriaUacjClave']);?></td>
					<td><?php echo utf8_encode($row['MateriaUacjNombre']);?></td>
					<td><?php echo utf8_encode($row['MateriaUacjCreditos']); ?></td>
					<td><?php echo utf8_encode($row['MateriaUacjObligatoria']); ?></td>
					<td><?php echo "<div class=\"input-group\">
	<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"location='usuario-editar.php?id=$id'\"><span class=\"glyphicon glyphicon-pencil\"></span>Editar</button> |   
	<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"Confirmacion($id)\"><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</button>
	</div>";?></td>					
				</tr>
				<?php
					$i++;
					}
				?>
			
			</table>
		</div>
	<?php
		}
	?>