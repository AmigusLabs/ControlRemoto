#!/bin/sh

#COLLENSE OS ULTIMOS 15 VALORES DO LOG PARA FACER A GRAFICA
tail -n 15 /home/pi/cultivo/logs/logTempOut | sed 's/t=//' > tempout.temp
tail -n 15 /home/pi/cultivo/logs/logTempIn | sed 's/t=//' > tempin.temp
tail -n 15 /home/pi/cultivo/logs/logHum | sed 's/t=//' > hum.temp
tail -n 15 /home/pi/cultivo/logs/logLight | sed 's/t=//' > light.temp

#FAISE A GRAFICA CO GNUPLOT E O FICHEIRO DE CONFIGURACION
gnuplot /home/pi/cultivo/aux/plotea.gnuplot

#MOVENSE AS IMAXES O DIRECTORIO DE LOGS, ONDE OS COLLERA A WEB
mv imgTempInOut.png /home/pi/cultivo/logs
mv imgLight.png /home/pi/cultivo/logs
mv imgHum.png /home/pi/cultivo/logs

#BORRANSE OS FICHEIROS PROVISIONAIS
rm tempout.temp
rm tempin.temp
rm hum.temp
rm light.temp

