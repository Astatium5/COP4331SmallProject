#!/bin/bash
# A server deployment script
# runs with with "bash deploy.sh"


# example directory: /home/dmitrii/Downloads/proj/:
read -p 'Enter the directory of your project: ' directory
cd $directory
git pull

scp -r $directory root@161.35.190.41:/var/www/html/
