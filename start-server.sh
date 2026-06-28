#!/bin/bash
cd /home/z/my-project
while true; do
    php -S 127.0.0.1:3000 -t public server.php 2>>/tmp/php-server.log
    sleep 1
done