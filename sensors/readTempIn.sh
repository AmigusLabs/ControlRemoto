#!/bin/sh
#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#OBTENSE A FECHA
DATE=$(date +"%Y-%m-%d_%H%M")

#LECTURA DO SENSOR IDENTIFICADO POR UN ID
tempin=$(sudo cat /sys/bus/w1/devices/28-0115538e52ff/w1_slave |grep -Po '(?<=t=).*')

#SE SE PASA A OPCION -o NON SE ESCRIBE O LOG E SACASE POR PANTALLA
if [ "$1" = "-o" ]
then
echo $tempin
else
#ESCRITURA NO FICHEIRO DE LOG
echo $DATE $tempin >> $config_logFolder/$config_fileTempIn
fi
