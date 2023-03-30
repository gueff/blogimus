#!/bin/bash

sHere=$(pwd);
export MVC_ENV="develop";

#---------------------------------------------------
sStartTime=$(date +%s);
#---------------------------------------------------
# Installation

# myMVC
git clone --branch 3.2.x https://github.com/gueff/myMVC.git;
cd myMVC/public || exit;
php index.php
cd "$sHere" || exit;

# myMVC_module_Blogimus
cd myMVC/modules/ || exit;
git clone --branch master https://github.com/gueff/blogimus.git Blogimus;
cd Blogimus || exit;
chmod a+x install.sh;
./install.sh
cd "$sHere" || exit;

#---------------------------------------------------
# Ready

sEndTime=$(date +%s);
sRuntime=$((sEndTime-sStartTime));
echo -e "\nRuntime: $sRuntime Seconds\n\n";

#---------------------------------------------------
# Run
cd myMVC/public/ || exit;
./serve.sh
