
/**
 * this is for codemirror
 */
function editorMaxlengthVisualFeedback(oObject, iSectionA, iSectionB, iSectionC, oTarget, sValueLength) {
    
    var iSectionA = ('undefined' === typeof iSectionA) ? 50 : iSectionA;
    var iSectionB = ('undefined' === typeof iSectionB) ? 70 : iSectionB;
    var iSectionC = ('undefined' === typeof iSectionC) ? 100 : iSectionC;
    
    if (null === oObject.val()) {
        return false
    }
    
    $(oObject).on('blur', function() {
        $('.maxlengthVisualFeedbackBar').hide()
    });
    
    var iProgressBarId = oTarget.next().attr('data-consumptionBar');    
    if ('undefined' === typeof iProgressBarId) {
        var iTimestamp = Date.now();
        $('<div id="' + iTimestamp + '" data-consumptionBar="' + iTimestamp + '" class="maxlengthVisualFeedbackBar progress progress-striped active"><div class="progress-bar"><div class="progresstext"></div></div></div>')
                .insertAfter(oTarget);
        $('.maxlengthVisualFeedbackBar').hide();
        $(oObject).focus();
        return false
    }
    
    var iMaxlength = (('undefined' !== typeof oObject.attr('maxlength') ? oObject.attr('maxlength') : (('undefined' !== typeof oObject.attr('data-maxlength')) ? oObject.attr('data-maxlength') : false)));
    if (false === iMaxlength) {
        return false
    }
    
    var iPercent = (sValueLength * 100 / iMaxlength);
    (iPercent >= iSectionA) ? $('#' + iProgressBarId).show(): $('#' + iProgressBarId).hide();
    (iPercent >= iSectionA && iPercent < iSectionB) ? $('#' + iProgressBarId + ' .progress-bar').removeClass('progress-bar-warning progress-bar-danger').addClass('progress-bar-info'): false;
    (iPercent >= iSectionB && iPercent < iSectionC) ? $('#' + iProgressBarId + ' .progress-bar').removeClass('progress-bar-info progress-bar-danger').addClass('progress-bar-warning'): false;
    (iPercent >= iSectionC) ? $('#' + iProgressBarId + ' .progress-bar').removeClass('progress-bar-info progress-bar-warning').addClass('progress-bar-danger'): false;
    $('#' + iProgressBarId).css({'width': oTarget.outerWidth()});
    (iPercent <= 100) ? $('#' + iProgressBarId + ' .progress-bar').css({width: iPercent + '%'}): false;
    $('#' + iProgressBarId + ' .progresstext').text(Math.round(iPercent) + '%');
    
    return true
}

function notify(sText, sType, sTitle) {

    if (typeof sText === 'undefined') {
        sText = 'undefined';
    }

    if (typeof sType === 'undefined') {
        sType = 'info';
    }

    if (typeof sTitle === 'undefined') {
        sTitle = sType.toUpperCase();
    }

    new PNotify({
        title: sTitle, //'Notify',
        text: sText,
        addclass: "stack-bottomright",
        // stack: {dir1: "up", dir2: "left", firstpos1: 25, firstpos2: 25},
        type: sType // success, info, error
    });
}

function btnOnCreateInit() {

    $('#btn_frontend').removeClass('active');
    $('#btn_frontend a').addClass('disabled');
    $('#btn_frontend a').attr('href', '#');     // path

    $('#btn_delete').removeClass('active');
    $('#btn_delete a').addClass('disabled');
    $('#btn_delete a').attr('data-type', '');   // post|page
    $('#btn_delete a').attr('data-url', '');    // path
    $('#btn_delete a').attr('data-name', '');   // name of page
}

function setBtnOnCreateSave(oResponse) {

    $('#btn_frontend').addClass('active');
    $('#btn_frontend a').removeClass('disabled');
    $('#btn_frontend a').attr('href', oResponse.aInfo.sUrl);        // path

    $('#btn_delete').addClass('active');
    $('#btn_delete a').removeClass('disabled');
    $('#btn_delete a').attr('data-type', oResponse.sType);    // post|page
    $('#btn_delete a').attr('data-url', oResponse.aInfo.sUrl);      // path
    $('#btn_delete a').attr('data-name', oResponse.aInfo.sName);    // name of page

    $('#info_lastModificationDate small span').html(oResponse.aInfo.sChangeStamp);
}

