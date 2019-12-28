                    <br>
                                        
					{*<!-- a Page -->*}
					{if isset($sPage)}
                        <h1 title="{$sTitle}">
                            {$sTitle}<br>
                            <small>{if isset($aSet.sCreateStamp)}{$aSet.sCreateStamp|substr:0:10}{/if}</small>
                        </h1>
                        <div class="paper shadow prettyBorder padding20">
                            {if (isset($aSet.sCreateStamp) && isset($aSet.sChangeStamp)) && !strstr($aSet.sChangeStamp, $aSet.sCreateStamp)}<small><i class="fa fa-edit"></i> {if isset($aSet.sChangeStamp)}{$aSet.sChangeStamp}{/if}</small>{/if}
                            {$sPage}
                        </div>

                        <br>
  					{/if}

					{*<!-- a Post -->*}
					{if isset($sPost)}
                        <h1 title="{$sTitle}">
                            {$sTitle}<br>
                            <small>{if isset($aSet.sCreateStamp)}{$aSet.sCreateStamp|substr:0:10}{/if}</small>
                        </h1>
                        <div class="paper shadow prettyBorder padding20">
                            {if (isset($aSet.sCreateStamp) && isset($aSet.sChangeStamp)) && !strstr($aSet.sChangeStamp, $aSet.sCreateStamp)}<small><i class="fa fa-edit"></i> {if isset($aSet.sChangeStamp)}{$aSet.sChangeStamp}{/if}</small>{/if}
                            {$sPost}
                        </div>
                        <br>


                        {if !empty($aSuggestion)}
                            <h3>
                                More Blog Posts
                                <small>with similar Tags</small>
                            </h3>
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
                                            						
					{elseif isset($aDate.aYear)}	
                        <div class="paper shadow prettyBorder padding20">
                        {foreach item=aMonth key=key from=$aDate.aYear}
                            <h2>{$sDateRequested}-{$key}</h2>
                            {foreach item=item key=iDay from=$aMonth}
                                {$sDateRequested}-{$key}-{$iDay}<br>
                                {foreach item=item2 from=$item}
                                    <li><a href="{$item2.sUrl}">{$item2.sName}</a></li>
                                {/foreach}
                            {/foreach}
                        {/foreach}
                        </div>

                        <br>
                                            						
					{/if}

					{*<!-- Posts Overview -->*}
					{if isset($aPost)}

                        {include file="index/pagination.tpl"}

                        <br>

                        {foreach item=aArticle from=$aPost}<h2 title="{$aArticle.sName}">
                            <a href="{$aArticle.sUrl}" title="{$aArticle.sName}">{$aArticle.sName}</a><br>
                            <small>{if isset($aArticle.sCreateStamp)}{$aArticle.sCreateStamp}{/if}</small>
                        </h2>
                        <div class="paper prettyBorder padding20 shadow">
                            {$aArticle.sContent}
                        </div><br>
                        {/foreach}

                        {include file="index/pagination.tpl"}

					{/if}


