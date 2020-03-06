#!/usr/bin/env bash

bad=0

for i in `cat server/sponsors.php | grep png | cut -d '"' -f 2`; do
	if [ ! -f server/images/sponsors/$i ]; then
		echo "from sponsors.php: $i is missing";
		bad=1
	fi;
done;

for i in `cat server/room.php | grep png | grep '=>' | cut -d '"' -f 4`; do
	if [ ! -f server/images/sponsors/$i ]; then
		echo "from room.php: $i is missing";
		bad=1
	fi;
done;

exit $bad
