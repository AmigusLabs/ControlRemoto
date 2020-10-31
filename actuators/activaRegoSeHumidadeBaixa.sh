#!/bin/sh
#ESTE SCRIPT ACTIVA O REGO DURANTE OS SEGUNDOS CONFIGURADOS NO PARAMETRO

#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#OBTEMOS A O BOOLEAN SOBRE A HUMIDADE
humidade=$(../sensors/readHumGround.sh)

#SE E 0 SIGNIFICA QUE BAIXOU DO VALOR CONFIGURADO
if [ "$humidade" -eq 0 ]
then
./activaRego.sh
fi
