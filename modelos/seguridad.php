<?php

class Seguridad{

	public $conexion;

	public function __construct(){

       $this->conexion = conexionBD();      

	}

	public function cerrarConexion(){

		$this->conexion->close();

	}

	

	public function logueo($usuario,$pass){

		$resultados = array();

		$consulta = "SELECT usuarioid,nombre,apaterno,administrador FROM cat_usuarios WHERE clave=? and pass=md5(?) and estatusid=1";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param("ss", $usuario, $pass);

			$stmt->execute();

			$stmt->bind_result($usuarioid,$nombre,$paterno,$administrador);

			while($stmt->fetch()) {

				array_push($resultados,array('usuarioid' => $usuarioid,

											 'nombre' => $nombre,

											 'paterno' => $paterno,

											 'administrador' => $administrador));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function consultarTicketUsuario($usuarioidConsulta,$filtroEstatusid){

		$Generica = new Generica();

		$resultados = array();		

		$consulta = "call consultarTicketsUsuario4(?);";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioidConsulta);

			$stmt->execute();

			$stmt->bind_result($soporteid,$cc,$usuarioid,$consecutivo,$fecha,$responsable,$aplicativo,$descripcion,

				$estatus,$estatusid,$numComentarios,$archivo,$calificacion,$asunto,

				$nombre,$paterno,$materno,$invitado);

			while($stmt->fetch()){

				if($filtroEstatusid == 5){

					if($estatusid == 3 && $calificacion=='')

						array_push($resultados,array('soporteid' => $soporteid,

												 'cc' => $cc,

												 'folio' => $Generica->formatoFolio($usuarioid,$consecutivo),

												 'fecha' => $fecha,

												 'responsable' => $responsable,

												 'aplicativo' => $aplicativo,

												 'descripcion' => $descripcion,

												 'estatus' => $estatus,

												 'estatusid' => $estatusid,

												 'numComentarios' => $numComentarios,

												 'archivo' => $archivo,

												 'calificacion' => $calificacion,

												 'asunto' => $asunto,

												 'nombre' => $nombre,

												 'paterno' => $paterno,

												 'materno' => $materno,

												 'invitado' => $invitado));

				}

				elseif($filtroEstatusid == 0 || $filtroEstatusid == $estatusid)

					array_push($resultados,array('soporteid' => $soporteid,

												 'cc' => $cc,

												 'folio' => $Generica->formatoFolio($usuarioid,$consecutivo),

												 'fecha' => $fecha,

												 'responsable' => $responsable,

												 'aplicativo' => $aplicativo,

												 'descripcion' => $descripcion,

												 'estatus' => $estatus,

												 'estatusid' => $estatusid,

												 'numComentarios' => $numComentarios,

												 'archivo' => $archivo,

												 'calificacion' => $calificacion,

												 'asunto' => $asunto,

												 'nombre' => $nombre,

												 'paterno' => $paterno,

												 'materno' => $materno,

												 'invitado' => $invitado));

			}

			$stmt->close();

		}					

		return $resultados;

	}

	

	public function consultarTicketPorNumero($noTicket){

		$resultados = array();

		$consulta = "SELECT s.fecha,s.con_copia,s.consecutivo,s.descripcion,s.aplicativoid,a.descripcion,s.usuarioid,s.estatusid,

					 	e.descripcion as estatus,u.nombre,IFNULL(u.apaterno,''),IFNULL(u.amaterno,''),u.email,IFNULL(s.archivo,''),

					 	s.asunto,s.tiposoporteid,ts.descripcion,IFNULL(s.calificacion,''),IFNULL(s.con_copia,'')

					 FROM soportes s

					 INNER JOIN cat_usuarios u USING(usuarioid)

					 INNER JOIN cat_estatus e ON s.estatusid=e.estatusid

					 INNER JOIN cat_aplicativos a ON s.aplicativoid=a.aplicativosid

					 INNER JOIN cat_tiposoporte ts ON s.tiposoporteid=ts.tiposoporteid

					 WHERE s.soporteid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$noTicket);

			$stmt->execute();

			$stmt->bind_result($fecha,$cc,$consecutivo,$descripcion,$aplicativoid,$aplicativo,$usuarioid,$estatusid,$estatus,$nombre,$paterno,$materno,$email,$nombreArchivo,

				$asunto,$responsableid,$responsable,$calificacion,$cc);



