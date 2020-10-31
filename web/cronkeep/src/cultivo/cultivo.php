<?php
  // configuration
  $capuraCamara = 'sudo /home/pi/cultivo/sensors/capturaCamara.sh';
//  $readHumAir = 'sudo /home/pi/cultivo/sensors/readHumAir.py';
  $readLight = 'sudo /home/pi/cultivo/sensors/readLight.py';
  $readTempIn = 'sudo /home/pi/cultivo/sensors/readTempIn.sh';
  $readTempOut = 'sudo /home/pi/cultivo/sensors/readTempOut.sh';

  $generaGraficas = 'sudo /home/pi/cultivo/aux/plotea.sh';

  $activaRego = 'sudo /home/pi/cultivo/actuators/activaRego.sh';
  $encendeLuz = 'sudo /home/pi/cultivo/actuators/encendeLuz.sh';
  $apagaLuz = 'sudo /home/pi/cultivo/actuators/apagaLuz.sh';
  $abreFiestras = 'sudo /home/pi/cultivo/actuators/abreFiestras.py';
  $cerraFiestras = 'sudo /home/pi/cultivo/actuators/cerraFiestras.py';

  $imgHum = 'logs/imgHum.png';
  $imgLight = 'logs/imgLight.png';
  $imgTempInOut = 'logs/imgTempInOut.png';
  $logTempIn="/home/pi/cultivo/logs/logTempIn";
  $logTempOut="/home/pi/cultivo/logs/logTempOut";
  $logLight="/home/pi/cultivo/logs/logLight";
  $logHum="/home/pi/cultivo/logs/logHum";



  function getLastImage($dir)
  {
    $imagetypes = array("image/jpeg", "image/gif");

    $retval = array();

    if(substr($dir, -1) != "/") $dir .= "/";

    $fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir";

    $d = @dir($fulldir) or die("getLastImages: Non se puido abrir $dir");
    while(false !== ($entry = $d->read())) {
      if($entry[0] == ".") continue;

      $f = escapeshellarg("$fulldir$entry");
      $mimetype = "image/jpeg";
      foreach($imagetypes as $valid_type) {
        if(preg_match("@^{$valid_type}@", $mimetype)) {
          $retval[] = array(
           'file' => "/$dir$entry",
           'size' => getimagesize("$fulldir$entry")
          );
          break;
        }
      }
    }
    $d->close();

    return $retval;
  }
  function actualizaContenido()
  {
    global $capuraCamara, $readHumAir, $readLight, $readTempIn, $readTempOut, $generaGraficas;
    shell_exec($capuraCamara);
    shell_exec($readHumAir);
    shell_exec($readLight);
    shell_exec($readTempIn);
    shell_exec($readTempOut);
    shell_exec($generaGraficas);
  }

?>
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <title>Cultivo</title>
    <style>
    .containerimages {
        box-shadow: 0 0 30px black;
        border-radius: 10px 10px 10px 10px;
    }
    </style>
 </head>
 <body>
     <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="cultivo.php">Cultivo</a>
                <a class="navbar-brand" href="/cronkeep">CronKeep</a>
                <a class="navbar-brand" href="params.php">Configuracion</a>
            </div>
        </div>
    </div>
    <div class="container containerimages">
<?php

  if (isset($_GET['update'])) {
    if ($_GET['update'] == 1){
          actualizaContenido();
    }
  }
  if (isset($_GET['luz'])) {
    $luz = $_GET['luz'];
    if ($luz==1){
          shell_exec($encendeLuz);
          actualizaContenido();

    }
    if ($luz==0){
          shell_exec($apagaLuz);
          actualizaContenido();

    }
  }
  if (isset($_GET['rego'])) {
    $luz = $_GET['rego'];
    if ($luz==1){
          shell_exec($activaRego);
          actualizaContenido();

    }
  }
  if (isset($_GET['vent'])) {
    $luz = $_GET['vent'];
    if ($luz==1){
          shell_exec($abreFiestras);
          actualizaContenido();

    }
    if ($luz==0){
          shell_exec($cerraFiestras);
          actualizaContenido();

    }
  }

  $images = getLastImage("logs/webcam");
  sort($images);
  $image = end($images);


  echo "<div><img width=\"585\" height=\"440\" class=\"photo\" src=\"{$image['file']}\" {$image['size'][3]} alt=\"\">\n";
  echo "<img width=\"550\" class=\"photo\" src=\"$imgLight\" alt=\"\"></div>\n";
  $tempin=shell_exec("tail -n 1 $logTempIn");
  echo "<div class=tempin><strong>Temperatura Interior:</strong>  $tempin</div>";
  $tempout=shell_exec("tail -n 1 $logTempOut");
  echo "<div class=tempout><strong>Temperatura Exterior:</strong>  $tempout</div>";
  $luz=shell_exec("tail -n 1 $logLight");
  echo "<div class=luz><strong>Luz:</strong>  $luz</div>";
  $humidade=shell_exec("tail -n 1 $logHum");
  echo "<div class=humedad><strong>Humidade:</strong> $humidade </div>";


  $encendida=shell_exec("sudo cat /sys/class/gpio/gpio20/value");
  if ($encendida==0){
    echo "<div><a href=?luz=0  class=\"btn btn-info\">Apaga Luz</a>";
  }else if ($encendida==1){

    echo "<div><a href=?luz=1 class=\"btn btn-info\">Encende Luz</a>";
  }
  echo "<a href=?rego=1 class=\"btn btn-info\">Activa Rego</a>";

  $abertas=shell_exec("sudo cat /home/pi/cultivo/logs/fiestraAberta");
  if ($abertas==0){
     echo "<a href=?vent=1 class=\"btn btn-info\">Abre Fiestras</a></div>";
  }else if ($abertas==1){
     echo "<a href=?vent=0 class=\"btn btn-info\">Cerra Fiestras</a></div>";
  }
  echo "<div><img width=\"550\" class=\"photo\" src=\"$imgTempInOut\" alt=\"\">\n";
  echo "<img width=\"550\" class=\"photo\" src=\"$imgHum\" alt=\"\"></div>\n";
?>
  </div>
 </body>
</html>
