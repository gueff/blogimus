<?php

$aConfig = array(
    'dir' => \MVC\Registry::get("MVC_MODULES") . '/Blogimus/DataType/',
    'unlinkDir' => false,
    'class' => array(
        array(
            'name' => 'DTResponse',
            'file' => 'DTResponse.php',
            'namespace' => 'Blogimus\\DataType',
            'createHelperMethods' => true,
            'constant' => array(
            ),
            'property' => array(
                array('key' => 'bSuccess', 'var' => 'bool'),
                array('key' => 'aInfo', 'var' => 'array'),
                array('key' => 'sType'),
                array('key' => 'sFilePath'),
                array('key' => 'sFilename'),
                array('key' => 'sMessage'),
            ),
        ),
        array(
            'name' => 'DTPostData',
            'file' => 'DTPostData.php',
            'namespace' => 'Blogimus\\DataType',
            'createHelperMethods' => true,
            'constant' => array(
            ),
            'property' => array(
                array('key' => 'sMethod'),
                array('key' => 'sAction'),
                array('key' => 'oParam',),
                array('key' => 'sUrl'),
                array('key' => 'sType'),
                array('key' => 'sTitle'),
                array('key' => 'sDate'),
                array('key' => 'sMarkdown'),
                array('key' => 'aTaglist', 'var' => 'array'),
                array('key' => 'oDataRecent',),
                array('key' => 'sFolder'),
                array('key' => 'sFileNameAbs'),
                array('key' => 'sFileNameAbsRecent'),
                array(
                    'key' => 'oInfo',
                    'var' => '\\Blogimus\\DataType\\DTFileInfo',
                ),
            ),
        ),
        array(
            'name' => 'DTCachefile',
            'file' => 'DTCachefile.php',
            'namespace' => 'Blogimus\\DataType',
            'createHelperMethods' => true,
            'constant' => array(
            ),
            'property' => array(
                array('key' => 'sFolder'),
                array('key' => 'sType'),
                array('key' => 'sFilename'),
                array('key' => 'sFilenameAbsolute'),
                array('key' => 'bFileExists', 'var' => 'bool'),
            ),
        ),
        array(
            'name' => 'DTFileInfo',
            'file' => 'DTFileInfo.php',
            'namespace' => 'Blogimus\\DataType',
            'createHelperMethods' => true,
            'constant' => array(
            ),
            'property' => array(
                array('key' => 'sFolder'),
                array('key' => 'sFilename'),
                array('key' => 'sFilenameAbsolute'),
                array('key' => 'sDate'),
                array('key' => 'iYear', 'var' => 'int'),
                array('key' => 'iMonth', 'var' => 'int'),
                array('key' => 'iDay', 'var' => 'int'),
                array('key' => 'sName'),
                array('key' => 'sUrl'),
                array('key' => 'sCreateStamp'),
                array('key' => 'sChangeStamp'),
                array('key' => 'bFileExists', 'var' => 'bool'),
            ),
        ),
    ),
);
