
<h1>Overview</h1>

<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#posts" aria-controls="posts" role="tab" data-toggle="tab">Posts</a></li>
		<li role="presentation"><a href="#pages" aria-controls="pages" role="tab" data-toggle="tab">Pages</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="posts">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<tr>
						<th><i class="fa fa-eye"></i> Url</th>
						<th><i class="fa fa-edit"></i> Name</th>
						<th>Action</th>
						<th>Created</th>
						<th>Changed</th>
					</tr>
				{foreach key=sUrl item=aValue from=$aPost}
					<tr>
						<td><a href="{$sUrl}">{$sUrl}</a></td>
						<td><a class="btn btn-xs btn-warning" href='@edit?a={ldelim}"type":"post","url":"{$sUrl}"{rdelim}'><i class="fa fa-edit"></i> {$aValue.sName}</a></td>
						<td>
							<a class="btnDelete btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#modalDelete" data-type="post" data-url="{$sUrl}" data-name="{$aValue.sName}"><i class="fa fa-trash-o"></i> Delete</a>
						</td>
						<td>{$aValue.sCreateStamp}</td>
						<td>{$aValue.sChangeStamp}</td>
					</tr>
				{/foreach}
				</table>
			</div>			
		</div>
		<div role="tabpanel" class="tab-pane" id="pages">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<tr>
						<th><i class="fa fa-eye"></i> Url</th>
						<th><i class="fa fa-edit"></i> Name</th>
						<th>Action</th>
					</tr>
				{foreach key=sUrl item=aValue from=$aPage}
					<tr>
						<td><a href="{$sUrl}">{$sUrl}</a></td>
						<td><a class="btn btn-xs btn-warning" href='@edit?a={ldelim}"type":"page","url":"{$sUrl}"{rdelim}'><i class="fa fa-edit"></i> {$aValue.sName}</a></td>
						<td>
							<a class="btnDelete btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#modalDelete" data-type="page" data-url="{$sUrl}" data-name="{$aValue.sName}"><i class="fa fa-trash-o"></i> Delete</a>
						</td>						
					</tr>
				{/foreach}
				</table>
			</div>			
		</div>
	</div>
</div>

				
