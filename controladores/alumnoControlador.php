<?php
	
	if($peticionAjax){
		require_once "../modelos/alumnoModelo.php";
	}else{
		require_once "./modelos/alumnoModelo.php";
	}

    class alumnoControlador extends alumnoModelo{
		public function agregar_alumno_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['AlumnoNombre']);
			$apellido=mainModel::limpiar_cadena($_POST['AlumnoApellido']);
			$fechaNac=mainModel::limpiar_cadena($_POST['AlumnoFechaNac']);
			$telefono=mainModel::limpiar_cadena($_POST['AlumnoTelefono']);
			$email=mainModel::limpiar_cadena($_POST['AlumnoEmail']);
            $universidad=mainModel::limpiar_cadena($_POST['uniSelect']);
			$carrera=mainModel::limpiar_cadena($_POST['carreraSelect']);
			$semestre=mainModel::limpiar_cadena($_POST['AlumnoSemestre']);

            $consulta1=mainModel::ejecutar_consulta_simple("SELECT AlumnoCuenta FROM alumno WHERE (AlumnoNombre='$nombre' AND AlumnoApellido='$apellido' AND AlumnoFechaNac='$fechaNac')");
	
			if($consulta1->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El alumno ya existe en el sistema, favor de intentar nuevamente!",
                    "Tipo"=>"error"
                ];
			}else{
				
				$consulta=mainModel::ejecutar_consulta_simple("SELECT AlumnoCodigo FROM alumno");
				$numero=($consulta->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("AL",7,$numero);
				$dataAlumno=[
					"Codigo"=>$codigo,
					"Nombre"=>$nombre,
					"Apellido"=>$apellido,
					"FechaNac"=>$fechaNac,
					"Telefono"=>$telefono,
					"Email"=>$email,
					"Universidad"=>$universidad,
					"Carrera"=>$carrera,
					"Semestre"=>$semestre
				];

				$guardarAlumno=alumnoModelo::agregar_alumno_modelo($dataAlumno);

				if($guardarAlumno->rowCount()>=1){
					$alerta=[
						"Alerta"=>"limpiar",
						"Titulo"=>"Alumno registrado",
						"Texto"=>"El alumno se registro con exito en el sistema",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido registrar el alumno, por favor intente nuevamente",
						"Tipo"=>"error"
					];
				}
			}
            return mainModel::sweet_alert($alerta);
        }

		// Controlador para paginar universidades
		public function paginador_alumno_controlador($pagina,$registros,$privilegio,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM alumno WHERE (UniversidadNombre LIKE '%$busqueda%' OR UniversidadIniciales LIKE '%$busqueda%' OR UniversidadPais LIKE '%$busqueda%' OR UniversidadEstado LIKE '%$busqueda%' OR UniversidadCiudad LIKE '%$busqueda%' OR UniversidadTipo LIKE '%$busqueda%') ORDER BY UniversidadNombre ASC LIMIT $inicio,$registros";
				$paginaurl="univSearch";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM alumno ORDER BY UniversidadNombre ASC LIMIT $inicio,$registros";
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
							<th class="text-center">CAMPUS</th>
							<th class="text-center">VER CARRERAS</th>';
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
							<td>'.$rows['UniversidadCiudad'].'</td>
							<td>
								<form action="'.SERVERURL.'ajax/universidadAjax.php" method="POST">
									<input type="hidden" name="uniSelect" value="'.mainModel::encryption($rows['UniversidadCodigo']).'">									
									<button type="submit" class="btn btn-success btn-raised btn-xs">
										<i class="zmdi zmdi-bookmark"></i>
									</button>
								</form>
							</td>';
								/*<a href="'.SERVERURL.'carrera/'.mainModel::encryption($rows['UniversidadCodigo']).'/" class="btn btn-success btn-raised btn-xs">
									<i class="zmdi zmdi-bookmark"></i>
								  </a>*/
							if($privilegio<=2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'univ/'.mainModel::encryption($rows['UniversidadCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>
									';
							}
							if($privilegio==1){
								$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/universidadAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['UniversidadCodigo']).'">
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

		public function eliminar_alumno_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if($adminPrivilegio==1){
				
				$DelUniv=alumnoModelo::eliminar_alumno_modelo($codigo);
				
				if($DelUniv->rowCount()>=1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Alumno eliminado",
						"Texto"=>"El alumnos fue eliminado del sistema con éxito",
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

		public function datos_alumno_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return alumnoModelo::datos_alumno_modelo($tipo,$codigo);
		}

		public function actualizar_alumno_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['nombreUniversidad-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
			$iniciales=mainModel::limpiar_cadena($_POST['iniciales-reg']);
			$pais=mainModel::limpiar_cadena($_POST['pais-reg']);
			$estado=mainModel::limpiar_cadena($_POST['estado-reg']);
			$ciudad=mainModel::limpiar_cadena($_POST['ciudad-reg']);
			$tipoUniversidad=mainModel::limpiar_cadena($_POST['optionsPublica']);
			$codigo=mainModel::decryption($_POST['codigoUniversidad-up']);
			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM alumno WHERE UniversidadCodigo='$codigo'");
			$DatosUniv=$query1->fetch();

			if($nombre!=$DatosUniv['UniversidadNombre'] || $iniciales!=$DatosUniv['UniversidadIniciales'] || $ciudad!=$DatosUniv['UniversidadCiudad']){
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT UniversidadNombre FROM alumno WHERE UniversidadNombre='$nombre'");
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT UniversidadIniciales FROM alumno WHERE UniversidadIniciales='$iniciales'");
				$consulta3=mainModel::ejecutar_consulta_simple("SELECT UniversidadCiudad FROM alumno WHERE UniversidadCiudad='$ciudad'");
		
				if(($consulta1->rowCount()>=1) && ($consulta2->rowCount()>=1) && ($consulta3->rowCount()>=1)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Los datos del alumno que acaba de ingresar ya se encuentran registrados en el sistema",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$dataAd=[
				"Codigo"=>$codigo,
				"Nombre"=>$nombre,
				"Telefono"=>$telefono,
				"Direccion"=>$direccion,
				"Iniciales"=>$iniciales,
				"Tipo"=>$tipoUniversidad,
				"Pais"=>$pais,
				"Estado"=>$estado,
				"Ciudad"=>$ciudad
			];

			if(alumnoModelo::actualizar_alumno_modelo($dataAd)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados!",
					"Texto"=>"Los datos del alumno han sido actualizados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del alumno, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

	}