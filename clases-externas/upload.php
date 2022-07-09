<?php
class Upload {
	var $extencionesPermitidas;
	var $tamanoMaximo;
	var $carpeta;
	var $errores = array();
	var $nombreCampoFile;
	var $mensaje = '';
	
	var $nombreArchivo;
	var $tipoArchivo;
	var $tamanoArchivo;
	var $archivoTemporal;
	
	function Upload(){
// 		$this->extencionesPermitidas = array(
// 				"image/bmp",
// 				"image/gif",
// 				"image/jpeg",
// 				"image/pjpeg",
// 				"image/png",
// 				"image/x-png",
// 				"application/msword",
// 				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
// 				"application/vnd.ms-excel",
// 				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
// 				"application/pdf"
// 			); //extensiones permitidas
		$this->extencionesPermitidas = array(
				"bmp","gif","jpeg","pjpeg","png","jpg","x-png",
				"xls","xlsx","xlsm","xltx",
				"xml",
				"doc","docx","txt",
				"rar","zip",
				"ppt","pptx",
				"pdf"
		); //extensiones permitidas
		$this->tamanoMaximo = 2097152; //tamano maximo en bytes
		$this->carpeta = "../archivos-usuarios/"; //carpeta de las imagenes
	}
	function subirArchivo(){
		$caracteresExtranos = array(":","*","/","!","°");
		$this->nombreArchivo = str_replace($caracteresExtranos, '', trim($_FILES[$this->nombreCampoFile]['name']));
// 		$this->tipoArchivo = $_FILES[$this->nombreCampoFile]['type'];
		$this->tipoArchivo = explode(".", $this->nombreArchivo);
		$this->tipoArchivo = end($this->tipoArchivo);
		$this->tamanoArchivo = $_FILES[$this->nombreCampoFile]['size'];
		$this->archivoTemporal = $_FILES[$this->nombreCampoFile]['tmp_name'];

		$this->nombreArchivo = rand().$this->nombreArchivo;
		$urlArchivo = $this->carpeta.$this->nombreArchivo;
		
// 		echo '<br>tipo:'.$this->tipoArchivo;
		if(in_array($this->tipoArchivo, $this->extencionesPermitidas) === false)
			$this->mensaje = 'El tipo de archivo no está permitido, verifique el problema con el administrador';
		elseif($this->tamanoArchivo > $this->tamanoMaximo)
			$this->mensaje = 'El tamaño del archivo debe ser menor a 2mb';
		elseif(move_uploaded_file($this->archivoTemporal, $urlArchivo))
			return true;
		return false;
	}
	
	function setNombreCampoFile($nombreCampoFile){
		$this->nombreCampoFile = $nombreCampoFile;
	}
	function getMensaje(){
		return $this->mensaje;
	}
	function getNombreArchivo(){
		return $this->nombreArchivo;
	}
}?>