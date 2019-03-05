<?php
	if($peticionAjax){
		require_once "../modelos/universidadModelo.php";
	}else{
		require_once "./modelos/universidadModelo.php";
	}

    class universidadControlador extends universidadModelo{
		public function agregar_universidad_controlador(){
            $nombre=mainModel::limpiar_cadena($_POST['nombreUniversidad-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
			$iniciales=mainModel::limpiar_cadena($_POST['iniciales-reg']);
			$pais=mainModel::limpiar_cadena($_POST['pais-reg']);
			$estado=mainModel::limpiar_cadena($_POST['estado-reg']);
			$ciudad=mainModel::limpiar_cadena($_POST['ciudad-reg']);
	
            $consulta1=mainModel::ejecutar_consulta_simple("SELECT id FROM universidad WHERE (UniversidadIniciales='$iniciales' AND UniversidadNombre='$nombre' AND UniversidadCiudad='$ciudad')");
	
			if($consulta1->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El instituto ya existe en el sistema, favor de intentar nuevamente!",
                    "Tipo"=>"error"
                ];
			}else{
				$dataAc=[
					"Nombre"=>$nombre,
					"Telefono"=>$telefono,
					"Direccion"=>$direccion,
					"Iniciales"=>$iniciales,
					"Pais"=>$pais,
					"Estado"=>$estado,
					"Ciudad"=>$ciudad
				];

				$guardarUniversidad=universidadModelo::agregar_universidad_modelo($dataAc);

				if($guardarUniversidad->rowCount()>=1){
					$alerta=[
						"Alerta"=>"limpiar",
						"Titulo"=>"Instituto registrado",
						"Texto"=>"El instituto se registro con exito en el sistema",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido registrar el instituto, por favor intente nuevamente",
						"Tipo"=>"error"
					];
				}
			}
            return mainModel::sweet_alert($alerta);
        }

		// Controlador para paginar universidades
		public function paginador_universidad_controlador($pagina,$registros,$privilegio,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM universidad WHERE (UniversidadNombre LIKE '%$busqueda%' OR UniversidadIniciales LIKE '%$busqueda%' OR UniversidadPais LIKE '%$busqueda%' OR UniversidadEstado LIKE '%$busqueda%' OR UniversidadCiudad LIKE '%$busqueda%') ORDER BY UniversidadNombre ASC LIMIT $inicio,$registros";
				$paginaurl="univSearch";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM universidad ORDER BY UniversidadNombre ASC LIMIT $inicio,$registros";
				$paginaurl="univList";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			$total= $conexion->query("SELECT FOUND_ROWS()");
			$total= (int) $total->fetchColumn();

			$Npaginas= ceil($total/$registros);

			$tabla.='
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">NOMBRE</th>
							<th class="text-center">INICIALES</th>
							<th class="text-center">TELÉFONO</th>
							<th class="text-center">CAMPUS</th>';
						if($privilegio<=2){
							$tabla.='
								<th class="text-center">A. DATOS</th>
							';
						}
						if($privilegio==1){
							$tabla.='
								<th class="text-center">ELIMINAR</th>
							';
						}
							
			$tabla.='</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr>
							<td>'.$contador.'</td>
							<td>'.$rows['UniversidadNombre'].'</td>
							<td>'.$rows['UniversidadIniciales'].'</td>
							<td>'.$rows['UniversidadTelefono'].'</td>
							<td>'.$rows['UniversidadCiudad'].'</td>';
							if($privilegio<=2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'univ/'.mainModel::encryption($rows['id']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>
								';
							}
							if($privilegio==1){
								$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/universidadAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['id']).'">
											<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
											<button type="submit" class="btn btn-danger btn-raised btn-xs">
												<i class="zmdi zmdi-delete"></i>
											</button>
											<div class="RespuestaAjax"></div>
										</form>
									</td>
								';	
							}
					$tabla.='</tr>';
					$contador++;
				}
			}else{
				if($total>=1){
					$tabla.='
						<tr>
							<td colspan="5">
								<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
									Haga clic aca para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr>
							<td colspan="5">No hay registros en el sistema</td>
						</tr>
					';	
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<nav class="text-center"><ul class="pagination pagination-sm">';

				if($pagina==1){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}

				for($i=1; $i<=$Npaginas; $i++){
					if($pagina==$i){
						$tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}else{
						$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($pagina==$Npaginas){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}
				$tabla.='</ul></nav>';
			}

			return $tabla;
		}

		public function eliminar_universidad_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if($adminPrivilegio==1){
				
				$DelUniv=universidadModelo::eliminar_universidad_modelo($codigo);
				
				if($DelUniv->rowCount()>=1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Instituto eliminado",
						"Texto"=>"El institutos fue eliminado del sistema con éxito",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No podemos eliminar este instituto en este momento, favor de intentar nuevamente!!",
						"Tipo"=>"error"
					];
				}
				return mainModel::sweet_alert($alerta);
			}
		}

		public function datos_universidad_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return universidadModelo::datos_universidad_modelo($tipo,$codigo);
		}

	}