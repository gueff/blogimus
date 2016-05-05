
					<aside class="hidden-print">

						<h3>Dates <i class="fa fa-calendar-o"></i></h3>
						<ul class="dates">
							{foreach item=item key=year from=$aPostDate}<li>
								<a href="/date/{$year}/" class="label label-primary">{$year}</a>

								{foreach item=item2 key=month from=$item}<a href="/date/{$year}/{$month}/" class="label label-default">{$month}</a>
								{/foreach}

							</li>
							{/foreach}
						
						</ul>

						<h3>Tags <i class="fa fa-tag"></i></h3>
						<ul class="tags">
							{foreach item=item key=key from=$aTag}<li>
								<a href="/tag/{$key}/" class="label label-info">{$key} 
									<span class="badge">{count($item)}</span>
								</a>
							</li>
							{/foreach}
						</ul>
						
					</aside>