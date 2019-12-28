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

use Blogimus\DataType\Post;
use Blogimus\DataType\Response;
use MVC\Helper;
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
     * @param Post $oPost
     * @return Response
     * @throws \ReflectionException
     */
    public function save(Post $oPost)
    {
        $oFalse = Response::create()->set_bSuccess(false)->set_sType($oPost->get_sType());

        // page or post
        if (false === in_array($oPost->get_sType(), array('page', 'post')))
        {
            return $oFalse->set_sMessage('unvalid type posted');
        }

        // post needs date
        if ('post' === $oPost->get_sType() && true === empty($oPost->get_sDate()))
        {
            return $oFalse->set_sMessage('post needs date');
        }

        // title
        if ('' == trim($oPost->get_sTitle()))
        {
            return $oFalse->set_sMessage('title missing');
        }

        // markdown content
        if ('' == trim($oPost->get_sMarkdown()))
        {
            return $oFalse->set_sMessage('content missing');
        }

        $oPost->set_sTitle(trim(str_replace(array('/', '\\'), array('|', '|'), $oPost->get_sTitle())));
        $oPost->set_sMarkdown(trim($oPost->get_sMarkdown()));

        // Paths
        $sFilePath = '';
        $sFilename = '';
        $sFilenameRecent = '';

        if ('post' === $oPost->get_sType()) {

            $sFilePath = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/post/';

            // create filename
            $sFilename = Helper::secureFilePath($sFilePath . $oPost->get_sDate() . '.' . $oPost->get_sTitle() . '.md');
            $sFilenameRecent = Helper::secureFilePath($sFilePath . $oPost->get_oDataRecent()['sDate'] . '.' . $oPost->get_oDataRecent()['sTitle'] . '.md');
        }
        if ('page' === $oPost->get_sType()){

            $sFilePath = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/page/';

            // create filename
            $sFilename = Helper::secureFilePath($sFilePath . $oPost->get_sTitle() . '.md');
            $sFilenameRecent = Helper::secureFilePath($sFilePath . $oPost->get_oDataRecent()['sTitle'] . '.md');
        }

        if ('' === $sFilePath)
        {
            return $oFalse->set_sMessage('$sFilePath empty');
        }

        // get infos on filename
        ('page' === $oPost->get_sType()) ? $aInfo = Index::getInfoArrayOnPageFileAbs($sFilename) : false;
        ('post' === $oPost->get_sType()) ? $aInfo = Index::getInfoArrayOnPostFileAbs($sFilename) : false;

        $oPost->set_sMarkdown(''
            // prepend new tag
            . '<tag>' . implode(',', $oPost->get_aTaglist()) . '</tag>' . "\n"
            // remove former tags from markup
            . preg_replace('#<tag>(.*?)</tag>#', '', $oPost->get_sMarkdown()));

        // prevent overwriting existing other
        if  (
                // either
                //      it's a new filename; make sure there is no file named so yet
                true === file_exists($sFilename) &&
                // or
                //      no changes in filename; still the same
                $sFilename !== $sFilenameRecent
            )
        {
            return $oFalse->set_sMessage(
                '<ul>'
                . '<li>cannot overwrite an already existing filename:<br><i>' . basename($sFilename) . '</i></li>'
                . '<li>Modify one of these to solve this problem:<ul><li>Title</li><li>Date</li></ul></li>'
                . '</ul>'
            );
        }

        if ('page' === $oPost->get_sType())
        {
            $sBasename = basename($sFilenameRecent);
            $sRest = Index::seoname(str_replace('.md', '', $sBasename));
            $sCacheNameRecent = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/#|#' . 'page' . '#|#' . $sRest . '#|#.json';
        }
        if ('post' === $oPost->get_sType())
        {
            $sBasename = basename($sFilenameRecent);
            $sDate = strtok($sBasename, '.');
            $sRest = Index::seoname(str_replace('.md', '', mb_substr($sBasename, mb_strlen($sDate))));
            $sDate = str_replace('-', '#|#', $sDate);
            $sCacheNameRecent = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/#|#' . 'post' . '#|#' . $sDate . '#|#' . $sRest . '#|#.json';
        }

        // delete recent versions
        (true === file_exists($sFilenameRecent)) ? unlink($sFilenameRecent) : false;
        (true === file_exists($sCacheNameRecent)) ? unlink($sCacheNameRecent) : false;

        // save
        if (false === file_put_contents($sFilename, $oPost->get_sMarkdown(), LOCK_EX))
        {
            return $oFalse->set_sMessage('⚠ could not save');
        }

        $oResponse = Response::create()
        ->set_bSuccess('true')
        ->set_aInfo($aInfo)
        ->set_sType($oPost->get_sType())
        ->set_sFilePath($sFilePath)
        ->set_sFilename($sFilename)
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
