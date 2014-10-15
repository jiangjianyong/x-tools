#!/bin/sh

while true
do
	echo "$(date) $@" >>keep.log
	"$@"
	sleep 10s
done
