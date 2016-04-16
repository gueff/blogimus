<?php

// override fallback routing
$aConfig['MVC_ROUTING_FALLBACK'] = $aConfig['MVC_GET_PARAM_MODULE'] . '=blogixx&'
	. $aConfig['MVC_GET_PARAM_C'] . '=index&'
	. $aConfig['MVC_GET_PARAM_M'] . '=index';


// override request a
$aConfig['MVC_REQUEST_WHITELIST_PARAMS']['GET']['a'] = array(
	'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:_\\ ?!&\|\{\}\"']+/u"
	, 'length' => 256
);

// Ajax request a
$aConfig['BLOG_AJAX_FILTER'] = array(
	'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:?!&']+/u"
	, 'length' => 10
);


// max amount of pages teasered in overview
$aConfig['BLOG_MAX_POST_ON_PAGE'] = 2;

// Teasertext size in Overview
$aConfig['BLOG_TEASER_SIZE_IN_OVERVIEW'] = 500;

// extra composer dir
$aConfig['MVC_COMPOSER_DIR'] = __DIR__ . '/Blogixx';

// routing.json file
$aConfig['MVC_ROUTING_JSON'] = __DIR__ . '/Blogixx/routing.json';
