/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

function loadPartidos(idjornada) {
    var html="";
    var selectItem = selectItem;
    $.getJSON("/live/apps/common/loadPartidos.php", 
    {
       idjornada: idjornada
    },
    function(data) { 
        //alert (data);
        //obj = JSON.parse(data);
        $.each(data,function(index,item) 
        {
            html+="<div class='two-column'>"+item.id+"'>"+item.nombre+"</div>";
        });
        $("#jornadas").html(html); 
    });
}

function loadSelect(selectItem, tabla, campo, campowhere, valor) {
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/live/apps/common/loadSelect.php", 
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
            items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectJornadas(selectItem, tabla, campo, campowhere, valor) {
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/live/apps/common/loadSelectJornadas.php", 
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
            items+="<option value='"+item.id+"'>"+item.num_jornada+"</option>";
        });
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadSelectJugadores(selectItem, tabla, campo, campowhere, valor) {
    var items="<option></option>";
    var selectItem = selectItem;
    $.getJSON("/live/apps/common/loadSelectJugadores.php", 
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
            items+="<option value='"+item.id+"'>"+item.display_name+"</option>";
        });
        //console.log (items);
        $("#" + selectItem).html(items); 
        $("#" + selectItem).selectpicker("refresh");
        $("#" + selectItem).selectpicker("render");
    });
}
function loadResumenJornadas(jornada, grupo) {
    //alert("aqui");
    $.getJSON("loadResumenJornadas.php", 
    {
       jornada: jornada,
       grupo: grupo
    },
    function(data) { 
        //alert (data[0].fecha_prog);
        //obj = JSON.parse(data);
        var items = "";
        $.each(data,function(index,item) 
        {
            items+="<div class='form-group' style='margin-bottom: 0px;'><label class='labelBefore partidosProgramados'><a href='javascript:removePartido("+item.partidoid+")'><img src='/live/img/remove.png' width='10'> </a> <span class='jugador-left'>"+item.player1+"</span> - <span class='jugador-right'>"+item.player2+"</span></label></div>";
        });
        //console.log (items);
        if (items != "") {
            $("#resumen-jornada").html(items); 
            $("#resumen-jornada").fadeIn("slow");
        }
        else {
            $("#resumen-jornada").html(""); 
        }
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
            case "tools_origenes":
                $("#crmorigenes_edit_nombre").val(data[0].nombre);
                break;
            case "tools_estados ":
                $("#crmestados_edit_nombre").val(data[0].nombre);
                break;
            case "tools_fuentes":
                $("#crmfuentes_edit_nombre").val(data[0].nombre);
                break;
            case "tools_roles":
                $("#accesosroles_edit_nombre").val(data[0].nombre);
                break;
            default:
        }
        
    });
}
function loadJornadas(id) {
    //alert(id);
    //alert(tabla);
    $.getJSON("/live/apps/common/loadJornadas.php", 
    {
       id: id
    },
    function(data) { 
        //alert (data[0].nombre);
        //obj = JSON.parse(data);
        //$.each(data,function(index,item) 
        //{
        //  items+="<option value='"+item.id+"'>"+item.nombre+"</option>";
        //});
        if (data[0].estado == 1) {
            $("#live").fadeIn("slow");
        }
        else {
            $("#live").fadeOut("slow");
        }
        $("#jornadas_edit_nombre").val(data[0].num_jornada);
        $("#start_fecha").val(data[0].start_datetime);
        $("#end_fecha").val(data[0].end_datetime);
        
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