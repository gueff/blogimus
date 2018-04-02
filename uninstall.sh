#!/bin/bash

MVC_APPLICATION_PATH='../../application';

echo "removing Data...";
rm -rf	../../public/Blogimus*
rm -rf	./data
echo "...done!";

echo "uninstalling libraries...";
rm -rf	../../config/Blogimus*
echo "...done!";


