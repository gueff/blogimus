
<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
        <a id="brand" class="navbar-brand" href="/">
            <i class="fa fa-square"></i> {$sBlogName}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0">
{*                        <input class="form-control mr-sm-2" type="text" placeholder="Search">*}
                        <div class="form-group">
                            <input type="text" 
                                    class="visualizeConsumption form-control" 
                                    id="inputSearch"    
                                    placeholder="search…" 
                                    maxlength="20" 
                                    autocomplete="off" 
                                    >					
                        </div>
                        <div id="suggest" class="shadow d-none"></div>
                    </form>                    				
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right ml-auto">							 
              {foreach item=page from=$aPage}<li class="nav-item{if $smarty.server.REQUEST_URI == $page.sUrl} active{/if}"><a class="nav-link" href="{$page.sUrl}">{$page.sName}</a></li>
              {/foreach}						  
            </ul>
        </div>
    </div>
</div>        


{* Backend Buttons *}
{if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
    
        {include file="backend/modalDelete.tpl"}	
        
        {* Backend Overlay Menu *}
        <div style="max-width: 20rem;position: fixed; bottom: 80px; left: 10px;z-index: 99;" 
             class="card bg-default"
             >
          <div class="card-header">
              <i class="fa fa-key"></i> Backend
          </div>
          <div class="card-body">
                <div class="list-group">
                    
{*                    <a class="list-group-item list-group-item-action text-white bg-info" href='/@'>
                        <i class="fa fa-info"></i> Overview
                    </a>  *}          
                    
                    <a class="list-group-item list-group-item-action text-white bg-success tooltipper" href="/@create" data-toggle="tooltip" data-placement="right" title="" data-original-title="Create new Content">
                        <i class="fa fa-plus-square-o"></i> Create
                    </a>
                    
                    <!-- Edit -->
                    {if '@' != $sLoginToken && ('post' == $sPageType || 'page' == $sPageType)}
                    <a class="list-group-item list-group-item-action text-white bg-warning tooltipper" href='/@edit?a={ldelim}"type":"{$sPageType}","url":"{$sRequest}"{rdelim}' data-toggle="tooltip" data-placement="right" title="" data-original-title="Edit this Content">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    {else}
                    <button href="#" class="list-group-item list-group-item-action bg-warning disabled">
                        <i class="fa fa-eye"></i> Edit
                    </button>                        
                    {/if}
                        
                    <!-- Delete -->
                    {if '@' != $sLoginToken && ('post' == $sPageType || 'page' == $sPageType)}
                    <a class="list-group-item list-group-item-action text-white bg-danger" 
                       href="#" 
                       data-deleteUrl='/@delete?a={ldelim}"type":"{$sPageType}","url":"{$sRequest}"{rdelim}' 
                       data-type="{$sPageType}" 
                       data-name="{$sTitle}"  
                       data-url="{$sRequest}"  
                       data-toggle="modal" 
                       data-target="#modalDelete" 
                       onclick="$('deleteUrl').text($(this).attr('data-deleteUrl'));$('modalDeleteType').text($(this).attr('data-type'));$('modalDeleteSpecific').html('<b>' + $(this).attr('data-name') + '</b>');$('modalDeleteUrl').text($(this).attr('data-url'));"
                       >
                        <i class="fa fa-trash-o"></i> Delete
                    </a>	
                    {else}
                    <button href="#" class="list-group-item list-group-item-action bg-danger disabled">
                        <i class="fa fa-eye"></i> Delete
                    </button>
                    {/if}
                
                    <!-- Logout -->
                    {if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
                    <a class="list-group-item list-group-item-action text-white bg-info tooltipper" href="/@logout" data-toggle="tooltip" data-placement="right" title="" data-original-title="Logout from Backend">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                    {/if}
                </div>   
          </div>
        </div>   
{/if}            