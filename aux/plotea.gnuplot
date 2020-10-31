set title "Humidade"
unset multiplot
set xdata time
set style data lines
set term png
set timefmt "%Y-%m-%d_%H%M"
set format x "%H:%M"
set xtics font ", 9"
set xlabel "Tempo"
set ylabel "Humidade"
set autoscale y
set autoscale x
set output "imgHum.png"
plot "hum.temp" using 1:2 smooth csp with lines notitle, "hum.temp" u 1:2 w points notitle
set title "Luz"
set ylabel "Luz"
set output "imgLight.png"
plot "light.temp" using 1:2 notitle, "light.temp" u 1:2 w points notitle
set title "Temperatura"
set ylabel "Temperatura"
set output "imgTempInOut.png"
plot "tempout.temp" using 1:2 smooth csp with lines title "Exterior", "tempin.temp" using 1:2 smooth csp with lines title "Interior"
