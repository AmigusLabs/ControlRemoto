#!/usr/bin/python
import smbus
import time
import urllib2
import yaml
import sys

#LECTURA DO FICHEIRO DE PARAMETROS
with open("/home/pi/cultivo/config.yaml", 'r') as stream:
    try:
        _config=yaml.load(stream)
        #PARAMETRO COA IP DO MODULO
        logFolder=_config.get('logFolder')
        fileLight=_config.get('fileLight')
    except yaml.YAMLError as exc:
        print(exc)

# - Carga de modulo para I2C  -----------------------------------
miADC = smbus.SMBus(1) 
 
# - Rutina de lectura del valor ADC -----------------------------
#   X = canal a leer (1 a 4)
# ---------------------------------------------------------------
def leeINPUT(X):
    # Configuro registro de control para lectura de canal X
    miADC.write_byte_data(0x48, (0x40 + X),X) 
    time.sleep(0.2)
    lectura = miADC.read_byte(0x48) # read A/D
    return lectura

an1 = 255-leeINPUT(1)
an2 = leeINPUT(2)
an3 = leeINPUT(3)
an4 = leeINPUT(4)
nON = an1 / 10
nOFF = 25 - nON
an1 = 255-leeINPUT(1)
an2 = leeINPUT(2)
an3 = leeINPUT(3)
an4 = leeINPUT(4)
nON = an1 / 10
nOFF = 25 - nON

#ESCRIBESE NO FICHEIRO DE LOG OU POR PANTALLA
if len(sys.argv)>=2:
      if sys.argv[1]=="-o":
           print(str(an1).rjust(3))
      else:
	   print('Parametro desconocido. -o para imprimir por pantalla.')
else:
      fecha=time.strftime("%Y-%m-%d_%H%M")
      outfile = open(logFolder+'/'+fileLight, 'a') # CONCATENA
      outfile.write(fecha+' '+str(an1).rjust(3)+'\n')
      outfile.close()

