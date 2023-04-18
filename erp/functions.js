/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
window.addEventListener("load", function() {  
    document.getElementById("frm_edit").edit_tlfnoUsuario.addEventListener("keypress", soloNumeros, false);
    document.getElementById("frm_add").new_tlfnoUsuario.addEventListener("keypress", soloNumeros, false);
    document.getElementById("frm_edit_client").editclient_telefono.addEventListener("keypress", soloNumeros, false);
    document.getElementById("frm_add_client").newclient_telefono.addEventListener("keypress", soloNumeros, false);
});
*/
function printElement(elem, append, delimiter) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    if (append !== true) {
        $printSection.innerHTML = "";
    }

    else if (append === true) {
        if (typeof (delimiter) === "string") {
            $printSection.innerHTML += delimiter;
        }
        else if (typeof (delimiter) === "object") {
            $printSection.appendChild(delimiter);
        }
    }
    //alert(domClone.innerHTML);
    $printSection.appendChild(domClone);
}

function openLocalFile(filename) {
    //
    //  Open an external file (i.e. a file which ISN'T in our IIS folder)
    //  To do this, we get an ASP.Net Handler to manually load the file, 
    //  then return it's contents in a Response.
    //
    var URL = "file:///\\192.168.3.108\\" + filename.replace("/", "\\");
    window.open(URL);
}

function copyFile(filename) {
    var myObject, f;
    myObject = new ActiveXObject("Scripting.FileSystemObject");
    f = myObject.GetFile("\\\\192.168.3.108\\" + filename);
    if(!f)
    {
        return alert("File Not Found");
    }
    f.copy("@\\Network_Name\Home$\User_Folder\Downloads\Backup_Folder");
}

//Solo permite introducir numeros.
function soloNumeros(e){
    var key = window.event ? e.which : e.which;
    console.log(key);
    if ((key != 8) && (key != 0)) {
      if (key < 48 || key > 57) {
        e.preventDefault();
      }
    }
}

function validateForm() {
    // validamos el formulario del nuevo pedido
    stopProcess = 0;
    $(".validationError").removeClass("validationError");
    $(".required").each(function() {
        if ($(this).val() == "") {
            stopProcess = 1;
            console.log($(this));
            if ($(this).is("select")) {
                $(this).parent("div.bootstrap-select").children("button.dropdown-toggle").addClass("validationError");
            }
            else {
                $(this).addClass("validationError");
            }
        }
    });

    return stopProcess;
};

function loadContent(div, source) {
    //$('#' + div).fadeOut('slow', function(){
        $('#' + div).parent("div").children(".loading-div").fadeIn();
        $("#loading-div").fadeIn();
        $('#' + div).load(source, function(){
            $('#' + div).parent("div").children(".loading-div").fadeOut("slow", function(){
                 $('#' + div).fadeIn('slow');
                 $("[data-toggle='tooltip']").tooltip();
            });
        });
    //});
};

