<?php

// Name of Blog
$aConfig['BLOG_NAME'] = 'blogimus';

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
			'user' 		=> '', 
			'password' 	=> ''
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
 * get used in /modules/Blogimus/View/Index.php::sendSecurityHeader()
 * For further Rules Explanation @see https://content-security-policy.com/
 */
SECURITY_HEADER_CONFIG: {

    /**
     * Websites (URLs) which are allowed to embed our Site into e.g. a <frame>
     */
    $aConfig['BLOG_CONTENT_SECURITY_FRAME_PARENTS'] = "'none'";
    $aConfig['BLOG_CONTENT_SECURITY_POLICY'] = ""

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/default-src
         */
        . "default-src  'self'; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src
         */
        . "script-src   'self' " .
                        "'unsafe-inline' " .
                        "http://cdnjs.cloudflare.com/ " .
                        "https://cdnjs.cloudflare.com/ " .
                        "http://cdn.jsdelivr.net/ " .
                        "https://cdn.jsdelivr.net/ " .
                        "; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/style-src
         */
        . "style-src    'self' " .
                        "'unsafe-inline' " .
                        "http://cdnjs.cloudflare.com/ " .
                        "https://cdnjs.cloudflare.com/ " .
                        "http://cdn.jsdelivr.net/ " .
                        "https://cdn.jsdelivr.net/ " .
                        "http://fonts.googleapis.com/ " .
                        "https://fonts.googleapis.com/ " .
                        "; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/img-src
         */
        . "img-src      'self' " .
                        "blob: " .
                        "data: " .
                        "http://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/images/ " .
                        "https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/images/ " .
                        "http://placehold.it/ " .
                        "https://placehold.it/ " .
                        "; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/connect-src
         */
        . "connect-src  'self'; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/font-src
         */
        . "font-src     'self' " .
                        "http://cdnjs.cloudflare.com " .
                        "https://cdnjs.cloudflare.com " .
                        "http://fonts.googleapis.com " .
                        "https://fonts.googleapis.com/ " .
                        "http://fonts.gstatic.com/ " .
                        "https://fonts.gstatic.com/ " .
                        "; "

        /**
         * To disallow all plugins, the object-src directive should be set to 'none' which will disallow plugins.
         * The plugin-types directive is only used if you are allowing plugins with object-src at all.
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/plugin-types
         */
        . "object-src   'none'; "
        #. "plugin-types ;"

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/media-src
         */
        . "media-src    'self'; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/child-src
         */
        . "child-src    'self';"

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox
         */
        . "sandbox      " .
                        "allow-forms " .
                        "allow-same-origin " .
                        "allow-scripts " .
                        "allow-popups " .
                        "allow-modals " .
                        "allow-orientation-lock " .
                        "allow-pointer-lock " .
                        "allow-presentation " .
                        "allow-popups-to-escape-sandbox " .
                        "allow-top-navigation; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-uri
         */
        . "report-uri   /; "

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/form-action
         */
        . "form-action  'self'; "

        /**
         * The HTTP Content-Security-Policy (CSP) frame-ancestors directive specifies valid parents
         * that may embed a page using <frame>, <iframe>, <object>, <embed>, or <applet>.
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/frame-ancestors
         */
        . "frame-ancestors " . $aConfig['BLOG_CONTENT_SECURITY_FRAME_PARENTS'] . "; "
        ;

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
     */
    $aConfig['BLOG_X_XSS_Protection'] = '1; mode=block';

    /**
     * 63072000 for 24 months
     * @see https://support.servertastic.com/knowledgebase/article/http-strict-transport-security-php
     */
    $aConfig['BLOG_STRICT_TRANSPORT_SECURITY'] = 'max-age=63072000'; # 63072000 for 24 months
}

/**
 * responsible Classes
 */
$aConfig['BLOG_CLASS_CONTROLLER_AJAX'] =    '\\Blogimus\\Controller\\Ajax';
$aConfig['BLOG_CLASS_CONTROLLER_BACKEND'] = '\\Blogimus\\Controller\\Backend';
$aConfig['BLOG_CLASS_CONTROLLER_INDEX'] =   '\\Blogimus\\Controller\\Index';
$aConfig['BLOG_CLASS_MODEL_AJAX'] =         '\\Blogimus\\Model\\Ajax';
$aConfig['BLOG_CLASS_MODEL_INDEX'] =        '\\Blogimus\\Model\\Index';
$aConfig['BLOG_CLASS_MODEL_BACKEND'] =      '\\Blogimus\\Model\\Backend';
$aConfig['BLOG_CLASS_VIEW_INDEX'] =         '\\Blogimus\\View\\Index';

/**
 * Data Directory
 * Place where your Posts and Pages reside
 */
$aConfig['BLOG_DATA_DIR'] = realpath(__DIR__ . '/../') . '/modules/Blogimus/data';

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
$aConfig['MVC_ROUTING_FALLBACK'] = $aConfig['MVC_GET_PARAM_MODULE'] . '=blogimus&'
	. $aConfig['MVC_GET_PARAM_C'] . '=index&'
	. $aConfig['MVC_GET_PARAM_M'] . '=index';	

// extra composer dir
$aConfig['MVC_COMPOSER_DIR'] = __DIR__ . '/Blogimus';

// routing.json file
$aConfig['MVC_ROUTING_JSON'] = __DIR__ . '/Blogimus/routing.json';
