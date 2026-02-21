<?php

class Archivo {
	var $archivo;
	var $archivo_nuevo;
	var $directorio;	
	var $tipoArchivo;
	var $tipoPermitido;
	var $tamanoArchivo;
	var $tmp;
	var $nombre;
	var $tamanoMaximo;
	var $error;
	

	public function __construct($archivo,$dir,$extPermitida=array(),$tamano,$tmp,$error) { //,$nombre='',$tamPermitido=''){
		$this->archivo			= $archivo;
		$this->archivo_nuevo	= $archivo;
		$this->directorio		= $dir;		
		//$this->tipoArchivo		= $this->getTipoArchivo($archivo);
		$this->tipoPermitido	= $extPermitida;
		$this->tamanoArchivo	= $tamano;		
		//$this->nombre			= empty($nombre) ? str_replace(".".$this->tipoArchivo,"",$archivo) : $nombre;		
		//$this->tamanoMaximo		= empty($tamPermitido) ? ini_get('upload_max_filesize')*1048576 : $tamPermitido*1048576;
		$this->tmp				= $tmp;
		$this->error			= $error;
	}
	
	public function getExtension() {
		$archivo_ = $this->archivo;
		if($archivo_!='') {
			$ultimo_ = explode('.',$archivo_);
			$extension=end($ultimo_);
			return $extension;
		}
		return null;
	}
	
	
	private function checkType(){
		if(in_array($this->tipoArchivo,$this->tipoPermitido)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Revisa si el archivo es del tamaño permitido
	 * @return boolean Si cumple o no con lo establecido
     * @author Jorge Andrade M.
	 */
	private function checkSize(){
		if($this->tamanoArchivo > $this->tamanoMaximo){
			return false;
		}else{
			return true;
		}
	}	
	/**
	 * Sube los archivos, revisa si no sobrepasa el tamaño máximo permitido,
	 *  si está dentro de los tipos aceptados y si no exite
	 *
	 * @return boolean indicando el resultado del proceso
	 */
	public function subir() {
		$responce	= new stdClass();
		$responce->codigo	= 0;
		$responce->mensaje=$this->archivo." ";
		if(!empty($this->error)) {
			switch($this->error) {
				case '1':
					$responce->mensaje.='El archivo excede el tamaño permitido.'; //'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$responce->mensaje.='El archivo excede el tamaño permitido.'; //The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$responce->mensaje.='El archivo subido fue s&oacute;lo parcialmente cargado'; //The uploaded file was only partially uploaded';
					break;
				case '4':
					$responce->mensaje.='El archivo no pudo ser subido'; //No file was uploaded.';
					break;
				case '6':
					$responce->mensaje.='Error con la carpeta temporal'; //Missing a temporary folder';
					break;
				case '7':
					$responce->mensaje.='No se pudo escribir el archivo en el disco'; //Failed to write file to disk';
					break;
				case '8':
					$responce->mensaje.='Carga de archivos detenido por extensi&oacute;n'; //File upload stopped by extension';
					break;
				case '999':
				default:
					$responce->mensaje.='Error indeterminado en subir el archivo.'; //'No error code available';
			}
		} elseif(empty($this->tmp) || $this->tmp=='none') {
			$responce->mensaje.='El archivo no pudo ser subido'; //No file was uploaded..';
		} else {
				move_uploaded_file($this->tmp,$this->directorio.$this->archivo_nuevo);
				$responce->codigo	= 1;
				$responce->mensaje.="Archivo subido con &eacute;xito.";
				//$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
				//$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
				//for security reason, we force to remove all uploaded file
				//@unlink($_FILES['fileToUpload']);		
		}
		return $responce;
	
				
	}

	public function delFile() {
		if(file_exists($this->directorio.$this->archivo)){
			unlink($this->directorio.$this->archivo);
			return true;
		}else{
			return false;
		}		
	}
}
?>