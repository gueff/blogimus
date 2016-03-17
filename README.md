# Blogixx

a markdown file Blog Module for [myMVC](https://www.mymvc.org/ )

## Requirements
- Linux OS
- PHP >=5.4
- [myMVC](https://www.mymvc.org/ )
- For Production only: a Webserver like Apache2

## Features
- no Database required
- fast
- secure
- automatic Indexing of new Posts, Pages
- automatic Post Overview
- automatic Tag list
- automatic Date list 
- Full text Search included, no need to update any Index for this
- easily add a new Post as a markdown file
- easily add a new Page as a markdown file

## Installation

1. Install myMVC https://www.mymvc.org/ (PHP>= 5.4 required)
2. cd into the modules folder `/trunk/modules` and download Blogixx from github via SVN or git:

    SVN:
    
        svn co https://github.com/gueff/Blogixx.git/trunk/ ./Blogixx

    git:
    
        git clone https://github.com/gueff/Blogixx.git ./Blogixx

3. cd into the new folder `Blogixx`, and run the install bash script:

	$ ./install.sh


## Run
1. cd to myMVC's /trunk/public/ 
2. run php internal server: `export MVC_ENV="develop";php -S 127.0.0.1:1969;`
3. open Browser and call `http://127.0.0.1:1969`

you could also "simulate" `test` and `live` environments, by just set the specific value. E.g: `export MVC_ENV="test";php -S 127.0.0.1:1969;`, and `export MVC_ENV="live";php -S 127.0.0.1:1969;`

For a live/production environment i recommended to use Apache2 Webserver and a Domain pointing to that. Using Apache2 Webserver will allow you to make use the .htaccess file located in `/trunk/public/.htaccess`. In there, you easily can set the environment variable. But of course, you also can make use of Nginx. See myMVC 's documentation for more Info.

## Write a Post
1. cd to /trunk/modules/Blogixx/data/post/
2. say you want to post an article for date `2016-03-14`, then you need to create the folders:

    $ mkdir -p 2016/03/14
    
3. change into the new folder:

    cd 2016/03/14 
    
4. create a new file. The filename should represent the title of the new post.

    touch "Linux: how to use iptables.md"
   
Don't worry about spaces, colons and double-colons in the filename. It will work. 

Now you can edit this file writing **Markdown** Syntax

## Create a Page
1. cd to /trunk/modules/Blogixx/data/page/2
2. create a new file. The filename should represent the title of the new Page.

    touch "Contact.md"
    
Now you can edit this file writing **Markdown** Syntax
    


## Templating / Design
See `/trunk/modules/Blogixx/templates/` for the Smarty template files which will be used for Blogixx.




 


