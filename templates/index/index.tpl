

	
<!-- a Page -->
{if isset($sPage)}
	<div class="paper shadow postOverviewpreview">
		{$sPage}
	</div>
{/if}

<!-- a Post -->
{if isset($sPost)}
	<h1>
		{$sTitle}<br />
		<small>{$aSet.sCreateStamp}</small>
	</h1>
	<div class="paper shadow postOverviewpreview">
		{$sPost}
	</div>
{/if}

<!-- TagList -->
{if isset($aTagInterest)}
	<h1>{$sTagInterest}</h1>
	<div class="paper shadow postOverviewpreview">
		<ul>
		{foreach item=aTag from=$aTagInterest}
			<li><a href="{$aTag.sUrl}">{$aTag.sName}</a></i>
		{/foreach}	
		</ul>
	</div>
{/if}

<!-- Date List -->
{if isset($sDateRequested)}
	<h1>{$sDateRequested}</h1>
{/if}

{if isset($aDate.aDay)}
	<div class="paper shadow postOverviewpreview">
	{foreach item=item from=$aDate.aDay}
		<li><a href="{$item.sUrl}">{$item.sName}</a></li>
	{/foreach}		
	</div>	
{elseif isset($aDate.aMonth)}
	<div class="paper shadow postOverviewpreview">
	{foreach item=aDay key=key from=$aDate.aMonth}
		{$sDateRequested}-{$key}:
		{foreach item=item from=$aDay}
		<li><a href="{$item.sUrl}">{$item.sName}</a></li>
		{/foreach}		
	{/foreach}		
	</div>	
{elseif isset($aDate.aYear)}	
	<div class="paper shadow postOverviewpreview">
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
{/if}

<!-- Posts Overview -->
{if isset($aPost)}

	<nav>
		<ul class="pagination">
			<li>
				<a href='?a={ldelim}"start":{$iMinus}{rdelim}' aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			{foreach item=item key=key from=$aPaginationToGo}
				<li{if $aParam.start == $item.iA} class="active"{/if}><a href='{$item.sUrl}'>{$item.iNr}</a></li>
			{/foreach}
			<li>
				<a href='?a={ldelim}"start":{$iPlus}{rdelim}' aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>		
	
	{foreach item=aArticle from=$aPost}
		<h2>
			<a href="{$aArticle.sUrl}">{$aArticle.sName}</a><br />
			<small>{$aArticle.sCreateStamp}</small>
		</h2>				
		<div class="paper postOverviewpreview shadow">
			{$aArticle.sContent}
		</div>
	{/foreach}		
	
	<nav>
		<ul class="pagination">
			<li>
				<a href='?a={ldelim}"start":{$iMinus}{rdelim}' aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			{foreach item=item key=key from=$aPaginationToGo}
				<li{if $aParam.start == $item.iA} class="active"{/if}><a href='{$item.sUrl}'>{$item.iNr}</a></li>
			{/foreach}
			<li>
				<a href='?a={ldelim}"start":{$iPlus}{rdelim}' aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>		

{/if}


