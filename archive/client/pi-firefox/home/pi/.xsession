openbox &
xset dpms 0 0 0
xset -dpms
xset s 0 0 s off s noblank
# if we have a mouse, we are a registration computer, otherwise we are a sign computer, pick the appropriate URL

if [ -e /sys/class/input/mouse0 ]
then
  while [ 1 ]
  do
    firefox -private -no-remote https://reg.socallinuxexpo.org/reg6?kiosk=1
  done
else
  # if we don't have a mouse, use xwit to move the mouse out of the way so we don't have a mouse pointer in the middle of a sign
  xwit -root -warp 2000 2000
  while [ 1 ]
    do firefox -no-remote http://signs.expo.socallinuxexpo.org
  done
fi
