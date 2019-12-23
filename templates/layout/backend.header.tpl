<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
        <a id="brand" class="navbar-brand tooltipper" href="/" data-toggle="tooltip" data-placement="top" title="" data-original-title="Call Frontend Homepage">
            <i class="fa fa-square"></i> {$sBlogName}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                
{*                <li{if $smarty.server.REQUEST_URI == '/@'} class="active"{/if}>
                    <a class="btn btn-info" href="/@">
                        <i class="fa fa-info"></i> Overview
                    </a>				
                </li>*}
                
                <!-- Create -->
                <li{if $smarty.server.REQUEST_URI == '/@create'} class="active"{/if}>
                    <a class="btn btn-success tooltipper" href="/@create" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create new Content">
                        <i class="fa fa-plus-square-o"></i> Create
                    </a>				
                </li>                
                
                <!-- Frontend -->
                {if $smarty.server.REQUEST_URI|stristr:'/@edit'}
                    <li class="active">
                        <a class="btn btn-primary tooltipper" href="{$aParam.url}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Watch this in Frontend">
                            <i class="fa fa-eye"></i> Frontend
                        </a>
                    </li>    
                {else}
                    <li>
                        <a href="#" class="btn btn-primary disabled">
                            <i class="fa fa-eye"></i> Frontend
                        </a>
                    </li>
                {/if}


                <!-- Files -->
                <li>
                    <a class="btn btn-primary text-white tooltipper" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Files">
                        <i class="fa fa-file"></i> Files
                    </a>
                </li>

                <!-- Delete -->
                {if $smarty.server.REQUEST_URI|stristr:'/@edit'}
                <li class="active">
                    <a class="btnDelete btn btn-xs btn-danger tooltipper" 
                       href="#" 
                       data-toggle="modal" 
                       data-target="#modalDelete" 
                       data-type="{$sType}" 
                       data-url="{$aParam.url}" 
                       data-name="{$sName}" 
                       >
                        <i class="fa fa-trash-o"></i> Delete
                    </a>
                </li>
                {else}
                    <li>
                        <a href="#" class="btn btn-danger disabled">
                            <i class="fa fa-eye"></i> Delete
                        </a>
                    </li>                
                {/if}
                
                <!-- Logout -->
                {if isset($smarty.session.blogixx.login) && 'true' == $smarty.session.blogixx.login}
                <li>
                    <a class="btn btn-primary text-white tooltipper" href="/@logout" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout from Backend">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>								
                {/if}
            </ul>
        </div>
    </div>
</div>     
