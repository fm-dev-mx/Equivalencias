<?php
	if($peticionAjax){
		require_once "../modelos/carreraModelo.php";
	}else{
		require_once "./modelos/carreraModelo.php";
	}

    class carreraControlador extends carreraModelo{
		public function agregar_carrera_controlador(){
            $nombre=mainModel::limpiar_cadena($_POST['nombre']);
            $codigoUniversidad=mainModel::limpiar_cadena($_POST['codigoUniversidad']);

            $consulta1=mainModel::ejecutar_consulta_simple("SELECT id FROM universidad WHERE CarreraNombre='$nombre' AND CarreraCodigoUniversidad='$codigoUniversidad'");
	
			if($consulta1->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"La carrera ya existe en el sistema, favor de intentar nuevamente!",
                    "Tipo"=>"error"
                ];
			}else{
				
				$consulta=mainModel::ejecutar_consulta_simple("SELECT id FROM carrera");
				$numero=($consulta->rowCount())+1;
				$codigoCarrera=mainModel::generar_codigo_aleatorio("CR",7,$numero);
				$dataAc=[
					"Nombre"=>$nombre,
                    "Codigo"=>$codigoCarrera,
                    "CodigoUniversidad"=>$codigoUniversidad,
				];

				$guardarCarrera=carreraModelo::agregar_carrera_modelo($dataAc);

				if($guardarCarrera->rowCount()>=1){
					$alerta=[
						"Alerta"=>"limpiar",
						"Titulo"=>"Instituto registrado",
						"Texto"=>"La carrera se registro con exito en el sistema",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido registrar la carrera, por favor intente nuevamente",
						"Tipo"=>"error"
					];
				}
			}
            return mainModel::sweet_alert($alerta);
        }

		// Controlador para paginar universidades
		public function paginador_carrera_controlador($pagina,$registros,$privilegio,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM carrera WHERE (CarreraNombre LIKE '%$busqueda%') ORDER BY CarreraNombre ASC LIMIT $inicio,$registros";
				$paginaurl="carrera";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM carrera ORDER BY UniversidadNombre ASC LIMIT $inicio,$registros";
				$paginaurl="carrera";
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
							<th class="text-center">NOMBRE</th>';
						if($privilegio<=2){
							$tabla.='
								<th class="text-center">RENOMBRAR</th>
								<th class="text-center">VER MATERIAS</th>
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
							<td>'.$rows['CarreraNombre'].'</td>';
							if($privilegio<=2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'carrera/'.mainModel::encryption($rows['CarreraCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>
									<td>
										<a href="'.SERVERURL.'univCarreras/'.mainModel::encryption($rows['CarreraCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-bookmark"></i>
										</a>
									</td>
								';
							}
							if($privilegio==1){
								$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/universidadAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CarreraCodigo']).'">
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

		public function eliminar_carrera_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if($adminPrivilegio==1){
				
				$DelCarrera=universidadModelo::eliminar_carrera_modelo($codigo);
				
				if($DelCarrera->rowCount()>=1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Carrera eliminada",
						"Texto"=>"La carrera fue eliminado del sistema con éxito",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No podemos eliminar esta carrera, favor de intentar nuevamente!!",
						"Tipo"=>"error"
					];
				}
				return mainModel::sweet_alert($alerta);
			}
		}

		public function datos_carrera_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return carreraModelo::datos_carrera_modelo($tipo,$codigo);
		}

		public function actualizar_carrera_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['nombre']);
            $codigo=mainModel::decryption($_POST['codigo']);
			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM carrera WHERE CarreraCodigo='$codigo'");
			$DatosCarrera=$query1->fetch();

			if($nombre!=$DatosCarrera['CarreraNombre']){
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT CarreraNombre FROM carrera WHERE CarreraNombre='$nombre'");
		
				if(($consulta1->rowCount()>=1)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre de la carrera que acaba de ingresar ya se encuentran registrado en el sistema",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$dataAd=[
				"Codigo"=>$codigo,
				"Nombre"=>$nombre,
				"CodigoUniversidad"=>$codigoUniversidad
			];

			if(universidadModelo::actualizar_universidad_modelo($dataAd)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados!",
					"Texto"=>"Los datos del instituto han sido actualizados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del instituto, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

	}