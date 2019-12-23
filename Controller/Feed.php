<?php

/**
 * Feed.php
 *
 * @package myMVC
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusController
 */
namespace Blogimus\Controller;

use MVC\Registry;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Feed implements \MVC\MVCInterface\Controller
{
    /**
     * View Object
     * @access public
     */
    public $oView;

    /**
     * this method is autom. called by MVC_Application->runTargetClassBeforeMethod()
     * in very early stage
     * 
     * @access public
     * @static
     */
    public static function __preconstruct()
    {
        ;
    }

    /**
     * Feed constructor.
     * @throws \ReflectionException
     */
    public function __construct()
    {
        header("Content-type: text/xml");

        $sViewIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_VIEW_INDEX'];
        $this->oView = new $sViewIndex();

        $this->oView->sTemplate = $this->oView->sTemplateDir . '/layout/feed.tpl';

        $this->oView->assign('sTitle', Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_NAME']);
        $this->oView->assign('sUrl', \MVC\Request::GETCURRENTREQUEST()['protocol'] . \MVC\Request::GETCURRENTREQUEST()['host']);
        $this->oView->assign('sDescription', Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DESCRIPTION']);
    }

    /**
     * @call /feed/post/
     * @throws \ReflectionException
     */
    public function post()
    {
        // read aPostUrl.json
        $aPost = json_decode(
            file_get_contents(
                Registry::get('MVC_CACHE_DIR')
                . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPostUrl.json'
            ), true
        );

        $aUrl = \MVC\Request::GETCURRENTREQUEST();
        $sItem = '';

        foreach ($aPost as $aValue)
        {
            $sItem .= '<item>' . "\n"
                . '<title>' . $aValue['sName'] . '</title>' . "\n"
                . '<link>' . $aUrl['protocol'] . $aUrl['host'] . $aValue['sUrl'] . '</link>' . "\n"
                . '<description>' . $aValue['sName'] . '</description>' . "\n"
                . '</item>' . "\n";
        }

        $this->oView->assign('sItem', $sItem);
    }

    /**
     * Destructor
     * 
     * @access public
     * @return void
     */
    public function __destruct()
    {
        $this->oView->render();
    }

}
