<?php

// Name of Blog
$aConfig['BLOG_NAME'] = 'Blogixx';

// short Description; will be shown in RSS Feed XML "/feed/post/"
$aConfig['BLOG_DESCRIPTION'] = 'Blog about relevant Stuff';

/**
 * Backend User Accounts for different Environments set by MVC_ENV
 * Notice: empty "user" or "password" means no login is possible
 */
$aConfig['BLOG_BACKEND'] = array(

	'develop' => array(
		
		// 1. account
		array(
			'user' 		=> 'test', 
			'password' 	=> 'test'
		)
	),
	
	'test' => array(
		
		// 1. account
		array(
			'user' 		=> '', 
			'password' 	=> ''
		)
	),
	
	'live' => array(
		
		// 1. account
		array(
			'user' 		=> '', 
			'password' 	=> ''
		)	
	)
);

/**
 * responsible Classes
 */
$aConfig['BLOG_CLASS_CONTROLLER_AJAX'] =    '\\Blogixx\\Controller\\Ajax';
$aConfig['BLOG_CLASS_CONTROLLER_BACKEND'] = '\\Blogixx\\Controller\\Backend';
$aConfig['BLOG_CLASS_CONTROLLER_INDEX'] =   '\\Blogixx\\Controller\\Index';
$aConfig['BLOG_CLASS_MODEL_AJAX'] =         '\\Blogixx\\Model\\Ajax';
$aConfig['BLOG_CLASS_MODEL_INDEX'] =        '\\Blogixx\\Model\\Index';
$aConfig['BLOG_CLASS_MODEL_BACKEND'] =      '\\Blogixx\\Model\\Backend';
$aConfig['BLOG_CLASS_VIEW_INDEX'] =         '\\Blogixx\\View\\Index';

/**
 * Data Directory
 * Place where your Posts and Pages reside
 */
$aConfig['BLOG_DATA_DIR'] = realpath(__DIR__ . '/../') . '/modules/Blogixx/data';

/**
 * Frontend Settings
 */
// max amount of posts teasered on Overview pages
$aConfig['BLOG_MAX_POST_ON_PAGE'] = 2;

// max amount of pagination steps on Overview pages
$aConfig['BLOG_MAX_AMOUNT_PAGINATION_STEPS'] = 13;

// Teasertext size in Overview
$aConfig['BLOG_TEASER_SIZE_IN_OVERVIEW'] = 500;

// max length of title names (filenames for page / post files)
$aConfig['BLOG_CREATE_MAX_TITLE'] = 200;

// max length of content
$aConfig['BLOG_CREATE_MAX_CONTENT'] = 20000;


/**
 * Linux Binaries
 * Set Paths to Linux' ls, find, grep, head, md5sum
 */
$aConfig['BLOG_BIN_LS'] = '/bin/ls';
$aConfig['BLOG_BIN_FIND'] = '/usr/bin/find';
$aConfig['BLOG_BIN_GREP'] = '/bin/grep';
$aConfig['BLOG_BIN_HEAD'] = '/usr/bin/head';
$aConfig['BLOG_BIN_MD5SUM'] = '/usr/bin/md5sum';

/*
 * Ajax
 */
// override MVC's request "a"
$aConfig['MVC_REQUEST_WHITELIST_PARAMS']['GET']['a'] = array(
	'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:_\\ ?!&\|\{\}\"']+/u"
	, 'length' => 256
);
// Filter Ajax request "a"
$aConfig['BLOG_AJAX_FILTER'] = array(
	
	// filter rule
	'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:?!&']+/u"
	// max items response
	, 'length' => 10
);
$aConfig['BLOG_AJAX_LOG_REQUESTS'] = false;


/**
 * Misc
 */
// override MVC's fallback routing
$aConfig['MVC_ROUTING_FALLBACK'] = $aConfig['MVC_GET_PARAM_MODULE'] . '=blogixx&'
	. $aConfig['MVC_GET_PARAM_C'] . '=index&'
	. $aConfig['MVC_GET_PARAM_M'] . '=index';	

// extra composer dir
$aConfig['MVC_COMPOSER_DIR'] = __DIR__ . '/Blogixx';

// routing.json file
$aConfig['MVC_ROUTING_JSON'] = __DIR__ . '/Blogixx/routing.json';
