{literal}
<style>
	#markdownEdit {
		width: 100%;
		height: 300px;
	}
	.btnWidth100 {
		width: 100%;
	}
</style>
{/literal}

<h1>
	<i class="fa fa-edit"></i> 
	{$sName} <a class="btnDelete btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#modalDelete" data-type="{$sType}" data-url="{$aParam.url}" data-name="{$sName}"><i class="fa fa-trash-o"></i> Delete</a><br>
	<small><i class="fa fa-eye"></i><a href="{$aParam.url}">{$aParam.url}</a></small>
</h1>

{if isset($sError) && '' != $sError}
<p class="text-danger">
	{$sError}
</p>
{/if}

<form action="" 
	  method="post" 
	  >
	
	<button type="submit" class="btn btn-warning btnWidth100">Save</button>
	
	<input type="hidden" name="type" value="{$sType}">
	<br>
	<br>
	
	<div class="form-group{if 'post' != $sType} hide{/if}">
		<label for="date">Date</label>
		<input type="text" 
			   id="date" 
			   class="form-control" 
			   name="date" 
			   value="{if '' != $sDate}{$sDate}{else}{$smarty.now|date_format:"%Y-%m-%d"}{/if}"  
			   placeholder="yyyy-mm-dd" 
			   {if 'post' != $sType}disabled="disabled" {/if}
			   >
	</div>
	
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" 
			   id="title" 
			   class="visualizeConsumption form-control" 
			   name="title" 
			   value="{$sName}" 
			   placeholder="Title" 
			   autofocus="autofocus" 
			   maxlength="{$BLOG_CREATE_MAX_TITLE}" 
			   >
	</div>	
	
	<label for="markdownEdit">Content</label>
	<textarea id="markdownEdit" 
			  class="visualizeConsumption markdown prettyBorder shadow padding20" 
			  name="sMarkdown" 
			  maxlength="{$BLOG_CREATE_MAX_CONTENT}"
			  >{$sMarkdown}</textarea>				  
	<button type="submit" class="btn btn-warning btnWidth100">Save</button>
</form>