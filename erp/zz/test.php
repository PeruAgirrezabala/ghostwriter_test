<?php

$curl = curl_init();
//api: /?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJqdWxlbmRpZXpAZ2VuZWxlay5jb20iLCJqdGkiOiJmMjZjY2NlYS1kNjRhLTRkNDItYjM3Yi03ODE5MDA2OTQ2MWUiLCJpc3MiOiJBRU1FVCIsImlhdCI6MTU1OTU0NDc5NywidXNlcklkIjoiZjI2Y2NjZWEtZDY0YS00ZDQyLWIzN2ItNzgxOTAwNjk0NjFlIiwicm9sZSI6IiJ9.EDYFPpujU-XJ0UKVZWPJpetJ3mDSiJRXi9xR7qblXjg
//URL PLAYAS: https://opendata.aemet.es/dist/index.html?#!/predicciones-especificas/Predicci%C3%B3n_para_las_playas_Tiempo_actual
// https://opendata.aemet.es/opendata/api/prediccion/especifica/playa/2008102 (Itzurun)
// Listado Playas: http://www.aemet.es/documentos/es/eltiempo/prediccion/playas/Playas_codigos.csv
//URL MUNICIPIOS: https://opendata.aemet.es/dist/index.html?#!/predicciones-especificas/Predicci%C3%B3n_por_municipios_diaria_Tiempo_actual
// https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/20081 (Zumaia)
// Listado municipios: http://www.ine.es/daco/daco42/codmun/codmun19/19codmun20.xls
$apiKey = "eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJnZW5lbGVrQGdlbmVsZWsuY29tIiwianRpIjoiOWFmZWQ2MzUtNTQyNC00NGU3LTg1MGEtYjBmNzNmYzI1MzEzIiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE1NzM3MzI5ODIsInVzZXJJZCI6IjlhZmVkNjM1LTU0MjQtNDRlNy04NTBhLWIwZjczZmMyNTMxMyIsInJvbGUiOiIifQ.BtpryCgP4PfnyZpYoyRI-ItWsALZxXXpkSQz8VwCKKc";
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/diaria/20081",
  //CURLOPT_URL => "https://opendata.aemet.es/opendata/api/red/especial/radiacion",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "Accept: application/json", 
    "api_key: " . $apiKey
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $character = json_decode($response);
  //echo "ZZZZZZZZ: ".$character->datos;
    $url = $character->datos; // path to your JSON file
    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode(utf8_encode($data)); // decode the JSON feed
    //echo json_encode($characters);
    $fulldayhoy = $characters[0]->prediccion->dia[0]->estadoCielo[0]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[0]->descripcion;
    $mitad1hoy = $characters[0]->prediccion->dia[0]->estadoCielo[1]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[1]->descripcion;
    $mitad2hoy = $characters[0]->prediccion->dia[0]->estadoCielo[2]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[2]->descripcion;
    $cuarto1hoy = $characters[0]->prediccion->dia[0]->estadoCielo[3]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[3]->descripcion;
    $cuarto2hoy = $characters[0]->prediccion->dia[0]->estadoCielo[4]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[4]->descripcion;
    $cuarto3hoy = $characters[0]->prediccion->dia[0]->estadoCielo[5]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[5]->descripcion;
    $cuarto4hoy = $characters[0]->prediccion->dia[0]->estadoCielo[6]->periodo." -> ".$characters[0]->prediccion->dia[0]->estadoCielo[6]->descripcion;
    
    $fulldaytomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[0]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[0]->descripcion;
    $mitad1tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[1]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[1]->descripcion;
    $mitad2tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[2]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[2]->descripcion;
    $cuarto1tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[3]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[3]->descripcion;
    $cuarto2tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[4]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[4]->descripcion;
    $cuarto3tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[5]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[5]->descripcion;
    $cuarto4tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo[6]->periodo." -> ".$characters[0]->prediccion->dia[1]->estadoCielo[6]->descripcion;
    //$desc2hoy = $characters[0]->prediccion->dia[0]->estadoCielo->descripcion2;
    //$desc1tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo->descripcion1;
    //$desc2tomorrow = $characters[0]->prediccion->dia[1]->estadoCielo->descripcion2;
    echo "MUNICIPIO: ".$characters[0]->nombre."<br><br>";
    echo "HOY: ". $fulldayhoy . "<br>";
    echo $mitad1hoy . "<br>";
    echo $mitad2hoy . "<br>";
    echo $cuarto1hoy . "<br>";
    echo $cuarto2hoy . "<br>";
    echo $cuarto3hoy . "<br>";
    echo $cuarto4hoy . "<br><br>";
    
    echo "MAÑANA: ". $fulldaytomorrow . "<br>";
    echo $mitad1tomorrow . "<br>";
    echo $mitad2tomorrow . "<br>";
    echo $cuarto1tomorrow . "<br>";
    echo $cuarto2tomorrow . "<br>";
    echo $cuarto3tomorrow . "<br>";
    echo $cuarto4tomorrow . "<br>";
    //echo "Hoy por la Mañana: ".$per1hoy."<br>";
    //echo "Hoy por la Tarde: ".$per2hoy."<br>";
    //echo "Mañana por la mañana: ".$desc1tomorrow."<br>";
    //echo "Mañana por la Tarde: ".$desc2tomorrow."<br>";
    //foreach ($characters[0]->prediccion->dia[0]->estadoCielo as $periodo) {
	//echo $periodo->periodo.":".$periodo->descripcion. '<br>';
    //}
}