function loadSelectYears(selectItem, tabla, campo, campowhere, valor) {
    //alert(selectItem);
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/loadSelectYears.php", 
    {
       tabla: tabla,
       campo: campo,
       campoWhere: campowhere,
       valor: valor
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            if(item.year!=0){
                items+="<option value='"+item.year+"'>"+item.year+"</option>";
            }
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}

function loadSelect(selectItem, tabla, campo, campowhere, valor, campo2, campowhere2, valor2, campo3, likeOrEqual) {
    var items="<option></option>";
    var selectItem = selectItem;
    //console.log ("LOG tabla: "+tabla);
    $.getJSON("/erp/loadSelect.php", 
    {
       tabla: tabla,
       campo: campo,
       campo2: campo2,
       campo3: campo3,
       campowhere: campowhere,
       valor: valor,
       campowhere2: campowhere2,
       valor2: valor2,
       likeOrEqual: likeOrEqual
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            switch (tabla) {
                case "PROYECTOS":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.nombre + "</option>";
                    break;
//                case "CLIENTES":
//                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.nombre + "</option>";
//                    break;
                case "INTERVENCIONES":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.nombre + "</option>";
                    break;
                case "TAREAS":
                    items += "<option value='"+item.id+"' data-perfil='" + item.campo2 + "'>" + item.nombre + "</option>";
                    break;
                case "PERFILES_HORAS":
                    items += "<option value='"+item.id+"' data-precio='" + item.campo2 + "'>" + item.nombre + "</option>";
                    break;
                case "MATERIALES_CATEGORIAS":
                    items += "<option value='"+item.id+"' data-parent='" + item.campo2 + "'>" + item.nombre + "</option>";
                    break;
                case "MATERIALES_PRECIOS":
                    items += "<option value='"+item.id+"'>" + item.pvp + "€ / " + item.campo2 + " / " + item.campo3 + "%</option>";
                    $("#pedidodetalle_dtomat").val(item.campo3);
                    break;
                case "PROVEEDORES_DTO":
                    items += "<option value='"+item.id+"'>" + item.dto_prov + "% / " + item.campo2 + "</option>";
                    break;
                case "PEDIDOS_PROV":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.titulo + "</option>";
                    break;
                case "OFERTAS":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.titulo + "</option>";
                    break;
                case "erp_users":
                    items += "<option value='"+item.id+"'>" + item.nombre + " " + item.campo2 + "</option>";
                    break;
                case "MATERIALES":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.nombre + "</option>";
                    break;
                case "ENVIOS_CLI":
                    items += "<option value='"+item.id+"'>" + item.campo2 + " - " + item.nombre + "</option>";
                    break;
                case "IVAS":
                    items += "<option value='"+item.id+"'>" + item.nombre + "%</option>";
                    break;
                case "SERIAL_NUMBERS":
                    items += "<option value='"+item.id+"'>" + item.sn + "</option>";
                    break;
                case "erp_apps":
                    items += "<option value='"+item.id+"'>" + item.ubicacion + "-" + item.campo2 + "</option>";
                    break;
                default:
                    items += "<option value='"+item.id+"'>" + item.nombre + "</option>";
                    break;
            }
            
        });
        if(selectItem=="newensayo_plantilla"){
            items = "<option value='5'>PROTOCOLO DE PRUEBAS RELES PROTECCIÓN</option>";
            items += "<option value='40'>PROTOCOLO DE PRUEBAS DE ARMARIOS EN INGLES</option>";
            items += "<option value='44'>PROTOCOLO DE PRUEBAS EN ARMARIO</option>";
            items += "<option value='99'>PROTOCOLO DE PRUEBAS</option>";
        }
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
// Pendiente mejorar para las tarifas del proveedor en orden de fecha descendente......
function loadSelectTarifas(selectItem, tabla, campo, campowhere, valor, campo2, campowhere2, valor2, campo3, likeOrEqual, orden) {
    var items="<option></option>";
    var selectItem = selectItem;
    console.log("functions.js orden: "+orden);
    $.getJSON("/erp/loadSelectTarifas.php", 
    {
       tabla: tabla,
       campo: campo,
       campo2: campo2,
       campo3: campo3,
       campowhere: campowhere,
       valor: valor,
       campowhere2: campowhere2,
       valor2: valor2,
       likeOrEqual: likeOrEqual,
       orden: orden
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {  
            items += "<option value='"+item.id+"'>" + item.pvp + "€ / " + item.campo2 + " / " + item.campo3 + "%</option>";
            $("#pedidodetalle_dtomat").val(item.campo3);
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectInstalacionesProyecto(selectItem,proyectoid){
    //console.log("en funcitions: "+proyectoid+"-"+selectItem);
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/entregas/loadSelectInstalacionesProyecto.php", 
    {
       id: proyectoid 
    },
    function(data) { 
        //console.log(data);
        $.each(data,function(index,item) 
        {
            // items += "<option value='"+item.id+"'>[" + item.nombrecliente + "] - " + item.nombreinstalacion + "</option>";
            items += "<option value='"+item.id+"'>" + item.nombreinstalacion + "</option>";
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadTitulosEntregas(item,tabla,id){
    $.getJSON("/erp/apps/entregas/loadTitulosEntregas.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log ("asasas: "+data[0].nombre);
        //obj = JSON.parse(data);
        $("#"+item).html(data[0].ref+" - "+data[0].nombre);
    });
}
function loadSelectPreciosOferta(selectItem, tabla, campowhere1, campo1, campowhere2, campo2) {
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/loadSelectPreciosOferta.php", 
    {
       tabla: tabla,
       campo1: campo1,
       campowhere1: campowhere1,
       campowhere2: campowhere2,
       campo2: campo2,
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            switch (tabla) {
                case "MATERIALES_PRECIOS":
                    items += "<option value='"+item.id+"' data-proveedorid='" + item.proveedor_id + "'>" + item.proveedor + " - " + item.pvp + "€ - " + item.fecha_val + " - " + item.dto_material + "%</option>";
                    break;
                default:
                    items += "<option value='"+item.id+"'>" + item.nombre + "</option>";
                    break;
            }
            
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectMaterialesProv(selectItem, valor) {
    console.log ("dentro1");
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/ofertas/loadSelectMaterialesProv.php", 
    {
       valor: valor
    },
    function(data) { 
        console.log ("dentro2");
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
             items += "<option value='"+item.id+"'>" + item.nombre + "</option>";
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadMaterialInfo(id,tabla) {
    $.getJSON("/erp/apps/ofertas/loadMaterialInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        
        if($("#ofertamat_material_id").length){
            $("#ofertamat_material_id").val(data[0].material); 
            $("#ofertamat_nombre").val(data[0].nombre); 
            $("#ofertamat_modelo").val(data[0].modelo); 
            $("#ofertamat_descripcion").val(data[0].descripcion);
            $("#ofertamat_preciomat").val(data[0].precio);
            $("#ofertamat_ref").val(data[0].ref);
        }
        else {
            $("#proyectomaterial_material_id").val(data[0].material); 
            $("#proyectomaterial_nombre").val(data[0].nombre); 
            $("#proyectomaterial_modelo").val(data[0].modelo); 
            $("#proyectomaterial_fabricante").val(data[0].fabricante); 
            $("#proyectomaterial_stock").val(data[0].stock); 
            $("#proyectomaterial_ref").val(data[0].ref); 
            $("#proyectomaterial_descripcion").val(data[0].descripcion);
            $("#proyectomaterial_preciomat").val(data[0].precio);
        }
    });
}
function loadSelectMaterialAlmacen(selectItem,campo) {
    var items="<option></option>";
    var selectItem = selectItem;
    var campo = campo;
    $.getJSON("/erp/apps/proyectos/loadSelectMaterialAlmacen.php", 
    {
       campo: campo
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        
        $.each(data,function(index,item) 
        {
            
            switch (campo) {
                case "ref":
                    items += "<option value='"+item.id_stock+"'>" + item.ref + "</option>";
                    break;
                case "material":
                    items += "<option value='"+item.id_stock+"'>" + item.nombre + "</option>";
                    break;
                default:
                    items += "<option value='"+item.id_stock+"'>?¿</option>";
                    break;
            }
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectActividadUser(selectItem,idAct){
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/actividad/loadSelectActividadUser.php", 
    {
       id: idAct
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        
        $.each(data,function(index,item) 
        {
            items += "<option value='"+item.id+"'>"+item.nombre+" "+item.apellidos+"</option>";
                    
            
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectNotEstadoOferta(selectItem,idNot){
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/ofertas/loadSelectNotEstadoOferta.php", 
    {
       id: idNot
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        
        $.each(data,function(index,item) 
        {
            items += "<option value='"+item.id+"'>"+item.nombre+"</option>";
                    
            
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSNlInfo(id,tabla) {
    $.getJSON("/erp/apps/intervenciones/loadSNInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        
        if (tabla == "envios") {
            $("#enviodetalle_nombre").val(data[0].nombre); 
            $("#enviodetalle_modelo").val(data[0].modelo); 
            $("#enviodetalle_fabricante").val(data[0].fabricante); 
            $("#enviodetalle_ref").val(data[0].ref); 
            $("#enviodetalle_numserie").val(data[0].sn);
        }
        else {
            $("#intmaterial_nombre").val(data[0].nombre); 
            $("#intmaterial_modelo").val(data[0].modelo); 
            $("#intmaterial_fabricante").val(data[0].fabricante); 
            $("#intmaterial_ref").val(data[0].ref); 
            $("#intmaterial_sn").val(data[0].sn);
            $("#intmaterial_proveedor").val(data[0].prov);
            $("#intmaterial_cliente").val(data[0].cli);
        }
        
    });
}

function loadOfertaDetalleInfo(id) {
    $.getJSON("/erp/apps/ofertas/loadOfertaDetalleInfo.php", 
    {
       id: id 
    },
    function(data) {
        //console.log (data);
        //obj = JSON.parse(data);
        $("#ofertamat_detalle_id").val(data[0].detalle);
        loadSelect("ofertamat_materiales","MATERIALES","id","categoria_id",data[0].categoria_id,"ref");
        $("#ofertamat_nombre").val(data[0].nombre); 
        $("#ofertamat_modelo").val(data[0].modelo); 
        $("#ofertamat_descripcion").val(data[0].descripcion);
        $("#ofertamat_preciomat").val(data[0].precio);
        $("#ofertamat_cantidad").val(data[0].cantidad);
        $("#ofertamat_pvp").val(data[0].precio);
        $("#ofertamat_dto").val(data[0].dto1);
        $("#ofertamat_pvpdto").val(data[0].pvp_dto);
        $("#ofertamat_incremento").val(data[0].incremento);
        $("#ofertamat_pvpinc").val(data[0].pvp_total);
        $("#ofertamat_material_id").val(data[0].material); 
        loadSelect("ofertamat_precios","MATERIALES_PRECIOS","id","proveedor_id",data[0].proveedor_id,"fecha_val", "material_id", data[0].material, "MATERIALES_PRECIOS.dto_material");
        loadSelect("ofertamat_dtoprov","PROVEEDORES_DTO","id","proveedor_id",data[0].proveedor_id,"fecha_val","","","");
        setTimeout(function(){
            $("#ofertamat_materiales").selectpicker("val", data[0].material);
            $("#ofertamat_precios").selectpicker("val", data[0].material_tarifa_id);
            $("#ofertamat_dtoprov").selectpicker("val", data[0].dto_prov_id);
            $('input[name="ofertamat_chkalmacen"]').bootstrapSwitch('state',parseInt(data[0].origen));
        }, 1000);
        
    });
}
function loadOfertaDetalleSubInfo(id) {
    $.getJSON("/erp/apps/ofertas/loadOfertaDetalleSubInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $("#ofertasub_detalle_id").val(data[0].detalle);
        loadSelect("ofertasub_terceros","PROVEEDORES","id","","","");
        $("#ofertasub_titulo").val(data[0].titulo); 
        $("#ofertasub_descripcion").val(data[0].descripcion);
        $("#ofertasub_unitario").val(data[0].unitario);
        $("#ofertasub_cantidad").val(data[0].cantidad);
        $("#ofertasub_pvp").val(data[0].pvp);
        $("#ofertasub_dto").val(data[0].dto1);
        $("#ofertasub_pvpdto").val(data[0].pvp_dto);
        $("#ofertasub_incremento").val(data[0].incremento);
        $("#ofertasub_pvpinc").val(data[0].pvp_total);
        setTimeout(function(){
            $("#ofertasub_terceros").selectpicker("val", data[0].tercero);
        }, 1000);
        
    });
}
function loadOfertaDetalleManoInfo(id) {
    $.getJSON("/erp/apps/ofertas/loadOfertaDetalleManoInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#ofertamano_detalle_id").val(data[0].detalle);
        loadSelect("ofertamano_tareas","TAREAS","id","","", "perfil_id");
        loadSelect("ofertamano_horas","PERFILES_HORAS","id","perfil_id",data[0].perfil,"precio");
        $("#ofertamano_titulo").val(data[0].titulo); 
        $("#ofertamano_descripcion").val(data[0].descripcion);
        $("#ofertamano_preciohora").val(data[0].precio);
        $("#ofertamano_cantidad").val(data[0].cantidad);
        $("#ofertamano_pvp").val(data[0].pvp);
        $("#ofertamano_dto").val(data[0].dto);
        $("#ofertamano_pvp_total").val(data[0].pvp_total);
        setTimeout(function(){
            $("#ofertamano_tareas").selectpicker("val", data[0].tarea);
            $("#ofertamano_horas").selectpicker("val", data[0].tipohora);
        }, 1000);
        
    });
}
function loadOfertaDetalleViajeInfo(id) {
    $.getJSON("/erp/apps/ofertas/loadOfertaDetalleViajeInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#ofertaviajes_detalle_id").val(data[0].detalle);
        $("#ofertaviajes_titulo").val(data[0].titulo); 
        $("#ofertaviajes_descripcion").val(data[0].descripcion);
        $("#ofertaviajes_unitario").val(data[0].unitario);
        $("#ofertaviajes_cantidad").val(data[0].cantidad);
        $("#ofertaviajes_pvp").val(data[0].pvp);
        $("#ofertaviajes_inc").val(data[0].incremento);
        $("#ofertaviajes_pvp_total").val(data[0].pvp_total);
    });
}
function loadOfertaDetalleOtrosInfo(id) {
    $.getJSON("/erp/apps/ofertas/loadOfertaDetalleOtrosInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#ofertaotros_detalle_id").val(data[0].detalle);
        $("#ofertaotros_titulo").val(data[0].titulo); 
        $("#ofertaotros_descripcion").val(data[0].descripcion);
        $("#ofertaotros_unitario").val(data[0].unitario);
        $("#ofertaotros_cantidad").val(data[0].cantidad);
        $("#ofertaotros_pvp").val(data[0].pvp);
        $("#ofertaotros_inc").val(data[0].incremento);
        $("#ofertaotros_pvp_total").val(data[0].pvp_total);
    });
}

function loadProyectoDetalleSubInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectoDetalleSubInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $("#proyectosub_detalle_id").val(data[0].detalle);
        loadSelect("proyectosub_terceros","PROVEEDORES","id","","","");
        $("#proyectosub_titulo").val(data[0].titulo); 
        $("#proyectosub_descripcion").val(data[0].descripcion);
        $("#proyectosub_unitario").val(data[0].unitario);
        $("#proyectosub_cantidad").val(data[0].cantidad);
        $("#proyectosub_pvp").val(data[0].pvp);
        $("#proyectosub_dto").val(data[0].dto1);
        $("#proyectosub_pvpdto").val(data[0].pvp_dto);
        $("#proyectosub_iva").val(data[0].iva);
        $("#proyectosub_pvp_total").val(data[0].pvp_total);
        setTimeout(function(){
            $("#proyectosub_terceros").selectpicker("val", data[0].tercero);
        }, 1000);
        
    });
}
function loadProyectoDetalleViajeInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectoDetalleViajeInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#proyectoviajes_detalle_id").val(data[0].detalle);
        $("#proyectoviajes_titulo").val(data[0].titulo); 
        $("#proyectoviajes_descripcion").val(data[0].descripcion);
        $("#proyectoviajes_unitario").val(data[0].unitario);
        $("#proyectoviajes_cantidad").val(data[0].cantidad);
        $("#proyectoviajes_pvp").val(data[0].pvp);
        $("#proyectoviajes_iva").val(data[0].iva);
        $("#proyectoviajes_pvp_total").val(data[0].pvp_total);
    });
}
function loadPoyectoDetalleOtrosInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadPoyectoDetalleOtrosInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#proyectootros_detalle_id").val(data[0].detalle);
        $("#proyectootros_titulo").val(data[0].titulo); 
        $("#proyectootros_descripcion").val(data[0].descripcion);
        $("#proyectootros_unitario").val(data[0].unitario);
        $("#proyectootros_cantidad").val(data[0].cantidad);
        $("#proyectootros_pvp").val(data[0].pvp);
        $("#proyectootros_iva").val(data[0].iva);
        $("#proyectootros_pvp_total").val(data[0].pvp_total);
    });
}

function loadProyectoOrdenInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectoOrdenInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#orden_detalle_id").val(data[0].detalle);
        loadSelect("orden_tareas","TAREAS","id","","", "perfil_id");
        loadSelect("orden_horas","PERFILES_HORAS","id","perfil_id",data[0].perfil,"");
        loadSelect("orden_tecnicos","erp_users","id","","", "apellidos");
        $("#orden_titulo").val(data[0].titulo); 
        $("#orden_descripcion").val(data[0].descripcion);
        $("#orden_cantidad").val(data[0].cantidad);
        $("#orden_fecha_entrega").val(data[0].fecha_entrega);
        setTimeout(function(){
            $("#orden_tareas").selectpicker("val", data[0].tarea);
            $("#orden_horas").selectpicker("val", data[0].tipohora);
            //$("#orden_tecnicos").selectpicker("val", data[0].tecnico);
        }, 1000);
        
    });
}

function loadProyectoHitoInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectoHitoInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#hito_detalle_id").val(data[0].hito);
        loadSelect("hito_tecnicos","erp_users","id","","", "apellidos");
        $("#hito_nombre").val(data[0].nombre); 
        $("#hito_descripcion").val(data[0].descripcion);
        $("#hito_fecha_entrega").val(data[0].fecha_entrega);
        $("#hito_fecha_realizacion").val(data[0].fecha_realizacion);
        $("#hito_observ").val(data[0].observaciones);
        setTimeout(function(){
            $("#hito_estados").selectpicker("val", data[0].estado_id);
            $("#hito_tecnicos").selectpicker("val", data[0].erpuser_id);
        }, 1000);
        
    });
}

function loadProyectoHorasInfo(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectoHorasInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#horas_detalle_id").val(data[0].detalle);
        loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
        loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",data[0].perfil,"");
        loadSelect("horas_tecnicos","erp_users","id","","", "apellidos");
        $("#horas_titulo").val(data[0].titulo); 
        $("#horas_descripcion").val(data[0].descripcion);
        $("#horas_cantidad").val(data[0].cantidad);
        $("#horas_fecha").val(data[0].fecha);
        if($("#horas_proyectos").length){
            $("#horas_proyectos").selectpicker("val", data[0].proyecto);
        }
        setTimeout(function(){
            $("#horas_tareas").selectpicker("val", data[0].tarea);
            $("#horas_horas").selectpicker("val", data[0].tipohora);
            $("#horas_tecnicos").selectpicker("val", data[0].tecnico);
        }, 1000);
        
    });
}

