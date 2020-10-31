#!/bin/sh
#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#ESTE SENSOR SO DEVOLVE UN 1 OU UN 0 SEGUN O VALOR DE HUMIDADE QUE TEÑA CONFIGURADO.
goodHumidity=sudo cat /sys/class/gpio/gpio$config_pinHumidade/value
