#!/bin/bash

sHere=`pwd`;
sMyMVCVersion="myMVC-master";
#export MVC_ENV="develop";

#---------------------------------------------------
sStartTime=`date +%s`;
#---------------------------------------------------
# Installation

# myMVC
svn co https://github.com/gueff/myMVC.git/trunk/ $sMyMVCVersion;
cd $sMyMVCVersion/public;
php index.php
cd $sHere;

# myMVC_module_Blogimus
cd $sMyMVCVersion/modules/;
svn co https://github.com/gueff/blogimus.git/trunk/ Blogimus;
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
cd myMVC-master/public/;
./serve.sh
