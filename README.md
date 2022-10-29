
# blogimus

![Lint Code Base image](https://github.com/gueff/blogimus/actions/workflows/super-linter.yml/badge.svg)

a PHP markdown Blog System using [myMVC](https://mymvc.ueffing.net/).

This is so called "_flat file blog system_", which means there is no database required.

Demo: [http://blog.ueffing.net](http://blog.ueffing.net)

## Overview

- [Features](#Features)
- [Requirements](#Requirements)
- [Installation](#Installation)
- [Run](#Run)
- [Creating Content](#Creating-Content)
- [Templating / Design](#Templating)
- [blogimus Screenshots](#blogimus-Screenshot)

## <a name="Features"></a> Features

- no Database required
- fast, secure and easy to understand
- automatic Indexing of new Posts, Pages
- automatic Post Overview - purified with [HTMLPurifier](http://htmlpurifier.org/) to avoid broken HTML
- using [Parsedown](https://github.com/erusev/parsedown) to convert Markdown into HTML
- automatic Tag list
- automatic Date list
- automatic meta tags: keyword, description
- Full text Search with Pulldown/Suggest Field included, no need to update any Index for this
- easily add a new Post as a markdown file
- easily add a new Page as a markdown file
- HTML5 Bootstrap Frontend with Bootswatch Design

## <a name="Requirements"></a> Requirements

- Linux OS
- Permission to execute these Linux binaries via PHP's `shell_exec` command: `ls`, `find`, `grep`, `head`, `md5sum`
- PHP >=5.4
- [myMVC 1.3.0](https://github.com/gueff/myMVC/releases/tag/1.3.0)

## <a name="Installation"></a> Installation

### Install & Run Bash Script

You can make use of the setup bash script. This will install Blogimus right at the place you call the command and run a php internal server on port 1969 when installation has finished.

~~~bash
export MVC_ENV="develop"; \
wget -qO - https://raw.githubusercontent.com/gueff/blogimus/master/etc/setupBlogimus.sh | bash
~~~

call: [http://127.0.0.1:1969](http://127.0.0.1:1969)

### Install by Hand

1. Download and install [myMVC 1.3.0](https://github.com/gueff/myMVC/releases/tag/1.3.0).
2. Install `blogimus` Module

- Download latest Release [blogimus](https://github.com/gueff/blogimus)
- Extract and place it into the myMVC's `module` folder.
- Make sure to name the folder `Blogimus`.
- Run the `install.sh` shell script which you will find inside Blogimus folder.

## <a name="Creating-Content"></a> Creating Content

The easiest Way is to use the **Backend**. Therefore you need to set up a user and password once:

After you [installed blogimus](#Installation) successfully, open  
`/modules/Blogimus/etc/config/Blogimus/config/{MVC_ENV}.php`  
and create an account for login.

**Example**

Creating an Account with user=`test` and password=`test`:

~~~php
// Backend User Accounts
// Notice: empty "user" or "password" means no login is possible
$aConfig['BLOG_BACKEND'] = array(

    // 1. account
    array(
        'user'   => 'test', 
        'password'  => 'test'
    ),

);
~~~

Just login by calling `/@` and create a post or page.

#### <a name="Creating-Content-manually"></a> Manually (optional)

Maybe you want to edit your Blog locally and `rsync` it to your Production `live` Server, or you just want to use the markdown editor of your choice (like ReText) locally, then the following way may be one for you.

**<a name="WriteAPost"></a> Write a Post**

Posts must have a leading `ISO Date` in the filename and a `.md` Suffix at the end.

1. cd to `/trunk/modules/blogimus/data/post/`
2. create a new file with the Syntax `YYYY-MM-DD.title.md`.

Examples:

- 2016-04-16.Linux: how to use iptables.md
- 2015-06-19.How to do this and that.md

Don't worry about spaces, colons and double-colons in the filename. It will work.

Now you can edit this file writing **Markdown** Syntax

**<a name="CreateAPage"></a> Create a Page**

cd to `/trunk/modules/blogimus/data/page/` and create a new file. The filename should represent the title of the new Page.

~~~bash
cd /trunk/modules/blogimus/data/page/
$ touch "Contact.md"
~~~

Now you can edit this file writing **Markdown** Syntax

## <a name="Templating"></a> Templating / Design

### Smarty Template Engine

As myMVC makes use of the [Smarty Template Engine](http://www.smarty.net/), so -of course- does blogimus.

See `/trunk/modules/blogimus/templates/` for the Smarty template files which will be used for blogimus.

### Frontend

For the Frontend, blogimus further makes use of

- [Bootstrap](http://getbootstrap.com/)
- [Bootswatch](http://bootswatch.com/)
- [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
- [jQuery](https://jquery.com/)
- [highlight.js](https://highlightjs.org/)

So blogimus makes use of Bootswatch 4, where its Design `cosmo` here is set as the default one.
But you can easily switch to another Bootswatch Design by changing in `/modules/blogimus/templates/layout/index.tpl`:

For example, you can change `cosmo`

~~~html
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/cosmo/bootstrap.min.css">
~~~

into `united`:

~~~html
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/united/bootstrap.min.css">
~~~

See  [Bootswatch](http://bootswatch.com/) for available Bootswatch Designs.

See Folder `/public/Blogimus/` for CSS and Scripts

## Events

- blogimus.controller.index.delegate.before
- blogimus.controller.index.delegate.page.before
- blogimus.controller.index.delegate.page.after
- blogimus.controller.index.delegate.post.before
- blogimus.controller.index.delegate.post.after
- blogimus.controller.index.delegate.date.before
- blogimus.controller.index.delegate.date.after
- blogimus.controller.index.delegate.tag.before
- blogimus.controller.index.delegate.tag.after
- blogimus.controller.index.delegate.overview.before
- blogimus.controller.index.delegate.overview.after
- blogimus.controller.index.delegate.notfound.before
- blogimus.controller.index.delegate.notfound.after
- blogimus.controller.index.delegate.after
- blogimus.controller.index.delegate.meta.after

___

- blogimus.controller.index.delegate.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.page.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.page.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.page.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.page.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aSet')->set_sValue($aSet)
));
~~~

- blogimus.controller.index.delegate.post.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.post.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.post.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.post.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aSet')->set_sValue($aSet)
));
~~~

- blogimus.controller.index.delegate.date.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.date.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aPostDate')->set_sValue($aPostDate)
));
~~~

- blogimus.controller.index.delegate.date.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.date.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aDate')->set_sValue($aDate)
));
~~~

- blogimus.controller.index.delegate.tag.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.tag.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aTag')->set_sValue($aTag)
));
~~~

- blogimus.controller.index.delegate.tag.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.tag.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aTagInterest')->set_sValue($aTagInterest)
));
~~~

- blogimus.controller.index.delegate.overview.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.overview.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.overview.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.overview.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('aPostOverview')->set_sValue($aPostOverview)
));
~~~

- blogimus.controller.index.delegate.notfound.before

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.notfound.before', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.notfound.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.notfound.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~

- blogimus.controller.index.delegate.meta.after

~~~
\MVC\Event::RUN('blogimus.controller.index.delegate.meta.after', DTArrayObject::create()->add_aKeyValue(
 DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
));
~~~
