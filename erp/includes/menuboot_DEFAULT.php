<nav class="navbar navbar-default" id="normal-menu">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><img src="/erp/img/logo.png"></a>
        </div>

        <ul class="nav navbar-nav">
            <li id="menuitem-home"><a href="/erp/">Inicio</a></li>
            <? 
                if (($_SESSION['user_rol'] == "USUARIO") || ($_SESSION['user_rol'] == "SUPERADMIN")) {
                    foreach ($_SESSION['user_apps'] as $app) {
                        //echo $app['menuitemname'];
            ?>
            <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
            <?
                    }
                }
                else {
            ?>
            <li id="menuitem-crm"><a href="/apps/crm/">CRM</a></li>
            <?
                }
            ?>
        </ul>
        
        <!--
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="/erp/img/gear2.png"> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <? 
                        if ($_SESSION['user_rol'] == "SUPERADMIN") {
                    ?>
                    <li><a href="/erp/accesos.php?p=w">Accesos/Permisos</a></li>
                    <?
                        }
                    ?>
                    <li id="menuitem-clientes"><a href="/erp/apps/empresas/?v=c">Clientes</a></li>
                    <li id="menuitem-proveedores"><a href="/erp/apps/empresas/?v=p">Proveedores</a></li>
                    <li id="menuitem-licencias"><a href="/erp/apps/licencias/">Licencias</a></li>
                    <li id="menuitem-organismos"><a href="/erp/campos.php?v=o">Organismos</a></li>
                    <li id="menuitem-periodicidades"><a href="/erp/campos.php?v=p">Periodicidades</a></li>
                </ul>
          </li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="/erp/img/user.png"> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="/erp/apps/jornada/?v=u">Mi Jornada</a></li>
                  <li><a href="/erp/apps/imputaciones/">Imputaciones</a></li>
                </ul>
          </li>
        </ul>
        -->
    
    </div>
</nav>

<nav class="navbar navbar-default" id="mobile-menu">
    <div class="container-fluid">
  	
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><img src="/erp/img/logo.png"></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mobile-bar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </button>
        </div>

        <div class="row collapse navbar-collapse" id="mobile-bar">
            <ul class="nav navbar-nav">
                <li id="menuitem-home"><a href="/erp/">Inicio</a></li>
                <? 
                    if ($_SESSION['user_rol'] != "CLIENTE") {
                        foreach ($_SESSION['user_apps'] as $app) {
                            //echo $app['menuitemname'];
                ?>
                <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                <?
                        }
                    }
                    else {
                ?>
                <li id="menuitem-crm"><a href="/apps/crm/">CRM</a></li>
                <?
                    }
                ?>
            </ul>
            <? 
                if ($_SESSION['user_rol'] == "SUPERADMIN") {
            ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="/erp/img/gear2.png"> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="/erp/apps/accesos/">Accesos/Permisos</a></li>
                    </ul>
                </li>
            </ul>
            <?
                }
            ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="/erp/img/user.png"> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="/erp/apps/jornada/?v=u">Mi Jornada</a></li>
                      <li><a href="/erp/apps/imputaciones/">Imputaciones</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>