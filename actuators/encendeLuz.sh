#!/bin/sh
#ESTE SCRIPT ACTIVA O REGO DURANTE OS SEGUNDOS CONFIGURADOS NO PARAMETRO

#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

echo 0 > /sys/class/gpio/gpio$config_pinLuz/value