/* RESPUESTA DEL JSON DE MUNICIPIOS DIA
 [ {
  "origen" : {
    "productor" : "Agencia Estatal de Meteorología - AEMET. Gobierno de España",
    "web" : "http://www.aemet.es",
    "enlace" : "http://www.aemet.es/es/eltiempo/prediccion/municipios/zumaia-id20081",
    "language" : "es",
    "copyright" : "© AEMET. Autorizado el uso de la información y su reproducción citando a AEMET como autora de la misma.",
    "notaLegal" : "http://www.aemet.es/es/nota_legal"
  },
  "elaborado" : "2019-06-03",
  "nombre" : "Zumaia",
  "provincia" : "Gipuzkoa",
  "prediccion" : {
    "dia" : [ {
      "probPrecipitacion" : [ {
        "value" : 20,
        "periodo" : "00-24"
      }, {
        "value" : 0,
        "periodo" : "00-12"
      }, {
        "value" : 20,
        "periodo" : "12-24"
      }, {
        "value" : 0,
        "periodo" : "00-06"
      }, {
        "value" : 0,
        "periodo" : "06-12"
      }, {
        "value" : 0,
        "periodo" : "12-18"
      }, {
        "value" : 20,
        "periodo" : "18-24"
      } ],
      "cotaNieveProv" : [ {
        "value" : "",
        "periodo" : "00-24"
      }, {
        "value" : "",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      }, {
        "value" : "",
        "periodo" : "00-06"
      }, {
        "value" : "",
        "periodo" : "06-12"
      }, {
        "value" : "",
        "periodo" : "12-18"
      }, {
        "value" : "",
        "periodo" : "18-24"
      } ],
      "estadoCielo" : [ {
        "value" : "13",
        "periodo" : "00-24",
        "descripcion" : "Intervalos nubosos"
      }, {
        "value" : "14",
        "periodo" : "00-12",
        "descripcion" : "Nuboso"
      }, {
        "value" : "13",
        "periodo" : "12-24",
        "descripcion" : "Intervalos nubosos"
      }, {
        "value" : "14n",
        "periodo" : "00-06",
        "descripcion" : "Nuboso"
      }, {
        "value" : "14",
        "periodo" : "06-12",
        "descripcion" : "Nuboso"
      }, {
        "value" : "12",
        "periodo" : "12-18",
        "descripcion" : "Poco nuboso"
      }, {
        "value" : "15",
        "periodo" : "18-24",
        "descripcion" : "Muy nuboso"
      } ],
      "viento" : [ {
        "direccion" : "N",
        "velocidad" : 10,
        "periodo" : "00-24"
      }, {
        "direccion" : "N",
        "velocidad" : 10,
        "periodo" : "00-12"
      }, {
        "direccion" : "NO",
        "velocidad" : 10,
        "periodo" : "12-24"
      }, {
        "direccion" : "E",
        "velocidad" : 5,
        "periodo" : "00-06"
      }, {
        "direccion" : "N",
        "velocidad" : 10,
        "periodo" : "06-12"
      }, {
        "direccion" : "NO",
        "velocidad" : 10,
        "periodo" : "12-18"
      }, {
        "direccion" : "C",
        "velocidad" : 0,
        "periodo" : "18-24"
      } ],
      "rachaMax" : [ {
        "value" : "",
        "periodo" : "00-24"
      }, {
        "value" : "",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      }, {
        "value" : "",
        "periodo" : "00-06"
      }, {
        "value" : "",
        "periodo" : "06-12"
      }, {
        "value" : "",
        "periodo" : "12-18"
      }, {
        "value" : "",
        "periodo" : "18-24"
      } ],
      "temperatura" : {
        "maxima" : 23,
        "minima" : 16,
        "dato" : [ {
          "value" : 16,
          "hora" : 6
        }, {
          "value" : 21,
          "hora" : 12
        }, {
          "value" : 20,
          "hora" : 18
        }, {
          "value" : 17,
          "hora" : 24
        } ]
      },
      "sensTermica" : {
        "maxima" : 23,
        "minima" : 16,
        "dato" : [ {
          "value" : 16,
          "hora" : 6
        }, {
          "value" : 21,
          "hora" : 12
        }, {
          "value" : 20,
          "hora" : 18
        }, {
          "value" : 17,
          "hora" : 24
        } ]
      },
      "humedadRelativa" : {
        "maxima" : 85,
        "minima" : 60,
        "dato" : [ {
          "value" : 70,
          "hora" : 6
        }, {
          "value" : 65,
          "hora" : 12
        }, {
          "value" : 75,
          "hora" : 18
        }, {
          "value" : 80,
          "hora" : 24
        } ]
      },
      "uvMax" : 7,
      "fecha" : "2019-06-03"
    }, {
      "probPrecipitacion" : [ {
        "value" : 100,
        "periodo" : "00-24"
      }, {
        "value" : 35,
        "periodo" : "00-12"
      }, {
        "value" : 100,
        "periodo" : "12-24"
      }, {
        "value" : 20,
        "periodo" : "00-06"
      }, {
        "value" : 15,
        "periodo" : "06-12"
      }, {
        "value" : 85,
        "periodo" : "12-18"
      }, {
        "value" : 95,
        "periodo" : "18-24"
      } ],
      "cotaNieveProv" : [ {
        "value" : "",
        "periodo" : "00-24"
      }, {
        "value" : "",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      }, {
        "value" : "",
        "periodo" : "00-06"
      }, {
        "value" : "",
        "periodo" : "06-12"
      }, {
        "value" : "",
        "periodo" : "12-18"
      }, {
        "value" : "",
        "periodo" : "18-24"
      } ],
      "estadoCielo" : [ {
        "value" : "26",
        "periodo" : "00-24",
        "descripcion" : "Cubierto con lluvia"
      }, {
        "value" : "15",
        "periodo" : "00-12",
        "descripcion" : "Muy nuboso"
      }, {
        "value" : "26",
        "periodo" : "12-24",
        "descripcion" : "Cubierto con lluvia"
      }, {
        "value" : "15n",
        "periodo" : "00-06",
        "descripcion" : "Muy nuboso"
      }, {
        "value" : "15",
        "periodo" : "06-12",
        "descripcion" : "Muy nuboso"
      }, {
        "value" : "26",
        "periodo" : "12-18",
        "descripcion" : "Cubierto con lluvia"
      }, {
        "value" : "26",
        "periodo" : "18-24",
        "descripcion" : "Cubierto con lluvia"
      } ],
      "viento" : [ {
        "direccion" : "NO",
        "velocidad" : 20,
        "periodo" : "00-24"
      }, {
        "direccion" : "NO",
        "velocidad" : 20,
        "periodo" : "00-12"
      }, {
        "direccion" : "NO",
        "velocidad" : 20,
        "periodo" : "12-24"
      }, {
        "direccion" : "C",
        "velocidad" : 0,
        "periodo" : "00-06"
      }, {
        "direccion" : "NO",
        "velocidad" : 20,
        "periodo" : "06-12"
      }, {
        "direccion" : "NO",
        "velocidad" : 10,
        "periodo" : "12-18"
      }, {
        "direccion" : "O",
        "velocidad" : 10,
        "periodo" : "18-24"
      } ],
      "rachaMax" : [ {
        "value" : "",
        "periodo" : "00-24"
      }, {
        "value" : "",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      }, {
        "value" : "",
        "periodo" : "00-06"
      }, {
        "value" : "",
        "periodo" : "06-12"
      }, {
        "value" : "",
        "periodo" : "12-18"
      }, {
        "value" : "",
        "periodo" : "18-24"
      } ],
      "temperatura" : {
        "maxima" : 24,
        "minima" : 15,
        "dato" : [ {
          "value" : 17,
          "hora" : 6
        }, {
          "value" : 21,
          "hora" : 12
        }, {
          "value" : 18,
          "hora" : 18
        }, {
          "value" : 15,
          "hora" : 24
        } ]
      },
      "sensTermica" : {
        "maxima" : 24,
        "minima" : 15,
        "dato" : [ {
          "value" : 17,
          "hora" : 6
        }, {
          "value" : 21,
          "hora" : 12
        }, {
          "value" : 18,
          "hora" : 18
        }, {
          "value" : 15,
          "hora" : 24
        } ]
      },
      "humedadRelativa" : {
        "maxima" : 85,
        "minima" : 65,
        "dato" : [ {
          "value" : 80,
          "hora" : 6
        }, {
          "value" : 70,
          "hora" : 12
        }, {
          "value" : 75,
          "hora" : 18
        }, {
          "value" : 85,
          "hora" : 24
        } ]
      },
      "uvMax" : 8,
      "fecha" : "2019-06-04"
    }, {
      "probPrecipitacion" : [ {
        "value" : 100,
        "periodo" : "00-24"
      }, {
        "value" : 100,
        "periodo" : "00-12"
      }, {
        "value" : 80,
        "periodo" : "12-24"
      } ],
      "cotaNieveProv" : [ {
        "value" : "1400",
        "periodo" : "00-24"
      }, {
        "value" : "1400",
        "periodo" : "00-12"
      }, {
        "value" : "1400",
        "periodo" : "12-24"
      } ],
      "estadoCielo" : [ {
        "value" : "25",
        "periodo" : "00-24",
        "descripcion" : "Muy nuboso con lluvia"
      }, {
        "value" : "26",
        "periodo" : "00-12",
        "descripcion" : "Cubierto con lluvia"
      }, {
        "value" : "25",
        "periodo" : "12-24",
        "descripcion" : "Muy nuboso con lluvia"
      } ],
      "viento" : [ {
        "direccion" : "O",
        "velocidad" : 20,
        "periodo" : "00-24"
      }, {
        "direccion" : "O",
        "velocidad" : 20,
        "periodo" : "00-12"
      }, {
        "direccion" : "O",
        "velocidad" : 20,
        "periodo" : "12-24"
      } ],
      "rachaMax" : [ {
        "value" : "50",
        "periodo" : "00-24"
      }, {
        "value" : "50",
        "periodo" : "00-12"
      }, {
        "value" : "50",
        "periodo" : "12-24"
      } ],
      "temperatura" : {
        "maxima" : 18,
        "minima" : 11,
        "dato" : [ ]
      },
      "sensTermica" : {
        "maxima" : 18,
        "minima" : 11,
        "dato" : [ ]
      },
      "humedadRelativa" : {
        "maxima" : 90,
        "minima" : 65,
        "dato" : [ ]
      },
      "uvMax" : 6,
      "fecha" : "2019-06-05"
    }, {
      "probPrecipitacion" : [ {
        "value" : 75,
        "periodo" : "00-24"
      }, {
        "value" : 35,
        "periodo" : "00-12"
      }, {
        "value" : 55,
        "periodo" : "12-24"
      } ],
      "cotaNieveProv" : [ {
        "value" : "1500",
        "periodo" : "00-24"
      }, {
        "value" : "1500",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      } ],
      "estadoCielo" : [ {
        "value" : "45",
        "periodo" : "00-24",
        "descripcion" : "Muy nuboso con lluvia escasa"
      }, {
        "value" : "15",
        "periodo" : "00-12",
        "descripcion" : "Muy nuboso"
      }, {
        "value" : "45",
        "periodo" : "12-24",
        "descripcion" : "Muy nuboso con lluvia escasa"
      } ],
      "viento" : [ {
        "direccion" : "NE",
        "velocidad" : 10,
        "periodo" : "00-24"
      }, {
        "direccion" : "NE",
        "velocidad" : 10,
        "periodo" : "00-12"
      }, {
        "direccion" : "E",
        "velocidad" : 15,
        "periodo" : "12-24"
      } ],
      "rachaMax" : [ {
        "value" : "",
        "periodo" : "00-24"
      }, {
        "value" : "",
        "periodo" : "00-12"
      }, {
        "value" : "",
        "periodo" : "12-24"
      } ],
      "temperatura" : {
        "maxima" : 19,
        "minima" : 11,
        "dato" : [ ]
      },
      "sensTermica" : {
        "maxima" : 19,
        "minima" : 11,
        "dato" : [ ]
      },
      "humedadRelativa" : {
        "maxima" : 80,
        "minima" : 55,
        "dato" : [ ]
      },
      "uvMax" : 7,
      "fecha" : "2019-06-06"
    }, {
      "probPrecipitacion" : [ {
        "value" : 100
      } ],
      "cotaNieveProv" : [ {
        "value" : "1400"
      } ],
      "estadoCielo" : [ {
        "value" : "24",
        "descripcion" : "Nuboso con lluvia"
      } ],
      "viento" : [ {
        "direccion" : "O",
        "velocidad" : 35
      } ],
      "rachaMax" : [ {
        "value" : "75"
      } ],
      "temperatura" : {
        "maxima" : 20,
        "minima" : 12,
        "dato" : [ ]
      },
      "sensTermica" : {
        "maxima" : 20,
        "minima" : 12,
        "dato" : [ ]
      },
      "humedadRelativa" : {
        "maxima" : 80,
        "minima" : 50,
        "dato" : [ ]
      },
      "uvMax" : 6,
      "fecha" : "2019-06-07"
    }, {
      "probPrecipitacion" : [ {
        "value" : 20
      } ],
      "cotaNieveProv" : [ {
        "value" : "1500"
      } ],
      "estadoCielo" : [ {
        "value" : "13",
        "descripcion" : "Intervalos nubosos"
      } ],
      "viento" : [ {
        "direccion" : "NE",
        "velocidad" : 15
      } ],
      "rachaMax" : [ {
        "value" : ""
      } ],
      "temperatura" : {
        "maxima" : 21,
        "minima" : 10,
        "dato" : [ ]
      },
      "sensTermica" : {
        "maxima" : 21,
        "minima" : 10,
        "dato" : [ ]
      },
      "humedadRelativa" : {
        "maxima" : 80,
        "minima" : 55,
        "dato" : [ ]
      },
      "fecha" : "2019-06-08"
    }, {
      "probPrecipitacion" : [ {
        "value" : 80
      } ],
      "cotaNieveProv" : [ {
        "value" : ""
      } ],
      "estadoCielo" : [ {
        "value" : "25",
        "descripcion" : "Muy nuboso con lluvia"
      } ],
      "viento" : [ {
        "direccion" : "O",
        "velocidad" : 20
      } ],
      "rachaMax" : [ {
        "value" : ""
      } ],
      "temperatura" : {
        "maxima" : 19,
        "minima" : 12,
        "dato" : [ ]
      },
      "sensTermica" : {
        "maxima" : 19,
        "minima" : 12,
        "dato" : [ ]
      },
      "humedadRelativa" : {
        "maxima" : 80,
        "minima" : 60,
        "dato" : [ ]
      },
      "fecha" : "2019-06-09"
    } ]
  },
  "id" : 20081,
  "version" : 1.0
} ]
 */

