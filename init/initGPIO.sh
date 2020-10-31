#!/bin/sh
#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#FUNCION QUE ACTIVA UN PIN EN MODO SAIDA
initOut(){
	echo $1 > /sys/class/gpio/export
	echo out > /sys/class/gpio/gpio$1/direction
	echo 1 > /sys/class/gpio/gpio$1/value
}
#FUNCION QUE ACTIVA UN PIN EN MODO ENTRADA
initIn(){
	echo $1 > /sys/class/gpio/export
	echo in > /sys/class/gpio/gpio$1/direction
}


####### SAIDAS #######
#LUZ
initOut $config_pinLuz

#REGO
initOut $config_pinRego

###### ENTRADAS #######

#HUMIDADEA
initIn $config_pinHumidade
