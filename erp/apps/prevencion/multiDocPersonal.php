
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['docversiones_id'] != "") {
        loadVersiones();
    }
    else {
        if($_POST["deldocversiones_id"] != ""){
            deleteVersiones();
        }
    }
    
    function loadVersiones () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $tohtml='<div class="modal-dialog dialog_estrecho">
                 <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" style="display: inline-block;">VER ARCHIVOS</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover" id="tabla-doc-PER-versiones">
                        <thead>
                            <tr class="bg-dark">
                                <th class="text-center">FECHA</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">VER</th>
                                <th class="text-center">E</th>
                            </tr>
                        </thead>';
        $sqlVersiones = "SELECT
                    USERS_DOC_VERSIONES.id,
                    USERS_DOC_VERSIONES.doc_path,
                    USERS_DOC_VERSIONES.fecha_exp,
                    USERS_DOC.nombre
                FROM 
                    USERS_DOC_VERSIONES 
                INNER JOIN
                    USERS_DOC ON USERS_DOC_VERSIONES.doc_id=USERS_DOC.id
                WHERE USERS_DOC_VERSIONES.doc_id =".$_POST['docversiones_id'];
        file_put_contents("loadVersionesDocPersonal.txt", $sqlVersiones);
        $resVersiones = mysqli_query($connString, $sqlVersiones) or die("Error al ejcutar la consulta de loadVersionesDocPersonal");
        while ($registros = mysqli_fetch_array($resVersiones)) {
            $tohtml.="<tr data-id=".$registros[0]." >
                        <td>".$registros[2]."</td>
                        <td>".$registros[3]."</td>
                        <td><a href='file:////192.168.3.108/".$registros[1]."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                        <td><button class='btn btn-circle btn-danger del-docs-personal' data-id='".$registros[0]."' title='Eliminar Proceso'><img src='/erp/img/cross.png'></button></td>
                      </tr>";
        }
        
        $tohtml.='</div>
                </div>
            </div>';
        echo $tohtml;
    }
    
    function deleteVersiones () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM USERS_DOC_VERSIONES WHERE USERS_DOC_VERSIONES.id = ".$_POST['deldocversiones_id'];
        file_put_contents("delDocVersiones.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar Doc Versiones");
    }
?>
	