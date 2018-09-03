#!/bin/bash

rm -rf /home/pi
cp -r /home/pi.save /home/pi
chown -R pi:pi /home/pi

exit 0