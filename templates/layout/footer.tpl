
				<div class="container">
					<span class="pull-left">
						&copy; {$smarty.now|date_format:"%Y"} &bull; Blog built with <a href="https://blogixx.ueffing.net/">Blogixx</a><br>
						
						{if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
							{if '@' != $sLoginToken && ('post' == $sPageType || 'page' == $sPageType)}
							<i class="fa fa-edit"></i> <a href='/@edit?a={ldelim}"type":"{$sPageType}","url":"{$sRequest}"{rdelim}'>Edit</a>
							{/if}
						{else}
						<i class="fa fa-sign-in"></i> <a href="/@">Login</a>
						{/if}
					</span>
					<span class="pull-right d-print-none"><a href="#top"><i class="fa fa-arrow-up"></i> back to Top</a></span>	
				</div>

				<div class="space d-print-none"></div>
