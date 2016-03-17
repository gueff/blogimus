#!/bin/bash

MVC_APPLICATION_PATH='../../application';

echo "removing Data...";
rm -rf	../../public/Blogixx*
rm -rf	./data
echo "...done!";

echo "uninstalling libraries...";
rm -rf	../../config/Blogixx*
echo "...done!";


