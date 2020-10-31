#!/usr/bin/python
import urllib2
import yaml
import time
import sys
import RPi.GPIO as GPIO

#LECTURA DO FICHEIRO DE PARAMETROS
with open("/home/pi/cultivo/config.yaml", 'r') as stream:
    try:
        _config=yaml.load(stream)
        #PARAMETRO COA IP DO MODULO
        pinServo=_config.get('pinServo')
	logFolder=_config.get('logFolder')
    except yaml.YAMLError as exc:
        print(exc)


GPIO.setmode(GPIO.BOARD)         #Ponhemos a Raspberry en modo BOARD
GPIO.setup(pinServo,GPIO.OUT)    #Ponhemos o pin do servo como saida
p = GPIO.PWM(pinServo,50)        #Ponhemos o pin do servo en modo PWM e enviamos 50 pulsos por segundo
p.start(4.5)                     #Enviamos un pulso do 4.5% para abrir as fiestras
time.sleep(0.5)
p.stop()                         #Detemos o servo 
GPIO.cleanup()                   #Limpamos os pines GPIO da Raspberry e cerramos o script

#ESCRIBE NO FICHEIRO PARA SABER COMO QUEDARON AS FIESTRAS
outfile = open(logFolder+'/'+"fiestraAberta", 'w') # SOBREESCRIBE
outfile.write('1\n')
outfile.close()

