#!/bin/bash

sHere=`pwd`;
export MVC_ENV="develop";

#---------------------------------------------------
sStartTime=`date +%s`;
#---------------------------------------------------
# Installation

# myMVC
git clone https://github.com/gueff/myMVC.git --branch 1.3.0;
cd myMVC/public;
php index.php
cd $sHere;

# myMVC_module_Blogimus
cd myMVC/modules/;
git clone https://github.com/gueff/blogimus.git Blogimus;
cd Blogimus;
chmod a+x install.sh;
./install.sh
cd $sHere;

#---------------------------------------------------
# Ready

sEndTime=`date +%s`;
sRuntime=$((sEndTime-sStartTime));
echo -e "\nRuntime: $sRuntime Seconds\n\n";

#---------------------------------------------------
# Run
cd myMVC/public/;
./serve.sh
