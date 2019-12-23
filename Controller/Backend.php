<?php

/**
 * Backend.php
 *
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
 * Backend
 */
class Backend
{
    /**
     * @var \Blogimus\Controller\Index
     */
    public $oControllerIndex;

    /**
     * @var \Blogimus\Model\Index
     */
    public $oModelIndex;

    /**
     * @var \Blogimus\Model\Backend
     */
    public $oModelBackend;

    /**
     * pages callable at backend
     * @var array
     */
    private $aPage = array(
        '@', '@edit', '@create', '@delete'
    );

    /**
     * Backend constructor.
     * @param $oControllerIndex
     * @throws \ReflectionException
     */
    public function __construct($oControllerIndex)
    {        
        $sModelIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_INDEX'];
        $sModelBackend = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_BACKEND'];
        
        $this->oControllerIndex = $oControllerIndex;
        $this->oModelIndex = new $sModelIndex();
        $this->oModelBackend = new $sModelBackend();
        
        $this->oControllerIndex->oView->assign('aParam', (isset($_GET['a'])) ? json_decode($_GET['a'], true) : array());        
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_TITLE', (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_TITLE'])) ? Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_TITLE'] : '');
        $this->oControllerIndex->oView->assign('BLOG_CREATE_MAX_CONTENT', (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_CONTENT'])) ? Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CREATE_MAX_CONTENT'] : '');
    }

    /**
     * checks login into backend and delegates actions
     * @param string $sRequest
     * @throws \ReflectionException
     */
    public function backend($sRequest = '')
    {
        // Logout
        if ('@logout' === $sRequest)
        {
            $this->oModelBackend->logout();
        }

        if (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BACKEND']))
        {
            /** @var array $aBlogBackend */
            $aBlogBackend = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BACKEND'];

            // invalid page request
            if (false === in_array($sRequest, $this->aPage))
            {
                $this->oControllerIndex->oView->sendHeader404();
            }

            // checks login
            if  (
                    // login already succeeded before
                    (
                            isset($_SESSION['blogimus']['login'])
                        &&  true === $_SESSION['blogimus']['login']
                    )
                    OR
                    // login success first time
                    (
                            isset($_POST['user'])
                        &&  isset($_POST['password'])
                        &&  (
                                    '' !== trim($_POST['user'])
                                ||  '' !== trim($_POST['password'])
                            )
                        &&  array_key_exists(
                                Registry::get('MVC_ENV'),
                                $aBlogBackend
                            )
                        &&  is_array($aBlogBackend[Registry::get('MVC_ENV')])
                        &&  true === in_array(
                            array(
                                'user' => $_POST['user'],
                                'password' => $_POST['password'],
                            ),
                            $aBlogBackend[Registry::get('MVC_ENV')]
                        )
                    )
                )
            {
                // login successful
                (!isset($_SESSION['blogimus'])) ? $_SESSION['blogimus'] = array() : false;
                $_SESSION['blogimus']['login'] = true;

                switch ($sRequest)
                {
                    case '@':
//                        $this->_overview();
                        \MVC\Request::REDIRECT('/');
                        break;

                    case '@edit':
                        $this->_edit();
                        break;

                    case '@create':
                        $this->_create();
                        break;

                    case '@delete':
                        $this->_delete();
                        break;

                    default:
                        \MVC\Request::REDIRECT('/@');
                        break;
                }
            }
            // show login Form
            else
            {
                $this->_loginForm();
            }
        }
    }

    /**
     * shows overview
     * @param string $sRequest
     * @throws \ReflectionException
     */
    private function _overview($sRequest = '')
    {
        // get all posts
        $aPost = $this->oModelIndex->getPostsOverview();
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('aPost', $aPost);

        // get all pages
        $aPage = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPage.json'), true);
        $this->oControllerIndex->oView->assign('aPage', $aPage);

        $this->oControllerIndex->oView->assign(
            'sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/overview.tpl')
        );
    }

    /**
     * edit contents
     * @throws \ReflectionException
     */
    private function _edit()
    {
        /** @see https://stackoverflow.com/a/44687900/2487859 */
        header('X-XSS-Protection:0');
        
        $bSuccess = false;
        $sSuccess = '';
        $sMarkdown = '';
        $sMessage = '';
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('sContent', '');

        (!isset($_GET['a'])) ? \MVC\Request::REDIRECT('/@') : false;
        $aParam = json_decode($_GET['a'], true);

        // invalid request
        (!isset($aParam['type']) || !isset($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : false;
        (!in_array($aParam['type'], array('page', 'post'))) ? \MVC\Request::REDIRECT('/@') : false;

        if ('post' === $aParam['type'])
        {
            $aSet = ('' === $this->oModelBackend->getPostOnUrl($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : $this->oModelBackend->getPostOnUrl($aParam['url']);
        }
        elseif ('page' === $aParam['type'])
        {
            $aSet = ('' === $this->oModelBackend->getPageOnUrl($aParam['url'])) ? \MVC\Request::REDIRECT('/@') : $this->oModelBackend->getPageOnUrl($aParam['url']);
        }
        
        if (!array_key_exists('sFilePath', $aSet))
        {
            \MVC\Request::REDIRECT('/@');
        }

        $sFilePath = $aSet['sFilePath'];
        $sFilePathNew = $sFilePath;

        (isset($_POST['title'])) ? $_POST['title'] = trim(str_replace(array('/', '\\'), array('|', '|'), $_POST['title'])) : false;
        (isset($_POST['sMarkdown'])) ? $_POST['sMarkdown'] = trim($_POST['sMarkdown']) : false;

        // Date
        (isset($_POST['date'])) ? $sDate = $this->oModelBackend->sDate($_POST['date']) : false;

        // new filename
        if (isset($_POST['type']) && isset($_POST['title']))
        {
            $sFilePathNew = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/' . $_POST['type'] . '/' . ((isset($sDate)) ? $sDate . '.' : '') . $_POST['title'] . '.md';
        }
        
        if ($_POST)
        {            
            (false === isset($_POST['sMarkdown'])) ? $sMessage .= 'Missing Content.<br>' : false;
            (true === file_exists($sFilePathNew) && $sFilePathNew !== $sFilePath) ? $sMessage .= 'a  ' . ucfirst($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>' : false;
        }

        if  (
                    isset($sFilePathNew) 
                && (
                        !file_exists($sFilePathNew)     // new filename; make sure there is no file named so yet
                    ||  $sFilePathNew === $sFilePath    // no changes in filename; still the same
                ) 
                &&  isset($_POST['sMarkdown'])
        )
        {
            // delete old
            (file_exists($sFilePath)) ? unlink($sFilePath) : false;      
            
            $_POST['sMarkdown'] = trim(''
                // prepend new tag
                . ((!empty($_POST['taggles'])) ? '<tag>' . implode(',', $_POST['taggles']) . '</tag>' . "\n" : '')
                // remove former tags from markup
                . preg_replace('#<tag>(.*?)</tag>#', '', $_POST['sMarkdown'])
            );
            
            // write new
            $bSuccess = (boolean) file_put_contents(
                $sFilePathNew, 
                $_POST['sMarkdown'], 
                LOCK_EX
            );
            $sSuccess = ((true === $bSuccess) ? 'true' : 'false');
            
            $sRedirect = '/@edit?a={"type":"' . $aParam['type'] . '","url":"/' . $aParam['type'] . ((isset($sDate))
                    ? '/' . str_replace('-', '/', $sDate)
                    : '') . '/' . \Blogimus\Model\Index::seoname($_POST['title']) . '/"}';
            \MVC\Request::REDIRECT($sRedirect);
        }

        // load content
        $sMarkdown = (file_exists($sFilePath)) ? file_get_contents($sFilePath) : '';
        $aTagArray = $this->oModelIndex->getTagArrayFromString($sMarkdown);
        $sTag = (!empty($aTagArray)) ? "'" . implode("','", $aTagArray) . "'" : "";

        $this->oControllerIndex->oView->assign('sTag', $sTag);
        
        $sMarkdown = preg_replace('#<tag>(.*?)</tag>#', '', $sMarkdown);

        $this->oControllerIndex->oView->assign('sError', $sMessage);
        $this->oControllerIndex->oView->assign('bSuccess', $sSuccess);
        $this->oControllerIndex->oView->assign('sNotifyText', (('true' == $sSuccess) ? 'successfully edited' : ''));
        $this->oControllerIndex->oView->assign('sDate', (isset($aSet['sCreateStamp'])) ? $aSet['sCreateStamp'] : '');
        $this->oControllerIndex->oView->assign('sName', $aSet['sName']);
        $this->oControllerIndex->oView->assign('sType', $aParam['type']);
        $this->oControllerIndex->oView->assign('sUrl', $aSet['sUrl']);
        $this->oControllerIndex->oView->assign('sMarkdown', $sMarkdown);
        $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/edit.tpl'));
    }

    /**
     * creates content
     * @return bool
     * @throws \ReflectionException
     */
    private function _create()
    {
        /** @see https://stackoverflow.com/a/44687900/2487859 */
        header('X-XSS-Protection:0');
        
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('bSuccess', 'false');
        $this->oControllerIndex->oView->assign('sFilename', '');
        $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/create.tpl'));

        if ($_POST)
        {
            if (!isset($_POST['type']) || ($_POST['type'] != 'page' && $_POST['type'] != 'post'))
            {
                return false;
            }
            
            if ($_POST['type'] == 'post' && (!isset($_POST['date']) || empty($_POST['date'])))
            {
                return false;
            }
            
            if ('' == trim($_POST['title']) || '' == trim($_POST['sMarkdown']))
            {
                return false;
            }

            // Path
            $sFilePath = '';
            ('post' == $_POST['type']) ? $sFilePath = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/post/' : false;
            ('page' == $_POST['type']) ? $sFilePath = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . '/page/' : false;

            if ('' === $sFilePath)
            {
                return false;
            }

            $_POST['title'] = trim(str_replace(array('/', '\\'), array('|', '|'), $_POST['title']));
            $_POST['sMarkdown'] = trim($_POST['sMarkdown']);

            // Date
            (isset($_POST['date'])) ? $sDate = $this->oModelBackend->sDate($_POST['date']) : false;

            $sFilename = $sFilePath . ((isset($_POST['date'])) ? $_POST['date'] . '.' : '') . $_POST['title'] . '.md';
            $sMessage = '';
            
            if (file_exists($sFilename))
            {
                $sMessage .= 'a  ' . ucfirst($_POST['type']) . ' "' . $_POST['title'] . '" ' . ((isset($sDate)) ? ' with date "' . $sDate . '" ' : '') . 'already exists.<br>';
            }
            
            $_POST['sMarkdown'] = ''
                // prepend new tag
                . ((!empty($_POST['taggles'])) ? '<tag>' . implode(',', $_POST['taggles']) . '</tag>' . "\n" : '')
                // remove former tags from markup
                . preg_replace('#<tag>(.*?)</tag>#', '', $_POST['sMarkdown']);
            
            // save
            if (false === file_put_contents($sFilename, $_POST['sMarkdown'], LOCK_EX))
            {
                return false;
            }

            $this->oControllerIndex->oView->assign('sError', $sMessage);
            $this->oControllerIndex->oView->assign('bSuccess', 'true');
            $this->oControllerIndex->oView->assign('sNotifyText', 'successfully created: ' . basename($sFilename, '.md'));
            $this->oControllerIndex->oView->assign('sFilename', basename($sFilename, '.md'));
            $this->oControllerIndex->oView->assign('sContent', $this->oControllerIndex->oView->loadTemplateAsString('backend/create.tpl'));
            
            return true;
        }
        
        return false;
    }

    /**
     * deletes a page or post
     * @throws \ReflectionException
     */
    private function _delete()
    {
        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/backend.tpl';        
        $this->oControllerIndex->oView->assign('sContent', '');

        (!isset($_GET['a'])) ? \MVC\Request::REDIRECT('/@') : false;
        $aParam = json_decode($_GET['a'], true);

        // valid request
        if  (
                    (isset($aParam['type']) && isset($aParam['url']))
                ||  (in_array($aParam['type'], array('page', 'post')))
        )
        {
            $sMarkdown = '';

            if ('post' === $aParam['type'])
            {
                $aPost = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPost.json'), true);
                (!array_key_exists($aParam['url'], $aPost['sUrl'])) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPost['sUrl'][$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }
            elseif ('page' === $aParam['type'])
            {
                $aPage = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPage.json'), true);
                (!array_key_exists($aParam['url'], $aPage)) ? \MVC\Request::REDIRECT('/@') : false;
                $aSet = $aPage[$aParam['url']];
                $sFilePath = $aSet['sFilePath'];
            }

            if (file_exists($sFilePath))
            {
                unlink($sFilePath);
            }
        }

        \MVC\Request::REDIRECT('/@');
    }

    /**
     * shows login form
     * @access private
     * @return void 
     */
    private function _loginForm()
    {
        unset($_SESSION['blogimus']);
        $_SESSION['blogimus'] = null;

        $this->oControllerIndex->oView->sTemplate = $this->oControllerIndex->oView->sTemplateDir . '/layout/index.tpl';
        
        $this->oControllerIndex->oView->assign(
            'sContent', 
            $this->oControllerIndex->oView->loadTemplateAsString('backend/login.tpl')
        );
    }
}