function loadIntHorasInfo(id) {
    $.getJSON("/erp/apps/intervenciones/loadIntHorasInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        if($("#horasint_int").length) {
            $("#horasint_detalle_id").val(data[0].detalle);
            loadSelect("horasint_tareas","TAREAS","id","","", "perfil_id");
            loadSelect("horasint_horas","PERFILES_HORAS","id","perfil_id",data[0].perfil,"");
            loadSelect("horasint_tecnicos","erp_users","id","","", "apellidos");
            $("#horasint_titulo").val(data[0].titulo); 
            $("#horasint_descripcion").val(data[0].descripcion);
            $("#horasint_cantidad").val(data[0].cantidad);
            $("#horasint_fecha").val(data[0].fecha);
            $("#horasint_int").selectpicker("val", data[0].intervencion);
            setTimeout(function(){
                $("#horasint_tareas").selectpicker("val", data[0].tarea);
                $("#horasint_horas").selectpicker("val", data[0].tipohora);
            }, 1000);
        }
        else {
            $("#horas_detalle_id").val(data[0].detalle);
            loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
            loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",data[0].perfil,"");
            loadSelect("horas_tecnicos","erp_users","id","","", "apellidos");
            $("#horas_titulo").val(data[0].titulo); 
            $("#horas_descripcion").val(data[0].descripcion);
            $("#horas_cantidad").val(data[0].cantidad);
            $("#horas_fecha").val(data[0].fecha);
            setTimeout(function(){
                $("#horas_tareas").selectpicker("val", data[0].tarea);
                $("#horas_horas").selectpicker("val", data[0].tipohora);
                $("#horas_tecnicos").selectpicker("val", data[0].tecnico);
            }, 1000);
        }
        
    });
}

function loadPedidoDetalleInfo(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/material/loadPedidoDetalleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        var pvp = parseFloat((data[0].precio*data[0].unidades).toFixed(2));
        var dto_adicional = parseFloat(data[0].dto_adicional);
        var dto_mat = parseFloat(data[0].dto_material);
        if (data[0].dto_prov != null) {
            dto_prov = parseFloat(data[0].dto_prov);
        }
        else {
            dto_prov = 0;
        }
        var dto_sum = 0;
        var pvp_dto_aplicado = 0;
        var pvp_dto = 0;
        $("#pedidodetalle_detalle_id").val(data[0].detalle);
        loadSelect("pedidodetalle_materiales","MATERIALES","id","categoria_id",data[0].categoria_id,"ref");
        loadSelect("pedidodetalle_entregas","ENTREGAS","id","proyecto_id",data[0].proyecto);
        $("#pedidodetalle_nombre").val(data[0].nombre); 
        $("#pedidodetalle_fabricante").val(data[0].fabricante); 
        $("#pedidodetalle_modelo").val(data[0].modelo); 
        $("#pedidodetalle_descripcion").val(data[0].descripcion);
        $("#pedidodetalle_stock").val(data[0].stock);
        if ((data[0].precio != null) && (data[0].precio != "")) {
            $("#pedidodetalle_preciomat").val(data[0].precio);
        }
        else {
            $("#pedidodetalle_preciomat").val(data[0].pvp);
        }
        $("#pedidodetalle_ref").val(data[0].ref);
        $("#pedidodetalle_cantidad").val(data[0].unidades);
        $("#pedidodetalle_pvp").val(pvp.toFixed(2));
        $("#pedidodetalle_dto").val(dto_adicional.toFixed(2));
        $("#pedidodetalle_dtomat").val(dto_mat.toFixed(2));
        $("#pedidodetalle_libre").val(data[0].detalle_libre);
        $("#pedidodetalle_desc").val(data[0].observaciones);
        
        //$("#pedidodetalle_pvpdto").val(((data[0].precio*data[0].unidades) - (((data[0].precio*data[0].unidades)*data[0].dto)/100)).toFixed(2));
        $("#pedidodetalle_fecha_entrega").val(data[0].fecha_entrega); 
        
        if (data[0].dto_prov_activo == 1) {
            $("#pedidodetalle_dtoprov_desc").prop('checked', true);
            dto_sum  = (parseFloat(dto_sum)+parseFloat(dto_prov));
        }
        else {
            $("#pedidodetalle_dtoprov_desc").prop('checked', false);
        }
        if (data[0].dto_mat_activo == 1) {
            $("#pedidodetalle_dtomat_desc").prop('checked', true);
            dto_sum  = parseFloat(dto_sum) + parseFloat(dto_mat);
        }
        else {
            $("#pedidodetalle_dtomat_desc").prop('checked', false);
        }
        if (data[0].dto_ad_activo == 1) {
            $("#pedidodetalle_dto_desc").prop('checked', true);
            if (data[0].dto_ad_prior == 1) {
                $("#pedidodetalle_dto_sobretotal").prop('checked', true);
                dto_adicional = parseFloat(data[0].dto_adicional);
            }
            else {
                $("#pedidodetalle_dto_sobretotal").prop('checked', false);
                dto_sum  = parseFloat(dto_sum) + parseFloat(dto_adicional);
            }
        }
        else {
            $("#pedidodetalle_dto_desc").prop('checked', false);
        }
        pvp_dto = (pvp*dto_sum)/100;
        pvp_dto_aplicado = pvp - pvp_dto;
        if (data[0].dto_ad_prior == 1) {
            dtoNeto = (pvp_dto_aplicado*dto_adicional)/100;
            pvp_dto_aplicado = pvp_dto_aplicado-dtoNeto;
        }
        else {
            $dtoNeto = 0;
        }
        
        $("#pedidodetalle_totaldtopercent").val(dto_sum.toFixed(2));
        if($('#pedidodetalle_dto_sobretotal').prop('checked')) {
            $("#pedidodetalle_totaldtopercent").val($("#pedidodetalle_totaldtopercent").val() + " + " + parseFloat(dto_adicional,10).toFixed(2));
        }
        $("#pedidodetalle_totaldto").val(pvp_dto.toFixed(2));
        $("#pedidodetalle_pvpdto").val(pvp_dto_aplicado.toFixed(2));
        
        if (data[0].fecha_recepcion != "0000-00-00 00:00:00") {
            var dt = new Date(data[0].fecha_recepcion);
            dt.setHours(dt.getHours() + 1);
            $("#pedidodetalle_fecha_recepcion").val(dt.toJSON().slice(0,19)); 
        }
        $("#pedidodetalle_material_id").val(data[0].material); 
        $("#pedidodetalle_proyectos").val(data[0].proyecto);
        loadSelectTarifas("pedidodetalle_precios","MATERIALES_PRECIOS","id","proveedor_id",$("#pedidos_edit_proveedores").val(),"fecha_val", "material_id", data[0].material, "MATERIALES_PRECIOS.dto_material","","fecha_val");
        setTimeout(function(){
            //$("#pedidodetalle_precios").selectpicker("val", data[0].precioid);
            loadSelectTarifas("pedidodetalle_precios","MATERIALES_PRECIOS","id","proveedor_id",$("#pedidos_edit_proveedores").val(),"fecha_val", "material_id", data[0].material, "MATERIALES_PRECIOS.dto_material","","fecha");
            $("#pedidodetalle_materiales").selectpicker("val", data[0].material);
            $("#pedidodetalle_proyectos").selectpicker("val", data[0].proyecto);
            $("#pedidodetalle_entregas").selectpicker("val", data[0].entregaid);
            $("#pedidodetalle_dtoprov").selectpicker("val", data[0].dto_prov_id);
            $("#pedidodetalle_tecnicos").selectpicker("val", data[0].erp_userid);
            $("#pedidodetalle_clientes").selectpicker("val", data[0].cliente_id);
            $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(data[0].recibido));
            $("#pedidodetalle_ivas").selectpicker("val", data[0].iva_id);
        }, 2000);
    });
}
function loadEnvioDetalleInfo(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/envios/loadEnvioDetalleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        /*
        var pvp = parseFloat((data[0].precio*data[0].unidades).toFixed(2));
        var dto_adicional = parseFloat(data[0].dto_adicional);
        var dto_mat = parseFloat(data[0].dto_material);
        if (data[0].dto_prov != null) {
            dto_prov = parseFloat(data[0].dto_prov);
        }
        else {
            dto_prov = 0;
        }
        var dto_sum = 0;
        var pvp_dto_aplicado = 0;
        var pvp_dto = 0;
        */
        if (data[0].material != null) {
            //alert(data[0].material);
            $("#enviodetalle_detalle_id").val(data[0].detalle);
            //loadSelect("enviodetalle_materiales","MATERIALES","id","categoria_id",data[0].categoria_id,"ref");
            loadSelect("enviodetalle_entregas","ENTREGAS","id","proyecto_id",data[0].proyecto);
            $("#enviodetalle_nombre").val(data[0].nombre); 
            $("#enviodetalle_fabricante").val(data[0].fabricante); 
            $("#enviodetalle_modelo").val(data[0].modelo); 
            $("#enviodetalle_descripcion").val(data[0].descripcion);
            $("#enviodetalle_stock").val(data[0].unidades);
            var opciones="";
            for(var i=0; i<data[0].stock; i++){
                opciones+="<option value='"+(i+1)+"'>"+(i+1)+"</option>";
            }
            $("#enviodetalle_cantidad").html(opciones);
            $("#enviodetalle_cantidad").selectpicker("refresh");
            $("#enviodetalle_cantidad").selectpicker("render");
            //$("#enviodetalle_preciomat").val(data[0].precio);
            $("#enviodetalle_ref").val(data[0].ref);
            //$("#enviodetalle_cantidad").val(data[0].unidades);
            if (data[0].fecha_recepcion != "0000-00-00 00:00:00") {
                var dt = new Date(data[0].fecha_recepcion);
                $("#enviodetalle_fecha_recepcion").val(dt.toJSON().slice(0,19)); 
            }
            else {
                $("#enviodetalle_fecha_recepcion").val(data[0].fecha_recepcion); 
            }

            $("#enviodetalle_material_id").val(data[0].material); 
            $("#enviodetalle_proyectos").val(data[0].proyecto);
            $("#enviodetalle_entregas").val(data[0].entregaid);
            $("#enviodetalle_descnota").val(data[0].descnota);
            $("#enviodetalle_categorias1").selectpicker("val", data[0].categoria_id);
            //$("#enviodetalle_materiales").selectpicker("val", data[0].material);
            //loadSelect("enviodetalle_precios","MATERIALES_PRECIOS","id","proveedor_id",$("#pedidos_edit_proveedores").val(),"fecha_val", "material_id", data[0].material, "MATERIALES_PRECIOS.dto_material");
            setTimeout(function(){
                $("#enviodetalle_materiales").html("<option value='"+data[0].pedido_detalle_id+"'>["+data[0].pedido_genelek+"] - "+data[0].nombre+"</option>"); 
                $("#enviodetalle_materiales").selectpicker("refresh");
                $("#enviodetalle_materiales").selectpicker("render");
                $("#enviodetalle_proyectos").selectpicker("val", data[0].proyecto);
                $("#enviodetalle_entregas").selectpicker("val", data[0].entregaid);
                $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(data[0].entregado));
                $('input[name="edit_chkgarantia"]').bootstrapSwitch('state',parseInt(data[0].garantia));
            }, 1000);
        }
        else {
            $("#enviodetalle_detalle_id").val(data[0].detalle);
            loadSelect("enviodetalle_entregas","ENTREGAS","id","proyecto_id",data[0].proyecto);
            $("#enviodetalle_nombre").val(data[0].nombresn); 
            $("#enviodetalle_fabricante").val(data[0].fabricantesn); 
            $("#enviodetalle_modelo").val(data[0].modelosn); 
            $("#enviodetalle_ref").val(data[0].refsn);
            $("#enviodetalle_sn").selectpicker("val", data[0].sn);
            $("#enviodetalle_categorias1").selectpicker("val", data[0].categoria_id);
            $("#enviodetalle_descnota").val(data[0].descnota);
            //$("#enviodetalle_materiales").selectpicker("val", data[0].material);
            setTimeout(function(){
                $("#enviodetalle_materiales").html("<option value='"+data[0].pedido_detalle_id+"'>["+data[0].pedido_genelek+"] - "+data[0].nombre+"</option>"); 
                $("#enviodetalle_materiales").selectpicker("refresh");
                $("#enviodetalle_materiales").selectpicker("render");
                $("#enviodetalle_proyectos").selectpicker("val", data[0].proyecto);
                $("#enviodetalle_entregas").selectpicker("val", data[0].entregaid);
                $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(data[0].entregado));
                $('input[name="edit_chkgarantia"]').bootstrapSwitch('state',parseInt(data[0].garantia));
            }, 1000);
        }
    });
}
function loadIntDetalleInfo(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/intervenciones/loadIntDetalleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#intdetalle_detalle_id").val(data[0].id); 
        $("#intdetalle_nombre").val(data[0].titulo); 
        var ed = tinymce.editors[0];
        ed.setProgressState(1); // Show progress
        //$("#intdetalle_desc").val(data[0].descripcion); 
        $("#intdetalle_fecha").val(data[0].fecha); 
        //$("#intdetalle_H820").val(data[0].H820);
        //$("#intdetalle_H208").val(data[0].H208);
        //$("#intdetalle_Hviaje").val(data[0].Hviaje);
        //$("#intdetalle_costeH820").val(data[0].coste_H820);
        //$("#intdetalle_costeH208").val(data[0].coste_H208);
        loadSelectTecnicos("intdetalle_tecnicos","INTERVENCIONES_TECNICOS","id","int_id",data[0].int_id);
        setTimeout(function(){
            ed.setProgressState(0); // Hide progress
            ed.setContent(data[0].descripcion);
        }, 2000);
    });
}
function loadPlanDetalleInfo(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/planificacion/loadPlanDetalleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#plandetalle_detalle_id").val(data[0].id); 
        $("#plandetalle_nombre").val(data[0].titulo); 
        $("#plandetalle_desc").val(data[0].descripcion); 
        $("#plandetalle_fecha").val(data[0].fecha); 
        setTimeout(function(){
            $("#plandetalle_tecnicos").selectpicker("val", data[0].erpuser_id);
        }, 2000);
    });
}
function loadActDetalleInfo(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/actividad/loadActDetalleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        var ed = tinymce.editors[0];
        ed.setProgressState(1); // Show progress
        
        $("#actdetalle_detalle_id").val(data[0].id); 
        $("#actdetallehoras_detalle_id").val(data[0].id);
        $("#actdetalle_nombre").val(data[0].nombre); 
        //$("#actdetalle_desc").val(data[0].descripcion); 
        $("#actdetalle_fecha").val(data[0].fecha); 
        setTimeout(function(){
            $("#actdetalle_tecnicos").selectpicker("val", data[0].erpuser_id);
            $("#actdetalle_completado").selectpicker("val", data[0].completado);
            ed.setProgressState(0); // Hide progress
            ed.setContent(data[0].descripcion);
        }, 1000);
        $("#bloque-horas").show();
        loadContent("tabla-horas", "/erp/apps/actividad/vistas/actdetalles-horas.php?det_id=" + $("#actdetalle_detalle_id").val());
    });
}
function loadHorasImputadas(id) {
    console.log("loaddetallee");
    $.getJSON("/erp/apps/proyectos/loadHorasImputadas.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#horas_detalle_id").val(id);
        $("#horas_tareas").val(data[0].tarea_id); 
        $("#horas_horas").val(data[0].tipo_hora_id); // Hay que precargarlo?¿
        $("#horas_titulo").val(data[0].titulo);
        $("#horas_descripcion").val(data[0].descripcion);
        $("#horas_cantidad").val(data[0].cantidad);
        $("#horas_tecnicos").val(data[0].tecnico_id);
        $("#horas_fecha").val(data[0].fecha);
        $(".selectpicker").selectpicker("refresh");
        
//        setTimeout(function(){
//            
//        }, 1000);
    });
}
function loadActTecnico(selectItem,selectItem2,id) {
    console.log("loadactTecnico");
    var items="";
    var items2="";
    $.getJSON("/erp/apps/actividad/loadTecnicosAct.php", 
    {
       id: id 
    },
    function(data) { 
        console.log ("DATA: "+data);
        
        items="<label class='viewTitle '>TÉCNICO/S:</label>";
        items2="<select class='form-control' id='act_edit_addtecnicos' name='act_edit_addtecnicos[]' multiple readonly>";
        $.each(data,function(index,item) 
        {
            items+="<label id='view_titulo'>" + item.nombre + " " + item.apellidos + ", </label>";
            items2+="<option value='"+item.id+"'>" + item.nombre + " " + item.apellidos + " </option>";
        });
        items2+="</select>";
        console.log ("ITEMS2: "+items2);
        
        $("#" + selectItem).html(items); 
        $("#" + selectItem2).html(items2); 
    });
}

