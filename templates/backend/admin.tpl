{*--------------------------------------------------------------------
* Start Formular
*}
<form id="blogimus_form_editor"
      action=""
      method="post"
>

	<div class="form-group row">
        <div class="col-5 col-sm-5 col-lg-7 col-xl-7">
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
        <div class="col-1 col-sm-1 col-lg-2 col-xl-2">
            <label for="type">Type</label>
            <div>
                <div class="custom-control custom-radio float-left">
                    <input type="radio"
                           id="sTypePost"
                           name="type"
                           value="post"
                           class="custom-control-input"
                           {if 'post' === $sType || '' === $sType}checked="checked"{/if}"
                    {if '@edit' === $sRequest}disabled{/if}
                    onclick="document.getElementById('date').disabled = false;"
                    >
                    <label class="custom-control-label" for="sTypePost">Post&nbsp;&nbsp;&nbsp;</label>
                </div>
                <div class="custom-control custom-radio float-left"">
                    <input type="radio"
                           id="sTypePage"
                           name="type"
                           value="page"
                           class="custom-control-input"
                           {if 'page' === $sType}checked="checked"{/if}"
                    {if '@edit' === $sRequest}disabled{/if}
                    onclick="document.getElementById('date').disabled = true;"
                    >
                    <label class="custom-control-label" for="sTypePage">Page&nbsp;&nbsp;&nbsp;</label>
                </div>
            </div>
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
                    >
        </div>
	</div>	
    <div class="clearfix"></div>
	
    {*  Editor + Preview
            Markdown Syntax Highlighting
                @see https://codemirror.net/mode/markdown/
    *}
    <div class="form-group row" id="editor">
        {* Editor *}
        <div class="col-lg-6">
            <label for="markdownEdit">Content</label>
            <textarea id="markdownEdit" 
                      class="maxlengthVisualFeedback prettyBorder shadow padding20"
                      name="sMarkdown"
                      maxlength="{$BLOG_CREATE_MAX_CONTENT}"
                      autocomplete="off"
                      tabindex="3"
                      >{$sMarkdown|escape}</textarea>
            <div id="info_lastModificationDate" class="pull-right tooltipper"
                 data-toggle="tooltip"
                 data-placement="bottom"
                 title="last modification date"
                 data-original-title="last modification date">
                <small>🕑<span>{if isset($aInfo.sChangeStamp)}{$aInfo.sChangeStamp}{/if}</span></small>
            </div>
        </div>
        {* Preview *}
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
        <div id="taglist" class="form-control"></div>
	</div>	 
                          
	<button id="blogimus_submit"
            type="submit"
            class="btn btn-warning btnWidth100"
            data-type="save"
    >💾 click here to SAVE (or press CTRL+S)
    </button>
</form>

{* save the current action to local storage so that the backend.js can read from it (@create, @edit) *}
<script>localStorage.setItem('action', '{$sRequest}');</script>