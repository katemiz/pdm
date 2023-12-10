#!/bin/sh
# Laravel App Ownership Script

sudo chown -R www-data:www-data /www/PDM
sudo chmod -R 755 /www/PDM/storage
sudo chmod -R 755 /www/PDM/bootstrap/cache
sudo chmod 600 /www/PDM/.env


sudo chown -R www-data:www-data /STORAGE