/**
 * @param sParam
 * @returns {*}
 */
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function getFormData(sAction) {

    var oDataRecent = JSON.parse(localStorage.getItem('oDataRecent'));
    // (null !== oDataRecent) ? console.log('oDataRecent.sTitle', oDataRecent.sTitle) : false;

    var aParam = getUrlParameter('a');
    var oParam =  ('undefined' !== typeof (aParam)) ? JSON.parse(aParam) : {};
    var sType = '';

    // on "create"
    if ('undefined' === typeof oParam.type) {
        sType = $('input[name="type"]:checked').val();
    } else {
        sType = oParam.type;
    }

    var sTitle = $('#title').val();
    var sDate = $('#date').val();
    var sMarkdown = oCodeMirror.getValue();
    var aTaglist = [];
    $('input[name="taggles[]"]').each(function (index, item){
        aTaglist.push($(item).val());
    });

    var sMethod = $('#blogimus_submit').attr('data-type');
    var sAction = ('undefined' === typeof sAction) ? 'init' : sAction;

    // btn_frontend a href
    var sUrl = $('#btn_frontend a').attr('href');

    var oData = {
        "sMethod":sMethod,
        "sAction":sAction,
        "oParam":oParam,
        "sUrl":sUrl,
        "sType":sType,
        "sTitle":sTitle,
        "sDate":sDate,
        "sMarkdown":sMarkdown,
        "aTaglist":aTaglist
    };

    return {
        "oDataCurrent": oData,
        "oDataRecent": oDataRecent
    };
}


function update(oCodeMirror, oTaggle, sAction) {

    var oFormData = getFormData();
    var oDataCurrent = oFormData.oDataCurrent;
    var oDataRecent = oFormData.oDataRecent;

    // add recent to current
    oDataCurrent.oDataRecent = oDataRecent;

    if ('' === oDataCurrent.sTitle) {
        notify('Title missing', 'error');
        return false;
    }

    if ('' === oDataCurrent.sMarkdown) {
        notify('Content missing', 'error');
        return false;
    }

    var oForm = $('form');
    var oAjax = $.ajax({
        url: '/Ajax/update/',
        dataType: 'json',
        type: 'POST',
        data: oDataCurrent,
        statusCode: {
            404: function() {
                notify("404 page not found", 'error');
                // console.log("404 page not found");
            }
        },
        success: function(oResponse, status, xhr){

            // console.log('oResponse.sMessage', typeof oResponse.sMessage);
            // console.log('success oResponse', oResponse);
            // console.log('success status', status);
            // console.log('success xhr', xhr);
        },
        complete: function(xhr, status){

            // notify('complete', 'info');
            // console.log('complete xhr', xhr);
            // console.log('complete status', status);
        },
        error: function(xhr, status, error){

            notify(error, 'error');
            // console.log('error xhr', xhr);
            // console.log('error status', status);
            // console.log('error error', error);
        }
    }).done(function(oResponse) {

        // save to storage only on success
        if ('true' === oResponse.bSuccess) {

            // save the current one as recent to storage
            localStorage.setItem('oDataRecent', JSON.stringify(oDataCurrent));
            // console.log('oDataRecent: ' + JSON.parse(localStorage.getItem('oDataRecent')));
        }

        notify(oResponse.sMessage, ('true' === oResponse.bSuccess) ? 'success' : 'error');
        // console.log('oResponse', oResponse);
        // console.log('sAction', sAction);

        setBtnOnCreateSave(oResponse);

        // after create, set mode to edit
        if ('@create' === sAction) {
            localStorage.setItem('action', '@edit');
            var sAction = localStorage.getItem('action');
            // console.log('sAction', sAction);
        }
    });

    return false;
}

/**
 * codemirror
 * https://codemirror.net/mode/markdown/#
 * https://cdnjs.com/libraries/codemirror
 */
if ($('#markdownEdit').length) {
    var oCodeMirror = CodeMirror.fromTextArea(document.getElementById("markdownEdit"), {
        mode: 'markdown',
        lineNumbers: true,
        theme: "default",
        lineWrapping: true,
        extraKeys: {
            "Enter": "newlineAndIndentContinueMarkdownList"
        }
    });
}

