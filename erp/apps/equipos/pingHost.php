<?
    $hostname = $_POST['host'];
    
    $ip = gethostbyname($hostname); // NAME = Name (DNS) der NAS
    //Rückgabe IP
    
    // Vergleich und Ausgabe
    if ($ip != $hostname)  
      {	
            //echo "<span class='label label-success'>Online</span>";	
            echo json_encode(
                array("data1" => "<span class='label label-success'>Online</span>", 
                "data2" => $ip)
            );
      }  
     else   
      {	
            echo json_encode(
                array("data1" => "<span class='label label-danger'>Offline</span>", 
                "data2" => $ip)
            );
            //echo "<span class='label label-danger'>Offline</span>";	
      }	
?>