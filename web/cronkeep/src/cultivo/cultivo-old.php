<?php
  $apagaLuz='sudo /home/pi/cultivo/apagaluz.sh';
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
?>
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Web-based crontab manager">
    <meta name="author" content="Bogdan Ghervan">
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
      shell_exec("sudo /home/pi/cultivo/bashcamscript.sh");
    }
  }
  if (isset($_GET['luz'])) {
    $luz = $_GET['luz'];
    if ($luz==1){
          shell_exec("sudo /home/pi/cultivo/enciendeluz.sh");
          shell_exec("sudo /home/pi/cultivo/bashcamscript.sh");

    }
    if ($luz==0){
          shell_exec($apagaLuz);
          shell_exec("sudo /home/pi/cultivo/bashcamscript.sh");

    }
  }

  $images = getLastImage("logs/webcam");
  sort($images);
  $image = end($images);


  echo "<div><img width=\"585\" height=\"440\" class=\"photo\" src=\"{$image['file']}\" {$image['size'][3]} alt=\"\">\n";
  echo "<img width=\"550\" class=\"photo\" src=\"logs/logLight.png\" alt=\"\"></div>\n";
  $tempin=shell_exec("tail -n 1 /home/pi/cultivo/logs/tempin");
  echo "<div class=tempin><strong>Temperatura Interior:</strong>  $tempin</div>";
  $tempout=shell_exec("awk 'END {print $NF}' /home/pi/cultivo/logs/tempout");
  echo "<div class=tempout><strong>Temperatura Exterior:</strong>  $tempout</div>";
  $encendida=shell_exec("sudo cat /sys/class/gpio/gpio20/value");
  $luz='2016-09-07_1913 56';
  echo "<div class=luz><strong>Luz:</strong>  $luz</div>";
  $humidade='2016-09-07_1913 61';
  echo "<div class=humedad><strong>Humidade:</strong> $humidade </div>";

  if ($encendida==0){
    echo "<div><a href=?luz=0  class=\"btn btn-info\">Apaga Luz</a>";
  }else if ($encendida==1){

    echo "<div><a href=?luz=1 class=\"btn btn-info\">Encende Luz</a>";
  }
  echo "<a href=?rego=1 class=\"btn btn-info\">Activa Rego</a>";
  echo "<a href=?vent=1 class=\"btn btn-info\">Abre Fiestras</a></div>";

  echo "<div><img width=\"550\" class=\"photo\" src=\"logs/logTempInOut.png\" alt=\"\">\n";
  echo "<img width=\"550\" class=\"photo\" src=\"logs/logHum.png\" alt=\"\"></div>\n";
?>
  </div>
 </body>
</html>
