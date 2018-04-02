<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            {$sTitle|escape}
            {if isset($iPaginationPageCurrent)}Page {$iPaginationPageCurrent}{/if}
            {if isset($iPaginationPageMax)}/ {$iPaginationPageMax}{/if}
        </title>
        {if isset($sMetaDescription)}<meta name="description" content="{$sMetaDescription|escape}">{/if}
        {if isset($sMetaKeywords)}<meta name="keywords" content="{$sMetaKeywords|escape}">{/if}

        {if isset($aPost)}{* Posts Overview *}
        <meta name="robots" content="noindex,follow">
        <link rel="canonical" href="{$aCurrentRequest.protocol}{$aCurrentRequest.host}{$aCurrentRequest.path}">
        {elseif isset($sPage)}{* Page *}
        <meta name="robots" content="index,follow">
        <link rel="canonical" href="{$aCurrentRequest.full}">
        {elseif isset($sPost)}{* Post *}
        <meta name="robots" content="index,follow">
        <link rel="canonical" href="{$aCurrentRequest.full}">
        {else}
        <meta name="robots" content="noindex,follow">
        {/if}

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/cosmo/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night-eighties.min.css">{*@see https://highlightjs.org/static/demo/*}		
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/shariff/1.26.2/shariff.min.css">	
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/gueff/jquery-maxlengthVisualFeedback@2.2/maxlengthVisualFeedback.css"> 
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/css/lightbox.min.css">
        <link rel="stylesheet" href="/Blogimus/styles/blog.css">		

        <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
    </head>
    <body>
        <a name="top" class="d-print-none"></a>       
        
        <div class="container">
            <header class="d-print-none">
                {include file="layout/header.tpl"}				
            </header>
            
            <section class="row">
                <div id="mainContent" class="col-lg-9">
                    {if isset($sContent)}{$sContent}{/if}
                </div>
                <div class="col-lg-3">
                    {include file="index/aside.tpl"}
                </div>
            </section>

            <div class="clearfix"></div>

        </div>  

        <footer>
            {include file="layout/footer.tpl"}
        </footer>

        <!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->	
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>		
        <script src="/Blogimus/scripts/popper.min.js"></script>{* this one is compatible to bootswatch themes *}
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>                
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>	
        <script src="//cdnjs.cloudflare.com/ajax/libs/shariff/1.26.2/shariff.min.js" type="text/javascript"></script>
        <script src="//cdn.jsdelivr.net/gh/gueff/jquery-maxlengthVisualFeedback@2.2/maxlengthVisualFeedback.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js"></script>
        <script src="/Blogimus/scripts/blog.js" type="text/javascript"></script>
    </body>
</html>
