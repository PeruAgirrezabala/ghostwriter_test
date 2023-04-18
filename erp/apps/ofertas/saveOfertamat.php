
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertamat_deldetalle'] != "") {
        delDetalleOferta($_POST['ofertamat_deldetalle']);
    }    
    else {
        if ($_POST['ofertamat_detalle_id'] != "") {
            updateDetalleOferta();
        }
        else {
            insertDetalleOferta();
        }
    }
    
    function insertDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['ofertamat_dtoprov'] != "") {
            $provdtoidfiled = ", dto_prov_id";
            $provdto_id = ", ".$_POST['ofertamat_dtoprov'];
        }
        else {
            $provdtoidfiled = "";
            $provdto_id = "";
        }
        if ($_POST['ofertamat_dtoprov_desc'] == "") {
            $dtoprov_activo = 0;
        }
        else {
            $dtoprov_activo = 1;
        }
        if ($_POST['ofertamat_dtomat_desc'] == "") {
            $dtomat_activo = 0;
        }
        else {
            $dtomat_activo = 1;
        }
        if ($_POST['ofertamat_dto_desc'] == "") {
            $dtoad_activo = 0;
        }
        else {
            $dtoad_activo = 1;
        }
        if ($_POST['ofertamat_chkalmacen'] == true) {
            $almacen = 1;
        }
        else {
            $almacen = 0;
        }
        $pvp=$_POST["ofertamat_pvp"];
        $pvp_dto=$_POST["ofertamat_pvpdto"];
        $pvp_total=$_POST["ofertamat_pvpinc"];
        
        $sql = "INSERT INTO OFERTAS_DETALLES_MATERIALES 
                    (material_id,
                    oferta_id,
                    cantidad,
                    dto1,
                    incremento,
                    material_tarifa_id,
                    dto_prov_activo,
                    dto_mat_activo,
                    dto_ad_activo,
                    origen,
                    pedcreado,
                    pvp,
                    pvp_dto,
                    pvp_total
                    ".$provdtoidfiled."
                    )
                VALUES (".$_POST['ofertamat_material_id'].",
                ".$_POST['ofertamat_oferta_id'].",
                ".$_POST['ofertamat_cantidad'].",
                ".$_POST['ofertamat_dto'].",
                ".$_POST['ofertamat_incremento'].",
                ".$_POST['ofertamat_precios'].",
                ".$dtoprov_activo.", 
                ".$dtomat_activo.",
                ".$dtoad_activo.",
                ".$almacen.",
                0,
                ".$pvp.",
                ".$pvp_dto.",
                ".$pvp_total."
                ".$provdto_id.")";
        //file_put_contents("insertofertamat.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle de Material");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['ofertamat_dtoprov'] != "") {
            $provdto_id = ", dto_prov_id = ".$_POST['ofertamat_dtoprov'];
        }
        else {
            $provdto_id = "";
        }
        
        if ($_POST['ofertamat_dtoprov_desc'] == "") {
            $dtoprov_activo = 0;
        }
        else {
            $dtoprov_activo = 1;
        }
        if ($_POST['ofertamat_dtomat_desc'] == "") {
            $dtomat_activo = 0;
        }
        else {
            $dtomat_activo = 1;
        }
        if ($_POST['ofertamat_dto_desc'] == "") {
            $dtoad_activo = 0;
        }
        else {
            $dtoad_activo = 1;
        }
        if ($_POST['ofertamat_chkalmacen'] == true) {
            $almacen = 1;
        }
        else {
            $almacen = 0;
        }
        
        $sql = "UPDATE OFERTAS_DETALLES_MATERIALES 
                SET material_id = ".$_POST['ofertamat_material_id'].", 
                    material_tarifa_id = ".$_POST['ofertamat_precios'].", 
                    oferta_id = ".$_POST['ofertamat_oferta_id'].", 
                    cantidad = ".$_POST['ofertamat_cantidad'].",  
                    dto1 = ".$_POST['ofertamat_dto'].", 
                    incremento = ".$_POST['ofertamat_incremento'].", 
                    dto_prov_activo = ".$dtoprov_activo.",
                    dto_mat_activo = ".$dtomat_activo.",
                    dto_ad_activo = ".$dtoad_activo.",
                    origen = ".$almacen."
                    ".$provdto_id." 
                WHERE id = ".$_POST['ofertamat_detalle_id'];
        //file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle de Material");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DETALLES_MATERIALES WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle de Material");
    }
?>
	