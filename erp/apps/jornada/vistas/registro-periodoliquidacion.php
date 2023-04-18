<!-- datos trabajador -->
<div id="accesos-datostrabajador" style="padding-left: 10px;">
    
    <?
        switch ($monthName) {
        case "January":
            $nombremes="Enero";
            break;
        case "February":
            $nombremes="Febrero";
            break;
        case "March":
            $nombremes="Marzo";
            break;
        case "April":
            $nombremes="Abril";
            break;
        case "May":
            $nombremes="Mayo";
            break;
        case "June":
            $nombremes="Junio";
            break;
        case "July":
            $nombremes="Julio";
            break;
        case "August":
            $nombremes="Agosto";
            break;
        case "September":
            $nombremes="Septiembre";
            break;
        case "October":
            $nombremes="Octubre";
            break;
        case "November":
            $nombremes="Noviembre";
            break;
        case "December":
            $nombremes="Dicciembre";
            break;
        default:
            $nombremes=$monthName;
            break;
        }
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Periodo de liquidación:</label> <label id='view_month' class='label-strong'>".$nombremes."</label>
              </div>";   
    ?>
</div>

<!-- datos trabajador -->