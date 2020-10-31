#!/bin/sh
#ESTE SCRIPT ACTIVA O REGO DURANTE OS SEGUNDOS CONFIGURADOS NO PARAMETRO

#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#OBTEMOS A LUZ ACTUAL
luz=$(../sensors/readLight.sh -o)

#SE E MENOR QUE O PARAMETRO CONFIGURADO ENCENDEMOS A LUZ ARTIFICIAL
if [ "$luz" -lt "$config_luzMin" ]
then
./encendeLuz.sh
fi
