# Blogixx

a markdown file Blog Module for [myMVC](https://www.mymvc.org/ )

Demo: http://blog.ueffing.net

## Overview
- [Requirements](#Requirements)
- [Features](#Features)
- [Installation](#Installation)
- [Run](#Run)
- [Write a Post](#WriteAPost)
- [Create a Page](#CreateAPage)
- [Templating / Design](#Templating)

##<a name="Requirements"> Requirements
- Linux OS
- PHP >=5.4
- [myMVC](https://www.mymvc.org/ )

For Production Environment you want a Webserver like Apache2. For develop or test you could easily run PHP's internal server (see [Run](#Run)).

##<a name="Features"> Features
- no Database required
- fast
- secure
- easy to understand
- automatic Indexing of new Posts, Pages
- automatic Post Overview - purified with [HTMLPurifier](http://htmlpurifier.org/) to avoid broken HTML
- using [Parsedown](https://github.com/erusev/parsedown) to comvert Markdown into HTML
- automatic Tag list
- automatic Date list 
- Full text Search with Pulldown/Suggest Field included, no need to update any Index for this
- easily add a new Post as a markdown file
- easily add a new Page as a markdown file
- makes fun :)

##<a name="Installation"> Installation

1. Install myMVC https://www.mymvc.org/ (PHP>= 5.4 required):
    
    for a "develop" Environment

        $ export MVC_ENV="develop"; svn co https://github.com/gueff/myMVC.git/trunk/ myMVC; cd myMVC/public; php index.php
        
2. Install Blogixx Module
    
    cd into myMVC's modules folder `myMVC/modules` and install Blogixx:

        $ svn co https://github.com/gueff/Blogixx.git/trunk/ Blogixx; cd Blogixx; ./install.sh;


_Install myMVC + Blogixx Module in one step:_

        $ export MVC_ENV="develop"; svn co https://github.com/gueff/myMVC.git/trunk/ myMVC; cd myMVC/public; php index.php; cd ../modules; svn co https://github.com/gueff/Blogixx.git/trunk/ Blogixx; cd Blogixx; ./install.sh;


##<a name="Run"> Run
cd to myMVC's `public/` folder and run php's internal server: 

        export MVC_ENV="develop"; php -S localhost:1969;
    
open Browser and call `http://localhost:1969`

you could also "simulate" `test` and `live` environments, by just set the specific value. E.g: `export MVC_ENV="test";php -S 127.0.0.1:1969;`, and `export MVC_ENV="live";php -S 127.0.0.1:1969;`

For a live/production environment i recommended to use Apache2 Webserver and a Domain pointing to that. Using Apache2 Webserver will allow you to make use the .htaccess file located in `/trunk/public/.htaccess`. In there, you easily can set the environment variable. But of course, you also can make use of Nginx. See myMVC 's documentation for more Info.

##<a name="WriteAPost"> Write a Post
1. cd to /trunk/modules/Blogixx/data/post/
2. say you want to post an article for date `2016-03-14`, then you need to create the folders:

    $ mkdir -p 2016/03/14
    
3. change into the new folder:

    cd 2016/03/14 
    
4. create a new file. The filename should represent the title of the new post.

    touch "Linux: how to use iptables.md"
   
Don't worry about spaces, colons and double-colons in the filename. It will work. 

Now you can edit this file writing **Markdown** Syntax

##<a name="CreateAPage"> Create a Page
1. cd to /trunk/modules/Blogixx/data/page/2
2. create a new file. The filename should represent the title of the new Page.

    touch "Contact.md"
    
Now you can edit this file writing **Markdown** Syntax
    


##<a name="Templating"> Templating / Design
See `/trunk/modules/Blogixx/templates/` for the Smarty template files which will be used for Blogixx.




 