function loadPrevisionInfo(id) {
    console.log("loadPrevisionInfo");
    $.getJSON("/erp/apps/previsiones/loadPrevisionInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#prev_id").val(data[0].id); 
        $("#prev_nombre").val(data[0].nombre); 
        $("#prev_descripcion").val(data[0].descripcion); 
        //$("#prev_instalacion").val(data[0].instalacion); 
        //$("#prev_instalacion").selectpicker("val", data[0].instalaciones); 
        loadSelectInstalacionesPrevision("prev_instalacion","CLIENTES_INSTALACIONES","id","prevision_id",data[0].cliente_id,data[0].id);
        $("#prev_fechaini").val(data[0].fecha_ini); 
        $("#prev_fechafin").val(data[0].fecha_fin);
        $("#prev_clientes").selectpicker("val", data[0].cliente_id);
        $("#prev_tipos").selectpicker("val", data[0].tipo_prev);
        $("#prev_estados").selectpicker("val", data[0].estado_id);
        switch (data[0].tipo_prev) {
            case "0":
                break;
            case "1":
                $("#prev_mantenimientos").selectpicker("val", data[0].item);
                $("#prev_mantenimientos").val(data[0].item); 
                break;
            case "2":
                $("#prev_intervenciones").selectpicker("val", data[0].item);
                $("#prev_intervenciones").val(data[0].item); 
                break;
            case "3":
                $("#prev_proyectos").selectpicker("val", data[0].item);
                $("#prev_proyectos").val(data[0].item); 
                break;
            case "4":
                $("#prev_ofertas").selectpicker("val", data[0].item);
                $("#prev_ofertas").val(data[0].item); 
                break;
        }
        loadSelectTecnicosPrevision("prev_addtecnicos","PREVISIONES_TECNICOS","id","prevision_id",data[0].id);
    });
}
function loadPlanInfo(id) {
    $.getJSON("/erp/apps/plantillas/loadPlanInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newplantilla_idplan").val(data[0].id); 
        $("#newplantilla_nombre").val(data[0].nombre); 
        $("#newplantilla_desc").val(data[0].descripcion); 
        $("#newplantilla_REF").val(data[0].ref); 
        setTimeout(function(){
            $("#newplantilla_tipo").selectpicker("val", data[0].tipodoc_id);
        }, 1000);
    });
}
function loadProcInfo(id) {
    $.getJSON("/erp/apps/procedimientos/loadProcInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newprocedimiento_idproc").val(data[0].id); 
        $("#newprocedimiento_nombre").val(data[0].nombre); 
        $("#newprocedimiento_desc").val(data[0].descripcion); 
        $("#newprocedimiento_REF").val(data[0].ref); 
        setTimeout(function(){
            $("#newprocedimiento_tipo").selectpicker("val", data[0].tipodoc_id);
        }, 1000);
    });
}
function loadRegistroInfo(id) {
    $.getJSON("/erp/apps/info/loadRegistroInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newregistro_idreg").val(data[0].id); 
        $("#newregistro_plataforma").val(data[0].plataforma); 
        $("#newregistro_usuario").val(data[0].usuario); 
        $("#newregistro_pass").val(data[0].password); 
        $("#newregistro_desc").val(data[0].descripcion); 
        setTimeout(function(){
            $("#newregistro_empresa").selectpicker("val", data[0].empresa_id);
        }, 1000);
    });
}
function loadRoleInfo(id) {
    $.getJSON("/erp/apps/accesos/loadRoleInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newrole_idrole").val(data[0].id); 
        $("#newrole_nombre").val(data[0].nombre); 
    });
}
function loadUserInfo(id) {
    $.getJSON("/erp/apps/accesos/loadUserInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        var user_onoff ="";
        if(data[0].activo=="on"){
            user_onoff=1;
            $("#newuser_activo").val("checked");
        }else{
            user_onoff=0;
            $("#newuser_activo").val("unchecked");
        }
        $("#newuser_iduser").val(data[0].id); 
        $("#newuser_nombre").val(data[0].nombre); 
        $("#newuser_apellidos").val(data[0].apellidos); 
        $("#newuser_username").val(data[0].user_name); 
        $("#newuser_email").val(data[0].user_email); 
        $("#newuser_tlfno").val(data[0].telefono); 
        $("#newuser_nif").val(data[0].NIF); 
        $("#newuser_firma").val(data[0].firma_path); 
        $("#newuser_txartela").val(data[0].txartela);
        $("#newuser_activo").prop("checked", user_onoff);
        $("#newuser_color").spectrum({
            color: data[0].color
        });
        $("#newuser_avatar_img").prop("src", data[0].avatar);
        setTimeout(function(){
            $("#newuser_roles").selectpicker("val", data[0].role_id);
            $("#newuser_empresas").selectpicker("val", data[0].empresa_id);
        }, 1000);
    });
}
function loadDocInfo(id) {
    $.getJSON("/erp/apps/documentacion/loadDocInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newdoc_iddoc").val(data[0].id); 
        $("#newdoc_nombre").val(data[0].nombre); 
        $("#newdoc_desc").val(data[0].descripcion); 
        $("#newdoc_REF").val(data[0].ref); 
        setTimeout(function(){
            $("#newdoc_tipo").selectpicker("val", data[0].tipodoc_id);
        }, 1000);
    });
}
function loadADMONInfo(id) {
    $.getJSON("/erp/apps/prevencion/loadADMONInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newdocADMON_id").val(data[0].id); 
        $("#newdocADMON_nombre").val(data[0].nombre); 
        $("#newdocADMON_desc").val(data[0].descripcion); 
        setTimeout(function(){
            $("#newdocADMON_organismo").selectpicker("val", data[0].org_id);
            $("#newdocADMON_periodicidades").selectpicker("val", data[0].periodicidad_id);
            $("#newdocADMON_empresas").selectpicker("val", data[0].empresa_id);
        }, 1000);
    });
}
function loadPRLInfo(id) {
    $.getJSON("/erp/apps/prevencion/loadPRLInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newdocPRL_id").val(data[0].id); 
        $("#newdocPRL_nombre").val(data[0].nombre); 
        $("#newdocPRL_desc").val(data[0].descripcion); 
        setTimeout(function(){
            $("#newdocPRL_organismo").selectpicker("val", data[0].org_id);
            $("#newdocPRL_periodicidades").selectpicker("val", data[0].periodicidad_id);
            $("#newdocPRL_empresas").selectpicker("val", data[0].empresa_id);
        }, 1000);
    });
}
function loadPERInfo(id) {
    $.getJSON("/erp/apps/prevencion/loadPERInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newdocPER_id").val(data[0].id); 
        $("#newdocPER_nombre").val(data[0].nombre); 
        $("#newdocPER_desc").val(data[0].descripcion); 
        setTimeout(function(){
            $("#newdocPER_organismo").selectpicker("val", data[0].org_id);
            $("#newdocPER_periodicidades").selectpicker("val", data[0].periodicidad_id);
            $("#newdocPER_empresas").selectpicker("val", data[0].empresa_id);
            $("#newdocPER_trabajadores").selectpicker("val", data[0].erpuser_id);
        }, 1000);
    });
}
function loadCLIInfo(id) {
    $.getJSON("/erp/apps/prevencion/loadCLIInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newdocCLI_id").val(data[0].id); 
        $("#newdocCLI_nombre").val(data[0].nombre); 
        $("#newdocCLI_desc").val(data[0].descripcion); 
        setTimeout(function(){
            $("#newdocCLI_organismo").selectpicker("val", data[0].org_id);
            $("#newdocCLI_periodicidades").selectpicker("val", data[0].periodicidad_id);
            $("#newdocCLI_clienteid").selectpicker("val", data[0].cliente_id);
        }, 1000);
    });
}

