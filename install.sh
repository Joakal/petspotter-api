#!/bin/bash

composer install;
cp config/app_local.example.php config/app_local.php;
bin/cake migrations migrate;
bin/cake migrations seed;