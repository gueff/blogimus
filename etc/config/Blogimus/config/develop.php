<?php

error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

// enable debug output
$aConfig['MVC_DEBUG'] = false;

//-------------------------------------------------------------------------------------
// Module Blogimus

$sModuleFolderName = basename(realpath(__DIR__ . '/../../../../'));
$aConfig['MODULE_FOLDERNAME'] = $sModuleFolderName;

$aConfig['MODULE_' . $sModuleFolderName] = array(

    // Name of Blog
    'BLOG_NAME' => $sModuleFolderName,

    // short Description; will be shown in RSS Feed XML "/feed/post/"
    'BLOG_DESCRIPTION' => 'Blog about relevant Stuff',

    /**
    * Backend User Accounts for different Environments set by MVC_ENV
    * Notice: empty "user" or "password" means no login is possible
    */
    'BLOG_BACKEND' => array(

        // 1. account
        array(
            'user' 		=> '',
            'password' 	=> ''
        ),

    ),

    /**
     * Frontend Settings
     */
    // max amount of posts teasered on Overview pages
    'BLOG_MAX_POST_ON_PAGE' => 2,

    // max amount of pagination steps on Overview pages
    'BLOG_MAX_AMOUNT_PAGINATION_STEPS' => 13,

    // Teasertext size in Overview
    'BLOG_TEASER_SIZE_IN_OVERVIEW' => 500,

    // max length of title names (filenames for page / post files)
    'BLOG_CREATE_MAX_TITLE' => 200,

    // max length of content
    'BLOG_CREATE_MAX_CONTENT' => 20000,

    /**
    * Linux Binaries
    * Set Paths to Linux' ls, find, grep, head, md5sum
    */
    'BLOG_BIN_LS' => '/bin/ls',
    'BLOG_BIN_FIND' => '/usr/bin/find',
    'BLOG_BIN_GREP' => '/bin/grep',
    'BLOG_BIN_HEAD' => '/usr/bin/head',
    'BLOG_BIN_MD5SUM' => '/usr/bin/md5sum',

    /*
    * Ajax
    */
    // Filter Ajax request "a"
    'BLOG_AJAX_FILTER' => array(
        // filter rule
        'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:?!&']+/u"
            // max items response
            , 'length' => 10
        ),
    'BLOG_AJAX_LOG_REQUESTS' => false,

    /**
     * Data Directory
     * Place where your Posts and Pages reside
     */
    'BLOG_DATA_DIR' => $aConfig['MVC_BASE_PATH'] . '/modules/' . $sModuleFolderName . '/etc/data',

    /**
     * responsible Classes
     */
    'BLOG_CLASS_CONTROLLER_AJAX' => '\\' . $sModuleFolderName . '\\Controller\\Ajax',
    'BLOG_CLASS_CONTROLLER_BACKEND' => '\\' . $sModuleFolderName . '\\Controller\\Backend',
    'BLOG_CLASS_CONTROLLER_INDEX' => '\\' . $sModuleFolderName . '\\Controller\\Index',
    'BLOG_CLASS_MODEL_AJAX' => '\\' . $sModuleFolderName . '\\Model\\Ajax',
    'BLOG_CLASS_MODEL_INDEX' => '\\' . $sModuleFolderName . '\\Model\\Index',
    'BLOG_CLASS_MODEL_BACKEND' => '\\' . $sModuleFolderName . '\\Model\\Backend',
    'BLOG_CLASS_VIEW_INDEX' => '\\' . $sModuleFolderName . '\\View\\Index',

    /**
     * Module specific Session Settings
     */
    'SESSION' => array(

        // where to activate Session
        'aEnableSessionForController' => array(
            'Index',
            'Backend',
        ),
    ),

    /**
     * Event Bindings
     */
    'EVENT_BIND' => array(

        'mvc.error' => function(\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE($oDTArrayObject->getDTKeyValueByKey('oException')->get_sValue()->getMessage(), 'error.log');
        },
        'mvc.invalidRequest' => function (\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE($oDTArrayObject, 'error.log');
        },
        'mvc.policy.apply.execute' => function (\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE($oDTArrayObject, 'mvc.log');
        },
        'mvc.application.destruct' => function (\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE($oDTArrayObject, 'mvc.log');
        },
        'mvc.helper.stop' => function (\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE("\n\n*** STOP ***\n" . print_r($oDTArrayObject->get_akeyvalue()[0]->get_sValue(), true), 'debug.log');
        },
        'mvc.application.construct.done' => function (\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \MVC\Log::WRITE($oDTArrayObject, 'mvc.log');
        },
        // get consent to set session cookie
        'mvc.setSession.before' => function(\MVC\DataType\DTArrayObject $oDTArrayObject) {
            \Blogimus\Event\Index::enableSession($oDTArrayObject);
        },
    ),
);

//-------------------------------------------------------------------------------------
// Frontend

/**
 * For further Rules Explanation @see https://content-security-policy.com/
 */
$aConfig['CONTENT_SECURITY_POLICY'] = array();

/**
 * Websites (URLs) which are allowed to embed our Site into e.g. a <frame>
 */
$aConfig['CONTENT_SECURITY_POLICY']['X-Frame-Options'] = "'none'";

$aConfig['CONTENT_SECURITY_POLICY']['Content-Security-Policy'] = ""

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/default-src
     */
    .   "default-src  'self'; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src
     */
    .   "script-src   'self' " .
        "'unsafe-inline' " .
        "http://cdnjs.cloudflare.com/ " .
        "https://cdnjs.cloudflare.com/ " .
        "http://cdn.jsdelivr.net/ " .
        "https://cdn.jsdelivr.net/ " .
        "; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/style-src
     */
    .   "style-src    'self' " .
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
    .   "img-src      'self' " .
        "blob: " .
        "data: " .
        "http://cdnjs.cloudflare.com " .
        "https://cdnjs.cloudflare.com " .
        "; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/connect-src
     */
    .   "connect-src  'self'; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/font-src
     */
    .   "font-src     'self' " .
        "http://cdnjs.cloudflare.com " .
        "https://cdnjs.cloudflare.com " .
        "http://fonts.gstatic.com/ " .
        "https://fonts.gstatic.com/ " .
        "; "

    /**
     * To disallow all plugins, the object-src directive should be set to 'none' which will disallow plugins.
     * The plugin-types directive is only used if you are allowing plugins with object-src at all.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/plugin-types
     */
    .   "object-src   'none'; "
    #. "plugin-types ;"

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/media-src
     */
    .   "media-src    'self'; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/child-src
     */
    .   "child-src    'self';"

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox
     */
    .   "sandbox      " .
        "allow-downloads " .
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
    .   "report-uri   /; "

    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/form-action
     */
    .   "form-action  'self'; "

    /**
     * The HTTP Content-Security-Policy (CSP) frame-ancestors directive specifies valid parents
     * that may embed a page using <frame>, <iframe>, <object>, <embed>, or <applet>.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/frame-ancestors
     */
    .   "frame-ancestors " . $aConfig['CONTENT_SECURITY_POLICY']['X-Frame-Options'] . "; "
;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
 */
$aConfig['CONTENT_SECURITY_POLICY']['X-XSS-Protection'] = '1; mode=block';

/**
 * 63072000 for 24 months
 * @see https://support.servertastic.com/knowledgebase/article/http-strict-transport-security-php
 */
$aConfig['CONTENT_SECURITY_POLICY']['Strict-Transport-Security'] = 'max-age=63072000'; # 63072000 for 24 months