function loadPCinfo(id) {
    $.getJSON("/erp/apps/equipos/loadPCinfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newPC_idpc").val(data[0].id); 
        $("#newPC_hostname").val(data[0].hostname); 
        $("#newPC_descripcion").val(data[0].descripcion); 
        $("#newPC_fecha_ini").val(data[0].fecha_inicio); 
        $("#newPC_tecnicos").val(data[0].erpuser_id); 
        $("#newPC_proyectos").val(data[0].proyecto_id); 
        setTimeout(function(){
            $("#newPC_tecnicos").selectpicker("val", data[0].erpuser_id);
            $("#newPC_proyectos").selectpicker("val", data[0].proyecto_id);
            $("#newPC_estados").selectpicker("val", data[0].estado_id);
        }, 1000);
    });
}
function loadContratistaPlataformaInfo(id) {
    $.getJSON("/erp/apps/prevencion/loadContratistaPlataformaInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newcontratistas-plataformas-id").val(data[0].id); 
        $("#newcontratistas-plataformas_instalacion").val(data[0].instalacion); 
        $("#newcontratistas-plataformas_url").val(data[0].url); 
        $("#newcontratistas-plataformas_usuario").val(data[0].user); 
        $("#newcontratistas-plataformas_pass").val(data[0].pass);
    });
}
function loadSelectTecnicosPrevision(selectItem, tabla, campo, campowhere, valor) {
    //alert(selectItem);
    var items="";
    var selectItem = selectItem;
    $.getJSON("/erp/loadSelectTecnicosPrevision.php", 
    {
       tabla: tabla,
       campo: campo,
       campoWhere: campowhere,
       valor: valor
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            items+="<option value='"+item.id+"'>" + item.nombre + " " + item.apellidos + "</option>";
        });
        $("#" + selectItem).html(items); 
    });
}
function loadSelectInstalacionesPrevision(selectItem, tabla, campo, campowhere, valor, valor2) {
    //alert(selectItem);
    var items="";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/previsiones/loadSelectInstalacionesPrevision.php", 
    {
       tabla: tabla,
       campo: campo,
       campoWhere: campowhere,
       valor: valor,
       valor2: valor2
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            items+="<option value='"+item.id+"'>" + item.nombre + "</option>";
        });
        $("#" + selectItem).html(items).selectpicker('refresh'); 
    });
}
function loadSelectTecnicos(selectItem, tabla, campo, campowhere, valor) {
    //alert(selectItem);
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/erp/apps/intervenciones/loadSelectTecnicos.php", 
    {
       tabla: tabla,
       campo: campo,
       campoWhere: campowhere,
       valor: valor
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            items+="<option value='"+item.id+"'>" + item.nombre + " " + item.apellidos + "</option>";
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadCuadroHoras(tecnicoId, intDetalleId) {
    $.getJSON("/erp/apps/intervenciones/loadCuadroHoras.php", 
    {
       tecnico_id: tecnicoId,
       intdetalle_id: intDetalleId
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        if (data != "") {
            $("#intdetalle_H820").val(data[0].H820); 
            $("#intdetalle_H208").val(data[0].H208);
            $("#intdetalle_Hviaje").val(data[0].Hviaje);
            $("#intdetalle_costeH820").val(data[0].coste_H820);
            $("#intdetalle_costeH208").val(data[0].coste_H208);
        }
        else {
            $("#intdetalle_H820").val("0"); 
            $("#intdetalle_H208").val("0");
            $("#intdetalle_Hviaje").val("0");
            $("#intdetalle_costeH820").val("0");
            $("#intdetalle_costeH208").val("0");
        }
        $("#intdetalle_horas").val("1");
        $("#cuadro-horas").show("slow");
    });
}

function loadContratista(id) {
    $.getJSON("/erp/apps/prevencion/loadContratista.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $("#view_direccion").html(data[0].direccion);
        $("#view_telefono").html(data[0].telefono);
        $("#view_email").html(data[0].email);
        $("#view_contacto").html(data[0].contacto);
        $("#view_urlprl").html("<a href='" + data[0].URL_PRL + "' target='contratista_plataforma'>" + data[0].URL_PRL + "</a>");
        $("#view_userprl").html(data[0].URL_PRL_U);
        $("#view_pwdprl").html(data[0].URL_PRL_P);
        $("#newdocCLI_clienteid").val(data[0].id);
    });
}
function loadContactoCliente(id) {
    $.getJSON("/erp/apps/prevencion/loadContactoCliente.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $("#newcontactoCLI_id").val(data[0].cliente_id);
        $("#newcontactoCLI_nombre").val(data[0].nombre);
        $("#newcontactoCLI_mail").val(data[0].mail);
        $("#newcontactoCLI_telefono").val(data[0].telefono);
        $("#newcontactoCLI_desc").val(data[0].descripcion);
        //console.log("data[0].instalacion_cliente_id666: "+data[0].instalacion_cliente_id);
        $("#newcontactoCLI_instalacion").val(data[0].instalacion_cliente_id);
        $('#newcontactoCLI_instalacion').selectpicker('render');
        //console.log("data[0].activo: "+data[0].activo);
        if(data[0].activo=="on"){
            contacto_activo=1;
            $('input[name="newcontactoCLI_activo"]').bootstrapSwitch('state',parseInt(contacto_activo));
            //$("#newcontactoCLI_activo").val("checked");
        }else{
            contacto_activo=0;
            $('input[name="newcontactoCLI_activo"]').bootstrapSwitch('state',parseInt(contacto_activo));
            //$("#newcontactoCLI_activo").val("unchecked");
        }
        //console.log("data[0].activo: "+data[0].activo);
        //console.log("contacto_activo: "+contacto_activo);
        $("#newcontactoCLI_activo").prop("checked", contacto_activo);
    });
}

