{literal}
<style>
    #markdownEdit, #preview {
        width: 100%;
    }
    
    #preview {
        background-color: #fff;
        overflow: auto;
    }
    .btnWidth100 {
        width: 100%;
    }
    
    /** codemirror
    */
    .CodeMirror {
        height: auto;
        box-shadow: 0px 0px 10px #d0d0d0;
        border: 1px solid #d0d0d0;
    }
</style>
{/literal}

<div class="row col-lg-12">
    <div class="pull-left">    
        <h1>

            <span class="d-block d-sm-none pull-left">
                <i class="fa fa-edit"></i> {$sName|truncate:18:"[…]"}
            </span>
            <span class="d-none d-sm-block d-md-none pull-left">
                <i class="fa fa-edit"></i> {$sName|truncate:25:"[…]"}
            </span>
            <span class="d-none d-md-block d-lg-none pull-left">
                <i class="fa fa-edit"></i> {$sName|truncate:40:"[…]"}
            </span>
            <span class="d-none d-lg-block d-xl-none pull-left">
                <i class="fa fa-edit"></i> {$sName|truncate:55:"[…]"}
            </span>
            <span class="d-none d-xl-block pull-left">
                <i class="fa fa-edit"></i> {$sName|truncate:65:"[…]"}
            </span> 
            <br>

        </h1>
    </div>    
</div>

{if isset($sError) && '' != $sError}
<p class="text-danger">
    {$sError}
</p>
{/if}

<form action="" 
      method="post" 
      >
	
	<input type="hidden" name="type" value="{$sType}">
	
	<div class="form-group row">
        <div class="col-7 col-sm-7 col-lg-9 col-xl-9">
            <label for="title">Title</label>
            <input type="text" 
                    id="title" 
                    class="maxlengthVisualFeedback form-control" 
                    name="title" 
                    value="{$sName|escape}" 
                    placeholder="Title" 
                    autofocus="autofocus" 
                    autocomplete="off" 
                    maxlength="{$BLOG_CREATE_MAX_TITLE}" 
                    tabindex="1" 
                    required="1" 
                    >
        </div>
        <div class="col-5 col-sm-5 col-lg-3 col-xl-3">            
            <label for="date">Date of Creation</label>
            <input type="date" 
                    id="date" 
                    class="form-control" 
                    maxlength="10" 
                    name="date" 
                    autocomplete="off" 
                    value="{if '' != $sDate}{$sDate|escape}{else}{$smarty.now|date_format:"%Y-%m-%d"}{/if}"  
                    placeholder="yyyy-mm-dd" 
                    tabindex="2" 
                    required="1"  
                    {if 'post' != $sType}disabled="disabled" {/if}
                    >
        </div>
	</div>	
    <div class="clearfix"></div>
	
    {*  Editor + Preview
            Markdown Syntax Highlighting
                @see https://codemirror.net/mode/markdown/
    *}
    <div class="form-group row" id="editor">
        <div class="col-lg-6">
            <label for="markdownEdit">Content</label>
            <textarea id="markdownEdit" 
                              class="maxlengthVisualFeedback prettyBorder shadow padding20" 
                              name="sMarkdown" 
                              maxlength="{$BLOG_CREATE_MAX_CONTENT}" 
                              autocomplete="off" 
                              tabindex="3" 
                              >{$sMarkdown|escape}</textarea>	
        </div>
        <div class="col-lg-6 d-none d-lg-block">
            <div class="pull-right">
                <div class="custom-control custom-checkbox pull-left">
                    <input type="checkbox" class="custom-control-input" id="iBindScrolling" checked="1">
                    <label class="custom-control-label" for="iBindScrolling">bind Scrolling</label>
                &nbsp;&nbsp;
                </div>                    
                <div class="custom-control custom-radio pull-left">
                    <input type="radio" id="iBindScrollingType1" name="iBindScrollingType" class="custom-control-input">
                    <label class="custom-control-label" for="iBindScrollingType1">equal</label>
                &nbsp;&nbsp;
                </div>
                <div class="custom-control custom-radio pull-left"">
                    <input type="radio" id="iBindScrollingType2" name="iBindScrollingType" class="custom-control-input" checked="1">
                    <label class="custom-control-label" for="iBindScrollingType2">relative</label>
                </div>
            </div>
            <label for="preview">Real-time Preview</label>	                
            <div id="preview" 
                 class="maxlengthVisualFeedback prettyBorder shadow padding20" 
                 >
                {$sMarkdown|escape}
            </div>	                
        </div>
	</div>
                          
	<div class="form-group">
        <label for="taglist">
            Tags <small class="text-muted">enter a tagname, then press <code>&lt;enter&gt;</code> key to confirm</small>
        </label>
        <div id="taglist" 
             class="form-control"
            >
        </div>
	</div>	 
                          
	<button type="submit" class="btn btn-warning btnWidth100">Update</button>
</form>