			$Generica = new Generica();

			while($stmt->fetch()){

				array_push($resultados,array(

					'fecha' => $fecha,

					'cc' => $cc,

					'consecutivo' => $consecutivo,

					'descripcion' => $descripcion,

					'aplicativoid' => $aplicativoid,

					'aplicativo' => $aplicativo,

					'usuarioid' => $usuarioid,

					'estatus' => $estatus,

					'estatusid' => $estatusid,

					'nombre' => $nombre,

					'paterno' => $paterno,

					'materno' => $materno,

					'email' => $email,

					'nombreArchivo' => $nombreArchivo,

					'asunto' => $asunto,

					'responsableid' => $responsable,

					'responsable' => $responsable,

					'calificacion' => $calificacion,

					'folio' => $Generica->formatoFolio($usuarioid,$consecutivo),

					'cc' =>$cc

				));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function consultarTickets($usuarioidFiltro, $filtroEstatusid){

		$Generica = new Generica();

		$resultados = array();

		$consulta = "call consultarTicketsPorUsuarioMonitor2(?);";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioidFiltro);

			$stmt->execute();

			$stmt->bind_result($soporteid,$usuarioid,$consecutivo,$asunto,$fecha,$tipoSoporte,$aplicativo,$descripcion,$nombre,$paterno,$materno,$estatus,$estatusid,$numComentarios,$archivo,$calificacion);

			while($stmt->fetch()){

				if($filtroEstatusid == 0 || $filtroEstatusid == $estatusid)

					array_push($resultados,array('soporteid' => $soporteid,

												 'usuarioid' => $usuarioid,

												 'folio' => $Generica->formatoFolio($usuarioid,$consecutivo),

												 'asunto' => $asunto,

												 'fecha' => $fecha,

												 'tipoSoporte' => $tipoSoporte,

												 'aplicativo' => $aplicativo,

												 'descripcion' => $descripcion,

												 'nombre' => $nombre,

												 'paterno' => $paterno,

												 'materno' => $materno,

												 'estatus' => $estatus,

												 'estatusid' => $estatusid,

												 'numComentarios' => $numComentarios,

												 'archivo' => $archivo,

												 'calificacion' => $calificacion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function consultarComentariosTicket($ticketid){

		$resultados = array();

		$consulta = "call consultarComentariosTicket(?);";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$ticketid);

			$stmt->execute();

			$stmt->bind_result($comentario,$fecha,$nombre,$paterno,$materno,$nombreArchivo);

			while($stmt->fetch()){

				array_push($resultados,array('comentario' => $comentario,

											 'fecha' => $fecha,

											 'nombre' => $nombre,

											 'paterno' => $paterno,

											 'materno' => $materno,

											 'nombreArchivo' => $nombreArchivo));

			}

			$stmt->close();

		}					

		return $resultados;

	}

	

	public function consultarTiposSoportes(){

		$usuarioid = $_SESSION['usuarioid']; 

		$resultado = '';
		$consulta = "SELECT departamentoid FROM cat_usuarios where  usuarioid=?";
		$stmt = $this->conexion->prepare($consulta);
		if($stmt){
			$stmt->bind_param('i',$usuarioid);
			$stmt->execute();
			$stmt->bind_result($departamentoid);
			while($stmt->fetch()){
				$resultado = $departamentoid;
			}
			$stmt->close();
		}	

		$resultados = array();
		if($resultado == 25)
		{
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte where tiposoporteid=12"; //12
		} else if($resultado == 24)
		{
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte where tiposoporteid=3";//3
		} else {
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte ORDER BY tiposoporteid";//general
		}

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){
			$stmt->execute();
			$stmt->bind_result($tipoSoporteId,$descripcion);
			while($stmt->fetch()){
				array_push($resultados,array('tipoSoporteId' => $tipoSoporteId,
											 'descripcion' => $descripcion));
			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarTiposSoportes2($valor){
		if($valor == 25)
		{
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte ORDER BY tiposoporteid where tiposoporteid=12"; //12
		} else if($valor == 24)
		{
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte ORDER BY tiposoporteid where tiposoporteid=3";//3
		} else {
			$consulta = "SELECT tiposoporteid,descripcion FROM cat_tiposoporte ORDER BY tiposoporteid";//general
		}

		$resultados = array();

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($tipoSoporteId,$descripcion);

			while($stmt->fetch()){

				array_push($resultados,array('tipoSoporteId' => $tipoSoporteId,

											 'descripcion' => $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function consultaTiposTickets(){

		$resultados = array();

		$consulta = "SELECT tiporeporteid,descripcion FROM cat_tiporeporte ORDER BY tiporeporteid";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($tipoTicketId,$descripcion);

			while($stmt->fetch()){

				array_push($resultados,array('tipoTicketId' => $tipoTicketId,

											 'descripcion' => $descripcion));

			}

			$stmt->close();

		}					

		return $resultados;

	}

	

	public function consultarTipoAplicativo($tipoSoporteid){

		$resultados = array();

		$consulta = "SELECT aplicativosid,descripcion FROM cat_aplicativos WHERE tiposoporteid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$tipoSoporteid);

			$stmt->execute();

			$stmt->bind_result($aplicativoid,$descripcion);

			while($stmt->fetch()){

				array_push($resultados,array('aplicativoid' => $aplicativoid,

											 'descripcion' => $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function guardarTicket($tipoTicket,$tipoSoporte,$tipoAplicativo,$detieneOperacion,$descripcion,$usuarioid,$nombreArchivo,$asunto,$listInvitados,$cc){

		$id = 0;

		$consulta = 'SELECT insertarTicket(?,?,?,?,?,?,?,?,?)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('iiiisisss',$tipoTicket,$tipoSoporte,$tipoAplicativo,$detieneOperacion,$descripcion,$usuarioid,$nombreArchivo,$asunto,$cc);

			$stmt->execute();

//			$id = $stmt->insert_id;

			$stmt->bind_result($idInsertado);

			while($stmt->fetch()){

				$id = $idInsertado;

			}

			$stmt->close();

		}



		if($id > 0){

			for($i=0; $i<count($listInvitados); $i++){

				error_log('invitado:'+$listInvitados[$i]);

				$consulta = "INSERT INTO soportes_invitados (soporteid,usuarioid,fecha_alta,estatus) VALUES ($id,$listInvitados[$i],CURDATE(),0)";

				$stmt = $this->conexion->prepare($consulta);

				if($stmt)

					$stmt->execute();

			}

		}

		return $id;

	}

	

	public function guardarComentario($ticketid,$comentario,$usuarioid,$nombreArchivo){

		$resultado = 0;

		$consulta = 'INSERT INTO comentarios_soporte

					 (descripcion,fecha,soporteid,usuarioid,archivo)

					 VALUES (?,NOW(),?,?,?)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('siis',$comentario,$ticketid,$usuarioid,$nombreArchivo);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	

	public function consultarEstatus(){

		$resultados = array();

		$consulta = "SELECT estatusid,descripcion FROM cat_estatus ORDER BY estatusid";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($estatusid,$descripcion);

			while($stmt->fetch()){

				array_push($resultados,array('estatusid' => $estatusid,

											 'descripcion' => $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function consultarUsuariosAplicativo($aplicativoid){

		$resultados = array();

		$consulta = "

			SELECT au.usuarioid,u.clave,u.nombre,IFNULL(u.apaterno,''),IFNULL(u.amaterno,'')

			FROM aplicativos_usuarios au

			INNER JOIN cat_usuarios u USING(usuarioid)

			WHERE au.aplicativoid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$aplicativoid);

			$stmt->execute();

			$stmt->bind_result($usuarioid,$usuario,$nombre,$paterno,$materno);

			while($stmt->fetch()){

				array_push($resultados,array(

					'usuarioid' => $usuarioid,

					'usuario'	=> $usuario,

					'nombre'	=> $nombre,

					'paterno'	=> $paterno,

					'materno'	=> $materno));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarUsuariosAplicativo2(){

		$resultados = array();

		$consulta = "SELECT u.usuarioid, a.descripcion, u.email FROM ((aplicativos_usuarios au INNER JOIN cat_aplicativos a ON au.aplicativoid = a.aplicativosid ) INNER JOIN cat_usuarios u ON au.usuarioid = u.usuarioid)"; 

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($usuarioid,$proyecto,$email);

			while($stmt->fetch()){

				array_push($resultados,array(

					'usuarioid'	=> $usuarioid,

					'proyecto'	=> $proyecto,

				    'email' => $email));

			}

			$stmt->close();

		}

		return $resultados;

	}



	public function invitadosTicket($soporteid){

		$resultados = array();

		$consulta = "SELECT si.usuarioid,u.clave,u.nombre,IFNULL(u.apaterno,''),IFNULL(u.amaterno,''),si.estatus

					 FROM soportes_invitados si

					 INNER JOIN cat_usuarios u USING(usuarioid)

					 WHERE si.soporteid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$soporteid);

			$stmt->execute();

			$stmt->bind_result($usuarioid,$usuario,$nombre,$paterno,$materno,$estatus);

			while($stmt->fetch()){

				array_push($resultados,array('usuarioid' => $usuarioid,

											 'usuario' => $usuario,

											 'nombre' => $nombre,

											 'paterno' => $paterno,

											 'materno' => $materno,

											 'estatus' => $estatus));

			}

			$stmt->close();

		}

		return $resultados;

	}

	

	public function cambiarEstatusTicket($ticketid,$estatusid,$usuarioid){

		$resultado = 0;

		$consulta = 'UPDATE soportes SET estatusid=?,usuarioid_estatus=? WHERE soporteid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			error_log($estatusid.'-'.$ticketid.'-'.$usuarioid);

			$stmt->bind_param('iii',$estatusid,$usuarioid,$ticketid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	

	public function consultarCorreo($usuarioid){

		$resultado = '';

		$consulta = "SELECT email FROM cat_usuarios WHERE usuarioid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioid);

			$stmt->execute();

			$stmt->bind_result($email);

			while($stmt->fetch()){

				$resultado = $email;

			}

			$stmt->close();

		}					

		return $resultado;

	}

	

	public function consultarCorreoTicket($ticketid){

		$resultado = '';

		$consulta = "SELECT u.email

					 FROM soportes s 

					 INNER JOIN cat_usuarios u USING (usuarioid)

					 WHERE s.soporteid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$ticketid);

			$stmt->execute();

			$stmt->bind_result($email);

			while($stmt->fetch()){

				$resultado = $email;

			}

			$stmt->close();

		}

		return $resultado;

	}

	

	public function consultarNuevosTickets($ticketid, $usuarioid){

		$resultado = 0;

		$consulta = "SELECT contarNuevosTicketUsuario(?,?)";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('ii',$ticketid,$usuarioid);

			$stmt->execute();

			$stmt->bind_result($countTikets);

			while($stmt->fetch()){

				$resultado = $countTikets;

				//error_log('counTickets2: '.$resultado);

			}

			$stmt->close();

		}					

		return $resultado;

	}

	

	public function guardarCalificacion($ticketid, $calificacion){

		$resultado = 0;

		$consulta = 'UPDATE soportes SET calificacion=? WHERE soporteid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('ii',$calificacion,$ticketid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function consultarUsuarios(){

		$resultados = array();

        $consulta = "SELECT u.usuarioid,u.clave,u.nombre,IFNULL(u.apaterno,''),IFNULL(u.amaterno,''),d.descripcion,e.descripcion,u.email

					 FROM cat_usuarios u

					 LEFT JOIN cat_departamentos d ON u.departamentoid=d.departamentoid

					 LEFT JOIN cat_estatus e ON u.estatusid=e.estatusid";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($usuarioid,$usuario,$nombre,$paterno,$materno,$departamento,$estatus,$email);

			while($stmt->fetch()){
				array_push($resultados,array(

					'usuarioid' => $usuarioid,

					'usuario'	=> $usuario,

					'nombre'	=> $nombre,

					'paterno'	=> $paterno,

					'materno'	=> $materno,

					'departamento' => $departamento,

					'estatus'	=> $estatus,

					'email'		=> $email));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarAplicativos(){

		$resultados = array();

        $consulta = "SELECT a.aplicativosid,a.descripcion,t.descripcion

					 FROM cat_aplicativos a

					 LEFT JOIN cat_tiposoporte t ON a.tiposoporteid=t.tiposoporteid";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($aplicativosid,$descripcion1,$descripcion2);

			while($stmt->fetch()){
				array_push($resultados,array(

					'aplicativosid' => $aplicativosid,

					'aplicativo' => $descripcion1,

					'tiposoporte'	=> $descripcion2));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarDepartamentos(){

		$resultados = array();

        $consulta = "SELECT d.departamentoid, d.descripcion

					 FROM cat_departamentos d";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($departamentoid, $descripcion);

			while($stmt->fetch()){
				array_push($resultados,array(
					'departamentoid'	=> $departamentoid,

					'descripcion'	=> $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarTipoSoporte(){

		$resultados = array();

        $consulta = "SELECT t.tiposoporteid, t.descripcion

					 FROM cat_tiposoporte t";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($tiposoporteid, $descripcion);

			while($stmt->fetch()){
				array_push($resultados,array(
					'tiposoporteid'	=> $tiposoporteid,

					'descripcion'	=> $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function guardarUsuario($nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$pass,$administrador){

		$resultado = 0;

		$consulta = 'INSERT INTO cat_usuarios

					 (nombre,apaterno,amaterno,departamentoid,puesto,email,estatusid,clave,pass,administrador)

					 VALUES (?,?,?,?,?,?,?,?,md5(?),0)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('sssississ',$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$pass);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	public function guardarAplicativosUsuario($nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$pass,$administrador,$tipoAplicativo){

		$resultado = 0;

		$usuarioid = 0;

		$consulta = 'INSERT INTO cat_usuarios

					 (nombre,apaterno,amaterno,departamentoid,puesto,email,estatusid,clave,pass,administrador)

					 VALUES (?,?,?,?,?,?,?,?,md5(?),1)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('sssississ',$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$pass);

			$stmt->execute();

			$usuarioid = $stmt->insert_id;

			$stmt->close();

		}

		if($usuarioid > 0){

			$consulta = 'INSERT INTO aplicativos_usuarios 

			             (aplicativoid,usuarioid) 

			             VALUES (?,?)';

			$stmt = $this->conexion->prepare($consulta);

			if($stmt){

                $stmt->bind_param('ii',$tipoAplicativo,$usuarioid);
                 
				$stmt->execute();

				$resultado = $stmt->affected_rows;

				$stmt->close();

			}	

		}					

		return $resultado;

	}

	public function guardarArea($descripcion){

		$resultado = 0;

		$consulta = 'INSERT INTO cat_departamentos

					 (descripcion)

					 VALUES (?)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('s',$descripcion);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	public function guardarAplicacion($descripcion,$tiposoporteid){

		$resultado = 0;

		$consulta = 'INSERT INTO cat_aplicativos

					 (descripcion,tiposoporteid)

					 VALUES (?,?)';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('si',$descripcion,$tiposoporteid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	public function consultarIdDepartamento($departamentoid){

		$resultado = '';

		$consulta = "SELECT descripcion FROM cat_departamentos WHERE departamentoid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$departamentoid);

			$stmt->execute();

			$stmt->bind_result($descripcion);

			while($stmt->fetch()){

				$resultado = $descripcion;

			}

			$stmt->close();

		}					

		return $resultado;

	}

	public function guardarModificacionDep($departamentoid, $descripcion){

		$resultado = 0;

		$consulta = 'UPDATE cat_departamentos SET descripcion=? WHERE departamentoid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('si',$descripcion,$departamentoid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function guardarModificacionCorreo($usuarioid, $email){

		$resultado = 0;

		$consulta = 'UPDATE cat_usuarios SET email=? WHERE usuarioid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('si',$email,$usuarioid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function consultarApps(){

		$resultados = array();

        $consulta = "SELECT d.aplicativosid, d.descripcion

					 FROM cat_aplicativos d";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->execute();

			$stmt->bind_result($aplicativoid, $descripcion);

			while($stmt->fetch()){
				array_push($resultados,array(
					'aplicativoid'	=> $aplicativoid,

					'descripcion'	=> $descripcion));

			}

			$stmt->close();

		}

		return $resultados;

	}

	public function consultarIdAplicativos($aplicativosid){

		$resultados = array();

		$consulta = "SELECT descripcion,tiposoporteid FROM cat_aplicativos WHERE aplicativosid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$aplicativosid);

			$stmt->execute();

			$stmt->bind_result($descripcion,$tiposoporteid);

			while($stmt->fetch()){
				array_push($resultados,array(
					'descripcion'	=> $descripcion,

					'tiposoporteid'	=> $tiposoporteid));
			}

			$stmt->close();

		}					

		return $resultados;

	}

	public function guardarModificacionApp($aplicativosid, $descripcion, $tiposoporteid){

		$resultado = 0;

		$consulta = 'UPDATE cat_aplicativos SET descripcion=?, tiposoporteid=? WHERE aplicativosid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('sii',$descripcion,$tiposoporteid,$aplicativosid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function eliminarDep($departamentoid){

		$resultado = 0;

		$consulta = 'DELETE FROM cat_departamentos WHERE departamentoid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$departamentoid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function eliminarApp($aplicativosid){

		$resultado = 0;

		$consulta = 'DELETE FROM cat_aplicativos WHERE aplicativosid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$aplicativosid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		return $resultado;

	}

	public function consultarIdUsuario($usuarioid){

		$resultados = array();

		$consulta = "SELECT nombre, apaterno,amaterno, departamentoid, puesto, email, estatusid, clave, pass, administrador FROM cat_usuarios WHERE usuarioid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioid);

			$stmt->execute();

			$stmt->bind_result($nombre, $apaterno,$amaterno, $departamentoid, $puesto, $email, $estatusid, $clave, $pass, $administrador);

			while($stmt->fetch()){
				array_push($resultados,array(
					'nombre'	=> $nombre,

					'apaterno'	=> $apaterno,

					'amaterno'	=> $amaterno,

					'departamentoid'	=> $departamentoid,

					'puesto'	=> $puesto,

					'estatusid'	=> $estatusid,

					'emails'	=> $email,

					'clave'	=> $clave,

					'pass'	=> $pass,

					'administrador'	=> $administrador));
			}

			$stmt->close();

		}					

		return $resultados;

	}

	public function guardarModificacionUser($usuarioid,$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave){

		$resultado = 0;

		$consulta = 'UPDATE cat_usuarios SET nombre=?, apaterno=?, amaterno=?, departamentoid=?, puesto=?, email=?, estatusid=?, clave=?, administrador=0 WHERE usuarioid=?'; 

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('sssissisi',$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$usuarioid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}					

		return $resultado;

	}

	public function guardarModificacionAplicativosUser($usuarioid,$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$aplicativoid){

		$resultado = 0;

		$consulta = 'UPDATE cat_usuarios SET nombre=?, apaterno=?, amaterno=?, departamentoid=?, puesto=?, email=?, estatusid=?, clave=?, administrador=1 WHERE usuarioid=?'; 

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('sssissisi',$nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$usuarioid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

			$stmt->close();

		}

		if($resultado == 0 || $resultado == 1){

			$consulta = 'UPDATE aplicativos_usuarios SET aplicativoid=? WHERE usuarioid=?';
            
            $stmt = $this->conexion->prepare($consulta);

            if($stmt){

            	$stmt->bind_param('ii',$aplicativoid,$usuarioid);

                $stmt->execute();

                $resultado = $stmt->affected_rows;

                $stmt->close();
            }
		}					

		return $resultado;

	}

	public function consultarAplicativosIdUsuario($usuarioid){

        $resultado = '';

		$consulta = "SELECT aplicativoid FROM aplicativos_usuarios WHERE usuarioid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioid);

			$stmt->execute();

			$stmt->bind_result($aplicativoid);

			while($stmt->fetch()){

				$resultado = $aplicativoid;

			}

			$stmt->close();

		}					

		return $resultado;

	}

	public function consultarAplicativosIdUsuario2($usuarioid){

        $resultado = array();

        $consulta = "SELECT ts.tiposoporteid, ts.descripcion

					 FROM cat_usuarios u

					 INNER JOIN aplicativos_usuarios au ON u.usuarioid=au.usuarioid

					 INNER JOIN cat_aplicativos a ON au.aplicativoid=a.aplicativosid

					 INNER JOIN cat_tiposoporte ts ON a.tiposoporteid=ts.tiposoporteid

					 WHERE u.usuarioid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$usuarioid);

			$stmt->execute();

			$stmt->bind_result($tipoSoporteId,$descripcion);

			while($stmt->fetch()){

				array_push($resultado,array('tipoSoporteId' => $tipoSoporteId,

											 'descripcion' => $descripcion));

			}

			$stmt->close();

		}					

		return $resultado;

	}

}