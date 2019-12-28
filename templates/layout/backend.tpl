<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$sTitle}</title>
        <meta name="robots" content="noindex,follow">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/cosmo/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night-eighties.min.css">{*@see https://highlightjs.org/static/demo/*}		
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />                
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/gueff/jquery-maxlengthVisualFeedback@2.2/maxlengthVisualFeedback.css"> 
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css" />
        <link rel="stylesheet" href="/Blogimus/styles/backend.css">
        <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
    </head>
    <body>
        <a name="top"></a>

        <div class="container-fluid">
            <header class="d-print-none">
                {include file="layout/backend.header.tpl"}				
            </header>

            <section class="row">
                <div id="mainContent" class="col-lg-12">
                    {$sContent}
                </div>
            </section>

            <div class="clearfix"></div>
        </div>  

        {include file="backend/modalDelete.tpl"}
        
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
        <script src="/Blogimus/scripts/popper.min.js"></script>{* this one is compatible to bootswatch materia theme *}
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
        <script src="//cdn.jsdelivr.net/gh/gueff/jquery-maxlengthVisualFeedback@2.2/maxlengthVisualFeedback.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/mode/markdown/markdown.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/addon/edit/continuelist.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/taggle/1.14.0/taggle.min.js"></script>
        <script>var aTagList = [{if isset($sTag)}{$sTag}{/if}];</script>
        <script src="/Blogimus/scripts/backend.js" type="text/javascript"></script>
    </body>
</html>