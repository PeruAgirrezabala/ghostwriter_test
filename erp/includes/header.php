
<header id="cabecera">
    <div id="cabecera-logo">
        <!-- <a href="/erp/" target="_blank"><img src="/erp/img/logo.png"></a> -->
    </div>
    <div id="cabecera-login">
        <div id="tittle-info">
            <ul class="tittle-info">
                <!-- <li><a href="/erp/"></span></a></li> -->
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
                        foreach ($_SESSION['user_apps_menu3'] as $app) {
                            //echo $app['menuitemname'];
                        ?>
                            <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                        <?
                        }
                        ?>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right tools-session">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?
                        //incluimos este archivo para usar sus metodos
                        include("pending_activities.php");
                        //guardamos en una variable el numero de actividades pendientes que tenemos
                        $activities = inportant_activities($_SESSION['user_session']);
                        //si el numero de actividades pendientes es 0 se ejecuta este bloque
                        if($activities==0){
                            echo "<img src='/erp/img/user.png'> <span class='caret'></span>";
                        //si no es hasi se ejecuta este codigo
                        }else{
                            echo "<img style='background-color:red; border-radius: 15px;' src='/erp/img/user.png'> <span class='caret'></span>";
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu">
                        <?
                        foreach ($_SESSION['user_apps_menu2'] as $app) {

                            //si el numero de actividades pendientes no es 0 y estamos en la eiteracion que queremos se ejecuta este bloque
                            if(($app['icon']=="img/lomio.png")&&$activities!=0){      
                        //texto rojo                              
                        ?>
                            <li id="menuitem-<? echo $app['menuitemname']; ?>"><a style="color:red" href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                        <?
                            }else{
                        //texto normal
                        ?>
                             <li  id="menuitem-<? echo $app['menuitemname']; ?>"><a  href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                        <?
                            }
                        }
                        ?>
                    </ul>
                </li>

            </ul>
            <ul class="session-info">
                <li>

                </li>
                <li><a href="/erp/apps/perfil/" class="nocolor" style="width: 10px;height:10px;"><? include($pathraiz . "/includes/avatar_on_header.php"); ?></span>&nbsp; <? echo $_SESSION['user_name']; ?></a></li>
                <input type="hidden" value="<? echo $_SESSION['user_session']; ?>" name="sesion_user_id" id="sesion_user_id">
                <li><a href="/erp/core/logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
    <? include($pathraiz . "/includes/menuboot.php"); ?>
</header>