#!/bin/bash

HOST="v0.ftp.upyun.com"
USER="Your FTP Username"
PASS="Your FTP Password"
LCD="Your Website Root Dir"
RCD="/"

lftp -c "open ftp://v0.ftp.upyun.com
user $USER $PASS;

lcd $LCD;

cd $RCD;

mirror --reverse --delete --dereference --verbose \
    --exclude-glob=*.php \
    --exclude-glob=*.txt \
    --exclude-glob=*.xml \
    --exclude-glob=*.htm \
    --exclude-glob=*.html \
    --exclude-glob=*.gz \
    --exclude-glob=*.psd \
    --exclude-glob=*.mo \
    --exclude-glob=*.po \
    --exclude-glob=*.pot \
    --exclude-glob=arthemia/ \
    --exclude-glob=ad/ \
    --exclude-glob=report/ \
    --verbose
;
"
