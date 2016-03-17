<?php

// override fallback routing
$aConfig['MVC_ROUTING_FALLBACK'] = $aConfig['MVC_GET_PARAM_MODULE'] . '=blogixx&'
	. $aConfig['MVC_GET_PARAM_C'] . '=index&'
	. $aConfig['MVC_GET_PARAM_M'] . '=index';


// override request a
$aConfig['MVC_REQUEST_WHITELIST_PARAMS']['GET']['a'] = array(
	'regex' => '/[^a-zA-Z0-9üöäÜÖÄß\|\:\[\]\{\},"\'_ ]+/'
	, 'length' => 256
);

// max amount of pages teasered in overview
$aConfig['BLOG_MAX_POST_ON_PAGE'] = 2;

// Teasertext size in Overview
$aConfig['BLOG_TEASER_SIZE_IN_OVERVIEW'] = 500;

// extra composer dir
$aConfig['MVC_COMPOSER_DIR'] = __DIR__ . '/Blogixx';

// routing.json file
$aConfig['MVC_ROUTING_JSON'] = __DIR__ . '/Blogixx/routing.json';
