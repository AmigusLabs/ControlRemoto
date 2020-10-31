#!/usr/bin/python
import urllib2
import yaml
import time
import sys

#LECTURA DO FICHEIRO DE PARAMETROS
with open("/home/pi/cultivo/config.yaml", 'r') as stream:
    try:
        _config=yaml.load(stream)
	#PARAMETRO COA IP DO MODULO
	esp8266Hum01=_config.get('esp8266Hum01')
	logFolder=_config.get('logFolder')
	fileHumidity=_config.get('fileHumidity')	
    except yaml.YAMLError as exc:
        print(exc)

#O MODULO RESPONDE UNICAMENTE CO VALOR OBTIDO.
#FAISE A PETICION A DIRECCION CONFIGURADA
try:
	response = urllib2.urlopen(esp8266Hum01)
	html = response.read()
	response.close()
	#ESCRIBESE NO FICHEIRO DE LOG OU POR PANTALLA
	if len(sys.argv)>=2:
		if sys.argv[1]=="-o":
			print(html)
		else:
			print('Parametro desconocido. -o para imprimir por pantalla.')
	else:
		fecha=time.strftime("%Y-%m-%d_%H%M")
		outfile = open(logFolder+'/'+fileHumidity, 'a') # CONCATENA
		outfile.write(fecha+' '+html+'\n')
		outfile.close()
except urllib2.HTTPError, e:
	print('HTTP GET Error')
