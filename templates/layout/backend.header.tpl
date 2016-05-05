
				<nav class="navbar navbar-default navbar-fixed-top topShadow">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<a id="brand" class="navbar-brand navbar-left" href='/'>
								<i class="fa fa-square"></i> {$sBlogName}
							</a>	
							

						</div>							
	
						{if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
						<div id="navbar" class="navbar-collapse collapse">
						  <ul class="nav navbar-nav navbar-left">
							<li{if $smarty.server.REQUEST_URI == '/@'} class="active"{/if}>
								<a class="btn btn-info" href="/@">
									<i class="fa fa-info"></i> Overview
								</a>				
							</li>
							<li{if $smarty.server.REQUEST_URI == '/@create'} class="active"{/if}>
								<a class="btn btn-success" href="/@create">
									<i class="fa fa-plus-square-o"></i> Create
								</a>				
							</li>
							{if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
							<li>
								<a class="btn btn-default text-black" href="/@logout">
									<i class="fa fa-sign-out"></i> Logout
								</a>
							</li>								
							{/if}						  
						  </ul>
						</div>							
						{/if}
						
					</div>						  
				</nav>