$(document).ready(function() {
	
    $('.popover').popover();
    $('.tooltipper').tooltip();

    var iBindScrolling = 1;
    var iBindScrollingType = 2;

    $('#btn_create a').on('click', function () {
        // console.log('oDataRecent gelöscht!');
        localStorage.setItem('oDataRecent', JSON.stringify(false));
        return true;
    });

    // bind scrolling in preview to editor
    $('#iBindScrolling').on('click', function(){
        var bBindScrolling = $(this).prop('checked');
        iBindScrolling = bBindScrolling ? 1 : 0;
    });        
    $('#iBindScrollingType1').on('click', function(){
        var bBindScrollingType1 = $(this).prop('checked');
        iBindScrollingType = bBindScrollingType1 ? 1 : 2;
    });
    $('#iBindScrollingType2').on('click', function(){
        var iBindScrollingType2 = $(this).prop('checked');
        iBindScrollingType = iBindScrollingType2 ? 2 : 1;
    });
        
	window.mobileAndTabletcheck = function() {
	  var check = false;
	  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
	  return check;
	}
	
	if (false === mobileAndTabletcheck()) {
        $('#inputSearch').focus();
	}	

	// make images behave responsive
	$('.container img').addClass('img-fluid');

	// better tables
	$('table').addClass('table table-hover table-bordered');
	
	// delete
	$('.btnDelete').on('click', function(){
        $('modalDeleteType').html($(this).attr('data-type'));
        $('modalDeleteSpecific').html('"<b>' + $(this).attr('data-name') + '</b>"');
        $('modalDeleteUrl').html('<a href="' + $(this).attr('data-url') + '">' + $(this).attr('data-url') + '</a>');
	});
	$('#modalBtnDelete').on('click', function(e){
        $('#modalDelete').modal('hide');
        var sUrl = '/@delete?a={"type":"' + $('modalDeleteType').text() + '","url":"' + $('modalDeleteUrl').text() + '"}';
        // console.log(sUrl);
        location.href = sUrl;
	});
        
    /**
     * using taggle for tagging
     * @see https://sean.is/poppin/tags/
     * @see https://www.devbridge.com/sourcery/components/jquery-autocomplete/
     */
    if (($("#taglist").length > 0)){

        var oTaggle = new Taggle('taglist', {
            "placeholder": "",
            "tabIndex": 4,
            tags: aTagList,
            "preserveCase": true
        });

        var oContainerTaglist = oTaggle.getContainer();
        var input = oTaggle.getInput();

        $.get(
            "/Ajax/taglist/",
            "all",
            function(getTags, status) {

                if (getTags.length > 0)
                {
                    $('#taglist input').autocomplete({
                        source: getTags,
                        appendTo: oContainerTaglist,
                        position: {my: "left bottom", at: "left top", collision: "flip", of: oContainerTaglist},
                        select: function(event, data) {
                            event.preventDefault();
                            //Add the tag if user clicks
                            if (event.which === 1) {
                                oTaggle.add(data.item.value);
                            }
                        }
                    });                     
                }
            }
        );
    }

    /**
     * submit button clicked
     */
    $(document).on('submit','form',function(oEvent){
        oEvent.preventDefault();
        update(oCodeMirror, oTaggle, 'save BUTTON CLICK');
    });

    /**
     * keyboard shortcuts
     * ctrl+s: send form
     */
    $(window).bind('keydown', function(oEvent) {

        if (oEvent.ctrlKey || oEvent.metaKey) {

            switch (String.fromCharCode(oEvent.which).toLowerCase()) {

                // ctrl+s (save)
                case 's':
                    oEvent.preventDefault();
                    update(oCodeMirror, oTaggle, 'save CTRL+S');
                    break;
            }
        }
    });

    /**
     * maximize editor windows
     */
    function adjustEditorHeight() {
        if ($('#markdownEdit').length) {
            var iInnerHeight = window.innerHeight;
            var iMarkdownEditHeightMax = (iInnerHeight - 330);
            $('#editor').height(iMarkdownEditHeightMax);

            $('#markdownEdit').height(iMarkdownEditHeightMax - 70);
            $('.CodeMirror').height(iMarkdownEditHeightMax - 30);

            $('#preview').height(iMarkdownEditHeightMax - 70);            
        }
    }        
    $( window ).resize(function() {
        adjustEditorHeight();
    });        

    /**
     * sync scrollbars
     * maybe better solution: https://stackoverflow.com/a/24168814/2487859, http://jsfiddle.net/XNVNj/2/
     */
    var iScrollHeightLeft;

    function adjustScrolling() {

        if ($('#markdownEdit').length) {

            var iScrollTopLeft = $('.CodeMirror-vscrollbar').scrollTop();
            var iInnerHeightLeft = $('.CodeMirror-vscrollbar').height();

            iScrollHeightLeft =  $(document.getElementsByClassName("CodeMirror-sizer")[0]).prop('scrollHeight');  
            var dPercentLeft = (iScrollTopLeft *  100  / iScrollHeightLeft);

            // calc scrollPosition preview div
            var iScrollHeightRight = $('#preview').prop('scrollHeight');            
            var iInnerHeightRight = $('#preview').height();
            var iScrollTopRight = Math.round(dPercentLeft * iScrollHeightRight / 100);

            var iCalcLeft = (iInnerHeightLeft + iScrollTopLeft);
            var iCalcPercentLeft = Math.round(iCalcLeft * 100 / iScrollHeightLeft);
            var iCalcRight = Math.round(iCalcPercentLeft * iScrollHeightRight / 100);

            var iDiffLeft = (iScrollHeightLeft - iInnerHeightLeft);
            var iDiffRight = (iScrollHeightRight - iInnerHeightRight);
            var iFactor = Math.round(iDiffRight / iDiffLeft);
            iScrollTopRight = ((iFactor > 1) ? (iScrollTopRight * iFactor) : iScrollTopRight);

            // sync scrolling for preview is enabled
            if (1 === iBindScrolling) {

                (1 === iBindScrollingType) ? $('#preview').scrollTop(iScrollTopLeft) : false;       // Version 1: same as left
                (2 === iBindScrollingType) ? $('#preview').scrollTop(iScrollTopRight) : false;      // Version 2: adjust on right
            }
        }
    }

    $('.CodeMirror-vscrollbar').on('scroll', function () {
        adjustScrolling();
    });               

    /**
     * Showdown
     * markdown preview
     * - https://github.com/showdownjs/showdown
     */
    var oShowdownConverter = new showdown.Converter({
        "strikethrough": true,
        "tables": true,
        "omitExtraWLInCodeBlocks": true
    });          
    
    // auto preview
    if ($('#markdownEdit').length) {
        
        var sCodeMirrorValue = '';
        var sCodeMirrorValueCache = '';
        
        setInterval(function() {           
            
            sCodeMirrorValue = oCodeMirror.getValue();
            
            if (sCodeMirrorValue !== sCodeMirrorValueCache) {
                sCodeMirrorValueCache = sCodeMirrorValue;
                
                sCodeMirrorValueCache = sCodeMirrorValue;
                var sHtml = oShowdownConverter.makeHtml(sCodeMirrorValue);          
                $('#preview').html(sHtml);
                $('table').removeClass('table table-hover table-bordered');
                $('table').addClass('table table-hover table-bordered');
        
                // @see https://highlightjs.org
                $('.language-bash').each(function(i, block) {hljs.highlightBlock(block);$(this).parent().css('padding',0);});	
                $('.language-php').each(function(i, block) {hljs.highlightBlock(block);$(this).parent().css('padding',0);});	
                $('.language-js').each(function(i, block) {hljs.highlightBlock(block);$(this).parent().css('padding',0);});		
                $('.language-css').each(function(i, block) {hljs.highlightBlock(block);$(this).parent().css('padding',0);});		
                $('.language-html').each(function(i, block) {hljs.highlightBlock(block);$(this).parent().css('padding',0);});    
            }
        }, 500);    // 1000 === 1 second
    }

    /**
     * CodeMirror
     */
    $('.CodeMirror').on('keypress keyup', function() {

        if ($(".CodeMirror-vscrollbar div").length >= 2) {
            $('#codemirrorScrollfix').remove();
        }

        adjustScrolling();
        
        editorMaxlengthVisualFeedback(
            $('#markdownEdit'),
            0, 70, 100,
            $('.CodeMirror'),
            oCodeMirror.getValue().length
        );
    });

    /** @see https://blog.ueffing.net/post/2018/02/17/jquery-maxlength-visual-feedback/ */
    $(".maxlengthVisualFeedback").on('click keyup keypress', function() {
        maxlengthVisualFeedback(
            $(this),
            0, 70, 100
        );
    });

    /**
     * inits
     */
    adjustEditorHeight();
    adjustScrolling();

    /**
     * style Fixes
     */
    $('.CodeMirror-vscrollbar').append('<div id="codemirrorScrollfix" style="min-width: 1px; height: auto; min-height: ' + iScrollHeightLeft + 'px;"></div>');
    $('.CodeMirror-vscrollbar').prop('style', 'bottom: 0px; display: block !important;');

    // show editor area
    $('#blogimus_form_editor').css('visibility', 'visible');
    $('#navbar ul li').css('visibility', 'visible');
    $('#title').focus();

    // manage buttons at start
    var sAction = localStorage.getItem('action');

    if ('@create' === sAction) {btnOnCreateInit();}


    var oFormData = getFormData();
    var oDataRecent = JSON.parse(localStorage.getItem('oDataRecent'));
    // console.log('oDataRecent', oDataRecent);

    if (false === oDataRecent) {

        var oDataCurrent = oFormData.oDataCurrent;
        var oDataRecent = oFormData.oDataRecent;

        // save the current one as recent to storage
        localStorage.setItem('oDataRecent', JSON.stringify(oDataCurrent));
        // console.log('oDataRecent: ' + JSON.parse(localStorage.getItem('oDataRecent')));
    }

});


