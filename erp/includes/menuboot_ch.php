<script type="text/javascript">
    var timestamp = '<?=time();?>';

    function yyyymmdd(y) {
        var x = new Date(y);
        var y = x.getFullYear().toString();
        var m = (x.getMonth() + 1).toString();
        var d = x.getDate().toString();
        var H = x.getHours().toString();
        var M = x.getMinutes().toString();
        var s = x.getSeconds().toString();
        (d.length == 1) && (d = '0' + d);
        (m.length == 1) && (m = '0' + m);
        (H.length == 1) && (H = '0' + H);
        (M.length == 1) && (M = '0' + M);
        (s.length == 1) && (s = '0' + s);
        var yyyymmdd = d + "-" + m + "-" + y + " " + H + ":" + M + ":" + s;
        return yyyymmdd;
    }
    
    function updateTime(){
        $('#time').html(yyyymmdd(Date(timestamp)));
        timestamp++;
    }
    $(function(){
        setInterval(updateTime, 1000);
    });
</script>
<nav class="navbar navbar-default">
  <div class="container-fluid">
  	
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="/erp/img/logo.png"></a>
        
    </div>
    <ul class="nav navbar-nav">
        <li id="menuitem-home"><a href="/erp/apps/jornada/">REGISTRO DE LA JORNADA LABORAL</a></li>
    </ul>
      <ul id="reloj" class="nav navbar-nav navbar-right">
        <li id="time">
            <?
                //$curDate  = date('Y-m-d H:i:s');
                //echo $curDate;
            ?>
        </li>
    </ul>
    
  </div>
</nav>