<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{$sTitle|escape}</title>
		{if isset($sMetaDescription)}<meta name="description" content="{$sMetaDescription|escape}">{/if}
		{if isset($sMetaKeywords)}<meta name="keywords" content="{$sMetaKeywords|escape}">{/if}
		<meta name="robots" content="index,follow">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cerulean/bootstrap.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/tomorrow-night-eighties.min.css">{*@see https://highlightjs.org/static/demo/*}		
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/shariff/1.23.0/shariff.min.css">	
		<link rel="stylesheet" href="/Blogixx/styles/blog.css">
		
		<link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
	</head>
	<body>
		<a name="top" class="hidden-print"></a>
		
		<div class="container">
			<header class="hidden-print">
				{include file="layout/header.tpl"}				
			</header>

			<section>
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
		
		<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>		
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>	
		<script src="//cdnjs.cloudflare.com/ajax/libs/shariff/1.23.0/shariff.min.js" type="text/javascript"></script>
		<script src="/Blogixx/scripts/blog.js" type="text/javascript"></script>
	</body>
</html>
