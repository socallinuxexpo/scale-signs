#!/usr/bin/env bash

bad=0

c=0
for i in `cat server/sponsors.php | grep 'png\|jpg' | cut -d '"' -f 2`; do
	if [ ! -f server/images/sponsors/$i ]; then
		echo "from sponsors.php: $i is missing";
		bad=1
	fi;
	c=`expr $c + 1`
done;
echo "checked $c files in sponsors.php"

c=0
for i in `cat server/room.php | grep 'png\|jpg' | grep '=>' | cut -d '"' -f 4`; do
	if [ ! -f server/images/sponsors/$i ]; then
		echo "from room.php: $i is missing";
		bad=1
	fi;
	c=`expr $c + 1`
done;
echo "checked $c files in room.php"

exit $bad
