<?php

/**
 * Backend.php
 *
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusModel
 */
namespace Blogimus\Model;

/**
 * Backend
 */
class Backend
{

    /**
     * Constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        ;
    }

    /**
     * logs out from backend
     * @access public
     * @return void 
     */
    public function logout()
    {
        unset($_SESSION['blogixx']);
        $_SESSION['blogixx'] = null;
        \MVC\Session::getInstance()->kill();
        \MVC\Request::REDIRECT('/@');
        \MVC\Helper::STOP();
    }
    
    /**
     * gets formatted Date
     * @param string $sPostDate
     * @return string
     */
    public function sDate($sPostDate = '')
    {
        // Date
        if (isset($sPostDate))
        {
            $sDate = $sPostDate;
            $iYear = (int) substr($sPostDate, 0, 4);
            $iMonth = (int) substr($sPostDate, 5, 2);
            $iDay = (int) substr($sPostDate, 8, 2);
            $sDate = (false === checkdate($iMonth, $iDay, $iYear)) ? date('Y-m-d') : $iYear . '-' . str_pad($iMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($iDay, 2, '0', STR_PAD_LEFT);
        }

        return $sDate;
    }

    /**
     * gets a post by url key      
     * @param string $sUrl
     * @return array $aSet | on fail=empty
     */
    public function getPostOnUrl($sUrl = '')
    {
        $aPost = json_decode(file_get_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPost.json'), true);

        if (!array_key_exists($sUrl, $aPost['sUrl']))
        {
            return array();
        }

        $aSet = $aPost['sUrl'][$sUrl];

        return $aSet;
    }

    /**
     * gets a page by url key 
     * @param string $sUrl
     * @return array $aSet | on fail=empty
     */
    public function getPageOnUrl($sUrl = '')
    {
        $aPage = json_decode(file_get_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPage.json'), true);

        if (!array_key_exists($sUrl, $aPage))
        {
            return array();
        }

        $aSet = $aPage[$sUrl];

        return $aSet;
    }

    /**
     * Destructor
     * @access public
     * @access public
     * @return void
     */
    public function __destruct()
    {
        ;
    }
}
