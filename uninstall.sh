#!/bin/bash

MVC_APPLICATION_PATH='../../application';

echo "removing Data...";
rm -rf	../../public/Blogixx*
rm -rf	data/page/*
rm -rf 	data/post/*
echo "...done!";

echo "uninstalling libraries...";
rm -rf	../../config/Blogixx*
echo "...done!";


