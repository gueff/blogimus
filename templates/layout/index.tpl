<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{$sTitle}</title>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/Blogixx/styles/blog.css">
	</head>
	<body>
		<a name="top"></a>
		<div class="container">
			{include file="layout/header.tpl"}

			<div id="mainContent" class="col-lg-10">
				{$sContent}
			</div>
			<div id="rightAside" class="col-lg-2">
				{include file="index/aside.tpl"}
			</div>

			<div class="clearfix"></div>
			{include file="layout/footer.tpl"}
		</div>  

		<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="/Blogixx/scripts/blog.js" type="text/javascript"></script>
	</body>
</html>