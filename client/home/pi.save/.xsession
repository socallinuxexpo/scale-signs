#!/bin/bash

# Disable DPMS / Screen blanking
xset dpms 0 0 0
xset -dpms
xset s off
xset s noblank

if [ -e /sys/class/input/mouse0 ]
then
  while true; do
	/usr/bin/reg.py
  done
else
  while true; do
	/usr/bin/web.py
  done
fi


openbox &

