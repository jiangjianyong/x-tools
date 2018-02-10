#!/bin/sh

rm -f $1-`date -d "-10days" "+%Y-%m-%d"`.*gz
