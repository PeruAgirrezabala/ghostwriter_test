<nav class="navbar navbar-default" id="normal-menu">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><img src="/erp/img/logo.png"></a>
        </div>

        <ul class="nav navbar-nav">
            <li id="menuitem-home"><a href="/erp/">Inicio</a></li>
            <? 
                foreach ($_SESSION['user_apps_menu1'] as $app) {
                    //echo $app['menuitemname'];
            ?>
                    <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
            <?
                }
            ?>
        </ul>
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
                    foreach ($_SESSION['user_apps_menu1'] as $app) {
                        //echo $app['menuitemname'];
                ?>
                        <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                <?
                    }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
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
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src='/erp/img/user.png'> <span class='caret'></span>

                    </a>
                    <ul class="dropdown-menu">
                        <? 
                            foreach ($_SESSION['user_apps_menu2'] as $app) {
                                //echo $app['menuitemname'];
                        ?>
                                <li id="menuitem-<? echo $app['menuitemname']; ?>"><a href="<? echo $app['url']; ?>"><? echo $app['nombre']; ?></a></li>
                        <?
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>