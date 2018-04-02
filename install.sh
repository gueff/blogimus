#!/bin/bash

MVC_APPLICATION_PATH='../../application';

echo "copying Data...";
cp -r ./_INSTALL/config/*			../../config/
cp -r ./_INSTALL/public/*			../../public/
cp -r ./_INSTALL/data				./
echo "...done!";

echo "installing libraries...";
php $MVC_APPLICATION_PATH/composer.phar --working-dir=../../config/Blogimus/ install;
echo "...done!";