function loadPerfilInfo(id) {
    $.getJSON("/erp/apps/parametros/loadPerfilInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newperfil_id").val(data[0].id); 
        $("#newperfil_nombre").val(data[0].nombre); 
    });
}
function loadCategoriaInfo(id) {
    $.getJSON("/erp/apps/parametros/loadCatInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newCat_id").val(data[0].id); 
        $("#newCat_nombre").val(data[0].nombre); 
    });
}
function loadTipoHoraInfo(id) {
    $.getJSON("/erp/apps/parametros/loadTipoHoraInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newtipohora_id").val(data[0].id); 
        $("#newtipohora_nombre").val(data[0].nombre); 
    });
}
function loadTareaInfo(id) {
    $.getJSON("/erp/apps/parametros/loadTareaInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newtarea_id").val(data[0].id); 
        $("#newtarea_nombre").val(data[0].nombre); 
        $("#newtarea_desc").val(data[0].descripcion);
        setTimeout(function(){
            $("#newtarea_perfil").selectpicker("val", data[0].perfil_id);
        }, 1000);
    });
}
function loadHoraInfo(id) {
    $.getJSON("/erp/apps/parametros/loadHoraInfo.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        $("#newhora_id").val(data[0].id); 
        $("#newhora_nombre").val(data[0].nombre); 
        $("#newhora_tarifa").val(data[0].precio);
        $("#newhora_coste").val(data[0].precio_coste);
        setTimeout(function(){
            $("#newhora_perfil").selectpicker("val", data[0].perfil_id);
            $("#newhora_tipo").selectpicker("val", data[0].tipo_id);
        }, 1000);
    });
}

function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}

function loadDetalleAcceso(id) {
    console.log("loadDetalleAcceso");
    $.getJSON("/erp/apps/jornada/loadDetalleAcceso.php", 
    {
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
        var timeentrada = new Date(data[0].hora_entrada);
        var h_entrada = timeentrada.getHours();
        var m_entrada = timeentrada.getMinutes(); 
        var timesalida = new Date(data[0].hora_salida);
        var h_salida = timesalida.getHours();
        var m_salida = timesalida.getMinutes();  
        $("#editacceso_id").val(data[0].id);
        $("#editacceso_idjornada").val(data[0].jornadaid);
        $("#editacceso_dia").val(data[0].fecha);
        $("#editacceso_horaentrada").val(pad(h_entrada) + ":" + pad(m_entrada));
        $("#editacceso_horasalida").val(pad(h_salida) + ":" + pad(m_salida));
        setTimeout(function(){
            $("#editacceso_tipohora").selectpicker("val", data[0].tipo_horas);
        }, 1000);
    });
}
function loadMaterialesStock(area,material) {
    $.getJSON("/erp/apps/material/loadMaterialesStock.php", 
    {
       id: material
    },function(data) {
        $("#"+area).val(data[0].suma_stock);
    });
}
function loadPedidoMaterialInfo(id,tabla, proveedor_id) {
    $.getJSON("/erp/apps/material/loadMaterialesMaterialInfo.php", 
    {
       tabla: tabla,
       id: id,
       proveedor_id: proveedor_id
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
               
        $("#pedidodetalle_material_id").val(data[0].material); 
        $("#pedidodetalle_ref").val(data[0].ref); 
        $("#pedidodetalle_nombre").val(data[0].nombre); 
        $("#pedidodetalle_fabricante").val(data[0].fabricante); 
        $("#pedidodetalle_modelo").val(data[0].modelo); 
        $("#pedidodetalle_dtomat").val(data[0].DTO2); 
        $("#pedidodetalle_stock").val(data[0].stock); 
        $("#pedidodetalle_descripcion").val(data[0].descripcion);
        $("#pedidodetalle_cantidad").val(data[0].cantidad);
        $("#pedidodetalle_preciomat").val(data[0].precio);
        
    });
}
function loadProyectoMaterialInfo(id,tabla) {
    $.getJSON("/erp/apps/proyectos/loadProyectoMaterialInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
               
        $("#pedidodetalle_material_id").val(data[0].material); 
        $("#pedidodetalle_nombre").val(data[0].nombre); 
        $("#pedidodetalle_nombre_fabricante").val(data[0].fabricante); 
        $("#pedidodetalle_modelo").val(data[0].modelo); 
        $("#pedidodetalle_dto").val(data[0].DTO2); 
        $("#pedidodetalle_stock").val(data[0].stock); 
        $("#pedidodetalle_descripcion").val(data[0].descripcion);
        $("#pedidodetalle_cantidad").val(data[0].cantidad);
        $("#pedidodetalle_preciomat").val(data[0].precio);
    });
}

function loadMaterialesMaterialInfo(id,tabla,proveedor_id) {
    $.getJSON("/erp/apps/material/loadMaterialesMaterialInfo.php", 
    {
       tabla: tabla,
       id: id,
       proveedor_id: proveedor_id
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
               
        $("#newmaterial_idmaterial").val(data[0].material); 
        $("#newmaterial_ref").val(data[0].ref); 
        $("#newmaterial_nombre").val(data[0].nombre); 
        $("#newmaterial_fabricante").val(data[0].fabricante); 
        $("#newmaterial_modelo").val(data[0].modelo); 
        $("#newmaterial_dto").val(data[0].DTO2); 
        $("#newmaterial_stock").val(data[0].stock); 
        $("#newmaterial_desc").val(data[0].descripcion);
        $("#newmaterial_lastprice").val(data[0].precio);
        $("#newmaterial_sustituto").val(data[0].sustituto);
    });
}
function loadEnvioMaterialInfo(id,tabla, proveedor_id) {
    $.getJSON("/erp/apps/envios/loadMaterialesMaterialInfo.php", 
    {
       tabla: tabla,
       id: id,
       proveedor_id: proveedor_id
    },
    function(data) { 
        console.log (data);
        //obj = JSON.parse(data);
               
        $("#enviodetalle_material_id").val(data[0].material); 
        $("#enviodetalle_nombre").val(data[0].nombre); 
        $("#enviodetalle_fabricante").val(data[0].fabricante); 
        $("#enviodetalle_modelo").val(data[0].modelo); 
        $("#enviodetalle_dtomat").val(data[0].DTO2); 
        $("#enviodetalle_stock").val(data[0].stock); 
        $("#enviodetalle_descripcion").val(data[0].descripcion);
        $("#enviodetalle_cantidad").val(data[0].cantidad);
        
        var picker = "";
        for(var i=0; i<data[0].stock; i++){
            picker += "<option value='"+(i+1)+"'>"+(i+1)+"</option>";
        }
        //$("#enviodetalle_cantidad").val(data[0].stock);
        
        
        $("#enviodetalle_cantidad").html(picker); 
        $("#enviodetalle_cantidad").selectpicker("refresh");
        $("#enviodetalle_cantidad").selectpicker("render");
        
    });
}

function loadProyectosClientes(id) {
    $.getJSON("/erp/apps/proyectos/loadProyectosClientes.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
        $("#newcliente_idcliente").val(data[0].id); 
        $("#newcliente_nombre").val(data[0].nombre); 
        $("#newcliente_direccion").val(data[0].direccion); 
        $("#newcliente_poblacion").val(data[0].poblacion); 
        $("#newcliente_provincia").val(data[0].provincia); 
        $("#newcliente_cp").val(data[0].cp); 
        $("#newcliente_pais").val(data[0].pais); 
        $("#newcliente_telefono").val(data[0].telefono);
        $("#newcliente_nif").val(data[0].nif);
        $("#newcliente_web").val(data[0].web);
        $("#newcliente_email").val(data[0].email);
        $("#newcliente_contacto").val(data[0].contacto);
        $("#newcliente_urlPRL").val(data[0].URL_PRL);
        $("#newcliente_urlPRL_U").val(data[0].URL_PRL_U);
        $("#newcliente_urlPRL_P").val(data[0].URL_PRL_P);
        $("#newcliente_imgprview").attr("src",data[0].img);
        $("#newcliente_imgprview").show();
    });
}

function loadProveedorInfo(id,tabla) {
    $.getJSON("/erp/apps/material/loadProveedorInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
               
        $("#newproveedor_idproveedor").val(data[0].id); 
        $("#newproveedor_nombre").val(data[0].nombre); 
        $("#newproveedor_CIF").val(data[0].CIF); 
        $("#newproveedor_direccion").val(data[0].direccion); 
        $("#newproveedor_poblacion").val(data[0].poblacion);
        $("#newproveedor_provincia").val(data[0].provincia);
        $("#newproveedor_contacto").val(data[0].contacto);
        $("#newproveedor_cp").val(data[0].cp);
        $("#newproveedor_pais").val(data[0].pais);
        $("#newproveedor_telefono").val(data[0].telefono);
        $("#newproveedor_email").val(data[0].email);
        $("#newproveedor_contacto").val(data[0].contacto);
        $("#newproveedor_formapago").val(data[0].formaPago);
        $("#newproveedor_email_pedidos").val(data[0].email_pedidos);
        $("#newproveedor_web").val(data[0].web);
        $("#newproveedor_dto").val(data[0].dto);
        $("#newproveedor_desc").val(data[0].descripcion);
        $("#newproveedor_fecha_aprobación").val(data[0].fecha_aprob);
        $("#newproveedor_urlPLAT").val(data[0].plataforma);
        $("#newproveedor_urlPLAT_U").val(data[0].usuario);
        $("#newproveedor_urlPLAT_P").val(data[0].password);
        setTimeout(function(){
            $('input[name="newproveedor_chkhomo"]').bootstrapSwitch('state',parseInt(data[0].homologado));
        }, 1000);
    });
}
function loadAuditorInfo(id,tabla) {
    $.getJSON("/erp/apps/empresas/loadAuditorInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
               
        $("#newauditor_idauditor").val(data[0].id); 
        $("#newauditor_nombre").val(data[0].nombre); 
        $("#newauditor_CIF").val(data[0].CIF); 
        $("#newauditor_direccion").val(data[0].direccion); 
        $("#newauditor_poblacion").val(data[0].poblacion);
        $("#newauditor_provincia").val(data[0].provincia);
        $("#newauditor_contacto").val(data[0].contacto);
        $("#newauditor_cp").val(data[0].cp);
        $("#newauditor_pais").val(data[0].pais);
        $("#newauditor_telefono").val(data[0].telefono);
        $("#newauditor_email").val(data[0].email);
        $("#newauditor_fax").val(data[0].fax);
        $("#newauditor_contacto").val(data[0].contacto);
        $("#newauditor_web").val(data[0].web);
        $("#newauditor_desc").val(data[0].descripcion);
        $("#newauditor_fecha_aprobación").val(data[0].fecha_aprob);
        $("#newauditor_urlPLAT").val(data[0].plataforma);
        $("#newauditor_urlPLAT_U").val(data[0].usuario);
        $("#newauditor_urlPLAT_P").val(data[0].password);
        setTimeout(function(){
            $('input[name="newauditor_chkhomo"]').bootstrapSwitch('state',parseInt(data[0].homologado));
        }, 1000);
    });
}
function loadLicInfo(id,tabla) {
    $.getJSON("/erp/apps/licencias/loadLicInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
               
        $("#newlicencia_idlic").val(data[0].id); 
        $("#newlicencia_nombre").val(data[0].nombre); 
        $("#newlicencia_ubicacion").val(data[0].ubicacion); 
        $("#newlicencia_users").selectpicker("val", data[0].user_id);
        $("#newlicencia_proyectos").selectpicker("val", data[0].proyecto_id);
        $("#newlicencia_fecha").val(data[0].fecha); 
        $("#newlicencia_activada").bootstrapSwitch("state",parseInt(data[0].activada));
    });
}

