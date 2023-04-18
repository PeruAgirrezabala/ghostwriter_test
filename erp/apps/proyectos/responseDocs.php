<?
    //file_put_contents("array.txt", "start");
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    //file_put_contents("array.txt", "second");
    
    // Se le pasa algun filtro?
    if ($_POST["filtro"]) {
        $filtro = " AND nombre LIKE '%".$_POST["filtro"]."%' ";
    }
    else {
        $filtro = " ";
    }
    
    // Determinar cuantos ficheros hay en cada uno de los directorios.
    // 1 Extraer el directorio del proyecto
    $sql0 = "SELECT 
            PROYECTOS.path
        FROM 
            PROYECTOS
        WHERE 
            PROYECTOS.id = ".$_GET["id"];
    file_put_contents("logResponse0.txt", $sql0);
    $res0 = mysqli_query($connString, $sql0) or die("Error selección directorio.");
    $row0 = mysqli_fetch_array($res0);
    file_put_contents("logResponse1.txt", "OK");
    $directorio=$row0[0];
    // 2 Combrobación de ficheros (.docx y .pdf) en el directorio
    // FUNCION getfiles($directorio,1);
    // 
    // 3 Actualizar base de datos
    // PTE...
    
    
    // Extraer el nombre de los grupos
    $sql = "SELECT 
            GRUPOS_DOC.id,
            GRUPOS_DOC.nombre 
        FROM 
            GRUPOS_DOC 
        WHERE 
            GRUPOS_DOC.proyecto_id = ".$_GET["id"].$filtro." 
        ORDER BY 
            GRUPOS_DOC.nombre ASC";
    $data = array();
    $states = array();
    $res = mysqli_query($connString, $sql) or die("database error:");
    $opcion=0;
    
    while( $row = mysqli_fetch_array($res) ) {
        //file_put_contents("array.txt", "in"); // Log
        $opcion++;
        // Estructuramos el directorio correspondiente
        switch ($opcion){
            case 1:
                $path = "/share/CACHEDEV1_DATA/PROYECTOS".$directorio."DOCUMENTACION/";
                $grupo = "DOCUMENTACION";
                break;
            case 2:
                $path = "/share/CACHEDEV1_DATA/PROYECTOS".$directorio."ENTREGAS/";
                $grupo = "ENTREGAS";
                break;
            case 3:
                $path = "/share/CACHEDEV1_DATA/PROYECTOS".$directorio."ESPECIFICACIONES/";
                $grupo = "ESPECIFICACIONES";
                break;
            case 4:
                $path = "/share/CACHEDEV1_DATA/PROYECTOS".$directorio."OFERTAS/";
                $grupo = "OFERTAS";
                break;
            case 5:
                $path = "/share/CACHEDEV1_DATA/PROYECTOS".$directorio."PARTES/";
                $grupo = "PARTES";
                break;
        }
        file_put_contents("logResponse1_1.txt", $path);
        $ficheros = glob($path . "*.{docx,pdf}",GLOB_BRACE); // Escanear el directorio en busca de ficheros // FORMATO ARRAY
        //$numFicheros = count($ficheros); // Número de ficheros
        
        //$ficheros=getfiles($row0[0],$contador); // objetenemos los ficheros de cada uno de los bloques de documentos
        $nficheros=count($ficheros); // contamos los ficheros
        $estilonficheros=" <span class='badge'>".$nficheros."</span>"; // damos formato
        file_put_contents("logResponse8.txt", $nficheros);
        // Realizamos los Insterts Correspondientes.
        if($nficheros>0){ // Solo si hay ficheros en el directorio.
            for($i=0;$i<$nficheros;$i++){
                //file_put_contents("logResponse".$opcion."_".$i.".txt", "OK");
                $nombre_fichero=str_replace($path,"",$ficheros[$i]);
                $doc_path=str_replace("/share/CACHEDEV1_DATA/","",$path);
                $doc_path=$doc_path.$nombre_fichero;
                // HAY PROBLEMAS CON LA QUERY?
                $sqlGrupoDoc = "SELECT PROYECTOS_DOC.id, PROYECTOS_DOC.titulo, PROYECTOS_DOC.grupo_id
                        FROM GRUPOS_DOC, PROYECTOS_DOC 
                        WHERE GRUPOS_DOC.id = PROYECTOS_DOC.grupo_id
                            AND GRUPOS_DOC.proyecto_id = ".$_GET["id"] ."
                            AND PROYECTOS_DOC.titulo='".$nombre_fichero."'
                        AND GRUPOS_DOC.nombre = '".$grupo."'";
                file_put_contents("logResponse9.txt", $sqlGrupoDoc);
                $resGrupoDoc = mysqli_query($connString, $sqlGrupoDoc) or die(mysqli_error($db));
                //file_put_contents("logResponse9_1.txt", $sqlGrupoDoc);
                $numero_filas = mysqli_num_rows($resGrupoDoc);
                file_put_contents("logResponse9_0.txt", $numero_filas);
                
                // NO EXISTE // Si es 0, sabemos que el título de ese documento no existe en la base de datos, por tanto no exite.
                // Es entonces cuando hay que hacer un insert, sino, sería 1 y no se hace el insert.
                if($numero_filas==0){ 
                    // Obtener el código del Grupoo // Misma query pero sin titulo.
                    $sqlGrupoDoc = "SELECT GRUPOS_DOC.id
                        FROM GRUPOS_DOC 
                        WHERE GRUPOS_DOC.proyecto_id = ".$_GET["id"]."
                        AND GRUPOS_DOC.nombre = '".$grupo."'";
                    $resGrupoDoc = mysqli_query($connString, $sqlGrupoDoc);
                    $rowGrupoDoc = mysqli_fetch_array($resGrupoDoc);
                    
                    file_put_contents("logResponse9_2.txt", "OK");
                    // INSERT
                    // Actualizar bd con los ficheros encontrados en el directorio
                    $sqlInsertDoc = "INSERT INTO PROYECTOS_DOC
                                (titulo,
                                grupo_id,
                                proyecto_id,
                                doc_path) VALUES(
                                '".$nombre_fichero."',
                                ".$rowGrupoDoc[0].",
                                ".$_GET["id"] .",
                                '".$doc_path."')";
                    file_put_contents("logResponse9_9.txt", $sqlInsertDoc);
                    $resInsertDoc = mysqli_query($connString, $sqlInsertDoc) or die("Error a la hora de Insertar el fichero en la base de datos.");
                }
                
            }
        }
        
        
        
        $tmp = array();
        $states['expanded'] = false;
        $tmp['text'] = $row[1].$estilonficheros; // Nombre del grupo de documentos con el formato de número de documentos
        $tmp['state'] = $states;
        $sql2 = "SELECT 
            PROYECTOS_DOC.id as docid,
            PROYECTOS_DOC.titulo,
            PROYECTOS_DOC.descripcion,
            PROYECTOS_DOC.doc_path as path, 
            GRUPOS_DOC.nombre 
        FROM 
            PROYECTOS_DOC, GRUPOS_DOC 
        WHERE 
            PROYECTOS_DOC.grupo_id = GRUPOS_DOC.id 
        AND
            PROYECTOS_DOC.grupo_id = ".$row[0]." 
        ORDER BY 
            PROYECTOS_DOC.id DESC";

        $res2 = mysqli_query($connString, $sql2) or die("database error:");
        //iterate on results row and create new index array of data
        $datanodes = array();
        $tmpnodes = array();
        while( $row2 = mysqli_fetch_array($res2) ) { 
                $tmpnodes['text'] = $row2[1];
                $tmpnodes['icon'] = "glyphicon glyphicon-file";
                $tmpnodes['href'] = "file:////192.168.3.108/".$row2[3];
                $tmpnodes['id'] = $row2[0];
                array_push($datanodes, $tmpnodes); 
        }
        $tmp['nodes'] = $datanodes;
        array_push($data, $tmp); 
    }

    
    //file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>