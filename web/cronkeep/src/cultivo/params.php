<?php

// configuration
$url = '/cultivo/params.php';
$file = "/home/pi/cultivo/config.yaml";

// check if form has been submitted
if (isset($_POST['text']))
{
    // save the text contents
    file_put_contents($file, $_POST['text']);
    shell_exec("sudo dos2unix $file");

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

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
	<div class="container">
	<div class="form-group">
	<form action="" method="post">
	<div class="texto">
	 <textarea class="form-control" rows="30" name="text"><?php echo htmlspecialchars($text) ?></textarea>
	</div>
	       <button type="submit" class="btn btn-primary" autocomplete="off">
            <span class="glyphicon"></span> Enviar
			</button>
		       <button type="reset" class="btn btn-primary" autocomplete="off">
            <span class="glyphicon"></span> Reiniciar
			</button>
	</form>
	</div class="form-group">
	</div>
</body>
</html>