function loadGruposDocInfo(id,tabla) {
    $.getJSON("/erp/apps/proyectos/loadGruposDocInfo.php", 
    {
       tabla: tabla,
       id: id 
    },
    function(data) { 
        //console.log (data);
        //obj = JSON.parse(data);
               
        $("#gruposdoc_idgrupo").val(data[0].id); 
        $("#proyecto_gruposdocnombre").val(data[0].nombre); 
        $("#proyecto_gruposdocdesc").val(data[0].descripcion); 
    });
}

function loadDetallesPedido(id) {
    $.getJSON("/erp/apps/material/loadDetallesPedido.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#editpedido_id").val(data[0].detalle);
        $("#editpedido_ref").val(data[0].ref); 
        $("#editpedido_titulo").val(data[0].titulo);
        $("#editpedido_desc").val(data[0].descripcion);
        $("#editpedido_proyectos").val(data[0].proyecto_id);
        $("#editpedido_proyectos").selectpicker("refresh");
        $("#editpedido_proveedores").val(data[0].proveedor_id);
        $("#editpedido_proveedores").selectpicker("refresh");
        $("#editpedido_fecha").val(data[0].fecha);
        $("#editpedido_formapago").val(data[0].forma_pago);
        $("#editpedido_contacto").val(data[0].contacto);
    });
}

function loadEnsayo(id) {
    $.getJSON("/erp/apps/entregas/loadEnsayo.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#newensayo_identrega").val(data[0].entregaid);
        $("#newensayo_idensayo").val(data[0].ensayoid); 
        $("#newensayo_nombre").val(data[0].ensayonombre);
        $("#newensayo_fecha").val(data[0].fecha);
        $("#newensayo_fechafin").val(data[0].fecha_finalizacion);
        $("#newensayo_tecnico").val(data[0].tecnico);
        $("#newensayo_tecnico").selectpicker("refresh");
        $("#newensayo_plantilla").val(data[0].plantilla_id);
        $("#newensayo_plantilla").selectpicker("refresh");
        $("#newensayo_estados").val(data[0].estado_id);
        $("#newensayo_estados").selectpicker("refresh");
        $("#newensayo_desc").val(data[0].descripcion);
        $("#newensayo_adjunto_previo").html(data[0].adjunto);
        
        // Carga INFO ENSAYO
        $.post( "infoEnsayo.php", 
            { 
                plantilla_id: data[0].plantilla_id,
                ensayo_id: data[0].ensayoid
            })
            .done(function( data ) {
                $("#info-ensayo").html(data);
        });
        
    });
}
function loadEnsayoInfo(id) {
    $.getJSON("/erp/apps/entregas/loadEnsayoInfo.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        $("#newensayoinfo_titulo").val(data[0].titulo);
        $("#newensayoinfo_desc").val(data[0].descripcion); 
        $("#newensayoinfo_estado").val(data[0].estado);
        $("#newensayoinfo_fecha").val(data[0].fecha);
        
        // Carga INFO ENSAYO
//        $.post( "infoEnsayo.php", 
//            { 
//                plantilla_id: data[0].plantilla_id,
//                ensayo_id: data[0].ensayoid
//            })
//            .done(function( data ) {
//                $("#info-ensayo").html(data);
//        });
        
    });
}
function loadEnsayoArchivos(selectItem,id) {
    var items="";
    var boton="";
    var link='';
    $.getJSON("/erp/apps/entregas/loadEnsayoArchivos.php", 
    {
       id: id 
    },
    function(data) { 
        //console.log (data[0].tipohora);
        //obj = JSON.parse(data);
        items='<table class="table table-striped table-hover" id="tabla-ensayos"><thead><tr class="bg-dark"><th>FICHERO</th><th class="text-center">E</th></tr></thead><tbody>';
        $.each(data,function(index,item) 
        {
            boton='<button type="button" class="btn btn-circle btn-danger remove-ensayo-doc" data-id="'+item.id+'" title="Eliminar Archivo Ensayo"><img src="/erp/img/cross.png"></button>';
            link='<a href="////192.168.3.108/'+item.path+'" target="_blank">'+item.nombre+'</a>';
            items+="<tr data-id='"+item.id+"'><td class='text-left'>"+link+"</td><td class='text-center'>"+boton+"</td></tr>";
        });
        items+="</tbody></table>";
        $("#" + selectItem).html(items); 
    });
}
function loadSistemaCalidad(id) {
    $.getJSON("/erp/apps/calidad/loadSistemaCalidad.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        if(data[0].habilitado=="on"){
            calidad_habilitado=1;
            $("#calidad_sistema_habilitado").val("checked");
        }else{
            calidad_habilitado=0;
            $("#calidad_sistema_habilitado").val("unchecked");
        }
        $("#calidad_sistema_nombre").val(data[0].nombre); 
        $("#calidad_sistema_organismo").selectpicker("val", data[0].organismo_id);
        $("#calidad_sistema_habilitado").prop("checked", calidad_habilitado);
    });
}
function loadProcesoDetalle(id) {
    $.getJSON("/erp/apps/calidad/loadProcesoDetalle.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#proceso_id").val(data[0].id);
        $("#proceso_nombre").val(data[0].nombre); 
        $("#proceso_resp").val(data[0].responsable);
        $("#proceso_year").val(data[0].year);
        $("#proceso_dptos").val(data[0].dptos);
        $("#proceso_objeto").val(data[0].objeto);
        $("#proceso_recursos").val(data[0].recursos);
        $("#proceso_entradas").val(data[0].entradas);
        $("#proceso_salidas").val(data[0].salidas);
        $("#proceso_registros").val(data[0].registros);
        $("#proceso_procedimientos").val(data[0].procedimientos);
        $("#proceso_actividades").val(data[0].actividades);
        
    });
}

function loadIndicadorDetalle(id) {
    $.getJSON("/erp/apps/calidad/loadIndicadorDetalle.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#indicador_id").val(data[0].id);
        $("#indicador_proceso_id").val(data[0].proceso_id);
        $("#indicador_proceso_id").selectpicker("refresh");
        $("#indicador_nombre").val(data[0].nombre);
        $("#indicador_meta").val(data[0].meta);
        $("#indicador_objetivo").val(data[0].objetivo);
        $("#indicador_calculo").val(data[0].calculo);
        $("#indicador_valor").val(data[0].valor);
        $("#indicador_tienehijos").val(data[0].tienehijos);
        var porcentaje_real = ((data[0].aceptados*100)/data[0].num_ofertas_total);
        // console.log(porcentaje_real+"|"+data[0].valor);
        if(parseFloat(porcentaje_real)>=parseFloat(data[0].valor)){
            // ok
            // console.log("En OK"+parseFloat(porcentaje_real)+"|"+parseFloat(data[0].valor));
            $("#indicador_resultado_div").html("<label class='labelBefore'>Resultado:</label><span class='label label-success'>OK</span>");
        }else{
            // nook
            // console.log("En NO-OK"+parseFloat(porcentaje_real)+"|"+parseFloat(data[0].valor));
            $("#indicador_resultado_div").html("<label class='labelBefore'>Resultado:</label><span class='label label-danger'>NO-OK</span>");
        }
        
    });
}
function loadActasDetalle(id) {
    $.getJSON("/erp/apps/calidad/loadActasDetalle.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#addActa_id").val(data[0].id);
        $("#addActa_nombre").val(data[0].nombre);
        $("#addActa_descripcion").val(data[0].descripcion);
        $("#addActa_fecha").val(data[0].fecha); 
    });
}
function loadCalibraciones(id) {
    $.getJSON("/erp/apps/calidad/loadCalibraciones.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        //alert("DATO: "+data[0].activo);
        if(data[0].activo=="on"){
            calidad_activo=1;
            //alert("ON");
            $("#addCalibraciones_activado").val("checked");
        }else{
            calidad_activo=0;
            //alert("OFF");
            $("#addCalibraciones_activado").val("unchecked");
        }
        
        $("#addCalibraciones_id").val(data[0].id);
        $("#addCalibraciones_equipo").val(data[0].equipo);
        $("#addCalibraciones_numserie").val(data[0].num_serie);
        $("#addCalibraciones_tecnico").selectpicker("val", data[0].tecnico_id);
        $("#addCalibraciones_labor").val(data[0].labor);
        $("#addCalibraciones_periodo").val(data[0].periodo);
        $("#addCalibraciones_proced").val(data[0].proced);
        $("#addCalibraciones_lastcalibracion").val(data[0].ult_cali);
        $("#addCalibraciones_nextcalibracion").val(data[0].next_cali);
        //$("#addCalibraciones_activado").val(data[0].activo);
        $("#addCalibraciones_activado").prop("checked", calidad_activo);
    });
}
function loadFormacion(id) {
    $.getJSON("/erp/apps/calidad/loadFormacion.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#addFormacion_id").val(data[0].id);
        $("#addFormacion_nombre").val(data[0].nombre);
        $("#addFormacion_descripcion").val(data[0].descripcion);
        $("#addFormacion_fecha").val(data[0].fecha);
    });
}
function loadFormacionDetalle(id) {
    $.getJSON("/erp/apps/calidad/loadFormacionDetalle.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#addFormacionDetalle_id").val(data[0].id);
        $("#addFormacionDetalle_nombre").val(data[0].nombre);
        $("#addFormacionDetalle_descripcion").val(data[0].descripcion);
        $("#addFormacionDetalle_fecha").val(data[0].fecha); 
    });
}
function loadConformidadDetalle(id) {
    $.getJSON("/erp/apps/calidad/loadConformidadDetalle.php", 
    {
       id: id 
    },
    function(data) { 
        //obj = JSON.parse(data);
        $("#conformidad_id").val(data[0].id);
        $("#conformidad_nombre").val(data[0].ref); 
        $("#conformidad_detectado1").selectpicker("val", data[0].detectado_por);
        detectado="";
        switch (data[0].detectado_por){
            case "genelek":
                detectado="conformidad_detectado_genelek";
                break;
            case"cliente":
                detectado="conformidad_detectado_cliente";
                break;
            case "proveedor":
                detectado="conformidad_detectado_proveedor";
                break;
            case "auditor":
                detectado="conformidad_detectado_auditor";
                break;
        }
        $("#conformidad_detectado_genelek").selectpicker('hide');
        $("#conformidad_detectado_cliente").selectpicker('hide');
        $("#conformidad_detectado_proveedor").selectpicker('hide');
        $("#"+detectado).selectpicker("val", data[0].detectado);
        $("#"+detectado).selectpicker('show');
        $("#conformidad_proyectos").selectpicker("val", data[0].proyecto_id);
        $("#conformidad_fecha").val(data[0].fecha);
        $("#conformidad_desc").val(data[0].descripcion);
        $("#conformidad_resolucion").val(data[0].resolucion);
        $("#conformidad_causa").val(data[0].causa);
        $("#conformidad_cierre").val(data[0].cierre);
        $("#conformidad_fecha_cierre").val(data[0].fecha_cierre);
    });
}
function loadSelectAccesosProyectos(clienteid) {
    var selectItem = "editclient_proyectosacceso";
    var items= "";
    //alert(clienteid);
    $.getJSON("loadSelectAccesosProyectos.php", 
    {
       cliente: clienteid
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            if (item.escritura === "0") {
                items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            }
            else {
                items+="<option style='background-color: #45ddc3 !important; color: #ffffff !important;' value='"+item.id+"'>"+item.nombre+"</option>";
            }
        });
        $("#" + selectItem).html(items); 
    });
}

