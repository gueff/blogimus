{* pagination for posts overview *}
<nav>
    <ul class="pagination flex-wrap d-print-none">
        <li class="page-item pagination-prev">
            <a class="page-link" href='?a={ldelim}"start":{$iMinus}{rdelim}' aria-label="Previous" title="Previous" rel="prev">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        {if null == $iArrayIndexStart && null == $iArrayIndexEnd}
            {foreach item=item key=key from=$aPaginationToGo}
                <li{if $aParam.start == $item.iA} class="page-item active"{/if}>
                    <a class="page-link" href='{$item.sUrl}'>{$item.iNr}</a>
                </li>
            {/foreach}
        {else}
            {if $iArrayIndexStart > 0}
                <li class="page-item disabled removable">
                    <a class="page-link">..</a>
                </li>
            {/if}
            {foreach item=item key=key from=$aPaginationToGo}
                {if $key >= $iArrayIndexStart && $key <= $iArrayIndexEnd}
                    <li{if $aParam.start == $item.iA} class="page-item active"{/if}>
                        <a class="page-link" href='{$item.sUrl}'>{$item.iNr}</a>
                    </li>
                {/if}
            {/foreach}
            {if $iArrayIndexEnd < ($iPaginationToGo-1)}
                <li class="page-item disabled removable">
                    <a class="page-link">..</a>
                </li>
            {/if}
        {/if}
        <li class="page-item pagination-next">
            <a class="page-link" href='?a={ldelim}"start":{$iPlus}{rdelim}' aria-label="Next" title="Next" rel="next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>