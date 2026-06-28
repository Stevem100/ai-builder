#!/bin/bash
cd /home/z/my-project
while true; do
    /usr/local/bin/php -S 0.0.0.0:3000 -t public server.php 2>>/home/z/my-project/dev.log
    sleep 1
done