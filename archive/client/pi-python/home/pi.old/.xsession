#!/bin/bash

#while true; do
openbox &
 # Clean out existing profile information
  #  rm -rf /home/pi/.cache;
  #  rm -rf /home/pi/.config;
  #  rm -rf /home/pi/.pki;
 # Disable DPMS / Screen blanking
#xset dpms 0 0 0
xset -dpms
xset s off
#xset s noblank

if [ -e /sys/class/input/mouse0 ]
then
#  while true; do
	/usr/bin/reg.py
#xterm
#  done
else
#  while true; do
	/usr/bin/web.py
#  done
fi



  #eReset the framebuffer's colour-depth
#  fbset -depth $( cat /sys/module/*fb*/parameters/fbdepth );
#  openbox & 
#  while true; do
#   /usr/bin/web.py
#xterm &
#  done;

# /usr/bin/web.py &
#openbox

#done;
