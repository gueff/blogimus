		<div class="header">
			
			<nav class="nav nav-pills pull-right">

				<li>
					<form class="form-inline">
						<div class="form-group">
							<input type="text" 
								   class="form-control" 
								   id="inputSearch" 
								   placeholder="search…" 
								   autofocus="true" 
								   autocomplete="off" 
								   >
						</div>
						<div id="suggest" class="shadow hide"></div>
					</form>						
				</li>
				
				{foreach item=page from=$aPage}
				<li>
					<a href="{$page.sUrl}"{if $smarty.server.REQUEST_URI == $page.sUrl} class="active"{/if}>{$page.sName|print_r:true}</a>				
				</li>					
				{/foreach}
								
			</nav>
			
			<h3 class="text-muted">
				<a href="/">
				Blog
				</a>
			</h3>
			
		</div>
				
		<hr />