/* RESPUESTA DEL JSON DE PLAYAS
 [ {
  "origen" : {
    "productor" : "Agencia Estatal de Meteorología - AEMET. Gobierno de España",
    "web" : "http://www.aemet.es",
    "language" : "es",
    "copyright" : "© AEMET. Autorizado el uso de la información y su reproducción citando a AEMET como autora de la misma.",
    "notaLegal" : "http://www.aemet.es/es/nota_legal"
  },
  "elaborado" : "2019-06-03",
  "nombre" : "Itzurun-San Telmo",
  "localidad" : 20081,
  "prediccion" : {
    "dia" : [ {
      "estadoCielo" : {
        "value" : "",
        "f1" : 110,
        "descripcion1" : "nuboso",
        "f2" : 100,
        "descripcion2" : "despejado"
      },
      "viento" : {
        "value" : "",
        "f1" : 210,
        "descripcion1" : "flojo",
        "f2" : 210,
        "descripcion2" : "flojo"
      },
      "oleaje" : {
        "value" : "",
        "f1" : 320,
        "descripcion1" : "moderado",
        "f2" : 320,
        "descripcion2" : "moderado"
      },
      "tMaxima" : {
        "value" : "",
        "valor1" : 23
      },
      "sTermica" : {
        "value" : "",
        "valor1" : 450,
        "descripcion1" : "suave"
      },
      "tAgua" : {
        "value" : "",
        "valor1" : 17
      },
      "uvMax" : {
        "value" : "",
        "valor1" : 7
      },
      "fecha" : 20190603,
      "stermica" : {
        "value" : "",
        "valor1" : 450,
        "descripcion1" : "suave"
      },
      "tagua" : {
        "value" : "",
        "valor1" : 17
      },
      "tmaxima" : {
        "value" : "",
        "valor1" : 23
      }
    }, {
      "estadoCielo" : {
        "value" : "",
        "f1" : 110,
        "descripcion1" : "nuboso",
        "f2" : 140,
        "descripcion2" : "muy nuboso con lluvia"
      },
      "viento" : {
        "value" : "",
        "f1" : 210,
        "descripcion1" : "flojo",
        "f2" : 210,
        "descripcion2" : "flojo"
      },
      "oleaje" : {
        "value" : "",
        "f1" : 320,
        "descripcion1" : "moderado",
        "f2" : 320,
        "descripcion2" : "moderado"
      },
      "tMaxima" : {
        "value" : "",
        "valor1" : 23
      },
      "sTermica" : {
        "value" : "",
        "valor1" : 450,
        "descripcion1" : "suave"
      },
      "tAgua" : {
        "value" : "",
        "valor1" : 18
      },
      "uvMax" : {
        "value" : "",
        "valor1" : 8
      },
      "fecha" : 20190604,
      "stermica" : {
        "value" : "",
        "valor1" : 450,
        "descripcion1" : "suave"
      },
      "tagua" : {
        "value" : "",
        "valor1" : 18
      },
      "tmaxima" : {
        "value" : "",
        "valor1" : 23
      }
    } ]
  },
  "id" : 2008102
} ]
 */