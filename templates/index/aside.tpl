				<aside>
					
					<h3>by Date</h3>
					<ul>
					{foreach item=item key=year from=$aPostDate}
						<li>
							<a href="/date/{$year}/">{$year}</a>
							<br />
							{foreach item=item2 key=month from=$item}
							<a href="/date/{$year}/{$month}/">-{$month},</a>
								{*
								<ul>
								{foreach item=item3 key=key3 from=$item2}								
								<li><a href="/date/{$year}/{$month}/{$key3}/">{$key3}</a></li>
								{/foreach}
								</ul>
								*}
							{/foreach}
						</li>
					{/foreach}
					</ul>
					
					<h3>by Tag</h3>
					<ul>
						{foreach item=item key=key from=$aTag}
							<li><a href="/tag/{$key}/">{$key} <sup>{count($item)}</sup></a></li>
						{/foreach}
					</ul>
				</aside>