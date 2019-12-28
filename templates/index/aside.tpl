
					<aside class="d-print-none">
                        
						<h3>Connect<br>
							<a href="/feed/post/" title="RSS Feed"><i class="fa fa-rss-square"></i></a>
{*							<a href="#" title="twitter"><i class="fa fa-twitter"></i></a>*}
{*							<a href="#" title="github"><i class="fa fa-github"></i></a>*}
{*							<a href="#" title="facebook"><i class="fa fa-facebook-official"></i></a>*}
{*							<a href="mailto:{'foo@example.com'|escape:"hexentity"}" title="E-Mail"><i class="fa fa-envelope"></i></a>*}
						</h3>             
                        
                        <h3>Dates <i class="fa fa-calendar-o"></i></h3>
                        <ul class="dates">
                            {foreach item=item key=year from=$aPostDate}<li>
                                <a href="/date/{$year}/" class="badge badge-primary">{$year}</a>

                                {foreach item=item2 key=month from=$item}<a href="/date/{$year}/{$month}/" class="badge badge-light">{$month}</a>
                                {/foreach}
                            </li>
                            {/foreach}
                        </ul>

                        <h3>Tags <i class="fa fa-tag"></i></h3>
                        <ul class="tags">
                            {foreach item=item key=key from=$aTag}<li>
                                <a href="/tag/{$key}/" class="badge badge-info">{$key} 
                                    <span class="badge-pill badge-primary">{count($item)}</span>
                                </a>
                            </li>
                            {/foreach}
                        </ul>
			
					</aside>