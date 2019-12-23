<?php

//-------------------------------------------------------------------------------------
// MVC

// enable debug output
$aConfig['MVC_DEBUG'] = false;

/*
 * Ajax
 */
// override MVC's request "a"
$aConfig['MVC_REQUEST_WHITELIST_PARAMS']['GET']['a'] = array(
    'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc},;.:_\\ ?!&\|\{\}\"']+/u"
, 'length' => 256
);

/**
 * Misc
 */
// override MVC's fallback routing
$aConfig['MVC_ROUTING_FALLBACK'] = $aConfig['MVC_GET_PARAM_MODULE'] . '=Blogimus&'
    . $aConfig['MVC_GET_PARAM_C'] . '=index&'
    . $aConfig['MVC_GET_PARAM_M'] . '=index';

// composer dir
$aConfig['MVC_COMPOSER_DIR'] = realpath(__DIR__ . '/../') . '/config/Blogimus';

// routing.json file
$aConfig['MVC_ROUTING_JSON'] = realpath(__DIR__ . '/../') . '/routing/final.json';

// Smarty
$aConfig['MVC_VIEW_TEMPLATES'] = $aConfig['MVC_MODULES'] . '/' . basename(realpath(__DIR__ . '/../../')) . '/templates';
$aConfig['MVC_SMARTY_TEMPLATE_DEFAULT'] = 'Frontend/layout/index.tpl';

// Add Location of Smarty PlugIns
$aConfig['MVC_SMARTY_PLUGINS_DIR'][] = $aConfig['MVC_MODULES'] . '/' . basename(realpath(__DIR__ . '/../../')) . '/etc/smarty';
