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

use Blogimus\DataType\DTPostData;
use Blogimus\DataType\DTResponse;
use MVC\Helper;
use MVC\Log;
use MVC\Registry;

/**
 * Backend
 */
class Backend
{
    /**
     * @var Index
     */
    protected $oModel;

    /**
     * Backend constructor.
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->oModel = new Index();
    }

    /**
     * logs out from backend
     * @throws \ReflectionException
     */
    public function logout()
    {
        unset($_SESSION[Registry::get('MODULE_FOLDERNAME')]);
        $_SESSION[Registry::get('MODULE_FOLDERNAME')] = null;
        \MVC\Session::is()->kill();
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
            $sDate = (false === checkdate($iMonth, $iDay, $iYear))
                ? date('Y-m-d')
                : $iYear . '-' . str_pad($iMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($iDay, 2, '0', STR_PAD_LEFT);
        }

        return $sDate;
    }

    /**
     * gets a post by url key      
     * @param string $sUrl
     * @return array
     * @throws \ReflectionException
     */
    public function getPostOnUrl($sUrl = '')
    {
        $aPost = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME'). '/aPost.json'), true);

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
     * @return array
     * @throws \ReflectionException
     */
    public function getPageOnUrl($sUrl = '')
    {
        $aPage = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPage.json'), true);

        if (!array_key_exists($sUrl, $aPage))
        {
            return array();
        }

        $aSet = $aPage[$sUrl];

        return $aSet;
    }

    /**
     * @param DTPostData $oDTPostData
     * @return Response
     * @throws \ReflectionException
     */
    public function save(DTPostData $oDTPostData)
    {
        $oFalse = DTResponse::create()
            ->set_bSuccess(false)
            ->set_sType($oDTPostData->get_sType())
        ;

        // page or post
        if (false === in_array($oDTPostData->get_sType(), array('page', 'post')))
        {
            return $oFalse->set_sMessage('unvalid type posted');
        }

        // post needs date
        if ('post' === $oDTPostData->get_sType() && true === empty($oDTPostData->get_sDate()))
        {
            return $oFalse->set_sMessage('post needs date');
        }

        // title
        if ('' == trim($oDTPostData->get_sTitle()))
        {
            return $oFalse->set_sMessage('title missing');
        }

        // markdown content
        if ('' == trim($oDTPostData->get_sMarkdown()))
        {
            return $oFalse->set_sMessage('content missing');
        }

        $oDTPostData->set_sTitle(trim(str_replace(array('/', '\\'), array('|', '|'), $oDTPostData->get_sTitle())));
        $oDTPostData->set_sMarkdown(trim($oDTPostData->get_sMarkdown()));

        if ('post' === $oDTPostData->get_sType()) {

            $oDTPostData->set_sFolder(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/post/');

            // create filename
            $oDTPostData->set_sFileNameAbs(Helper::secureFilePath($oDTPostData->get_sFolder() . $oDTPostData->get_sDate() . '.' . $oDTPostData->get_sTitle() . '.md'));
            $oDTPostData->set_sFileNameAbsRecent(Helper::secureFilePath($oDTPostData->get_sFolder() . $oDTPostData->get_oDataRecent()['sDate'] . '.' . $oDTPostData->get_oDataRecent()['sTitle'] . '.md'));
        }
        if ('page' === $oDTPostData->get_sType()){

            $oDTPostData->set_sFolder(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/page/');

            // create filename
            $oDTPostData->set_sFileNameAbs(Helper::secureFilePath($oDTPostData->get_sFolder() . $oDTPostData->get_sTitle() . '.md'));
            $oDTPostData->set_sFileNameAbsRecent(Helper::secureFilePath($oDTPostData->get_sFolder() . $oDTPostData->get_oDataRecent()['sTitle'] . '.md'));
        }


        if ('' === $oDTPostData->get_sFolder())
        {
            return $oFalse->set_sMessage('$sFilePath empty');
        }

        // get infos on filename
        ('page' === $oDTPostData->get_sType()) ? $aInfo = Index::getInfoArrayOnPageFileAbs($oDTPostData->get_sFileNameAbs()) : false;
        ('post' === $oDTPostData->get_sType()) ? $aInfo = Index::getInfoArrayOnPostFileAbs($oDTPostData->get_sFileNameAbs()) : false;

        $oDTPostData->set_sMarkdown(''
            // prepend new tag
            . '<tag>' . implode(',', $oDTPostData->get_aTaglist()) . '</tag>' . "\n"
            // remove former tags from markup
            . preg_replace('#<tag>(.*?)</tag>#', '', $oDTPostData->get_sMarkdown()));

        // prevent overwriting existing other
        if  (
                // either
                //      it's a new filename; make sure there is no file named so yet
                true === file_exists($oDTPostData->get_sFileNameAbs()) &&
                // or
                //      no changes in filename; still the same
                $oDTPostData->get_sFileNameAbs() !== $oDTPostData->get_sFileNameAbsRecent()
            )
        {
            return $oFalse->set_sMessage(
                '<ul>'
                . '<li>cannot overwrite an already existing filename:<br><i>' . basename($oDTPostData->get_sFileNameAbs()) . '</i></li>'
                . '<li>Modify one of these to solve this problem:<ul><li>Title</li><li>Date</li></ul></li>'
                . '</ul>'
            );
        }

        if ('page' === $oDTPostData->get_sType())
        {
            $sBasename = basename($oDTPostData->get_sFileNameAbsRecent());
            $sRest = Index::seoname(str_replace('.md', '', $sBasename));
            $sCacheNameRecent = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/#|#' . 'page' . '#|#' . $sRest . '#|#.json';
        }
        if ('post' === $oDTPostData->get_sType())
        {
            $sBasename = basename($oDTPostData->get_sFileNameAbsRecent());
            $sDate = strtok($sBasename, '.');
            $sRest = Index::seoname(str_replace('.md', '', mb_substr($sBasename, mb_strlen($sDate))));
            $sDate = str_replace('-', '#|#', $sDate);
            $sCacheNameRecent = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/#|#' . 'post' . '#|#' . $sDate . '#|#' . $sRest . '#|#.json';
        }

        // delete recent versions
        (true === file_exists($oDTPostData->get_sFileNameAbsRecent())) ? unlink($oDTPostData->get_sFileNameAbsRecent()) : false;
        (true === file_exists($sCacheNameRecent)) ? unlink($sCacheNameRecent) : false;

        // save
        if (false === file_put_contents($oDTPostData->get_sFileNameAbs(), $oDTPostData->get_sMarkdown(), LOCK_EX))
        {
            return $oFalse->set_sMessage('⚠ could not save');
        }

//        Log::WRITE($oDTPostData, 'debug.log');

        $oResponse = DTResponse::create()
        ->set_bSuccess('true')
        ->set_aInfo($aInfo)
        ->set_sType($oDTPostData->get_sType())
        ->set_sFilePath($oDTPostData->get_sFolder())
        ->set_sFilename($oDTPostData->get_sFileNameAbs())
        ->set_sMessage('✔ saved: `' . $aInfo['sName'] . '`')
        ;

        return $oResponse;

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
