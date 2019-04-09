<?php
	require_once ("../core/db.php");
	require_once ("../core/conexion.php");
?>

<?php
	$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
	
	$sWhere = "";
	$sWhere.="WHERE id<=1000";
	if ( $_GET['q'] != "" )
	{
		$sWhere.= " and nombres like '%$q%' or cargo like '%$q%' or apellidos like '%$q%'";			
	}
	
	$sWhere.=" order by nombres asc";

	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM usuarios $sWhere");
	$row= mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];

	//main query to fetch the data
	$sql="SELECT * FROM  usuarios $sWhere";
	$query = mysqli_query($con, $sql);
	
	//loop through fetched data
	if ($numrows>0){
		echo mysqli_error($con);
		?>
		<div class="table-responsive ">
			<table class="table table-hover" style="border-color: #337ab7;">
			<tr style="color: #fff; background-color: #337ab7; border-color: #337ab7;">
				<th>ID</th>
				<th>NMBRES</th>
				<th>APELLIDOS</th>
				<th>CARGO</th>
				<th>ACCIONES</th>
			</tr>
			<?php
			while ($row=mysqli_fetch_array($query)){
					$id=$row['id'];
					$nombres=$row['nombres'];
					$apellidos=$row['apellidos'];
					$cargo=$row['cargo'];
	
				?>
				<tr>
					<td><?php echo utf8_encode($id); ?></td>
					<td><?php echo utf8_encode($nombres);?></td>
					<td><?php echo utf8_encode($apellidos);?></td>
					<td><?php echo utf8_encode($cargo); ?></td>	
					<td><?php echo "<div class=\"input-group\">
	<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"location='usuario-editar.php?id=$id'\"><span class=\"glyphicon glyphicon-pencil\"></span>Editar</button> |   
	<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"Confirmacion($id)\"><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</button>
	</div>";?></td>					
				</tr>
				<?php
			}
			?>
			
			</table>
		</div>
	<?php
		}
	?>