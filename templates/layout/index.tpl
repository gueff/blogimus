<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$sTitle|escape}{if isset($iPaginationPageCurrent)}Page {$iPaginationPageCurrent}{/if}{if isset($iPaginationPageMax)}/ {$iPaginationPageMax}{/if}</title>
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

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/cosmo/bootstrap.min.css">
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

        <noscript>
            <h1>JavaScript</h1>
            <p>
                This website uses JavaScript to provide you with the best possible service.<br>
                See our <a href="#">Privacy Policy</a> for more information.<br>
                <b><i class="fa fa-warning text-warning"></i> Please make sure that you accept JavaScript in your browser.</b>
            </p>
        </noscript>

        <div id="myMVC_cookieConsent">
            This website uses Cookies to provide you with the best possible service. Please see our <a href="#">Privacy Policy</a> for more information.
            Click the check box below to accept cookies.
            Then confirm with a click on "Save".
            <input id="myMVC_cookieConsentCheckbox" type="checkbox" name="checked" value="0">
            <label for="myMVC_cookieConsentCheckbox">Yes, cookies may be saved.</label>
            <button class="btn btn-warning">
                Save
            </button>
        </div>

        <footer>
            {include file="layout/footer.tpl"}
        </footer>

        <!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="/myMVC/assets/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="/Blogimus/scripts/popper.min.js"></script>{* this one is compatible to bootswatch themes *}
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/shariff/1.26.2/shariff.min.js" type="text/javascript"></script>
        <script src="//cdn.jsdelivr.net/gh/gueff/jquery-maxlengthVisualFeedback@2.2/maxlengthVisualFeedback.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js"></script>
        <script src="/myMVC/scripts/cookieConsent.js" type="text/javascript"></script>
        <script src="/Blogimus/scripts/blog.js" type="text/javascript"></script>
    </body>
</html>
