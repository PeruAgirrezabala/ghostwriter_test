<header id="cabecera">
    <div id="cabecera-logo">
        <!-- <a href="/erp/" target="_blank"><img src="/erp/img/logo.png"></a> -->
    </div>
    <div id="cabecera-login">
        <div id="tittle-info">
            <ul class="tittle-info">
                <!-- <li><a href="/erp/"></span>&nbsp;tools.we-roi.com</a></li> -->
            </ul>
        </div>
        <div id="session-info">
            <ul class="nav navbar-nav navbar-right tools-session">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="/erp/img/gear2.png"> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <? 
                        if (strtoupper($_SESSION['user_rol']) == "SUPERADMIN") {
                    ?>
                    <li id="menuitem-accesos"><a href="/erp/apps/accesos/">Accesos/Permisos</a></li>
                    <li id="menuitem-infoempresa"><a href="/erp/apps/info/">Info Empresa</a></li>
                    <?
                        }
                    ?>
                    <li id="menuitem-clientes"><a href="/erp/apps/empresas/?v=c">Clientes</a></li>
                    <li id="menuitem-proveedores"><a href="/erp/apps/empresas/?v=p">Proveedores</a></li>
                    <li id="menuitem-equipos"><a href="/erp/apps/equipos/">Equipos</a></li>
                    <li id="menuitem-licencias"><a href="/erp/apps/licencias/">Licencias</a></li>
                    <li id="menuitem-formaspago"><a href="/erp/apps/formaspago/">Formas de Pago</a></li>
                    <li id="menuitem-procedimientos"><a href="/erp/apps/procedimientos/">Procedimientos</a></li>
                    <li id="menuitem-documentacion"><a href="/erp/apps/documentacion/">Documentación</a></li>
                    <li id="menuitem-plantillas"><a href="/erp/apps/plantillas/">Plantillas</a></li>
                    <li id="menuitem-organismos"><a href="/erp/apps/parametros/">Parámetros</a></li>
                </ul>
          </li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right tools-session">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="/erp/img/user.png"> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li id="menuitem-jornada"><a href="/erp/apps/jornada/?v=u">Mi Jornada</a></li>
                  <li id="menuitem-imputaciones"><a href="/erp/apps/imputaciones/">Imputaciones</a></li>
                  <li id="menuitem-lomio"><a href="/erp/apps/lomio/">Como está lo mio</a></li>
                </ul>
          </li>
        </ul>
            <ul class="session-info">
                <li><a class="nocolor"><span class="glyphicon glyphicon-user"></span>&nbsp; <? echo $_SESSION['user_name']; ?></a></li>
                <li><a href="/erp/core/logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
    <? include($pathraiz."/includes/menuboot.php"); ?>
</header>