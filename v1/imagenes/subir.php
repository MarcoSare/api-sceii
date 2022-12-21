<?php
echo '<html><head></head><body>';
echo '<h1>Ejemplo subida de fichero</h1>';
echo '<form method="post" enctype="multipart/form-data">';
echo 'Fichero a recibir: <input type="file" name="myfile" /><br />';
echo '<input type="submit" value="Enviar">';
echo '</form>';

if ( isset( $_FILES ) && isset( $_FILES['myfile'] ) && !empty( $_FILES['myfile']['name'] && !empty($_FILES['myfile']['tmp_name']) ) ) {
	//Hemos recibido el fichero
	//Comprobamos que es un fichero subido por PHP, y no hay inyección por otros medios
	if ( ! is_uploaded_file( $_FILES['myfile']['tmp_name'] ) ) {
		echo "Error: El fichero encontrado no fue procesado por la subida correctamente";
		exit;
	} 
	$source = $_FILES['myfile']['tmp_name'];
	$destination = __DIR__.'/upload/'.$_FILES['myfile']['name'];
			
	if ( is_file($destination) ) {
	 echo "Error: Ya existe almacenado un fichero con ese nombre";
	 @unlink(ini_get('upload_tmp_dir').$_FILES['myfile']['tmp_name']);
	 exit;
	}

	if ( ! @move_uploaded_file($source, $destination ) ) {
		echo "Error: No se ha podido mover el fichero enviado a la carpeta de destino";
		@unlink(ini_get('upload_tmp_dir').$_FILES['myfile']['tmp_name']);
		exit;
	}
	echo "Fichero subido correctamente a: ".$destination;
				
}
?>