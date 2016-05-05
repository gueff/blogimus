<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{$sTitle}</title>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cerulean/bootstrap.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/Blogixx/styles/backend.css">
		
		<link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
	</head>
	<body>
		<a name="top"></a>
		
		{* modal delete *}
		<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			  </div>
			  <div class="modal-body">
				  Please confirm Deletion of:<br><br>
				  <div class="ucfirst" style="text-indent: 1cm;">
					  <modalDeleteType></modalDeleteType>&nbsp;<modalDeleteSpecific></modalDeleteSpecific>
				  </div>
				  <div style="text-indent: 1cm;">
					  <modalDeleteUrl></modalDeleteUrl>
				  </div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" id="modalBtnDelete" class="btn btn-danger">Delete</button>
			  </div>
			</div>
		  </div>
		</div>	
		
		<div class="container">
			<header class="hidden-print">
				{include file="layout/backend.header.tpl"}				
			</header>

			<section>
				<div id="mainContent" class="col-lg-12">
					{$sContent}
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
		<script src="/Blogixx/scripts/backend.js" type="text/javascript"></script>
	</body>
</html>