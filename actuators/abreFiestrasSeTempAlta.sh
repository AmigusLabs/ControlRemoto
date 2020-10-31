#!/bin/sh
#ESTE SCRIPT ACTIVA O REGO DURANTE OS SEGUNDOS CONFIGURADOS NO PARAMETRO

#INCLUIMOS O SCRIPT COA FUNCION PARA A LECTURA DOS PARAMETROS DESDE FICHEIRO
. /home/pi/cultivo/aux/parse_yaml.sh

#LEMOS O FICHEIRO E ALMACENANSE OS PARAMETROS BAIXO O SUFIXO config_
eval $(parse_yaml /home/pi/cultivo/config.yaml "config_")

#OBTEMOS A TEMPRERATURA ACTUAL
temp=$(../sensors/readTempIn.sh -o)

#SE E MAIOR QUE O PARAMETRO CONFIGURADO ABRIMOS AS FIESTRAS O TEMPO MARCADO
if [ "$temp" -gt "$config_tempMax" ]
then
./abreFiestras.py
sleep $config_secsVent
./cerraFiestras.py
fi
