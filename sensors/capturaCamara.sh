#!/bin/bash
#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#OBTENSE A FECHA

DATE=$(date +"%Y-%m-%d_%H%M")

fswebcam -r 640x480 --skip 20 $config_logFolder/$config_imageCamFolder/$DATE.jpg