function loadSelectAccesosProyectosWeroi(userid) {
    var selectItem = "edit_proyectosacceso";
    var items= "";
    //alert(clienteid);
    $.getJSON("loadSelectAccesosProyectosWeroi.php", 
    {
       user: userid
    },
    function(data) { 
       //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            if (item.escritura === "0") {
                items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            }
            else {
                items+="<option style='background-color: #45ddc3 !important; color: #ffffff !important;' value='"+item.id+"'>"+item.nombre+"</option>";
            }
        });
        $("#" + selectItem).html(items); 
    });
}

function loadClientes(id,tabla) {
    //alert(id);
    //alert(tabla);
    $.getJSON("loadClientes.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        $("#crmclientes_edit_nombre").val(data[0].nombre);
        $("#crmclientes_edit_email").val(data[0].user_email);
        $("#crmclientes_edit_user").val(data[0].user_username);
        $("#crmclientes_edit_password").val(data[0].user_password);
    });
}

function loadComerciales(id,tabla,origen) {
    //alert(id);
    //alert(tabla);
    var origen = origen;
    $.getJSON("loadComerciales.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        //alert(origen);
        switch (origen) {
            case "edit":
                $("#edit_nombreComercial").val(data[0].nombre);
                $("#edit_tlfnoComercial").val(data[0].email);
                $("#edit_emailComercial").val(data[0].tlfno);
                break;
            case "new":
                $("#new_nombreComercial").val(data[0].nombre);
                $("#new_tlfnoComercial").val(data[0].tlfno);
                $("#new_emailComercial").val(data[0].email);
                break;
            case "ind":
                $("#crmcomerciales_edit_nombre").val(data[0].nombre);
                $("#crmcomerciales_edit_tlfno").val(data[0].tlfno);
                $("#crmcomerciales_edit_email").val(data[0].email);
                $('#crmcomerciales_clientes').selectpicker('val', data[0].cliente_id);
                break;
            
        }
    });
}

function loadEmpresas(id,tabla,origen) {
    //alert(id);
    //alert(tabla);
    var origen = origen;
    $.getJSON("loadEmpresas.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        //alert(origen);
        if (origen === "edit") {
            $("#edit_nombreEmpresa").val(data[0].nombre);
            $("#edit_tlfnoEmpresa").val(data[0].telefono);
            $("#edit_webEmpresa").val(data[0].web);
            $("#edit_sectorEmpresa").val(data[0].sector);
            $("#edit_paisEmpresa").val(data[0].pais);
            $("#edit_ciudadEmpresa").val(data[0].ciudad);
            $("#edit_descripcionEmpresa").val(data[0].descripcion);
        }
        else {
            $("#new_nombreEmpresa").val(data[0].nombre);
            $("#new_tlfnoEmpresa").val(data[0].telefono);
            $("#new_webEmpresa").val(data[0].web);
            $("#new_sectorEmpresa").val(data[0].sector);
            $("#new_paisEmpresa").val(data[0].pais);
            $("#new_ciudadEmpresa").val(data[0].ciudad);
            $("#new_descripcionEmpresa").val(data[0].descripcion);
        };
    });
}

function loadCampanas(id,tabla) {
    //alert(id);
    //alert(tabla);
    $.getJSON("loadCampanas.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        $('#crmcampanas_proyectos').selectpicker('val', data[0].proyecto_id);
        $("#crmcampanas_edit_nombre").val(data[0].nombre);
        $("#crmcampanas_edit_desc").val(data[0].descripcion);
    });
}

function loadProyectos(id,tabla) {
    //alert(id);
    //alert(tabla);
    $.getJSON("loadProyectos.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        $("#crmproyectos_edit_nombre").val(data[0].nombre);
        $("#crmproyectos_edit_desc").val(data[0].descripcion);
        $('#crmproyectos_clientes').selectpicker('val', data[0].cliente_id);
    });
}

function loadSoloNombre(id,tabla) {
    //alert(id);
    //alert(tabla);
    $.getJSON("loadSoloNombre.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        switch(tabla) {
            case "PROVEEDORES":
                $("#ofertasub_nombreprov").val(data[0].nombre);
                break;
            default:
        }
        
    });
}

function loadRoles(id,tabla) {
    //alert(id);
    //alert(tabla);
    $("*[data-id]").removeClass("appSelected");
    $.getJSON("loadRoles.php", 
    {
       tabla: tabla,
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        data.forEach(
            function (value) { 
                $("#" + value.nombre_html).val(value.appid); 
                $('[data-id="' + value.appid + '"]').addClass("appSelected");
            }
        );
        
        
    });
}

function asignarProyecto(proyectoid, clienteid, accion, escritura) {
    if (proyectoid === 0) {
        $("#errorMessageClientes").html("Selecciona un proyecto");
        $("#alertProyectosClientes").slideDown();
    }
    else {
        $.post( "asignarProyecto.php", 
            { 
                proyecto_id: proyectoid,
                cliente_id: clienteid,
                accion: accion,
                escritura: escritura
            })
            .done(function( data ) {
                //alert( "Data Loaded: " + data );
                if (data === "ok") {
                    loadSelectAccesosProyectos(clienteid);
                    $("#asignar-proyecto").prop("disabled", true);
                    $("#desasignar-proyecto").prop("disabled", true);
                    $('input[name="chkescritura"]').bootstrapSwitch('state', false, true);
                }
                else {
                    $("#errorMessageClientes").html(data);
                    $("#alertProyectosClientes").slideDown();
                }
        });
    }
};

function asignarProyectoWeroi(proyectoid, userid, accion, escritura) {
    if (proyectoid === 0) {
        $("#errorMessageWeroi").html("Selecciona un proyecto");
        $("#alertProyectosWeroi").slideDown();
    }
    else {
        $.post( "asignarProyectoWeroi.php", 
            { 
                proyecto_id: proyectoid,
                user_id: userid,
                accion: accion,
                escritura: escritura
            })
            .done(function( data ) {
                //alert( "Data Loaded: " + data );
                if (data === "ok") {
                    loadSelectAccesosProyectosWeroi(userid);
                    $("#asignar-proyecto-weroi").prop("disabled", true);
                    $("#desasignar-proyecto-weroi").prop("disabled", true);
                    $('input[name="chkescritura-weroi"]').bootstrapSwitch('state', false, true);
                }
                else {
                    $("#errorMessageWeroi").html(data);
                    $("#alertProyectosWeroi").slideDown();
                }
        });
    }
};

function refreshSelects () {
    loadSelect("accesosroles_roles","tools_roles","id","","");
    $('#accesosroles_roles').selectpicker('render');
    
    loadSelect("edit_accesosroles_roles","tools_roles","id","","");
    $('#edit_accesosroles_roles').selectpicker('render');
    
    loadSelect("new_accesosroles_roles","tools_roles","id","","");
    $('#new_accesosroles_roles').selectpicker('render');
    
    loadSelect("accesos_proyecto","tools_proyectos","id","","");
    $('#accesos_proyecto').selectpicker('render');
    
    loadSelect("edit_accesos_proyecto","tools_proyectos","id","","");
    $('#edit_accesos_proyecto').selectpicker('render');
    
    loadSelect("crmproyectos_proyectos","tools_proyectos","id","","");
    $('#crmproyectos_proyectos').selectpicker('render');
    
    loadSelect("crmproyectos_clientes","tools_clientes","id","","");
    $('#crmproyectos_clientes').selectpicker('render');
    
    loadSelect("crmcampanas_campanas","tools_campanas","id","","");
    $('#crmcampanas_campanas').selectpicker('render');
    
    loadSelect("crmcampanas_proyectos","tools_proyectos","id","","");
    $('#crmcampanas_proyectos').selectpicker('render');
    
    loadSelect("crmclientes_clientes","tools_clientes","id","","");
    $('#crmclientes_clientes').selectpicker('render');
    
    //loadSelect("proyecto","tools_proyectos","id","","");
    //$('#proyecto').selectpicker('render');
    
    loadSelect("new_proyecto","tools_proyectos","id","","");
    $('#new_proyecto').selectpicker('render');
    
    loadSelect("edit_proyecto","tools_proyectos","id","","");
    $('#edit_proyecto').selectpicker('render');

    loadSelect("edit_comercial","tools_comerciales","id","","");
    $('#edit_comercial').selectpicker('render');
    
    loadSelect("edit_origen","tools_origenes","id","","");
    $('#edit_origen').selectpicker('render');
    
    loadSelect("edit_fuente","tools_fuentes","id","","");
    $('#edit_fuente').selectpicker('render');
    
    loadSelect("edit_cualificacion","tools_cualificaciones","id","","");
    $('#edit_cualificacion').selectpicker('render');
    
    loadSelect("edit_estado","tools_estados","id","","");
    $('#edit_estado').selectpicker('render');
    
    loadSelect("edit_empresa","tools_empresas","id","","");
    $('#edit_empresa').selectpicker('render');

    loadSelect("new_comercial","tools_comerciales","id","","");
    $('#new_comercial').selectpicker('render');
    
    loadSelect("new_origen","tools_origenes","id","","");
    $('#new_origen').selectpicker('render');
    
    loadSelect("new_fuente","tools_fuentes","id","","");
    $('#new_fuente').selectpicker('render');
    
    loadSelect("new_cualificacion","tools_cualificaciones","id","","");
    $('#new_cualificacion').selectpicker('render');
    
    loadSelect("new_estado","tools_estados","id","","");
    $('#new_estado').selectpicker('render');
    
    loadSelect("new_empresa","tools_empresas","id","","");
    $('#new_empresa').selectpicker('render');
}