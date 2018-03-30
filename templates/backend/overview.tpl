
<h1>Overview</h1>

<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="nav-item active">
            <a class="nav-link active" href="#posts" aria-controls="posts" role="tab" data-toggle="tab">Posts</a>
        </li>
        <li role="presentation" class="nav-item">
            <a class="nav-link" href="#pages" aria-controls="pages" role="tab" data-toggle="tab">Pages</a>
        </li>
    </ul>

    <div class="tab-content prettyBorder shadow padding20 paper">
        <div role="tabpanel" class="tab-pane active" id="posts">
            
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="*"><i class="fa fa-eye"></i> Url</th>
                            <th scope="col" width="50%"><i class="fa fa-edit"></i> Name</th>
                            <th scope="col" width="100">Action</th>
                            <th scope="col" width="100" class="d-none d-md-table-cell">Created</th>
                            <th scope="col" width="150" class="d-none d-md-table-cell">Changed</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach key=sUrl item=aValue from=$aPost}
                        <tr>
                            <td>
                                <a class="btn btn-primary" href="{$sUrl}">
                                    <i class="fa fa-eye"></i>
                                </a><br>
                                <span class="d-none d-lg-block">
                                    <small>
                                        {$sUrl}
                                    </small>
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-warning" href='@edit?a={ldelim}"type":"post","url":"{$sUrl}"{rdelim}'>
                                    <span class="d-block d-sm-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:20:"[…]"}
                                    </span>
                                    <span class="d-none d-sm-block d-md-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:30:"[…]"}
                                    </span>
                                    <span class="d-none d-md-block d-lg-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:40:"[…]"}
                                    </span>
                                    <span class="d-none d-lg-block d-xl-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:65:"[…]"}
                                    </span>
                                    <span class="d-none d-xl-block">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:90:"[…]"}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <a class="btnDelete btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#modalDelete" data-type="post" data-url="{$sUrl}" data-name="{$aValue.sName}">
                                    <i class="fa fa-trash-o"></i> 
                                    <span class="d-none d-sm-inline-flex">
                                        Delete
                                    </span>
                                </a>
                            </td>
                            <td class="d-none d-md-table-cell">{$aValue.sCreateStamp}</td>
                            <td class="d-none d-md-table-cell">{$aValue.sChangeStamp}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>			
        </div>
        <div role="tabpanel" class="tab-pane" id="pages">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="*"><i class="fa fa-eye"></i> Url</th>
                            <th scope="col" width="50%"><i class="fa fa-edit"></i> Name</th>
                            <th scope="col" width="100">Action</th>
                            <th scope="col" width="100" class="d-none d-md-table-cell">Created</th>
                            <th scope="col" width="150" class="d-none d-md-table-cell">Changed</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach key=sUrl item=aValue from=$aPage}
                        <tr>
                            <td>
                                <a class="btn btn-primary" href="{$sUrl}">
                                    <i class="fa fa-eye"></i>
                                </a><br>
                                <small>
                                    {$sUrl}
                                </small>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-warning" href='@edit?a={ldelim}"type":"page","url":"{$sUrl}"{rdelim}'>
                                    <span class="d-block d-sm-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:20:"[…]"}
                                    </span>
                                    <span class="d-none d-sm-block d-md-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:30:"[…]"}
                                    </span>
                                    <span class="d-none d-md-block d-lg-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:40:"[…]"}
                                    </span>
                                    <span class="d-none d-lg-block d-xl-none">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:65:"[…]"}
                                    </span>
                                    <span class="d-none d-xl-block">
                                        <i class="fa fa-edit"></i> {$aValue.sName|truncate:90:"[…]"}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <a class="btnDelete btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#modalDelete" data-type="page" data-url="{$sUrl}" data-name="{$aValue.sName}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>	
                            <td>{$aValue.sCreateStamp}</td>
                            <td>{$aValue.sChangeStamp}</td>                            
                        </tr>
                    {/foreach}
                </tbody>
                </table>
            </div>			
        </div>
    </div>
</div>

				
