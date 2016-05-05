

	

			
{* Backend Buttons *}
{if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
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
					  <span class="hide"><deleteUrl></deleteUrl></span>
				  </div>
			  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" id="modalBtnDelete" class="btn btn-danger" onclick="location.href=$('deleteUrl').text()">Delete</button>
		  </div>
		</div>
	  </div>
	</div>	

	<ul class="nav" style="position: fixed; top: 80px; right: 10px;z-index: 9999;"><i class="fa fa-key"></i> Backend
		<li>
			<a class="btn btn-info" href='/@'>
				<i class="fa fa-info"></i> Overview
			</a>
		</li>
		<li>
			<a class="btn btn-success" href='/@create'>
				<i class="fa fa-plus-square-o"></i> Create
			</a>
		</li>
		{if '@' != $sLoginToken && ('post' == $sPageType || 'page' == $sPageType)}
		<li>
			<a class="btn btn-warning" href='/@edit?a={ldelim}"type":"{$sPageType}","url":"{$sRequest}"{rdelim}'>
				<i class="fa fa-edit"></i> Edit
			</a>
		</li>								
		<li>
			<a class="btn btn-danger" 
			   href="#" 
			   data-deleteUrl='/@delete?a={ldelim}"type":"{$sPageType}","url":"{$sRequest}"{rdelim}' 
			   data-type="{$sPageType}" 
			   data-name="{$sTitle}"  
			   data-url="{$sRequest}"  
			   data-toggle="modal" 
			   data-target="#modalDelete" 
			   onclick="$('deleteUrl').text($(this).attr('data-deleteUrl'));$('modalDeleteType').text($(this).attr('data-type'));$('modalDeleteSpecific').html('<b>' + $(this).attr('data-name') + '</b>');$('modalDeleteUrl').text($(this).attr('data-url'));"
			   >
				<i class="fa fa-trash-o"></i> Delete
			</a>			
		</li>								
		{/if}
		<li>
			<a class="btn btn-default text-black" href='/@logout'>
				<i class="fa fa-sign-out"></i> Logout
			</a>
		</li>
	</ul>
{/if}	

				<nav class="navbar navbar-default navbar-fixed-top topShadow">
					  <div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<a id="brand" class="navbar-brand navbar-left text-shadow" href='/'>
								<i class="fa fa-square"></i> {$sBlogName}
							</a>								
						</div>

						<div id="navbar" class="navbar-collapse collapse">
						  <ul class="nav navbar-nav navbar-left">
							<li>
								<form class="navbar-form pull-left">
									<div class="form-group">
										<input type="text" 
											   class="visualizeConsumption form-control" 
											   id="inputSearch" 
											   placeholder="search…" 
											   maxlength="20" 
											   autocomplete="off" 
											   >					
									</div>
									<div id="suggest" class="shadow hide"></div>
								</form>					
							</li>
						  </ul>
						  <ul class="nav navbar-nav navbar-right">							 
							{foreach item=page from=$aPage}<li{if $smarty.server.REQUEST_URI == $page.sUrl} class="active"{/if}><a href="{$page.sUrl}">{$page.sName}</a></li>
							{/foreach}						  
						  </ul>

						</div>
					  </div>
				</nav>
