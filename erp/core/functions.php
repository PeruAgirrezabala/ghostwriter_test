
<?
	function query_bd($strConsulta) {
		global $connection;
		//$db = mysqli_select_db('iralbizu_fisio', $enlace);
		//$resultado = mysqli_query($strConsulta);
		$resultado = mysqli_query($connection, $strConsulta);
		return $resultado;
	}
	function build_menu($items) {
		//require($_SERVER['DOCUMENT_ROOT']."/includes/dbconnection.php");
		//$sql = "SELECT id, parent_id, title, link, position FROM gogo_menu_items ORDER BY parent_id, position";
		//$items = mysql_db_query("cms", $sql, $db);	
		//$items = mysql_fetch_array($result);
		
		
		$html = '';
		$parent = 0;
		$parent_stack = array();
		
		// $items contains the results of the SQL query
		$children = array();
		foreach ( $items as $item )
			$children[$item['parent_id']][] = $item;
		
		while ( ( $option = each( $children[$parent] ) ) || ( $parent > 0 ) )
		{
			if ( !empty( $option ) )
			{
				// 1) The item contains children:
				// store current parent in the stack, and update current parent
				if ( !empty( $children[$option['value']['id']] ) )
				{
					$html .= '<li>' .'<a href="'.$option['value']['link'].'">'. $option['value']['title'].'</a>' ;
					$html .= '<ul>'; 
					array_push( $parent_stack, $parent );
					$parent = $option['value']['id'];
				}
				// 2) The item does not contain children
				else
					$html .= '<li>' .'<a href="'.$option['value']['link'].'">'. $option['value']['title'].'</a>' ;
			}
			// 3) Current parent has no more children:
			// jump back to the previous menu level
			else
			{
				$html .= '</li></ul>';
				$parent = array_pop( $parent_stack );
			}
		}
		
		// At this point, the HTML is already built
		echo $html;
	}
	function build_menu_movil($items) {
		//require($_SERVER['DOCUMENT_ROOT']."/includes/dbconnection.php");
		//$sql = "SELECT id, parent_id, title, link, position FROM gogo_menu_items ORDER BY parent_id, position";
		//$items = mysql_db_query("cms", $sql, $db);	
		//$items = mysql_fetch_array($result);
		
		
		$html = '';
		$parent = 0;
		$parent_stack = array();
		
		// $items contains the results of the SQL query
		$children = array();
		foreach ( $items as $item )
			$children[$item['parent_id']][] = $item;
		
		while ( ( $option = each( $children[$parent] ) ) || ( $parent > 0 ) )
		{
			if ( !empty( $option ) )
			{
				// 1) The item contains children:
				// store current parent in the stack, and update current parent
				if ( !empty( $children[$option['value']['id']] ) )
				{
					$html .= '<li>' .'<a href="'.$option['value']['link'].'">'. $option['value']['title'].'</a>' ;
					$html .= '<ul>'; 
					array_push( $parent_stack, $parent );
					$parent = $option['value']['id'];
				}
				// 2) The item does not contain children
				else
					$html .= '<li>' .'<a href="'.$option['value']['link'].'">'. $option['value']['title'].'</a>' ;
			}
			// 3) Current parent has no more children:
			// jump back to the previous menu level
			else
			{
				$html .= '</li></ul>';
				$parent = array_pop( $parent_stack );
			}
		}
		
		// At this point, the HTML is already built
		echo $html;
	}
	
	function form_mail($sPara, $sAsunto, $sTexto, $sDe) {
		$sDe = $sDe;
		$bHayFicheros = 0;
		$sCabeceraTexto = "";
		$sAdjuntos = "";
		
		if ($sDe)$sCabeceras = "From:".$sDe."\n";
		else $sCabeceras = "";
		$sCabeceras .= "MIME-version: 1.0\n";
		foreach ($_POST as $sNombre => $sValor)
		$sTexto = $sTexto."\n".$sNombre." : ".$sValor;
		
		foreach ($_FILES as $vAdjunto)
		{
		if ($bHayFicheros == 0)
		{
		$bHayFicheros = 1;
		$sCabeceras .= "Content-type: multipart/mixed;";
		$sCabeceras .= "boundary=\"--_Separador-de-mensajes_--\"\n";
		
		$sCabeceraTexto = "----_Separador-de-mensajes_--\n";
		$sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n";
		$sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n";
		
		$sTexto = $sCabeceraTexto.$sTexto;
		}
		if ($vAdjunto["size"] > 0)
		{
		$sAdjuntos .= "\n\n----_Separador-de-mensajes_--\n";
		$sAdjuntos .= "Content-type: ".$vAdjunto["type"].";name=\"".$vAdjunto["name"]."\"\n";;
		$sAdjuntos .= "Content-Transfer-Encoding: BASE64\n";
		$sAdjuntos .= "Content-disposition: attachment;filename=\"".$vAdjunto["name"]."\"\n\n";
		
		$oFichero = fopen($vAdjunto["tmp_name"], 'r');
		$sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"]));
		$sAdjuntos .= chunk_split(base64_encode($sContenido));
		fclose($oFichero);
		}
		}
		
		if ($bHayFicheros)
		$sTexto .= $sAdjuntos."\n\n----_Separador-de-mensajes_----\n";
		return(mail($sPara, $sAsunto, $sTexto, $sCabeceras));
	} //Fin de la funcion mail
	
	function convertir_fecha($fecha_datetime){
		//Esta función convierte la fecha del formato DATETIME de SQL
		//a formato DD-MM-YYYY HH:mm:ss
		$fecha = split("-",$fecha_datetime);
		$hora = split(":",$fecha[2]);
		$fecha_hora=split(" ",$hora[0]);
		$fecha_convertida = $fecha_hora[0].'-'.$fecha[1].'-'.$fecha[0];//.' 	'.$fecha_hora[1].':'.$hora[1].':'.$hora[2];
		return $fecha_convertida;
	}	
	function dameURL(){
		$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		return $url;
	}
?>