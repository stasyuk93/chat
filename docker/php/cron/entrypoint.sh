#!/bin/bash
# Run scheduler
while [ true ]
do
  php /var/www/chat/artisan schedule:run
  sleep 60
done