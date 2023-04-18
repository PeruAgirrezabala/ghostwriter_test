<?php
    // Prueba 1
    //$file = dirname(__FILE__)."/output.txt";
    //$data = "hello, it's ".date("d/m/Y H:i:s")."\n";
    //file_put_contents($file, $data, FILE_APPEND);

    //Prueba 2
    /*
    $ip =   "127.0.0.1";
    $exec = exec( "ping 127.0.0.1 -c 3 ", $output, $status );
    print_r($output);
    echo $exec;
     * 
     */

     $hostname = 'WLOECHESINT01';

    $ip = gethostbyname($hostname); // NAME = Name (DNS) der NAS
    //Rückgabe IP
    
    // Vergleich und Ausgabe
    if ($ip != $hostname)  
      {	
        echo '<b><font color=#00FF00>Online</font></b>';	
      }  
     else   
      {	
        echo '<b><font color=#FF0000>Offline</font></b>';  
      }	
    
    /*
    $scriptPath = '/bin/ping';
    var_dump(array(
        'file' => is_file($scriptPath),
        'readable' => is_readable($scriptPath),
        'executable' => is_executable($scriptPath)
    ));
     * 
     */
    
    /*
    function exec_enabled() {
      $disabled = explode(',', ini_get('disable_functions'));
      return !in_array('exec', $disabled);
    }
    echo exec_enabled();
     * 
     */
?>