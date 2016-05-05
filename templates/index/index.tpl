
					{*<!-- a Page -->*}
					{if isset($sPage)}
						<h1 title="{$sTitle}">
							{$sTitle}
						</h1>	
						<div class="paper shadow prettyBorder padding20">
							{$sPage}
						</div>
						
						<br>
						<div class="shariff"></div>						
					{/if}

					{*<!-- a Post -->*}
					{if isset($sPost)}
						<h1 title="{$sTitle}">
							{$sTitle}<br />
							<small>{$aSet.sCreateStamp}</small>
						</h1>
						<div class="paper shadow prettyBorder padding20">
							{$sPost}
						</div>
						<br>
						<div class="shariff"></div>						
						
						{if !empty($aSuggestion)}
							<h3>Weitere Artikel <small>mit gleichen Tags</small></h3>
						<div class="paper shadow prettyBorder padding20">
							{foreach key=sName item=aValue from=$aSuggestion}
								<li><a href="/tag/{$aValue.sTag}/"><span class="label label-info">{$aValue.sTag}</span></a> - <a href="{$aValue.sUrl}">{$sName}</a></i>
							{/foreach}	
						</div>
						<br>
						{/if}						
					{/if}

					{*<!-- TagList -->*}
					{if isset($aTagInterest)}
						<h1 title="{$sTagInterest}">{$sTagInterest}</h1>
						<div class="paper shadow prettyBorder padding20">
							<ul>
							{foreach item=aTag from=$aTagInterest}
								<li><a href="{$aTag.sUrl}">{$aTag.sName}</a></i>
							{/foreach}	
							</ul>
						</div>
							
						<br>
						<div class="shariff"></div>
					{/if}

					{*<!-- Date List -->*}
					{if isset($sDateRequested)}
						<h1 title="{$sDateRequested}">{$sDateRequested}</h1>
					{/if}

					{if isset($aDate.aDay)}
						<div class="paper shadow prettyBorder padding20">
						{foreach item=item from=$aDate.aDay}
							<li><a href="{$item.sUrl}">{$item.sName}</a></li>
						{/foreach}		
						</div>	
							
						<br>
						<div class="shariff"></div>						
					{elseif isset($aDate.aMonth)}
						<div class="paper shadow prettyBorder padding20">
						{foreach item=aDay key=key from=$aDate.aMonth}
							{$sDateRequested}-{$key}:
							{foreach item=item from=$aDay}
							<li><a href="{$item.sUrl}">{$item.sName}</a></li>
							{/foreach}		
						{/foreach}		
						</div>	
							
						<br>
						<div class="shariff"></div>						
					{elseif isset($aDate.aYear)}	
						<div class="paper shadow prettyBorder padding20">
						{foreach item=aMonth key=key from=$aDate.aYear}
							<h2>{$sDateRequested}-{$key}</h2>		
							{foreach item=item key=iDay from=$aMonth}
								{$sDateRequested}-{$key}-{$iDay}<br />
								{foreach item=item2 from=$item}
									<li><a href="{$item2.sUrl}">{$item2.sName}</a></li>
								{/foreach}			
							{/foreach}					
						{/foreach}		
						</div>			
							
						<br>
						<div class="shariff"></div>						
					{/if}

					{*<!-- Posts Overview -->*}
					{if isset($aPost)}

						<nav>
							<ul class="pagination">
								<li>
									<a href='?a={ldelim}"start":{$iMinus}{rdelim}' aria-label="Previous" title="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								{foreach item=item key=key from=$aPaginationToGo}
									<li{if $aParam.start == $item.iA} class="active"{/if}><a href='{$item.sUrl}'>{$item.iNr}</a></li>
								{/foreach}
								<li>
									<a href='?a={ldelim}"start":{$iPlus}{rdelim}' aria-label="Next" title="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>		

						{foreach item=aArticle from=$aPost}<h2 title="{$aArticle.sName}">
							<a href="{$aArticle.sUrl}" title="{$aArticle.sName}">{$aArticle.sName}</a><br />
							<small>{$aArticle.sCreateStamp}</small>
						</h2>				
						<div class="paper prettyBorder padding20 shadow">
							{$aArticle.sContent}
						</div>
						{/foreach}		

						<nav>
							<ul class="pagination">
								<li>
									<a href='?a={ldelim}"start":{$iMinus}{rdelim}' aria-label="Previous" title="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								{foreach item=item key=key from=$aPaginationToGo}<li{if $aParam.start == $item.iA} class="active"{/if}><a href='{$item.sUrl}'>{$item.iNr}</a></li>
								{/foreach}
								
								<li>
									<a href='?a={ldelim}"start":{$iPlus}{rdelim}' aria-label="Next" title="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>		
							
						<div class="shariff"></div>						

					{/if}


