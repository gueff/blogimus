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

<h1><i class="fa fa-plus-square-o"></i> Create</h1>

{if isset($sError) && '' != $sError}
<p class="text-danger">
	{$sError}
</p>
{/if}
{if isset($bSuccess) && 'true' == $bSuccess}
<p class="text-success">
	successfully created: "{$sFilename}"
</p>
{/if}

<form action="" 
	  method="post" 
	  >
	
	<button type="submit" class="btn btn-success btnWidth100">Save</button>
	<div class="radio">
		<label>
			<input type="radio" name="type" value="post" checked onclick="document.getElementById('date').disabled = false;">
			Post
		</label>
	</div>
	<div class="radio">
		<label>
			<input type="radio" name="type" value="page" onclick="document.getElementById('date').disabled = true;">
			Page
		</label>
	</div>
	
	<div class="form-group">
		<label for="date">Date <small class="text-muted">mandatory when creating a Post</small></label>
		<input type="text" id="date" class="form-control" name="date" value="{$smarty.now|date_format:"%Y-%m-%d"}" placeholder="yyyy-mm-dd">
	</div>
	
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" 
			   id="title" 
			   class="visualizeConsumption form-control" 
			   name="title" 
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
			  ></textarea>				  
	<button type="submit" class="btn btn-success btnWidth100">Save</button>
</form>
		